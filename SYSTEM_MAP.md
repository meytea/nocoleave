# Project Summary

- **Tujuan sistem**: Sistem pengajuan cuti karyawan berbasis web bernama NocoLeave untuk PT Nocola IoT Solution.
- **Tech stack**: Laravel 12, PHP 8.3, MySQL, Blade, Tailwind CSS, Alpine.js, Laravel Breeze, Spatie Laravel Permission.
- **Arsitektur Laravel**: MVC per-role dengan Eloquent ORM, middleware auth, role-based access Spatie Permission.
- **Status**: **WORKFLOW APPROVAL FULLY IMPLEMENTED** - Pengajuan & approval cuti untuk semua role sudah operasional.
- **Refactoring**: Controller diorganisir per-role (Hrd/, Karyawan/, Lead/, Head/, Direktur/) dengan workflow approval lengkap.

# Core Logic Flow

## Authentication & Profile
- **Login**: Route GET/POST `/login` -> `AuthenticatedSessionController[create/store]` -> `User` model.
- **Profile**: Route GET/PATCH/DELETE `/profile` -> `ProfileController` -> update user data.

## Role-Based Dashboards
- **Karyawan**: Route GET `/karyawan/dashboard` -> `Karyawan\DashboardController@index`.
- **Lead**: Route GET `/lead/dashboard` -> `Lead\DashboardController@index`.
- **Head**: Route GET `/head/dashboard` -> `Head\DashboardController@index`.
- **HRD**: Route GET `/hrd/dashboard` -> `Hrd\DashboardController@index`.
- **Direktur**: Route GET `/direktur/dashboard` -> `Direktur\DashboardController@index`.

## Karyawan - Pengajuan Cuti
- **List pengajuan**: Route GET `/karyawan/pengajuan_cuti` -> `Karyawan\PengajuanCutiController@index` -> list ajuan milik karyawan.
- **Create pengajuan**: Route GET/POST `/karyawan/pengajuan_cuti/create` -> form & store -> `PengajuanCuti` table, status `pending_lead`.
- **Filter pengajuan**: GET `/karyawan/pengajuan_cuti/disetujui`, `/karyawan/pengajuan_cuti/ditolak` -> list filter by status.
- **Detail pengajuan**: Route GET `/karyawan/pengajuan_cuti/{id}` -> show detail + approval history via `RiwayatApprovalController`.

## Lead - Pengajuan & Approval
- **List karyawan**: Route GET `/lead/karyawan` -> `Lead\KaryawanController@index` -> list tim karyawan.
- **List pengajuan**: Route GET `/lead/pengajuan_cuti` -> `Lead\PengajuanCutiController@index` -> list pending approval.
- **Filter pengajuan**: GET `/lead/pengajuan_cuti/disetujui`, `/ditolak` -> list by status.
- **Detail pengajuan**: Route GET `/lead/pengajuan_cuti/{id}` -> show detail.
- **Approval list**: Route GET `/lead/approval_cuti` -> `Lead\ApprovalCutiController@index` -> list untuk di-approve.
- **Filter approval**: GET `/lead/approval_cuti/pengajuan/disetujui`, `/ditolak`.
- **Approve action**: Route POST `/lead/approval_cuti/{id}/setuju` -> update status + create approval_cuti record.
- **Reject action**: Route POST `/lead/approval_cuti/{id}/tolak` -> update status ditolak + alasan penolakan.

## Head - Pengajuan & Approval
- **List karyawan**: Route GET `/head/karyawan` -> `Head\KaryawanController@index` (via `Hrd\HeadController`).
- **List pengajuan**: Route GET `/head/pengajuan_cuti` -> `Head\PengajuanCutiController@index`.
- **Filter pengajuan**: GET `/head/pengajuan_cuti/disetujui`, `/ditolak`.
- **Approval list**: Route GET `/head/approval_cuti` -> `Head\ApprovalCutiController@index`.
- **Filter approval**: GET `/head/approval_cuti/pengajuan/disetujui`, `/ditolak`.
- **Approve action**: Route POST `/head/approval_cuti/{id}/setuju`.
- **Reject action**: Route POST `/head/approval_cuti/{id}/tolak`.

