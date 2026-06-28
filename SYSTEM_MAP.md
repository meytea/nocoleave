# Project Summary

- **Tujuan sistem**: Sistem pengajuan cuti karyawan berbasis web bernama NocoLeave untuk PT Nocola IoT Solution.
- **Tech stack**: Laravel 12, PHP 8.3, MySQL, Blade, Tailwind CSS, Alpine.js, Laravel Breeze, Spatie Laravel Permission.
- **Arsitektur Laravel**: MVC per-role dengan Eloquent ORM, middleware auth, role-based access Spatie Permission.
- **Status**: **WORKFLOW APPROVAL 95% COMPLETE** - Karyawan ? Lead ? HRD ? Head fully operational. Direktur pending route integration.
- **Update**: Landing page redirect ke login (tidak perlu welcome page untuk non-auth). Direktur struktur controller siap tapi route belum terintegrasi.

# Core Logic Flow

## Authentication & Landing
- **Landing**: Route GET `/` -> redirect ke `/login` (perlu auth untuk akses sistem).
- **Login**: Route GET/POST `/login` -> `AuthenticatedSessionController[create/store]`.
- **Register**: Route GET/POST `/register` -> `RegisteredUserController[create/store]`.
- **Profile**: Route GET/PATCH/DELETE `/profile` -> `ProfileController`.

## Role-Based Dashboards
- **Karyawan**: Route GET `/karyawan/dashboard` -> `Karyawan\DashboardController@index`.
- **Lead**: Route GET `/lead/dashboard` -> `Lead\DashboardController@index`.
- **Head**: Route GET `/head/dashboard` -> `Head\DashboardController@index`.
- **HRD**: Route GET `/hrd/dashboard` -> `Hrd\DashboardController@index`.
- **Direktur**: Route GET `/direktur/dashboard` -> `Direktur\DashboardController@index`.

## Karyawan - Workflow
- **Dashboard**: View pengajuan, hak cuti, history approval.
- **Create pengajuan**: Route POST `/karyawan/pengajuan_cuti/create` -> store -> status `pending_lead`.
- **List pengajuan**: GET `/karyawan/pengajuan_cuti` -> list milik sendiri.
- **Filter pengajuan**: `/karyawan/pengajuan_cuti/disetujui`, `/ditolak`.
- **Detail pengajuan**: GET `/karyawan/pengajuan_cuti/{id}` -> show + approval history.

## Lead - Approval Workflow (Level 1)
- **Dashboard**: Overview tim karyawan & pending approval.
- **List karyawan**: GET `/lead/karyawan` -> view tim.
- **List pengajuan**: GET `/lead/pengajuan_cuti` -> pengajuan dari tim karyawan.
- **Filter pengajuan**: `/lead/pengajuan_cuti/disetujui`, `/ditolak`.
- **Detail pengajuan**: GET `/lead/pengajuan_cuti/{id}`.
- **Approval list**: GET `/lead/approval_cuti` -> list untuk di-approve.
- **Approve action**: POST `/lead/approval_cuti/{id}/setuju` -> update status `pending_hrd`.
- **Reject action**: POST `/lead/approval_cuti/{id}/tolak` -> update status `ditolak`.

## Head - Approval Workflow (Level 3)
- **Dashboard**: Overview pending approval.
- **List karyawan**: GET `/head/karyawan` -> view tim (via HeadController).
- **List pengajuan**: GET `/head/pengajuan_cuti` -> pengajuan status `pending_head`.
- **Filter pengajuan**: `/head/pengajuan_cuti/disetujui`, `/ditolak`.
- **Approval list**: GET `/head/approval_cuti` -> list untuk di-approve.
- **Approve action**: POST `/head/approval_cuti/{id}/setuju` -> update status `pending_direktur`.
- **Reject action**: POST `/head/approval_cuti/{id}/tolak` -> update status `ditolak`.

