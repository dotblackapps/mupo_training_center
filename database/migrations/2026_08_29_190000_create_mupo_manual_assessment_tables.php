<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMupoManualAssessmentTables extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('mupo_manual_assessments')) {
            Schema::create('mupo_manual_assessments', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('course_id')->index();
                $table->string('course_slug', 190)->index();
                $table->string('section_code', 10);
                $table->string('title', 255);
                $table->string('assessment_type', 80);
                $table->text('instruction')->nullable();
                $table->unsignedInteger('total_marks')->default(0);
                $table->unsignedInteger('duration_minutes')->nullable();
                $table->string('source_document', 500)->nullable();
                $table->string('memorandum_document', 500)->nullable();
                $table->longText('memorandum_text')->nullable();
                $table->boolean('active')->default(true);
                $table->timestamps();

                $table->unique(['course_id', 'section_code'], 'mupo_assessment_course_section_unique');
            });
        }

        if (!Schema::hasTable('mupo_manual_assessment_questions')) {
            Schema::create('mupo_manual_assessment_questions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('assessment_id')->index();
                $table->unsignedInteger('question_number');
                $table->string('question_type', 80)->default('manual');
                $table->string('title', 255)->nullable();
                $table->longText('scenario')->nullable();
                $table->longText('question')->nullable();
                $table->longText('parts_json')->nullable();
                $table->unsignedInteger('marks')->default(0);
                $table->unsignedInteger('position')->default(0);
                $table->timestamps();

                $table->unique(['assessment_id', 'question_number'], 'mupo_assessment_question_unique');
            });
        }

        if (!Schema::hasTable('mupo_manual_assessment_submissions')) {
            Schema::create('mupo_manual_assessment_submissions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('assessment_id')->index();
                $table->unsignedInteger('user_id')->index();
                $table->string('status', 20)->default('draft')->index();
                $table->decimal('total_score', 8, 2)->nullable();
                $table->longText('feedback')->nullable();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamp('marked_at')->nullable();
                $table->unsignedInteger('marked_by')->nullable()->index();
                $table->timestamps();

                $table->unique(['assessment_id', 'user_id'], 'mupo_assessment_submission_unique');
            });
        }

        if (!Schema::hasTable('mupo_manual_assessment_answers')) {
            Schema::create('mupo_manual_assessment_answers', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('submission_id')->index();
                $table->unsignedBigInteger('question_id')->index();
                $table->longText('answer')->nullable();
                $table->decimal('score', 8, 2)->nullable();
                $table->text('feedback')->nullable();
                $table->timestamps();

                $table->unique(['submission_id', 'question_id'], 'mupo_assessment_answer_unique');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('mupo_manual_assessment_answers');
        Schema::dropIfExists('mupo_manual_assessment_submissions');
        Schema::dropIfExists('mupo_manual_assessment_questions');
        Schema::dropIfExists('mupo_manual_assessments');
    }
}
