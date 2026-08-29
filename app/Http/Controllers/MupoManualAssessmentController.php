<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MupoManualAssessmentController extends Controller
{
    public function show($id)
    {
        $this->ensureTables();
        $assessment = DB::table('mupo_manual_assessments')->where('id', $id)->where('active', 1)->first();
        abort_unless($assessment, 404);
        $this->authoriseLearner($assessment);

        $questions = DB::table('mupo_manual_assessment_questions')
            ->where('assessment_id', $assessment->id)
            ->orderBy('position')
            ->orderBy('question_number')
            ->get();

        $submission = DB::table('mupo_manual_assessment_submissions')
            ->where('assessment_id', $assessment->id)
            ->where('user_id', Auth::id())
            ->first();

        $answers = collect();
        if ($submission) {
            $answers = DB::table('mupo_manual_assessment_answers')
                ->where('submission_id', $submission->id)
                ->get()
                ->keyBy('question_id');
        }

        $course = DB::table('courses')->where('id', $assessment->course_id)->first();

        return view('frontend.infixlmstheme.pages.mupo_manual_assessment', compact(
            'assessment', 'questions', 'submission', 'answers', 'course'
        ));
    }

    public function save(Request $request, $id)
    {
        $this->ensureTables();
        $assessment = DB::table('mupo_manual_assessments')->where('id', $id)->where('active', 1)->first();
        abort_unless($assessment, 404);
        $this->authoriseLearner($assessment);

        $action = $request->input('action') === 'submit' ? 'submit' : 'draft';
        $questions = DB::table('mupo_manual_assessment_questions')
            ->where('assessment_id', $assessment->id)
            ->orderBy('position')
            ->get();

        if ($action === 'submit') {
            foreach ($questions as $question) {
                $request->validate([
                    'answers.'.$question->id => ['required', 'string'],
                ], [
                    'answers.'.$question->id.'.required' => 'Please answer question '.$question->question_number.' before submitting.',
                ]);
            }
        }

        DB::transaction(function () use ($request, $assessment, $questions, $action) {
            $existing = DB::table('mupo_manual_assessment_submissions')
                ->where('assessment_id', $assessment->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existing && $existing->status === 'marked') {
                abort(422, 'This assessment has already been marked and can no longer be changed.');
            }

            if ($existing) {
                $submissionId = $existing->id;
                DB::table('mupo_manual_assessment_submissions')->where('id', $submissionId)->update([
                    'status' => $action === 'submit' ? 'submitted' : 'draft',
                    'submitted_at' => $action === 'submit' ? now() : $existing->submitted_at,
                    'updated_at' => now(),
                ]);
            } else {
                $submissionId = DB::table('mupo_manual_assessment_submissions')->insertGetId([
                    'assessment_id' => $assessment->id,
                    'user_id' => Auth::id(),
                    'status' => $action === 'submit' ? 'submitted' : 'draft',
                    'submitted_at' => $action === 'submit' ? now() : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            foreach ($questions as $question) {
                $answer = trim((string) $request->input('answers.'.$question->id, ''));
                DB::table('mupo_manual_assessment_answers')->updateOrInsert(
                    ['submission_id' => $submissionId, 'question_id' => $question->id],
                    ['answer' => $answer, 'updated_at' => now(), 'created_at' => now()]
                );
            }
        });

        return redirect()->route('mupo.assessment.show', $assessment->id)
            ->with('success', $action === 'submit'
                ? 'Your assessment has been submitted for manual marking.'
                : 'Your assessment draft has been saved.');
    }

    public function adminIndex()
    {
        $this->ensureTables();
        $submissions = DB::table('mupo_manual_assessment_submissions as s')
            ->join('mupo_manual_assessments as a', 'a.id', '=', 's.assessment_id')
            ->join('users as u', 'u.id', '=', 's.user_id')
            ->leftJoin('courses as c', 'c.id', '=', 'a.course_id')
            ->select('s.*', 'a.title as assessment_title', 'a.section_code', 'a.total_marks', 'u.name as learner_name', 'u.email as learner_email', 'c.title as course_title')
            ->orderByRaw("FIELD(s.status, 'submitted', 'draft', 'marked')")
            ->orderByDesc('s.updated_at')
            ->get();

        return view('admin.mupo_training_manuals.assessments', compact('submissions'));
    }

    public function adminShow($id)
    {
        $this->ensureTables();
        $submission = DB::table('mupo_manual_assessment_submissions as s')
            ->join('mupo_manual_assessments as a', 'a.id', '=', 's.assessment_id')
            ->join('users as u', 'u.id', '=', 's.user_id')
            ->leftJoin('courses as c', 'c.id', '=', 'a.course_id')
            ->where('s.id', $id)
            ->select('s.*', 'a.title as assessment_title', 'a.section_code', 'a.total_marks', 'a.instruction', 'a.memorandum_text', 'a.memorandum_document', 'a.source_document', 'u.name as learner_name', 'u.email as learner_email', 'c.title as course_title')
            ->first();
        abort_unless($submission, 404);

        $questions = DB::table('mupo_manual_assessment_questions as q')
            ->leftJoin('mupo_manual_assessment_answers as ans', function ($join) use ($submission) {
                $join->on('ans.question_id', '=', 'q.id')->where('ans.submission_id', '=', $submission->id);
            })
            ->where('q.assessment_id', $submission->assessment_id)
            ->orderBy('q.position')
            ->select('q.*', 'ans.answer', 'ans.score', 'ans.feedback as answer_feedback')
            ->get();

        return view('admin.mupo_training_manuals.assessment_submission', compact('submission', 'questions'));
    }

    public function grade(Request $request, $id)
    {
        $this->ensureTables();
        $submission = DB::table('mupo_manual_assessment_submissions')->where('id', $id)->first();
        abort_unless($submission, 404);

        $questions = DB::table('mupo_manual_assessment_questions')
            ->where('assessment_id', $submission->assessment_id)
            ->orderBy('position')
            ->get();

        $total = 0;
        DB::transaction(function () use ($request, $submission, $questions, &$total) {
            foreach ($questions as $question) {
                $score = (float) $request->input('scores.'.$question->id, 0);
                if ($score < 0 || $score > (float) $question->marks) {
                    abort(422, 'Score for question '.$question->question_number.' must be between 0 and '.$question->marks.'.');
                }
                $total += $score;

                DB::table('mupo_manual_assessment_answers')
                    ->where('submission_id', $submission->id)
                    ->where('question_id', $question->id)
                    ->update([
                        'score' => $score,
                        'feedback' => $request->input('answer_feedback.'.$question->id),
                        'updated_at' => now(),
                    ]);
            }

            DB::table('mupo_manual_assessment_submissions')->where('id', $submission->id)->update([
                'status' => 'marked',
                'total_score' => $total,
                'feedback' => $request->input('feedback'),
                'marked_at' => now(),
                'marked_by' => Auth::id(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('admin.mupo-assessments.show', $submission->id)
            ->with('success', 'Assessment marked successfully.');
    }

    private function authoriseLearner($assessment): void
    {
        $user = Auth::user();
        abort_unless($user, 403);

        if ((int) $user->role_id === 1) {
            return;
        }

        $enrolled = DB::table('course_enrolleds')
            ->where('user_id', $user->id)
            ->where('course_id', $assessment->course_id)
            ->where('status', 1)
            ->exists();

        abort_unless($enrolled, 403, 'You must be enrolled in this course to access the assessment.');
    }

    private function ensureTables(): void
    {
        abort_unless(
            Schema::hasTable('mupo_manual_assessments') &&
            Schema::hasTable('mupo_manual_assessment_questions') &&
            Schema::hasTable('mupo_manual_assessment_submissions') &&
            Schema::hasTable('mupo_manual_assessment_answers'),
            503,
            'MUPO manual assessment tables are not installed. Run php artisan migrate.'
        );
    }
}
