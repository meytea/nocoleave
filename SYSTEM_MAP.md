# Project Summary

- **Tujuan sistem**: Sistem pengajuan cuti karyawan berbasis web bernama NocoLeave untuk PT Nocola IoT Solution.
- **Tech stack**: Laravel 12, PHP 8.3, MySQL, Blade, Tailwind CSS, Alpine.js, Laravel Breeze, Spatie Laravel Permission.
- **Arsitektur Laravel**: MVC standar dengan Eloquent ORM, middleware auth, role-based access menggunakan Spatie Permission, Laravel Breeze auth.
- **Konsep workflow approval**: Multi-level approval berjenjang berdasarkan role (karyawan -> lead -> hrd -> head -> direktur), dengan tracking status dan history approval. Struktur sudah dirancang di model/migration/routes.
- **Refactoring terbaru**: Controller diorganisir per-role dalam folder terpisah. HRD memiliki master data management: divisi, karyawan, jenis cuti, dan hak cuti.

# Core Logic Flow

- **Login**: Route GET/POST `/login` -> `AuthenticatedSessionController[create/store]` -> `User` model -> `users` table.
- **HRD dashboard**: Route GET `/hrd/dashboard` [role:hrd] -> `Hrd\DashboardController@index` -> view `hrd/dashboard`.
- **Lead dashboard**: Route GET `/lead/dashboard` [role:lead] -> `Lead\DashboardController@index` -> view `lead/dashboard`.
- **Head dashboard**: Route GET `/head/dashboard` [role:head] -> `Head\DashboardController@index` -> view `head/dashboard`.
- **Direktur dashboard**: Route GET `/direktur/dashboard` [role:direktur] -> `Direktur\DashboardController@index` -> view `direktur/dashboard`.
- **Karyawan dashboard**: Route GET `/karyawan/dashboard` [role:karyawan] -> `Karyawan\DashboardController@index` -> view `karyawan/dashboard`.

## HRD Master Data Modules
- **Divisi master**: Resource route `/hrd/divisi` [role:hrd] -> `Hrd\DivisiController` (CRUD) -> `Divisi` model -> `divisi` table.
- **Karyawan master**: Resource route `/hrd/karyawan` [role:hrd] -> `Hrd\KaryawanController` (CRUD) -> `User` model + role assignment via Spatie.
- **Jenis Cuti master**: Resource route `/hrd/jenis_cuti` [role:hrd] -> `Hrd\JenisCutiController` (CRUD) -> `JenisCuti` model -> `jenis_cuti` table.
- **Hak Cuti master**: Resource route `/hrd/hak_cuti` [role:hrd] -> `Hrd\HakCutiController` (CRUD) -> `HakCuti` model -> `hak_cuti` table. Menampilkan relasi user dan jenis cuti.

## Workflow Cuti (Belum Implementasi)
- **Pengajuan cuti**: Belum ada route; `PengajuanCutiController` skeleton.
- **Approval cuti**: Belum ada route; `ApprovalCutiController` skeleton.
- **Monitoring cuti**: Belum ada route implementasi.

# Database Structure

Entity inti dengan relasi:

- **users**: id, name, foto, email, password, nik, jenis_kelamin, divisi_id, is_active, remember_token, timestamps, soft deletes. Relasi: `belongsTo(Divisi)`, `hasMany(PengajuanCuti)`, `hasMany(HakCuti)`, `hasMany(ApprovalCuti)` sebagai approver.
- **divisi**: id, nama_divisi, timestamps. Relasi: `hasMany(User)`.
- **jenis_cuti**: id, nama_cuti, kode_cuti, kuota, is_tahunan, keterangan, timestamps. Relasi: `hasMany(HakCuti)`, `hasMany(PengajuanCuti)`.
- **hak_cuti**: id, user_id, jenis_cuti_id, tahun, jatah, terpakai, sisa, timestamps. Relasi: `belongsTo(User)`, `belongsTo(JenisCuti)`.
- **pengajuan_cuti**: id, kode_pengajuan, user_id, jenis_cuti_id, tanggal_mulai, tanggal_selesai, tanggal_masuk, jumlah_hari, alasan, status (enum: pending_lead, pending_hrd, pending_head, pending_direktur, disetujui, ditolak), current_approver_id, ditolak_oleh, alasan_penolakan, approved_at, timestamps, soft deletes. Relasi: `belongsTo(User)`, `belongsTo(JenisCuti)`, `hasMany(ApprovalCuti)`, `belongsTo(User, current_approver_id)`, `belongsTo(User, ditolak_oleh)`.
- **approval_cuti**: id, pengajuan_cuti_id, approver_id, level_approval, status (approved/rejected), catatan, approved_at, timestamps, soft deletes. Relasi: `belongsTo(PengajuanCuti)`, `belongsTo(User, approver_id)`.

