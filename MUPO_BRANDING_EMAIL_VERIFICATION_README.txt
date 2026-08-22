MUPO Training Center branding and email-verification update

Changes made:
- Replaced visible Infix LMS/InfixLMS/Infix Learning Management System branding in Blade views and safe application defaults.
- Preserved technical identifiers such as the `infixlmstheme` folder/theme name so routes/theme loading do not break.
- New self-registered users are explicitly auto-verified in RegisterController (email_verified_at=now, email_verify=1).
- Added migration to mark all existing users as verified and clean branding stored in the database.
- Added an SQL patch for immediate database execution.
- Added a rebranded copy of the supplied SQL dump for future imports.

After copying files run:
php artisan optimize:clear
php artisan migrate --force
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

Verification checks:
php artisan tinker --execute='dump(DB::table("users")->whereNull("email_verified_at")->count());'
Expected: 0

Branding check example:
grep -RIn --exclude-dir=vendor --exclude-dir=node_modules -E "InfixLMS|Infix LMS|Infix Learning Management System" resources/views Modules/*/Resources/views config/app.php config/pdf.php
