# HIMATIF Website Project Handoff

## Current Structure

The project now has two main surfaces:

- Public landing page: `/`
- Internal app/admin portal: `/app`

The old `/admin` panel has been removed. The active Filament panel is now the app portal.

## App Portal

Filament 5 is installed and configured through:

- `app/Providers/Filament/AppPanelProvider.php`

Panel configuration:

- Panel ID: `app`
- Path: `/app`
- Login: `/app/login`
- Brand name: `HIMATIF App`
- Brand logo: `public/assets/landing/images/logo-himatif-jgu.png`
- Favicon: `public/assets/landing/images/favicon.ico`

The old `/login` route redirects to `/app/login`.

## Admin Account

The default admin account is seeded from:

- `database/seeders/AdminAccessSeeder.php`

Credentials:

- Email: `admin@himatif-jgu.ac.id`
- Password: `AdminHimatif@2026`

## Roles

Seeded organization roles:

- `admin`
- `ketua`
- `wakil_ketua`
- `sekretaris`
- `bendahara`
- `ketua_departemen`
- `wakil_ketua_departemen`
- `anggota_divisi`
- `dosen`

The `User` model implements Filament panel access control. Only active users with one of the organization roles can access `/app`.

File:

- `app/Models/User.php`

## Permissions

Basic permissions are seeded and assigned to the `admin` role.

Examples:

- `app.access`
- `cms.view`
- `cms.create`
- `cms.update`
- `cms.delete`
- `users.view`
- `users.create`
- `users.update`
- `users.delete`
- `roles.view`
- `roles.create`
- `roles.update`
- `roles.delete`
- `permissions.view`
- `permissions.create`
- `permissions.update`
- `permissions.delete`
- `profile.update`
- `attendance.view`
- `attendance.create`
- `attendance.update`
- `attendance.delete`

## Filament Resources

All CRUD resources are page-based, not modal-based.

CMS resources:

- `LandingContentResource`
- `HistoryEntryResource`
- `FoundationContentResource`
- `TeamUnitResource`
- `LeadershipMemberResource`
- `ContactInformationResource`
- `BlogResource`
- `BlogCategoryResource`

Access management resources:

- `UserResource`
- `RoleResource`
- `PermissionResource`

Attendance resources:

- `AttendanceEventResource`
- `AttendanceRecordResource`
- `AttendanceScanner` page

Main directory:

- `app/Filament/Resources`

## CMS Models

CMS-related models:

- `app/Models/LandingContent.php`
- `app/Models/HistoryEntry.php`
- `app/Models/FoundationContent.php`
- `app/Models/TeamUnit.php`
- `app/Models/LeadershipMember.php`
- `app/Models/ContactInformation.php`

Existing blog models kept:

- `app/Models/Blog.php`
- `app/Models/BlogCategory.php`

## CMS Migrations

CMS migrations:

- `database/migrations/2026_06_12_000000_create_landing_contents_table.php`
- `database/migrations/2026_06_12_000001_create_landing_cms_tables.php`

The second migration creates:

- `history_entries`
- `foundation_contents`
- `team_units`
- `leadership_members`
- `contact_information`

## CMS Seed Data

Landing CMS data is synced from the current landing page content through:

- `database/seeders/LandingContentSeeder.php`

Seeded data:

- `landing_contents`: 2 records
  - Hero
  - About
- `history_entries`: 8 records
  - 4 FAQ entries
  - 4 journey timeline entries
- `foundation_contents`: 2 records
  - Vision
  - Mission
- `team_units`: 8 records
- `leadership_members`: 11 records
- `contact_information`: 3 records

Run seeders:

```bash
php artisan db:seed --class=AdminAccessSeeder
php artisan db:seed --class=LandingContentSeeder
```

## Landing Page Integration

The landing page is still rendered from:

- `resources/views/landingpage/pages/home.blade.php`

It now reads CMS data from the database and falls back to the old static content if no CMS data exists.

The home route loads:

- latest blogs
- landing contents
- history entries
- foundation contents
- team units
- leadership members
- contact information

Route file:

- `routes/web.php`

## Meet Our Team Detail Page

Team units on the landing page link to a detail page:

- `/team/{slug}`

View:

- `resources/views/landingpage/pages/team/show.blade.php`

Route name:

- `team.show`

## Upload Rules

Configured in Filament form fields.

Leadership member photo:

- Max size: `512 KB`
- Crop ratio: `1:1`
- Resize target: `600x600`

Team unit image:

- Max size: `512 KB`
- Resize target: `800x600`

Foundation image:

- Max size: `512 KB`
- Recommended size: `800x600`

Contact icon:

- Max size: `128 KB`
- Resize target: `128x128`

## Landing Atomic Design Structure

Landing views were reorganized into an atomic-style structure:

- `resources/views/landingpage/atoms`
- `resources/views/landingpage/molecules`
- `resources/views/landingpage/organisms`
- `resources/views/landingpage/templates`
- `resources/views/landingpage/pages`

Documentation:

- `resources/views/landingpage/README.md`

## Removed Legacy Admin

Removed old admin-related code:

- old admin controllers
- old admin Blade views
- old admin public assets
- old admin routes
- old admin dashboard/profile routes
- old attendance/admin meeting resources
- old admin-specific request classes
- old division/social/meeting models and migrations

Kept blog models and migrations because the public landing/blog still uses them.

## Attendance Module

The attendance module is available inside the app portal.

Routes:

- `/app/attendance-events`
- `/app/attendance-records`
- `/app/attendance-scanner`
- `/attendance/{token}`
- `/attendance/{token}/qr.svg`

Tables:

- `attendance_events`
- `attendance_records`

Models:

- `app/Models/AttendanceEvent.php`
- `app/Models/AttendanceRecord.php`

Migration:

- `database/migrations/2026_06_12_000002_create_attendance_tables.php`

Main behavior:

- Officers create an attendance event from `/app/attendance-events/create`.
- Each event has an auto-generated `qr_token`.
- The event edit page displays the check-in URL and QR preview.
- Public QR check-in URL: `/attendance/{token}`.
- SVG QR endpoint: `/attendance/{token}/qr.svg`.
- Logged-in users can self check-in through the QR URL.
- Officers can scan member card QR or type NIM through `/app/attendance-scanner`.
- Scanner extracts NIM from payload formats like `nim=...`, `student_number=...`, or raw NIM text.

Database naming uses English fields:

- `student_number`
- `activity_type`
- `starts_at`
- `ends_at`
- `check_in_opens_at`
- `check_in_closes_at`
- `assigned_to`
- `checked_in_at`
- `checked_in_by`

Attendance permissions seeded:

- `attendance.view`
- `attendance.create`
- `attendance.update`
- `attendance.delete`
- `attendance.scan`
- `attendance.export`

The old membership migration was adjusted so fresh installs use English user field names directly:

- `student_number`
- `batch_year`

The follow-up migration still supports old databases by renaming legacy `nim` and `angkatan` if they exist.

## Validation Already Run

Successful:

```bash
php artisan migrate
php artisan db:seed --class=AdminAccessSeeder
php artisan db:seed --class=LandingContentSeeder
php artisan view:cache
php artisan route:list --path=app
php artisan route:list --path=attendance
php artisan test tests\Unit\ExampleTest.php
```

Known environment warning:

Pest may warn that it cannot write to:

```text
vendor/pestphp/pest/.temp/test-results
```

The test still passes. This appears to be a local filesystem permission issue, not an application failure.

## Next Recommended Work

Suggested next steps:

- Add authorization checks per resource using permissions.
- Build the attendance/presensi module inside `/app`.
- Add dashboard widgets for CMS counts, member counts, and latest activity.
- Move more static landing copy into CMS if needed.
- Add request validation or policies for each CMS model.
- Add feature tests for app login and resource access.