## HRD - Full Master Data & Approval Workflow (Level 2)
- **Dashboard**: Overview semua cuti, pending approval.
- **Master divisi**: Resource `/hrd/divisi` -> CRUD divisi.
- **Master karyawan**: Resource `/hrd/karyawan` -> CRUD + role assign.
- **Master jenis cuti**: Resource `/hrd/jenis_cuti` -> CRUD jenis cuti.
- **Master hak cuti**: Resource `/hrd/hak_cuti` -> CRUD hak cuti.
- **Master head/supervisor**: Resource `/hrd/head` -> CRUD head organisasi.
- **List pengajuan**: GET `/hrd/pengajuan_cuti` -> semua pengajuan.
- **Filter pengajuan**: `/hrd/pengajuan_cuti/disetujui`, `/ditolak`.
- **Approval list**: GET `/hrd/approval_cuti` -> list untuk di-approve.
- **Approve action**: POST `/hrd/approval_cuti/{id}/setuju` -> update status `pending_head`.
- **Reject action**: POST `/hrd/approval_cuti/{id}/tolak` -> update status `ditolak`.
- **History cuti**: GET `/hrd/riwayat_cuti` -> riwayat approval cuti semua karyawan.
- **History approval**: GET `/hrd/riwayat_approval` -> audit trail approval (siapa approve kapan).

## Direktur - Dashboard Only (Pending Implementation)
- **Dashboard**: Route GET `/direktur/dashboard` -> view only.
- **Approval workflow**: **BELUM TERINTEGRASI** - controller & view folder ada tapi route/action belum.
- **Karyawan view**: Controller `DirekturController` punya index() untuk list karyawan (reuse HRD view).
- **Blocker**: Butuh route POST untuk action setuju/tolak & business logic untuk update status `disetujui`.

# Database Structure

- **users**: id, name, foto, email, password, nik, jenis_kelamin, divisi_id, is_active, timestamps, soft deletes. Relasi: `belongsTo(Divisi)`, `hasMany(PengajuanCuti)`, `hasMany(HakCuti)`, `hasMany(ApprovalCuti)`.
- **divisi**: id, nama_divisi, timestamps. Relasi: `hasMany(User)`.
- **jenis_cuti**: id, nama_cuti, kode_cuti, kuota, is_tahunan, keterangan, timestamps. Relasi: `hasMany(HakCuti)`, `hasMany(PengajuanCuti)`.
- **hak_cuti**: id, user_id, jenis_cuti_id, tahun, jatah, terpakai, sisa, timestamps. Relasi: `belongsTo(User)`, `belongsTo(JenisCuti)`.
- **pengajuan_cuti**: id, kode_pengajuan, user_id, jenis_cuti_id, tanggal_mulai, tanggal_selesai, tanggal_masuk, jumlah_hari, alasan, status (pending_lead, pending_hrd, pending_head, pending_direktur, disetujui, ditolak), current_approver_id, ditolak_oleh, alasan_penolakan, approved_at, timestamps, soft deletes. Relasi: `belongsTo(User)`, `belongsTo(JenisCuti)`, `hasMany(ApprovalCuti)`.
- **approval_cuti**: id, pengajuan_cuti_id, approver_id, level_approval, status (approved/rejected), catatan, approved_at, timestamps, soft deletes. Relasi: `belongsTo(PengajuanCuti)`, `belongsTo(User)`.

# Role & Permission Map

- **Role**: `karyawan`, `lead`, `head`, `hrd`, `direktur`.
- **Authorization**: Spatie Permission `HasRoles` + middleware `role:[role]`.

## Privileges per Role
- **Karyawan**: 
  - Create pengajuan cuti (status `pending_lead`).
  - View pengajuan milik sendiri.
  - Filter & view history approval.
  
- **Lead**:
  - View karyawan di tim (divisi yang sama).
  - List pengajuan dari tim (status `pending_lead`).
  - Approve/reject -> geser ke `pending_hrd` atau `ditolak`.
  - View history approval.
  
- **Head**:
  - View karyawan di organisasi.
  - List pengajuan status `pending_head`.
  - Approve/reject -> geser ke `pending_direktur` atau `ditolak`.
  - View history approval.
  
