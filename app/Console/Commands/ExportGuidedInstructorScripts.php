<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ExportGuidedInstructorScripts extends Command
{
    protected $signature = 'mupo:export-guided-instructor
        {--course= : Export one course ID only}
        {--lesson= : Export one lesson ID only}
        {--force : Replace draft script files that already exist}';

    protected $description = 'Export review-required teaching scripts for the offline MUPO Guided Instructor audio generator.';

    public function handle(): int
    {
        $query = DB::table('lessons')
            ->join('courses', 'courses.id', '=', 'lessons.course_id')
            ->leftJoin('chapters', 'chapters.id', '=', 'lessons.chapter_id')
            ->where('lessons.host', 'Editor')
            ->where('lessons.is_quiz', 0)
            ->where('courses.status', 1)
            ->select([
                'lessons.id', 'lessons.course_id', 'lessons.chapter_id', 'lessons.name',
                'lessons.editor', 'lessons.duration', 'courses.title as course_title',
                'chapters.name as chapter_name',
            ])
            ->orderBy('lessons.course_id')
            ->orderBy('lessons.position');

        if ($this->option('course')) {
            $query->where('lessons.course_id', (int) $this->option('course'));
        }
        if ($this->option('lesson')) {
            $query->where('lessons.id', (int) $this->option('lesson'));
        }

        $lessons = $query->get();
        if ($lessons->isEmpty()) {
            $this->warn('No supported Editor lessons matched the requested filters.');
            return self::SUCCESS;
        }

        $written = 0;
        $skipped = 0;
        foreach ($lessons as $lesson) {
            $path = storage_path("app/guided-instructor/scripts/course-{$lesson->course_id}/lesson-{$lesson->id}.json");
            if (File::exists($path) && !$this->option('force')) {
                $skipped++;
                continue;
            }

            File::ensureDirectoryExists(dirname($path));
            $segments = $this->segmentsFromHtml((string) $lesson->editor);
            if (!$segments) {
                $skipped++;
                continue;
            }

            $payload = [
                'schema_version' => 1,
                'course_id' => (int) $lesson->course_id,
                'lesson_id' => (int) $lesson->id,
                'course_title' => $this->translated($lesson->course_title),
                'chapter_title' => $this->translated($lesson->chapter_name),
                'lesson_title' => $this->translated($lesson->name),
                'language' => 'en-ZA',
                'voice_profile' => 'mupo-guided-instructor-v1',
                'approved' => false,
                'approval' => [
                    'reviewer' => null,
                    'reviewed_at' => null,
                    'notes' => 'Review every segment against the approved learner material. Set approved to true only after sign-off.',
                ],
                'segments' => $segments,
            ];

            File::put($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
            $written++;
        }

        $this->info("Export complete: {$written} draft script(s) written; {$skipped} skipped.");
        $this->line('Drafts: storage/app/guided-instructor/scripts');
        $this->warn('Audio generation remains locked until each script has approved=true.');
        return self::SUCCESS;
    }

    private function segmentsFromHtml(string $html): array
    {
        $html = trim($html);
        if ($html === '') return [];

        $parts = preg_split('/(<h[1-4][^>]*>.*?<\/h[1-4]>)/is', $html, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $segments = [];
        $heading = 'Introduction';
        $buffer = '';

        $flush = function () use (&$segments, &$heading, &$buffer): void {
            $text = $this->cleanText($buffer);
            if ($text === '') return;
            $id = Str::slug($heading ?: 'segment-' . (count($segments) + 1));
            $segments[] = [
                'id' => $id ?: 'segment-' . (count($segments) + 1),
                'section_id' => $id ?: null,
                'title' => $heading ?: 'Lesson Segment',
                'approved' => false,
                'text' => $text,
            ];
            $buffer = '';
        };

        foreach ($parts as $part) {
            if (preg_match('/^<h[1-4][^>]*>(.*?)<\/h[1-4]>$/is', trim($part), $match)) {
                $flush();
                $heading = $this->cleanText($match[1]) ?: 'Lesson Segment';
            } else {
                $buffer .= ' ' . $part;
            }
        }
        $flush();

        if (!$segments) {
            $text = $this->cleanText($html);
            if ($text !== '') {
                $segments[] = ['id' => 'lesson-overview', 'section_id' => null, 'title' => 'Lesson Overview', 'approved' => false, 'text' => $text];
            }
        }

        return array_values($segments);
    }

    private function cleanText(string $html): string
    {
        $text = html_entity_decode(strip_tags(str_replace(['</p>', '</li>', '<br>', '<br/>', '<br />'], '. ', $html)), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text) ?: '';
        $text = preg_replace('/\.{2,}/', '.', $text) ?: $text;
        return trim($text, " \t\n\r\0\x0B.");
    }

    private function translated(?string $value): string
    {
        if (!$value) return '';
        $decoded = json_decode($value, true);
        return is_array($decoded) ? (string) ($decoded['en'] ?? reset($decoded) ?: '') : $value;
    }
}
