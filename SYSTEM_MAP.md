# Project Summary

- **Tujuan sistem**: Sistem pengajuan cuti karyawan berbasis web bernama NocoLeave untuk PT Nocola IoT Solution.
- **Tech stack**: Laravel 12, PHP 8.3, MySQL, Blade, Tailwind CSS, Alpine.js, Laravel Breeze, Spatie Laravel Permission.
- **Arsitektur Laravel**: MVC standar dengan Eloquent ORM, middleware auth, role-based access menggunakan Spatie Permission, Laravel Breeze auth.
- **Konsep workflow approval**: Multi-level approval berjenjang berdasarkan role (karyawan -> lead -> hrd -> head -> direktur), dengan tracking status dan history approval. Struktur sudah dirancang di model/migration/routes, namun implementasi full approval workflow masih belum lengkap.
- **Refactoring terbaru**: Controller sudah diorganisir per-role dalam folder terpisah (Hrd/, Karyawan/, Lead/, Head/, Direktur/).

# Core Logic Flow

- **Login**: Route GET/POST `/login` -> `AuthenticatedSessionController[create/store]` -> `User` model -> `users` table.
- **HRD dashboard**: Route GET `/hrd/dashboard` [role:hrd] -> `Hrd\DashboardController@index` -> view `dashboard.hrd`.
- **Lead dashboard**: Route GET `/lead/dashboard` [role:lead] -> `Lead\DashboardController@index` -> view `dashboard.lead`.
- **Head dashboard**: Route GET `/head/dashboard` [role:head] -> `Head\DashboardController@index` -> view `dashboard.head`.
- **Direktur dashboard**: Route GET `/direktur/dashboard` [role:direktur] -> `Direktur\DashboardController@index` -> view `dashboard.direktur`.
- **Karyawan dashboard**: Route GET `/karyawan/dashboard` [role:karyawan] -> `Karyawan\DashboardController@index` -> view `dashboard.karyawan`.
- **Divisi master (HRD)**: Resource route `/hrd/divisi` [role:hrd] -> `Hrd\DivisiController` (`index/create/store/edit/update/destroy`) -> `Divisi` model -> `divisi` table.
- **Karyawan master (HRD)**: Resource route `/hrd/karyawan` [role:hrd] -> `Hrd\KaryawanController` (`index/create/store/edit/update/destroy`) -> `User` model -> `users` table + role assignment.
- **Pengajuan cuti**: Belum ada route implementasi; hanya ada `PengajuanCutiController` skeleton.
- **Approval cuti**: Belum ada route implementasi; hanya ada `ApprovalCutiController` skeleton.

# Database Structure

Entity inti dengan relasi:

- **users**: id, name, foto, email, password, nik, jenis_kelamin, divisi_id, is_active, remember_token. Relasi: `belongsTo(Divisi)`, `hasMany(PengajuanCuti)`, `hasMany(HakCuti)`, `hasMany(ApprovalCuti)` sebagai approver.
- **divisi**: id, nama_divisi. Relasi: `hasMany(User)`.
- **jenis_cuti**: id, nama_cuti, kode_cuti, durasi_default, is_tahunan, keterangan. Relasi: `hasMany(HakCuti)`, `hasMany(PengajuanCuti)`.
- **hak_cuti**: id, user_id, jenis_cuti_id, tahun, jatah, terpakai, sisa. Relasi: `belongsTo(User)`, `belongsTo(JenisCuti)`.
- **pengajuan_cuti**: id, kode_pengajuan, user_id, jenis_cuti_id, tanggal_mulai, tanggal_selesai, tanggal_masuk, jumlah_hari, alasan, status (enum: pending_lead, pending_hrd, pending_head, pending_direktur, disetujui, ditolak), current_approver_id, ditolak_oleh, alasan_penolakan, approved_at. Relasi: `belongsTo(User)`, `belongsTo(JenisCuti)`, `hasMany(ApprovalCuti)`, `belongsTo(User, current_approver_id)`, `belongsTo(User, ditolak_oleh)`.
- **approval_cuti**: id, pengajuan_cuti_id, approver_id, level_approval, status (approved/rejected), catatan, approved_at, timestamps, soft deletes. Relasi: `belongsTo(PengajuanCuti)`, `belongsTo(User, approver_id)`.

Relasi utama: `User -> Divisi`, `User -> PengajuanCuti -> JenisCuti`, `PengajuanCuti -> ApprovalCuti`, `User -> HakCuti -> JenisCuti`.

# Role & Permission Map

- **Role**: `karyawan`, `lead`, `head`, `hrd`, `direktur`.
- **Hak akses**: Spatie Permission digunakan; role-based middleware diterapkan di route level.
- **Dashboard enforcement**: Setiap role memiliki route `/[role]/dashboard` yang terlindungi middleware `role:[role]`.
- **Approval responsibility**:
  - `karyawan`: mengajukan cuti, akses dashboard karyawan.
  - `lead`: level pertama approval, akses dashboard lead.
  - `hrd`: level berikutnya, master data divisi/karyawan, akses dashboard HRD.
  - `head`: approval lanjutan, akses dashboard head.
  - `direktur`: approval final, akses dashboard direktur.
