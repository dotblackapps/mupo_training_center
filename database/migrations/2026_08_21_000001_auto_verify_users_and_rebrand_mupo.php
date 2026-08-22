<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AutoVerifyUsersAndRebrandMupo extends Migration
{
    public function up()
    {
        // Existing accounts: mark email as verified without requiring a verification email.
        if (Schema::hasTable('users')) {
            DB::table('users')->whereNull('email_verified_at')->update([
                'email_verified_at' => now(),
                'email_verify' => '1',
                'updated_at' => now(),
            ]);
            DB::table('users')->where('email_verify', '!=', '1')->orWhereNull('email_verify')->update([
                'email_verify' => '1',
                'updated_at' => now(),
            ]);
        }

        // Current database branding. Technical identifiers such as `infixlmstheme` are intentionally preserved.
        if (Schema::hasTable('general_settings')) {
            DB::table('general_settings')->where('key', 'site_title')->update(['value' => 'Mupo Training Center']);
            DB::table('general_settings')->where('key', 'copyright_text')->update(['value' => 'Copyright © 2026 Mupo Training Center. All rights reserved | Owned by DotBlack']);
            DB::table('general_settings')->where('key', 'footer_copy_right')->update(['value' => 'Copyright © 2026 Mupo Training Center. All rights reserved | Developed By DotBlack']);
        }

        $replaceColumns = function ($table, array $columns) {
            if (!Schema::hasTable($table)) return;
            foreach ($columns as $column) {
                if (!Schema::hasColumn($table, $column)) continue;
                DB::table($table)->update([
                    $column => DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(`{$column}`, 'Infix Learning Management System', 'Mupo Training Center Learning Management System'), 'InfixLMS', 'Mupo Training Center'), 'Infix LMS', 'Mupo Training Center'), 'Infix Lms', 'Mupo Training Center'), 'Infix', 'Mupo Training Center')")
                ]);
            }
        };

        $replaceColumns('login_pages', ['title','slogans1','slogans2','slogans3','reg_title','reg_slogans1','reg_slogans2','reg_slogans3','forget_title','forget_slogans1','forget_slogans2','forget_slogans3']);
        $replaceColumns('frontend_settings', ['title','description','btn_name']);
        $replaceColumns('home_contents', ['value']);
        $replaceColumns('about_pages', ['who_we_are','banner_title','story_title','story_description','teacher_title','teacher_details','course_title','course_details','student_title','student_details','about_page_content_title','about_page_content_details','live_class_title','live_class_details','sponsor_title','sponsor_sub_title','registered_students','questions_answers','quality_content','our_mission','our_vision','about_page_content_details2']);
        $replaceColumns('become_instructors', ['section','title','description','btn_name']);
        $replaceColumns('footer_categories', ['title','description','placeholder']);
        $replaceColumns('footer_widgets', ['name','description']);
        $replaceColumns('front_pages', ['name','title','sub_title','details']);
        $replaceColumns('popup_contents', ['title','message','btn_txt']);
        $replaceColumns('modules', ['details']);

        if (Schema::hasTable('lms_institutes')) {
            DB::table('lms_institutes')->whereIn('name', ['Infix Lms','Infix LMS','InfixLMS'])->update(['name' => 'Mupo Training Center']);
            DB::table('lms_institutes')->whereIn('description', ['Infix Lms','Infix LMS','InfixLMS'])->update(['description' => 'Mupo Training Center']);
        }

        if (Schema::hasTable('themes')) {
            // Keep `name` and `folder_path` unchanged because they are technical theme identifiers.
            DB::table('themes')->update([
                'title' => DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(`title`, 'InfixLMS', 'Mupo Training Center'), 'Infix LMS', 'Mupo Training Center'), 'Infix Lms', 'Mupo Training Center'), 'Infix', 'Mupo Training Center')"),
                'description' => DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(`description`, 'InfixLMS', 'Mupo Training Center'), 'Infix LMS', 'Mupo Training Center'), 'Infix Lms', 'Mupo Training Center'), 'Infix', 'Mupo Training Center')"),
            ]);
        }

        if (Schema::hasTable('oauth_clients')) {
            DB::table('oauth_clients')->update([
                'name' => DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(`name`, 'InfixLMS', 'Mupo Training Center'), 'Infix LMS', 'Mupo Training Center'), 'Infix Lms', 'Mupo Training Center'), 'Infix', 'Mupo Training Center')")
            ]);
        }
    }

    public function down()
    {
        // Intentionally not reversed: email verification and production branding are data corrections.
    }
}
