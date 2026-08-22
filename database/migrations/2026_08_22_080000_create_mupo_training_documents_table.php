<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('mupo_training_documents')) {
            Schema::create('mupo_training_documents', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('course_id')->nullable()->index();
                $table->string('title');
                $table->string('document_type')->nullable();
                $table->string('audience', 30)->default('staff')->index();
                $table->string('version')->nullable();
                $table->string('original_filename');
                $table->text('storage_path');
                $table->boolean('active')->default(true);
                $table->unsignedInteger('uploaded_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('mupo_training_documents');
    }
};