Relasi utama: `User -> Divisi`, `User -> HakCuti -> JenisCuti`, `User -> PengajuanCuti -> JenisCuti`, `PengajuanCuti -> ApprovalCuti -> User`.

# Role & Permission Map

- **Role**: `karyawan`, `lead`, `head`, `hrd`, `direktur`.
- **Hak akses**: Spatie Permission; role-based middleware di route level.
- **Dashboard enforcement**: Setiap role `/[role]/dashboard` terlindungi middleware `role:[role]`.
- **HRD privileges**:
  - Master divisi: create/read/update/delete divisi.
  - Master karyawan: create/read/update/delete user + assign role.
  - Master jenis cuti: create/read/update/delete jenis cuti.
  - Master hak cuti: read hak cuti per user.
- **Approval responsibility** (struktur ada, implementasi pending):
  - `karyawan`: ajukan cuti.
  - `lead`: approve level 1.
  - `hrd`: approve level 2, monitoring master data.
  - `head`: approve level 3.
  - `direktur`: approve final.
- **AdminSeeder**: user admin HRD default (email: admin@nocoleave.com, password: password).

# Module Map

## Routes
- `routes/web.php`: auth, profile, role-based dashboard, HRD master data resource.
- `routes/auth.php`: Laravel Breeze standard auth.

## Controllers (Role-based)
### HRD Module
- `Hrd/DashboardController.php`: HRD dashboard view.
- `Hrd/DivisiController.php`: CRUD divisi.
- `Hrd/KaryawanController.php`: CRUD user/karyawan + role assignment.
- `Hrd/JenisCutiController.php`: CRUD jenis cuti (paginate 10, store dengan validation).
- `Hrd/HakCutiController.php`: CRUD hak cuti dengan relasi user & jenis cuti.

### Dashboard Controllers
- `Karyawan/DashboardController.php`: karyawan dashboard view.
- `Lead/DashboardController.php`: lead dashboard view.
- `Head/DashboardController.php`: head dashboard view.
- `Direktur/DashboardController.php`: direktur dashboard view.

### Skeleton (Pending Implementation)
- `PengajuanCutiController.php`: pengajuan cuti skeleton.
- `ApprovalCutiController.php`: approval cuti skeleton.
- `ProfileController.php`: user profile management.

## Models
- `User.php`: `HasRoles`, relasi Divisi, PengajuanCuti, HakCuti, ApprovalCuti.
- `Divisi.php`: relasi hasMany User.
- `JenisCuti.php`: relasi hasMany HakCuti, PengajuanCuti.
- `HakCuti.php`: relasi belongsTo User, JenisCuti.
- `PengajuanCuti.php`: relasi belongsTo/hasMany.
- `ApprovalCuti.php`: relasi belongsTo PengajuanCuti, User.
- `Jabatan.php`: kosong, belum diintegrasikan.

## Seeders
- `RoleSeeder.php`: seed role (karyawan, lead, head, hrd, direktur).
- `AdminSeeder.php`: seed admin HRD.
- `DivisiSeeder.php`: seed 10 divisi awal.
- `JenisCutiSeeder.php`: seed 9 jenis cuti awal.
- `DatabaseSeeder.php`: call RoleSeeder -> AdminSeeder -> DivisiSeeder -> JenisCutiSeeder.

## Views (Role-based)
### HRD Master Data
- `hrd/divisi/`: index, create, edit.
- `hrd/karyawan/`: index, create, edit.
- `hrd/jenis_cuti/`: index, create, edit.
- `hrd/hak_cuti/`: index, create, edit.

### Dashboards
- `dashboard/`: role-specific dashboard views.
- `karyawan/`, `lead/`, `head/`, `direktur/`: role folder (dashboard views).

