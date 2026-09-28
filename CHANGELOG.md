# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Added
- **Base Tailwind Public Design System**:
  - Implemented sleek modern public aesthetics referencing Base Tailwind across public interfaces (`layouts/public.blade.php`, `home.blade.php`, `kalender.blade.php`, `agenda.blade.php`, and subpages).
  - Modern sticky header with translucent backdrop-blur, subtle borders, high contrast active indicators, and dynamic CTA button.
  - Interactive 3-column Agenda & Calendar page (`public/pages/agenda.blade.php`) matching the requested reference:
    - Left column: interactive Alpine.js calendar navigator (month/year picker, date selection with active events dots indicator, quick category filter pills, academic calendar banner).
    - Right column: featured events hero cards and horizontal event cards with thumbnail cover, date badges, real-time client-side search, and status tags.
  - Redesigned `kalender.blade.php` academic calendar page with PDF/image viewer cards and modern timeline lists.
  - Passing `allAgenda` and `featuredAgenda` in `PageController@agenda` to support calendar interactivity.
- Added slug field generation in `TenantController@store` when registering a new tenant.
- Added `slug` property for `Sekolah` tests.
- Implemented modern UI/UX grid card layout on the public `jurusan` page.
- Added Alpine.js lightbox component and micro-interactions on the public `galeri` page.
- Added hover transform and shadow animations to article cards on the public `berita` page.
- Added seeding for `pengguna` (admin and operator accounts) in `TenantSmkn2BandungSeeder`.
- Configured single-tenant setup for SMK Negeri 2 Bandung across Central, Tenant Admin, and Public interfaces.

### Database & Migrations
- Initialized central database `website_sekolah_central` with Super Admin and SMK Negeri 2 Bandung.
- Initialized tenant database `tenant_smk_negeri_2_bandung` with complete schema (20 tables) and official school data.

### Fixed
- Fixed a SQL error in `SuperAdminAuthTest` causing tests to fail when trying to insert records without a default `slug`.
- Fixed `TenantController@store` failing when creating tenants without passing a generated slug.

### Removed
- Removed obsolete `ExampleTest.php` that was testing the root `/` endpoint which was removed/changed due to multi-tenancy URL structure.