## HRD - Master Data & Full Workflow
- **Dashboard**: Route GET `/hrd/dashboard` -> overview.
- **Master divisi**: Resource route `/hrd/divisi` -> `Hrd\DivisiController` (CRUD).
- **Master karyawan**: Resource route `/hrd/karyawan` -> `Hrd\KaryawanController` (CRUD + role assign).
- **Master jenis cuti**: Resource route `/hrd/jenis_cuti` -> `Hrd\JenisCutiController` (CRUD).
- **Master hak cuti**: Resource route `/hrd/hak_cuti` -> `Hrd\HakCutiController` (CRUD).
- **Master head/supervisor**: Resource route `/hrd/head` -> `Hrd\HeadController` (CRUD).
- **List pengajuan cuti**: Route GET `/hrd/pengajuan_cuti` -> `Hrd\PengajuanCutiController@index` -> all pengajuan.
- **Filter pengajuan**: GET `/hrd/pengajuan_cuti/disetujui`, `/ditolak`.
- **Detail pengajuan**: Route GET `/hrd/pengajuan_cuti/{id}`.
- **Approval list**: Route GET `/hrd/approval_cuti` -> `Hrd\ApprovalCutiController@index`.
- **Filter approval**: GET `/hrd/approval_cuti/pengajuan/disetujui`, `/ditolak`.
- **Approve action**: Route POST `/hrd/approval_cuti/{id}/setuju`.
- **Reject action**: Route POST `/hrd/approval_cuti/{id}/tolak`.
- **History cuti**: Route GET `/hrd/riwayat_cuti` -> `Hrd\RiwayatCutiController@index` -> riwayat approval cuti.
- **History approval**: Route GET `/hrd/riwayat_approval` -> `Hrd\RiwayatApprovalController@index` -> audit trail approval.

## Direktur - Approval (Placeholder)
- **Dashboard**: Route GET `/direktur/dashboard` -> view only.
- **Approval workflow**: Belum terintegrasi (route belum ada).

# Database Structure

- **users**: id, name, foto, email, password, nik, jenis_kelamin, divisi_id, is_active, timestamps, soft deletes. Relasi: `belongsTo(Divisi)`, `hasMany(PengajuanCuti)`, `hasMany(HakCuti)`, `hasMany(ApprovalCuti)`.
- **divisi**: id, nama_divisi, timestamps. Relasi: `hasMany(User)`.
- **jenis_cuti**: id, nama_cuti, kode_cuti, kuota, is_tahunan, keterangan, timestamps. Relasi: `hasMany(HakCuti)`, `hasMany(PengajuanCuti)`.
- **hak_cuti**: id, user_id, jenis_cuti_id, tahun, jatah, terpakai, sisa, timestamps. Relasi: `belongsTo(User)`, `belongsTo(JenisCuti)`.
- **pengajuan_cuti**: id, kode_pengajuan, user_id, jenis_cuti_id, tanggal_mulai, tanggal_selesai, tanggal_masuk, jumlah_hari, alasan, status (pending_lead, pending_hrd, pending_head, pending_direktur, disetujui, ditolak), current_approver_id, ditolak_oleh, alasan_penolakan, approved_at, timestamps, soft deletes. Relasi: `belongsTo(User)`, `belongsTo(JenisCuti)`, `hasMany(ApprovalCuti)`.
- **approval_cuti**: id, pengajuan_cuti_id, approver_id, level_approval, status (approved/rejected), catatan, approved_at, timestamps, soft deletes. Relasi: `belongsTo(PengajuanCuti)`, `belongsTo(User)`.

# Role & Permission Map

- **Role**: `karyawan`, `lead`, `head`, `hrd`, `direktur`.
- **Authorization**: Spatie Permission + middleware `role:[role]` di setiap route group.

## Privileges per Role
- **Karyawan**: 
  - Create/view pengajuan cuti sendiri.
  - View history approval pengajuan.
  - Filter: disetujui, ditolak.
  
- **Lead**:
  - View tim karyawan di divisi.
  - List pengajuan cuti dari karyawan tim.
  - Approve/reject pengajuan (level 1).
  - Filter pengajuan: disetujui, ditolak.
  
- **Head**:
  - View tim karyawan.
  - List pengajuan cuti untuk approval (level 3).
  - Approve/reject pengajuan.
  - Filter pengajuan: disetujui, ditolak.
  
- **HRD**:
  - Master data: divisi, karyawan, jenis cuti, hak cuti, head/supervisor.
  - Assign role ke karyawan.
  - List semua pengajuan cuti.
  - Approve/reject pengajuan (level 2).
  - View history cuti dan approval.
  - Filter pengajuan: disetujui, ditolak.
  
- **Direktur**:
  - Dashboard view (approval workflow belum terintegrasi).

# Module Map

## Routes
- `routes/web.php`: Guest welcome, auth (login/register/reset), profile, role-based dashboard, workflow routes per role.
- `routes/auth.php`: Laravel Breeze auth standard.