### Standard
- `auth/`: login, register, password reset.
- `profile/`: user profile edit.
- `layouts/app.blade.php`: main layout.
- `welcome.blade.php`: landing page.

# Workflow Approval Map

**Struktural (Model/DB):**
- Pengajuan status: pending_lead -> pending_hrd -> pending_head -> pending_direktur -> disetujui/ditolak.
- ApprovalCuti table: track per approver dan level.
- Relasi: pengajuan_cuti.current_approver_id, ditolak_oleh.

**Operasional (Implementasi Pending):**
- Route untuk create pengajuan cuti: **BELUM**.
- Route untuk approval per role: **BELUM**.
- View pengajuan cuti form: **BELUM**.
- View approval workflow dashboard: **BELUM**.

# Clean Tree

```
app/
  Http/Controllers/
    ApprovalCutiController.php (skeleton)
    PengajuanCutiController.php (skeleton)
    ProfileController.php
    Direktur/
      DashboardController.php
    Head/
      DashboardController.php
    Hrd/
      DashboardController.php
      DivisiController.php (CRUD)
      KaryawanController.php (CRUD)
      JenisCutiController.php (CRUD)
      HakCutiController.php (CRUD)
    Karyawan/
      DashboardController.php
    Lead/
      DashboardController.php
  Models/
    ApprovalCuti.php
    Divisi.php
    HakCuti.php
    Jabatan.php (empty)
    JenisCuti.php
    PengajuanCuti.php
    User.php
config/
  permission.php
database/
  migrations/
    0001_01_01_000001_create_users_table.php
    2026_05_10_140220_create_jenis_cuti_table.php
    2026_05_10_204520_create_hak_cuti_table.php
    2026_05_11_154522_create_pengajuan_cuti_table.php
    2026_05_12_050435_create_approval_cuti_table.php
  seeders/
    AdminSeeder.php
    DatabaseSeeder.php
    DivisiSeeder.php
    JenisCutiSeeder.php
    RoleSeeder.php
routes/
  auth.php
  web.php
resources/views/
  admin/
  auth/
    login.blade.php
    register.blade.php
  components/
  dashboard/
    hrd.blade.php
    karyawan.blade.php
    lead.blade.php
    head.blade.php
    direktur.blade.php
  direktur/
  head/
  hrd/
    divisi/
      index.blade.php
      create.blade.php
      edit.blade.php
    karyawan/
      index.blade.php
      create.blade.php
      edit.blade.php
    jenis_cuti/
      index.blade.php
      create.blade.php
      edit.blade.php
    hak_cuti/
      index.blade.php
      create.blade.php
      edit.blade.php
  karyawan/
  lead/
  profile/
  layouts/
    app.blade.php
    guest.blade.php
  welcome.blade.php
```

# Risks / Blind Spots

- **Workflow approval cuti belum implementasi**: Route pengajuan, approval, dan monitoring cuti masih skeleton. Pendekatan implementasi belum jelas.
- **Permintaan flow per role unclear**: Bagaimana karyawan mengajukan? Bagaimana lead/head/direktur melakukan approval? UI/route belum ada.
- **HakCuti view incomplete**: Edit/destroy HakCuti belum terimplementasi penuh; hanya index dan create.
- **JenisCuti schema updated**: Field `durasi_default` diubah menjadi `kuota`; migration perlu dikonfirmasi.
- **API endpoint tidak ada**: Semua via web route; tidak ada REST API untuk operasi.
- **Testing belum ada**: Unit/feature test untuk approval workflow belum ditemukan.
- **Jabatan model unused**: Masih kosong, tidak ada relasi atau penggunaan di controller.

# Implementation Checklist (Next Steps)

- [ ] Implementasi route pengajuan cuti (karyawan).
- [ ] Implementasi dashboard approval per role (lead/head/direktur).
- [ ] Implementasi approval action (approve/reject) dengan status update.
- [ ] Implementasi monitoring cuti karyawan (history approval).
- [ ] Fix HakCuti edit/destroy controller.
- [ ] Konfirmasi schema JenisCuti (durasi_default vs kuota).
- [ ] Integrate Jabatan model jika diperlukan.
- [ ] Add email notification untuk approval action.
- [ ] Add role-specific redirect di dashboard.
