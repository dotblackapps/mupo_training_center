<?php

namespace App\Console\Commands\Concerns;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Shared, safe deletion logic for MUPO-imported course content.
 *
 * Used by both ImportMupoTrainingManuals (to rebuild a single course's
 * content under --replace, without touching the course row's own id) and
 * CleanupDuplicateMupoCourses (to fully remove a duplicate course, id and
 * all). Kept in one place so both commands stay in lock-step about which
 * child tables belong to an imported MUPO course.
 */
trait ManagesMupoCourseData
{
    /**
     * Delete every chapter/lesson/quiz/question/document row that belongs
     * to the given course, WITHOUT touching the `courses` row itself.
     */
    private function deleteCourseChildren(int $courseId): void
    {
        $lessonIds = DB::table('lessons')->where('course_id', $courseId)->pluck('id');
        if (Schema::hasTable('lesson_files') && $lessonIds->isNotEmpty()) {
            DB::table('lesson_files')->whereIn('lesson_id', $lessonIds)->delete();
        }

        $quizIds = DB::table('online_quizzes')->where('course_id', $courseId)->pluck('id');
        if ($quizIds->isNotEmpty()) {
            $questionIds = DB::table('online_exam_question_assigns')
                ->whereIn('online_exam_id', $quizIds)
                ->pluck('question_bank_id');

            DB::table('online_exam_question_assigns')->whereIn('online_exam_id', $quizIds)->delete();

            if ($questionIds->isNotEmpty()) {
                DB::table('question_bank_mu_options')->whereIn('question_bank_id', $questionIds)->delete();
                DB::table('question_banks')->whereIn('id', $questionIds)->delete();
            }

            DB::table('online_quizzes')->whereIn('id', $quizIds)->delete();
        }

        DB::table('lessons')->where('course_id', $courseId)->delete();
        DB::table('chapters')->where('course_id', $courseId)->delete();

        if (Schema::hasTable('mupo_training_documents')) {
            DB::table('mupo_training_documents')->where('course_id', $courseId)->delete();
        }
    }

    /**
     * Delete a course and all of its structured content. Only ever call
     * this for a course row that has already been positively identified as
     * a MUPO-imported duplicate — never on an arbitrary/legitimate course.
     */
    private function deleteCourseAndChildren(int $courseId): void
    {
        $this->deleteCourseChildren($courseId);
        DB::table('courses')->where('id', $courseId)->delete();
    }
}
