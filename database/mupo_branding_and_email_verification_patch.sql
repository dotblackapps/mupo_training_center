-- MUPO Training Center branding + automatic email verification patch
-- Safe to run against the current LMS database. Technical identifiers like `infixlmstheme` are not renamed.

START TRANSACTION;

UPDATE users
SET email_verified_at = COALESCE(email_verified_at, NOW()),
    email_verify = '1',
    updated_at = NOW();

UPDATE general_settings SET value='Mupo Training Center' WHERE `key`='site_title';
UPDATE general_settings SET value='Copyright © 2026 Mupo Training Center. All rights reserved | Owned by DotBlack' WHERE `key`='copyright_text';
UPDATE general_settings SET value='Copyright © 2026 Mupo Training Center. All rights reserved | Developed By DotBlack' WHERE `key`='footer_copy_right';

UPDATE login_pages SET
 title=REPLACE(REPLACE(REPLACE(REPLACE(title,'Infix Learning Management System','Mupo Training Center Learning Management System'),'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'),
 reg_title=REPLACE(REPLACE(REPLACE(REPLACE(reg_title,'Infix Learning Management System','Mupo Training Center Learning Management System'),'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'),
 forget_title=REPLACE(REPLACE(REPLACE(REPLACE(forget_title,'Infix Learning Management System','Mupo Training Center Learning Management System'),'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');

UPDATE frontend_settings SET title=REPLACE(REPLACE(REPLACE(title,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), description=REPLACE(REPLACE(REPLACE(description,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE home_contents SET value=REPLACE(REPLACE(REPLACE(value,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE about_pages SET sponsor_sub_title=REPLACE(REPLACE(REPLACE(sponsor_sub_title,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE become_instructors SET title=REPLACE(REPLACE(REPLACE(title,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), description=REPLACE(REPLACE(REPLACE(description,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE footer_categories SET title=REPLACE(REPLACE(REPLACE(title,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), description=REPLACE(REPLACE(REPLACE(description,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE footer_widgets SET name=REPLACE(REPLACE(REPLACE(name,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), description=REPLACE(REPLACE(REPLACE(description,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE front_pages SET name=REPLACE(REPLACE(REPLACE(name,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), title=REPLACE(REPLACE(REPLACE(title,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), sub_title=REPLACE(REPLACE(REPLACE(sub_title,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), details=REPLACE(REPLACE(REPLACE(details,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE popup_contents SET title=REPLACE(REPLACE(REPLACE(REPLACE(title,'Infix Learning Management System','Mupo Training Center Learning Management System'),'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), message=REPLACE(REPLACE(REPLACE(REPLACE(message,'Infix Learning Management System','Mupo Training Center Learning Management System'),'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE modules SET details=REPLACE(REPLACE(REPLACE(details,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE lms_institutes SET name='Mupo Training Center' WHERE name IN ('Infix Lms','Infix LMS','InfixLMS');
UPDATE lms_institutes SET description='Mupo Training Center' WHERE description IN ('Infix Lms','Infix LMS','InfixLMS');
UPDATE themes SET title=REPLACE(REPLACE(REPLACE(title,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center'), description=REPLACE(REPLACE(REPLACE(description,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');
UPDATE oauth_clients SET name=REPLACE(REPLACE(REPLACE(name,'InfixLMS','Mupo Training Center'),'Infix LMS','Mupo Training Center'),'Infix Lms','Mupo Training Center');

-- Remove any remaining standalone Infix brand references from user-facing content.
UPDATE frontend_settings SET title=REPLACE(title,'Infix','Mupo Training Center'), description=REPLACE(description,'Infix','Mupo Training Center');
UPDATE home_contents SET value=REPLACE(value,'Infix','Mupo Training Center');
UPDATE about_pages SET sponsor_sub_title=REPLACE(sponsor_sub_title,'Infix','Mupo Training Center');
UPDATE become_instructors SET title=REPLACE(title,'Infix','Mupo Training Center'), description=REPLACE(description,'Infix','Mupo Training Center');
UPDATE footer_categories SET title=REPLACE(title,'Infix','Mupo Training Center'), description=REPLACE(description,'Infix','Mupo Training Center');
UPDATE footer_widgets SET name=REPLACE(name,'Infix','Mupo Training Center'), description=REPLACE(description,'Infix','Mupo Training Center');
UPDATE front_pages SET name=REPLACE(name,'Infix','Mupo Training Center'), title=REPLACE(title,'Infix','Mupo Training Center'), sub_title=REPLACE(sub_title,'Infix','Mupo Training Center'), details=REPLACE(details,'Infix','Mupo Training Center');
UPDATE popup_contents SET title=REPLACE(title,'Infix','Mupo Training Center'), message=REPLACE(message,'Infix','Mupo Training Center');
UPDATE modules SET details=REPLACE(details,'Infix','Mupo Training Center');

COMMIT;