## Controllers (Role-based Structure)

### Karyawan/
- `DashboardController.php`: Karyawan dashboard view.
- `PengajuanCutiController.php`: Create pengajuan; list milik sendiri.
- `RiwayatApprovalController.php`: View history approval pengajuan.

### Lead/
- `DashboardController.php`: Lead dashboard view.
- `KaryawanController.php`: View karyawan di tim lead.
- `PengajuanCutiController.php`: List pengajuan pending approval; filter disetujui/ditolak; show detail.
- `ApprovalCutiController.php`: Index approval list; setuju/tolak action.

### Head/
- `DashboardController.php`: Head dashboard view.
- `KaryawanController.php`: View karyawan di bawah head (via Hrd\HeadController).
- `PengajuanCutiController.php`: List pengajuan; filter; show detail.
- `ApprovalCutiController.php`: Index approval; setuju/tolak action.

### HRD/
- `DashboardController.php`: HRD dashboard view.
- `DivisiController.php`: CRUD divisi.
- `KaryawanController.php`: CRUD karyawan + role assign.
- `JenisCutiController.php`: CRUD jenis cuti.
- `HakCutiController.php`: CRUD hak cuti.
- `HeadController.php`: CRUD head/supervisor.
- `PengajuanCutiController.php`: List all pengajuan; filter; show detail.
- `ApprovalCutiController.php`: Index approval; setuju/tolak action.
- `RiwayatCutiController.php`: View history cuti.
- `RiwayatApprovalController.php`: View history approval (audit trail).

### Direktur/
- `DashboardController.php`: Direktur dashboard view.

### Standalone
- `ProfileController.php`: Edit/update user profile.

## Models
- `User.php`: `HasRoles`, relasi Divisi, PengajuanCuti, HakCuti, ApprovalCuti.
- `Divisi.php`: relasi `hasMany(User)`.
- `JenisCuti.php`: relasi `hasMany(HakCuti)`, `hasMany(PengajuanCuti)`.
- `HakCuti.php`: relasi `belongsTo(User)`, `belongsTo(JenisCuti)`.
- `PengajuanCuti.php`: relasi `belongsTo(User)`, `belongsTo(JenisCuti)`, `hasMany(ApprovalCuti)`.
- `ApprovalCuti.php`: relasi `belongsTo(PengajuanCuti)`, `belongsTo(User)`.
- `Jabatan.php`: kosong, belum diintegrasikan.

## Seeders
- `RoleSeeder.php`: Seed 5 role (karyawan, lead, head, hrd, direktur).
- `AdminSeeder.php`: Seed admin HRD (admin@nocoleave.com).
- `DivisiSeeder.php`: Seed 10 divisi.
- `JenisCutiSeeder.php`: Seed 9 jenis cuti.
- `HakCutiSeeder.php`: Seed hak cuti per user (NEW).
- `DatabaseSeeder.php`: Call semua seeder.

## Views (Role-based Structure)
### Karyawan/
- `dashboard.blade.php`: Karyawan dashboard.
- `pengajuan_cuti/`: index, create, show.
- `riwayat_approval/`: index (history approval).

### Lead/
- `dashboard.blade.php`: Lead dashboard.
- `karyawan/`: index (list tim).
- `pengajuan_cuti/`: index, show, filter views.
- `approval_cuti/`: index (approval list).

### Head/
- `dashboard.blade.php`: Head dashboard.
- `karyawan/`: index (list tim).
- `pengajuan_cuti/`: index, show, filter views.
- `approval_cuti/`: index (approval list).

### HRD/
- `dashboard.blade.php`: HRD dashboard.
- `divisi/`: index, create, edit.
- `karyawan/`: index, create, edit.
- `jenis_cuti/`: index, create, edit.
- `hak_cuti/`: index, create, edit.
- `head/`: index, create, edit.
- `pengajuan_cuti/`: index, show, filter views.
- `approval_cuti/`: index (approval list).
- `riwayat_cuti/`: index.
- `riwayat_approval/`: index (audit trail).

### Direktur/
- `dashboard.blade.php`: Direktur dashboard view.

### Standard
- `auth/`: login, register, password reset (Breeze).
- `profile/`: edit (standard Breeze).
- `layouts/app.blade.php`: Main layout.
- `welcome.blade.php`: Landing page.

# Workflow Approval Map