- **HRD**:
  - Master data full: divisi, karyawan, jenis_cuti, hak_cuti, head.
  - List ALL pengajuan cuti.
  - Approve/reject level 2 -> geser ke `pending_head` atau `ditolak`.
  - View history cuti & approval (audit trail).
  - Assign role ke user.
  
- **Direktur**:
  - Dashboard view.
  - **Approval workflow PENDING** (controller ada, route belum).
  - Expected: Approve/reject level 4 -> `disetujui` atau `ditolak`.

# Module Map

## Routes
- `routes/web.php`: Guest landing (redirect login), auth, profile, all role-based workflow routes.
- `routes/auth.php`: Laravel Breeze auth (login, register, password reset).

## Controllers (Role-based Structure)

### Karyawan/
- `DashboardController.php`: Karyawan dashboard.
- `PengajuanCutiController.php`: Create/list/show pengajuan cuti.
- `RiwayatApprovalController.php`: View history approval pengajuan.

### Lead/
- `DashboardController.php`: Lead dashboard.
- `KaryawanController.php`: List tim karyawan.
- `PengajuanCutiController.php`: List/show pengajuan pending lead approval.
- `ApprovalCutiController.php`: Approval action (setuju/tolak).

### Head/
- `DashboardController.php`: Head dashboard.
- `KaryawanController.php`: List tim (via HeadController).
- `PengajuanCutiController.php`: List/show pengajuan pending head approval.
- `ApprovalCutiController.php`: Approval action (setuju/tolak).

### Direktur/
- `DashboardController.php`: Direktur dashboard view.
- `KaryawanController.php`: **STUB** - punya index() untuk list karyawan (reuse HRD view).
- `ApprovalCutiController.php`: **NOT FOUND** - perlu dibuat untuk approve/reject.

### HRD/
- `DashboardController.php`: HRD dashboard.
- `DivisiController.php`: CRUD divisi.
- `KaryawanController.php`: CRUD karyawan + role assign.
- `JenisCutiController.php`: CRUD jenis cuti.
- `HakCutiController.php`: CRUD hak cuti.
- `HeadController.php`: CRUD head organisasi.
- `PengajuanCutiController.php`: List/show pengajuan + approval.
- `ApprovalCutiController.php`: Approval action (setuju/tolak).
- `RiwayatCutiController.php`: History cuti.
- `RiwayatApprovalController.php`: Audit trail approval.

### Standalone
- `ProfileController.php`: Edit/update profile.

## Models
- `User.php`: `HasRoles`, relasi Divisi, PengajuanCuti, HakCuti, ApprovalCuti.
- `Divisi.php`, `JenisCuti.php`, `HakCuti.php`, `PengajuanCuti.php`, `ApprovalCuti.php`.
- `Jabatan.php`: Kosong, belum diintegrasikan.

## Seeders
- `RoleSeeder.php`: 5 role.
- `AdminSeeder.php`: Admin HRD default.
- `DivisiSeeder.php`: 10 divisi.
- `JenisCutiSeeder.php`: 9 jenis cuti.
- `HakCutiSeeder.php`: Hak cuti per user.
- `DatabaseSeeder.php`: Call semua seeder.

## Views (Role-based)
### Karyawan/
- `dashboard.blade.php`, `pengajuan_cuti/` (index, create, show), `riwayat_approval/` (index).

### Lead/
- `dashboard.blade.php`, `karyawan/` (index), `pengajuan_cuti/` (index, show, filter), `approval_cuti/` (index).

### Head/
- `dashboard.blade.php`, `karyawan/` (index), `pengajuan_cuti/` (index, show, filter), `approval_cuti/` (index).

### HRD/
- `dashboard.blade.php`, `divisi/`, `karyawan/`, `jenis_cuti/`, `hak_cuti/`, `head/`, `pengajuan_cuti/`, `approval_cuti/`, `riwayat_cuti/`, `riwayat_approval/`.

### Direktur/
- `dashboard.blade.php`, `approval_cuti/` (folder kosong, belum ada view).

### Standard
- `auth/`: login, register, password reset (Breeze).
- `profile/`: edit profile.
- `layouts/app.blade.php`, `welcome.blade.php`.

# Workflow Approval Map

