<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class ImportMupoTrainingManuals extends Command
{
    protected $signature = 'mupo:import-training-manuals {--replace : Replace previously imported MUPO training courses}';
    protected $description = 'Import all supplied MUPO PSIRA and NKP manuals into the LMS as structured courses, lessons, resources and quizzes.';

    public function handle(): int
    {
        $dataFile = database_path('seeders/data/mupo_training_content.json');
        if (!File::exists($dataFile)) {
            $this->error('Training content data file is missing: '.$dataFile);
            return self::FAILURE;
        }
        if (!Schema::hasTable('courses') || !Schema::hasTable('chapters') || !Schema::hasTable('lessons')) {
            $this->error('Required LMS course tables are missing. Run migrations first.');
            return self::FAILURE;
        }

        $payload = json_decode(File::get($dataFile), true);
        if (!is_array($payload) || empty($payload['courses'])) {
            $this->error('Training content data is invalid or empty.');
            return self::FAILURE;
        }

        $adminId = (int) (DB::table('users')->where('role_id', 1)->value('id') ?: DB::table('users')->min('id') ?: 1);
        $langId = (int) (DB::table('languages')->where('code', 'en')->value('id') ?: 19);
        $lmsId = 1;

        try {
            DB::transaction(function () use ($payload, $adminId, $langId, $lmsId) {
                $categoryId = $this->upsertCategory($adminId, $lmsId);

                foreach ($payload['courses'] as $courseData) {
                    $courseId = $this->importCourse($courseData, $categoryId, $adminId, $langId, $lmsId);
                    $this->importResources($courseId, $courseData, $adminId, $lmsId);
                    $this->importQuiz($courseId, $courseData, $categoryId, $adminId, $lmsId);
                    $this->refreshCourseCounts($courseId);
                }

                DB::table('categories')->where('id', $categoryId)->update([
                    'total_courses' => DB::table('courses')->where('category_id', $categoryId)->where('type', 1)->count(),
                    'updated_at' => now(),
                ]);
            }, 3);
        } catch (Throwable $e) {
            $this->error('Import failed: '.$e->getMessage());
            return self::FAILURE;
        }

        $this->newLine();
        $this->info('MUPO training manuals imported successfully.');
        $this->line('Courses: '.count($payload['courses']));
        $this->line('Chapters: '.DB::table('chapters')->whereIn('course_id', DB::table('courses')->whereIn('slug', collect($payload['courses'])->pluck('slug'))->pluck('id'))->count());
        $this->line('Lessons: '.DB::table('lessons')->whereIn('course_id', DB::table('courses')->whereIn('slug', collect($payload['courses'])->pluck('slug'))->pluck('id'))->count());
        $this->line('Staff controlled documents: '.(Schema::hasTable('mupo_training_documents') ? DB::table('mupo_training_documents')->where('audience','staff')->count() : 0));
        $this->warn('Assessor memoranda and staff assessment packs are stored privately and are not exposed as learner lesson files.');
        return self::SUCCESS;
    }

    private function jsonText(string $value): string
    {
        return json_encode(['en' => $value], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function durationToMinutes($value): int
    {
        if (is_numeric($value)) {
            return max(1, (int) $value);
        }

        $text = strtolower(trim((string) $value));
        if (preg_match('/([0-9]+(?:\.[0-9]+)?)\s*hour/', $text, $matches)) {
            return max(1, (int) round(((float) $matches[1]) * 60));
        }
        if (preg_match('/([0-9]+)\s*min/', $text, $matches)) {
            return max(1, (int) $matches[1]);
        }

        return 60;
    }

    private function upsertCategory(int $adminId, int $lmsId): int
    {
        $existing = DB::table('categories')->where('title', 'MUPO Security Training')->first();
        if ($existing) {
            DB::table('categories')->where('id', $existing->id)->update([
                'name' => $this->jsonText('MUPO Security Training'),
                'description' => $this->jsonText('Accredited and controlled security training programmes delivered through Mupo Training Center.'),
                'status' => 1,
                'show_home' => 1,
                'updated_at' => now(),
            ]);
            return (int) $existing->id;
        }

        return (int) DB::table('categories')->insertGetId([
            'name' => $this->jsonText('MUPO Security Training'),
            'title' => 'MUPO Security Training',
            'description' => $this->jsonText('Accredited and controlled security training programmes delivered through Mupo Training Center.'),
            'user_id' => $adminId,
            'status' => 1,
            'show_home' => 1,
            'position_order' => 1,
            'parent_id' => null,
            'lms_id' => $lmsId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function removeExistingCourse(string $slug): void
    {
        $course = DB::table('courses')->where('slug', $slug)->first();
        if (!$course) return;
        if (!$this->option('replace')) {
            throw new \RuntimeException("Course '{$slug}' already exists. Re-run with --replace to rebuild it safely.");
        }

        $courseId = (int) $course->id;
        $lessonIds = DB::table('lessons')->where('course_id', $courseId)->pluck('id');
        if (Schema::hasTable('lesson_files') && $lessonIds->isNotEmpty()) DB::table('lesson_files')->whereIn('lesson_id', $lessonIds)->delete();

        $quizIds = DB::table('online_quizzes')->where('course_id', $courseId)->pluck('id');
        if ($quizIds->isNotEmpty()) {
            $questionIds = DB::table('online_exam_question_assigns')->whereIn('online_exam_id', $quizIds)->pluck('question_bank_id');
            DB::table('online_exam_question_assigns')->whereIn('online_exam_id', $quizIds)->delete();
            if ($questionIds->isNotEmpty()) {
                DB::table('question_bank_mu_options')->whereIn('question_bank_id', $questionIds)->delete();
                DB::table('question_banks')->whereIn('id', $questionIds)->delete();
            }
            DB::table('online_quizzes')->whereIn('id', $quizIds)->delete();
        }

        DB::table('lessons')->where('course_id', $courseId)->delete();
        DB::table('chapters')->where('course_id', $courseId)->delete();
        if (Schema::hasTable('mupo_training_documents')) DB::table('mupo_training_documents')->where('course_id', $courseId)->delete();
        DB::table('courses')->where('id', $courseId)->delete();
    }

    private function importCourse(array $data, int $categoryId, int $adminId, int $langId, int $lmsId): int
    {
        $this->removeExistingCourse($data['slug']);

        $courseId = (int) DB::table('courses')->insertGetId([
            'category_id' => $categoryId,
            'user_id' => $adminId,
            'lang_id' => $langId,
            'title' => $this->jsonText($data['title']),
            'slug' => $data['slug'],
            'duration' => $this->durationToMinutes($data['duration']),
            'image' => 'mupo/assets/images/bulb.jpg',
            'thumbnail' => 'mupo/assets/images/bulb.jpg',
            'price' => 0,
            'discount_price' => 0,
            'publish' => 1,
            'status' => 1,
            'level' => $data['level'] ?? 2,
            'about' => $this->jsonText($data['about']),
            'requirements' => $this->jsonText($data['requirements']),
            'outcomes' => $this->jsonText($data['outcomes']),
            'type' => 1,
            'scope' => 1,
            'complete_order' => 1,
            'show_overview_media' => 0,
            'show_mode_of_delivery' => 1,
            'mode_of_delivery' => 1,
            'feature' => 1,
            'lms_id' => $lmsId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $lessonPosition = 1;
        foreach ($data['chapters'] as $chapterIndex => $chapterData) {
            $chapterId = (int) DB::table('chapters')->insertGetId([
                'course_id' => $courseId,
                'name' => $chapterData['name'],
                'chapter_no' => $chapterIndex + 1,
                'is_lock' => $chapterIndex === 0 ? 0 : 1,
                'position' => $chapterIndex + 1,
                'lms_id' => $lmsId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($chapterData['lessons'] as $lessonIndex => $lessonData) {
                if (trim(strip_tags($lessonData['html'] ?? '')) === '') continue;
                DB::table('lessons')->insert([
                    'course_id' => $courseId,
                    'chapter_id' => $chapterId,
                    'name' => Str::limit($lessonData['title'] ?: 'Learning Content', 190, ''),
                    'description' => 'MUPO structured learning content from the approved course manual.',
                    'host' => 'Editor',
                    'duration' => (string) max(5, (int) ceil(($chapterData['duration'] ?? 60) / max(1, count($chapterData['lessons'])))),
                    'is_lock' => $chapterIndex === 0 && $lessonIndex === 0 ? 0 : 1,
                    'is_quiz' => 0,
                    'position' => $lessonPosition++,
                    'lms_id' => $lmsId,
                    'editor' => '<div class="mupo-manual-lesson">'.($lessonData['html'] ?? '').'</div>',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        return $courseId;
    }

    private function importResources(int $courseId, array $courseData, int $adminId, int $lmsId): void
    {
        $sourceBase = resource_path('mupo-training-manuals');
        $publicBase = public_path('uploads/mupo-training-manuals');
        $privateBase = storage_path('app/private/mupo-training-manuals');
        File::ensureDirectoryExists($publicBase);
        File::ensureDirectoryExists($privateBase);

        $resourceChapterId = (int) DB::table('chapters')->insertGetId([
            'course_id' => $courseId,
            'name' => 'Course Resources & Controlled Documents',
            'chapter_no' => DB::table('chapters')->where('course_id',$courseId)->max('chapter_no') + 1,
            'is_lock' => 0,
            'position' => DB::table('chapters')->where('course_id',$courseId)->max('position') + 1,
            'lms_id' => $lmsId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        foreach ($courseData['resources'] as $i => $resource) {
            $src = $sourceBase.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $resource['file']);
            if (!File::exists($src)) throw new \RuntimeException('Manual resource missing: '.$resource['file']);
            $safe = Str::slug(pathinfo($resource['file'], PATHINFO_FILENAME)).'.'.pathinfo($resource['file'], PATHINFO_EXTENSION);

            if ($resource['audience'] === 'learner') {
                $courseFolder = $publicBase.DIRECTORY_SEPARATOR.$courseData['slug'];
                File::ensureDirectoryExists($courseFolder);
                $dest = $courseFolder.DIRECTORY_SEPARATOR.$safe;
                File::copy($src, $dest);
                $publicLink = 'public/uploads/mupo-training-manuals/'.$courseData['slug'].'/'.$safe;
                DB::table('lessons')->insert([
                    'course_id'=>$courseId,'chapter_id'=>$resourceChapterId,'name'=>$resource['title'],
                    'description'=>'Download the approved learner resource.','video_url'=>$publicLink,
                    'host'=>$this->hostForExtension(pathinfo($safe, PATHINFO_EXTENSION)),'duration'=>'5','is_lock'=>0,'is_quiz'=>0,
                    'position'=>9000+$i,'lms_id'=>$lmsId,'editor'=>'<p>This is an approved MUPO learner resource for this course.</p>',
                    'created_at'=>now(),'updated_at'=>now(),
                ]);
            } else {
                $courseFolder = $privateBase.DIRECTORY_SEPARATOR.$courseData['slug'];
                File::ensureDirectoryExists($courseFolder);
                $dest = $courseFolder.DIRECTORY_SEPARATOR.$safe;
                File::copy($src, $dest);
                if (Schema::hasTable('mupo_training_documents')) {
                    DB::table('mupo_training_documents')->insert([
                        'course_id'=>$courseId,'title'=>$resource['title'],'document_type'=>$this->hostForExtension(pathinfo($safe, PATHINFO_EXTENSION)),
                        'audience'=>'staff','version'=>$this->extractVersion($resource['title']),'original_filename'=>basename($resource['file']),
                        'storage_path'=>'private/mupo-training-manuals/'.$courseData['slug'].'/'.$safe,'active'=>1,'uploaded_by'=>$adminId,
                        'created_at'=>now(),'updated_at'=>now(),
                    ]);
                }
            }
        }
    }

    private function importQuiz(int $courseId, array $courseData, int $categoryId, int $adminId, int $lmsId): void
    {
        if (empty($courseData['quiz']['questions'])) return;
        $quiz = $courseData['quiz'];
        $quizId = (int) DB::table('online_quizzes')->insertGetId([
            'title'=>$this->jsonText($quiz['title']),'percentage'=>$quiz['percentage'],'instruction'=>$this->jsonText('Answer all questions. Select the one best answer for each question. Practical and structured-response evidence remains subject to the provider-approved assessment process.'),
            'status'=>1,'active_status'=>1,'category_id'=>$categoryId,'course_id'=>$courseId,'created_by'=>$adminId,'updated_by'=>$adminId,
            'random_question'=>0,'question_time_type'=>1,'question_time'=>$quiz['time'] ?? 60,'question_review'=>1,'show_result_each_submit'=>1,'multiple_attend'=>1,
            'lms_id'=>$lmsId,'show_ans_with_explanation'=>1,'show_ans_sheet'=>1,'show_score_result'=>1,'show_correct_ans_in_ans_sheet'=>1,
            'total_questions'=>count($quiz['questions']),'total_marks'=>array_sum(array_column($quiz['questions'],'marks')),
            'created_at'=>now(),'updated_at'=>now(),
        ]);

        foreach ($quiz['questions'] as $q) {
            $questionId = (int) DB::table('question_banks')->insertGetId([
                'type'=>'M','question'=>$q['question'],'marks'=>$q['marks'] ?? 1,'number_of_option'=>count($q['options']),
                'category_id'=>$categoryId,'active_status'=>1,'user_id'=>$adminId,'lms_id'=>$lmsId,'shuffle'=>1,
                'explanation'=>'Correct answer is determined from the supplied controlled assessor memorandum.','number_of_ans'=>1,
                'created_at'=>now(),'updated_at'=>now(),
            ]);
            foreach ($q['options'] as $pos=>$opt) {
                DB::table('question_bank_mu_options')->insert([
                    'title'=>$opt['label'].'. '.$opt['text'],'status'=>$opt['correct']?1:0,'active_status'=>1,
                    'question_bank_id'=>$questionId,'created_by'=>$adminId,'updated_by'=>$adminId,'lms_id'=>$lmsId,'position'=>$pos+1,'option_index'=>$pos+1,
                    'created_at'=>now(),'updated_at'=>now(),
                ]);
            }
            DB::table('online_exam_question_assigns')->insert([
                'online_exam_id'=>$quizId,'question_bank_id'=>$questionId,'created_by'=>$adminId,'updated_by'=>$adminId,'lms_id'=>$lmsId,
                'created_at'=>now(),'updated_at'=>now(),
            ]);
        }

        $chapterId = (int) DB::table('chapters')->insertGetId([
            'course_id'=>$courseId,'name'=>'Final Knowledge Assessment','chapter_no'=>DB::table('chapters')->where('course_id',$courseId)->max('chapter_no')+1,
            'is_lock'=>1,'position'=>DB::table('chapters')->where('course_id',$courseId)->max('position')+1,'lms_id'=>$lmsId,
            'created_at'=>now(),'updated_at'=>now(),
        ]);
        DB::table('lessons')->insert([
            'course_id'=>$courseId,'chapter_id'=>$chapterId,'quiz_id'=>$quizId,'name'=>$quiz['title'],'description'=>'Final online knowledge assessment.',
            'host'=>null,'duration'=>(string)($quiz['time'] ?? 60),'is_lock'=>1,'is_quiz'=>1,'position'=>9999,'lms_id'=>$lmsId,
            'created_at'=>now(),'updated_at'=>now(),
        ]);
    }

    private function refreshCourseCounts(int $courseId): void
    {
        DB::table('courses')->where('id',$courseId)->update([
            'total_chapters'=>DB::table('chapters')->where('course_id',$courseId)->count(),
            'total_lessons'=>DB::table('lessons')->where('course_id',$courseId)->where('is_quiz',0)->count(),
            'total_quiz_lessons'=>DB::table('lessons')->where('course_id',$courseId)->where('is_quiz',1)->count(),
            'updated_at'=>now(),
        ]);
    }

    private function hostForExtension(string $ext): string
    {
        return match (strtolower($ext)) {
            'pdf' => 'PDF', 'doc','docx' => 'Word', 'ppt','pptx' => 'PowerPoint', 'zip' => 'Zip', default => 'Self'
        };
    }

    private function extractVersion(string $title): ?string
    {
        return preg_match('/(?:Version|Edition)\s+([0-9.]+)/i',$title,$m) ? $m[1] : null;
    }
}
