<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MUPO policy: all existing accounts are verified and active for LMS access.
        if (Schema::hasTable('users')) {
            $userUpdates = [];
            if (Schema::hasColumn('users', 'email_verified_at')) {
                DB::table('users')->whereNull('email_verified_at')->update(['email_verified_at' => now()]);
            }
            if (Schema::hasColumn('users', 'email_verify')) {
                DB::table('users')->where(function ($q) {
                    $q->whereNull('email_verify')->orWhere('email_verify', '!=', '1');
                })->update(['email_verify' => '1']);
            }
            if (Schema::hasColumn('users', 'status')) $userUpdates['status'] = 1;
            if (Schema::hasColumn('users', 'is_active')) $userUpdates['is_active'] = 1;
            if ($userUpdates) DB::table('users')->update($userUpdates);
        }

        // Correct the two imported MUPO course records for the native LMS expectations.
        if (Schema::hasTable('courses')) {
            $courseFixes = [
                'psira-grade-e-d-c-security-training' => 1920,
                'national-key-point-security-training' => 900,
            ];
            foreach ($courseFixes as $slug => $minutes) {
                $update = ['duration' => $minutes, 'updated_at' => now()];
                if (Schema::hasColumn('courses', 'image')) $update['image'] = 'mupo/assets/images/bulb.jpg';
                if (Schema::hasColumn('courses', 'thumbnail')) $update['thumbnail'] = 'mupo/assets/images/bulb.jpg';
                DB::table('courses')->where('slug', $slug)->update($update);
            }
        }

        // Imported manual content is stored in `editor`; therefore it must use the Editor host.
        if (Schema::hasTable('lessons') && Schema::hasColumn('lessons', 'host') && Schema::hasColumn('lessons', 'editor')) {
            DB::table('lessons')
                ->where('description', 'MUPO structured learning content from the approved course manual.')
                ->whereNotNull('editor')
                ->where('editor', '!=', '')
                ->update(['host' => 'Editor', 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        // Intentionally non-destructive: do not unverify users or remove imported learning content.
    }
};
