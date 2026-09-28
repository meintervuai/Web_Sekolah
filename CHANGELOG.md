# Changelog

All notable changes to this project will be documented in this file.

## [Unreleased]

### Added
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
