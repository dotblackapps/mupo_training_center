<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /*
         * InfixLMS changed general_settings from a normal column-based table
         * to a key/value table in later migrations. Support BOTH schemas so
         * this migration works on older dumps and the current application DB.
         */
        if (Schema::hasTable('general_settings')) {
            $columns = Schema::getColumnListing('general_settings');

            if (in_array('key', $columns, true) && in_array('value', $columns, true)) {
                $settings = [
                    'site_title' => 'Mupo Training Center',
                    'logo' => 'public/mupo/assets/images/mupo-logo_1.jpeg',
                    'logo2' => 'public/mupo/assets/images/mupo-logo_1.jpeg',
                    'favicon' => 'public/mupo/assets/images/mupo-logo_1.jpeg',
                    'copyright_text' => 'Copyright © 2026 Mupo Training Center. All rights reserved',
                ];

                foreach ($settings as $key => $value) {
                    DB::table('general_settings')->updateOrInsert(
                        ['key' => $key],
                        ['value' => $value, 'updated_at' => now(), 'created_at' => now()]
                    );
                }
            } else {
                // Legacy column-based general_settings schema.
                $update = [];
                $legacySettings = [
                    'site_title' => 'Mupo Training Center',
                    'logo' => 'public/mupo/assets/images/mupo-logo_1.jpeg',
                    'logo2' => 'public/mupo/assets/images/mupo-logo_1.jpeg',
                    'favicon' => 'public/mupo/assets/images/mupo-logo_1.jpeg',
                    'copyright_text' => 'Copyright © 2026 Mupo Training Center. All rights reserved',
                ];

                foreach ($legacySettings as $column => $value) {
                    if (Schema::hasColumn('general_settings', $column)) {
                        $update[$column] = $value;
                    }
                }

                if (!empty($update)) {
                    DB::table('general_settings')->update($update);
                }
            }
        }

        $tables = [
            'login_pages',
            'home_contents',
            'about_pages',
            'front_pages',
            'frontend_settings',
            'footer_settings',
            'footer_widgets',
            'popup_contents',
            'lms_institutes',
        ];

        $replacements = [
            'Infix Learning Management System' => 'Mupo Training Center',
            'InfixLMS' => 'Mupo Training Center',
            'Infix LMS' => 'Mupo Training Center',
            'Infix Lms' => 'Mupo Training Center',
        ];

        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            foreach (Schema::getColumnListing($table) as $column) {
                foreach ($replacements as $from => $to) {
                    try {
                        DB::table($table)
                            ->where($column, 'like', "%{$from}%")
                            ->update([
                                $column => DB::raw(
                                    "REPLACE(`{$column}`, " .
                                    DB::getPdo()->quote($from) . ', ' .
                                    DB::getPdo()->quote($to) . ')'
                                ),
                            ]);
                    } catch (\Throwable $e) {
                        // Ignore numeric/binary/JSON columns that cannot use LIKE/REPLACE.
                    }
                }
            }
        }
    }

    public function down(): void
    {
        // Branding migration is intentionally non-reversible.
    }
};