**Flow Status Pengajuan:**
1. Karyawan ajukan cuti (POST `/karyawan/pengajuan_cuti`) -> `status: pending_lead`, `current_approver_id: lead_id`.
2. Lead approve (POST `/lead/approval_cuti/{id}/setuju`) -> `status: pending_hrd`, `current_approver_id: hrd_id`, create ApprovalCuti record.
3. Lead reject (POST `/lead/approval_cuti/{id}/tolak`) -> `status: ditolak`, `ditolak_oleh: lead_id`, alasan.
4. HRD approve (POST `/hrd/approval_cuti/{id}/setuju`) -> `status: pending_head`, `current_approver_id: head_id`.
5. HRD reject -> `status: ditolak`, `ditolak_oleh: hrd_id`.
6. Head approve (POST `/head/approval_cuti/{id}/setuju`) -> `status: pending_direktur`, `current_approver_id: direktur_id`.
7. Head reject -> `status: ditolak`, `ditolak_oleh: head_id`.
8. Direktur approve -> `status: disetujui`, `approved_at: now`.
9. Direktur reject -> `status: ditolak`, `ditolak_oleh: direktur_id`.

**Approval Tracking:**
- Setiap approval action create record di `ApprovalCuti` table (level_approval, status, catatan, approver_id).
- History dapat dilihat di `RiwayatApprovalController` (karyawan) atau `HrdRiwayatApprovalController` (HRD).

# Implementation Status

## ? COMPLETE
- Role-based dashboard untuk semua role.
- Master data HRD (divisi, karyawan, jenis_cuti, hak_cuti, head).
- Karyawan pengajuan cuti & view riwayat.
- Lead approval workflow (view karyawan, list pengajuan, approve/reject).
- Head approval workflow (approve/reject).
- HRD full workflow (list, approve/reject, history).
- History tracking & audit trail.

## ?? PENDING / INCOMPLETE
- Direktur approval route & action (dashboard only).
- Email notification untuk approval action.
- Batch approval/rejection.
- Advanced filtering & export.
- Automatic status update ke next approver (mungkin perlu delay atau email trigger).

# Clean Tree

```
app/Http/Controllers/
  Auth/
    AuthenticatedSessionController.php
    ConfirmablePasswordController.php
    EmailVerificationNotificationController.php
    EmailVerificationPromptController.php
    NewPasswordController.php
    PasswordController.php
    PasswordResetLinkController.php
    RegisteredUserController.php
    VerifyEmailController.php
  Direktur/
    DashboardController.php
  Head/
    ApprovalCutiController.php
    DashboardController.php
    KaryawanController.php
    PengajuanCutiController.php
  Hrd/
    ApprovalCutiController.php
    DashboardController.php
    DivisiController.php
    HakCutiController.php
    HeadController.php
    JenisCutiController.php
    KaryawanController.php
    PengajuanCutiController.php
    RiwayatApprovalController.php
    RiwayatCutiController.php
  Karyawan/
    DashboardController.php
    PengajuanCutiController.php
    RiwayatApprovalController.php
  Lead/
    ApprovalCutiController.php
    DashboardController.php
    KaryawanController.php
    PengajuanCutiController.php
  Controller.php
  ProfileController.php

app/Models/
  ApprovalCuti.php
  Divisi.php
  HakCuti.php
  Jabatan.php
  JenisCuti.php
  PengajuanCuti.php
  User.php

routes/
  auth.php
  web.php

resources/views/
  (per-role dashboard & workflow views)
```

# Key Observations

1. **Workflow fully implemented**: Lead -> HRD -> Head approval chain working end-to-end.
2. **History tracking**: Both riwayat_cuti dan riwayat_approval available for audit.
3. **Filter by status**: Semua workflow page bisa filter disetujui/ditolak.
4. **Detail view**: Setiap pengajuan punya detail view untuk lihat history approval.
5. **Role separation**: Strict separation per-role dengan minimal cross-role visibility.
6. **Direktur pending**: Direktur hanya punya dashboard, approval workflow belum terintegrasi.

# Risks / Blind Spots

- **Direktur workflow**: Route/action belum ada; workflow berhenti di Head.
- **Automatic status push**: Apakah ada automasi untuk geser ke next approver atau manual polling?
- **Email notification**: Belum ada implementasi (no notification service di seeders/config).
- **Batch operation**: Tidak ada bulk approve/reject.
- **API endpoint**: Semua via web route; tidak ada REST API.
- **Testing**: Unit/feature test belum ditemukan.
- **Concurrent approval**: Bagaimana jika 2 approver approve simultaneously?
- **Direktur integration**: Harus implementasi approval route & action untuk Direktur.