- **AdminSeeder**: membuat user admin HRD default (email: admin@nocoleave.com, password: password).

# Module Map

## Routes
- `routes/web.php`: route auth, profile, dan role-based dashboard + HRD master data resource.
- `routes/auth.php`: Laravel Breeze auth route standard.

## Controllers (Role-based)
- `app/Http/Controllers/Hrd/DashboardController.php`: HRD dashboard view.
- `app/Http/Controllers/Hrd/DivisiController.php`: CRUD divisi.
- `app/Http/Controllers/Hrd/KaryawanController.php`: CRUD pengguna/karyawan dan role assignment.
- `app/Http/Controllers/Karyawan/DashboardController.php`: Karyawan dashboard view.
- `app/Http/Controllers/Lead/DashboardController.php`: Lead dashboard view.
- `app/Http/Controllers/Head/DashboardController.php`: Head dashboard view.
- `app/Http/Controllers/Direktur/DashboardController.php`: Direktur dashboard view.
- `app/Http/Controllers/ApprovalCutiController.php`: skeleton approval cuti.
- `app/Http/Controllers/PengajuanCutiController.php`: skeleton pengajuan cuti.
- `app/Http/Controllers/ProfileController.php`: profile user standard.

## Models
- `app/Models/User.php`: model user dengan `HasRoles`, relasi ke Divisi, PengajuanCuti, HakCuti.
- `app/Models/PengajuanCuti.php`: model pengajuan cuti.
- `app/Models/ApprovalCuti.php`: model approval cuti.
- `app/Models/HakCuti.php`: model hak cuti.
- `app/Models/JenisCuti.php`: model jenis cuti.
- `app/Models/Divisi.php`: model divisi.
- `app/Models/Jabatan.php`: model jabatan (kosong, belum dipakai).

## Seeders
- `database/seeders/RoleSeeder.php`: seed role (karyawan, lead, head, hrd, direktur).
- `database/seeders/AdminSeeder.php`: seed admin HRD default.
- `database/seeders/DivisiSeeder.php`: seed divisi awal (10 divisi).
- `database/seeders/JenisCutiSeeder.php`: seed jenis cuti (9 tipe).
- `database/seeders/DatabaseSeeder.php`: memanggil `RoleSeeder`, `AdminSeeder`, `DivisiSeeder`, `JenisCutiSeeder`.

## Views (Role-based)
- `resources/views/hrd/` (divisi/, karyawan/): HRD master data views.
- `resources/views/karyawan/`: Karyawan dashboard view.
- `resources/views/lead/`: Lead dashboard view.
- `resources/views/head/`: Head dashboard view.
- `resources/views/direktur/`: Direktur dashboard view.
- `resources/views/dashboard/`: Dashboard views per role.
- `resources/views/auth/`: Auth views (Breeze).
- `resources/views/profile/`: Profile views.

# Workflow Approval Map

Struktur approval mapping (di database/model sudah ada):
- Karyawan ajukan cuti -> status `pending_lead` -> Lead review/reject.
- Jika Lead approve -> status `pending_hrd` -> HRD review/reject.
- Jika HRD approve -> status `pending_head` -> Head review/reject.
- Jika Head approve -> status `pending_direktur` -> Direktur review/reject.
- Final: `disetujui` atau `ditolak`.

**Catatan**: Alur approval sudah dipetakan di model/migration, tetapi route/controller operasional untuk pengajuan dan approval cuti belum ada di `routes/web.php`.

# Clean Tree

```
app/
  Http/Controllers/
    ApprovalCutiController.php
    PengajuanCutiController.php
    ProfileController.php
    Direktur/
      DashboardController.php
    Head/
      DashboardController.php
    Hrd/
      DashboardController.php
      DivisiController.php
      KaryawanController.php
    Karyawan/
      DashboardController.php
    Lead/
      DashboardController.php
  Models/
    ApprovalCuti.php
    Divisi.php
    HakCuti.php
    Jabatan.php
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
  components/
  dashboard/
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
  karyawan/
  lead/
  profile/
  welcome.blade.php
  layouts/
    app.blade.php
```

# Risks / Blind Spots

- `PengajuanCutiController` dan `ApprovalCutiController` masih skeleton; workflow pengajuan dan approval cuti belum terimplementasi.
- Route untuk pengajuan cuti, approval, dan monitoring cuti belum ada di `routes/web.php`.
- Permission CRUD atau action granular belum didefinisikan; hanya role dasar di middleware.
- Tidak ada API endpoint; semua via web route.
- `Jabatan` model belum diintegrasikan atau digunakan.
- View workflow/approval pages belum ada di views.