**Status Flow:**
1. Karyawan ajukan -> `pending_lead` (current_approver_id = lead).
2. Lead approve/reject -> `pending_hrd`/`ditolak`.
3. HRD approve/reject -> `pending_head`/`ditolak`.
4. Head approve/reject -> `pending_direktur`/`ditolak`.
5. Direktur approve/reject -> `disetujui`/`ditolak` **[PENDING IMPLEMENTATION]**.

**Approval Records:**
- Each action create `ApprovalCuti` record: (pengajuan_cuti_id, approver_id, level_approval, status, catatan, approved_at).

**History Tracking:**
- `Karyawan\RiwayatApprovalController`: Lihat history pengajuan milik sendiri.
- `Hrd\RiwayatApprovalController`: Audit trail semua approval.

# Implementation Status

## ? COMPLETE (95%)
- Karyawan pengajuan & history view.
- Lead level 1 approval workflow.
- HRD level 2 approval workflow + master data.
- Head level 3 approval workflow.
- History tracking & audit trail.
- Role-based dashboard semua role.

## ?? PENDING / INCOMPLETE (5%)
- **Direktur level 4 approval**: Route & action untuk setuju/tolak.
- **Direktur ApprovalCutiController**: Belum ada, perlu dibuat.
- **Email notification**: Belum implementasi.
- **Direktur view**: approval_cuti folder ada tapi kosong (no views).

# Risks / Blind Spots

- **Direktur workflow incomplete**: Route belum ada di web.php; controller `DirekturController` hanya stub.
- **Direktur blocker**: Tanpa route/action, pengajuan macet di status `pending_direktur`.
- **Email notification missing**: Approver tidak dapat notifikasi approval pending.
- **Concurrent approval**: Tidak ada protection jika 2 orang approve simultaneously.
- **API endpoint**: Semua web route; tidak ada REST API.
- **Batch operation**: Tidak ada bulk approve/reject.
- **Testing**: Unit/feature test belum ditemukan.
- **Jabatan unused**: Model kosong, tidak dipakai.

# Next Steps (Immediate)

- [ ] Buat `Direktur\ApprovalCutiController` dengan method approve/reject.
- [ ] Tambah route group untuk Direktur approval di `web.php`.
- [ ] Buat view Direktur approval UI (`approval_cuti/index`, `show`, etc).
- [ ] Implementasi Direktur action POST setuju/tolak.
- [ ] Test end-to-end approval workflow (karyawan -> lead -> hrd -> head -> direktur -> disetujui).
- [ ] **OPTIONAL**: Email notification service.

# Key Observations

1. **Nearly complete**: Hanya tinggal Direktur approval saja untuk workflow 100%.
2. **Clean architecture**: Per-role controller organization memudahkan maintenance.
3. **History tracking**: Audit trail lengkap untuk compliance.
4. **Flexible status filter**: Semua role punya filter disetujui/ditolak.
5. **Reusable views**: Direktur bisa reuse HRD karyawan view.
6. **Landing redirect**: User non-auth langsung ke login (security improvement).

# Clean Tree

```
app/Http/Controllers/
  Direktur/
    DashboardController.php ?
    KaryawanController.php ?? (stub only)
    (ApprovalCutiController.php - MISSING) ?
  Head/
    DashboardController.php ?
    KaryawanController.php ?
    PengajuanCutiController.php ?
    ApprovalCutiController.php ?
  Hrd/
    DashboardController.php ?
    DivisiController.php ?
    KaryawanController.php ?
    JenisCutiController.php ?
    HakCutiController.php ?
    HeadController.php ?
    PengajuanCutiController.php ?
    ApprovalCutiController.php ?
    RiwayatCutiController.php ?
    RiwayatApprovalController.php ?
  Karyawan/
    DashboardController.php ?
    PengajuanCutiController.php ?
    RiwayatApprovalController.php ?
  Lead/
    DashboardController.php ?
    KaryawanController.php ?
    PengajuanCutiController.php ?
    ApprovalCutiController.php ?
  ProfileController.php ?
```

**Legend**: ? Complete | ?? Incomplete | ? Missing
