# Project Summary

- **Tujuan sistem**: Sistem pengajuan cuti karyawan berbasis web bernama NocoLeave untuk PT Nocola IoT Solution.
- **Tech stack**: Laravel 12, PHP 8.3, MySQL, Blade, Tailwind CSS, Alpine.js, Laravel Breeze, Spatie Laravel Permission.
- **Arsitektur Laravel**: MVC standar dengan Eloquent ORM, middleware auth, role-based access menggunakan Spatie Permission.
- **Konsep workflow approval**: Multi-level approval berjenjang berdasarkan role (karyawan -> lead -> hrd -> head/direktur), dengan tracking status dan history approval.

# Core Logic Flow

Fokus pada flow utama. Controller dan service belum diimplementasi penuh, sehingga flow berdasarkan model dan migration.

- **Login**: Route GET/POST /login -> AuthenticatedSessionController[create/store] -> User model -> DB (users table).
- **Pengajuan cuti**: Route belum ada -> PengajuanCutiController[store] (belum implementasi) -> PengajuanCuti model -> DB (pengajuan_cuti table).
- **Approval cuti**: Route belum ada -> ApprovalCutiController[update] (belum implementasi) -> ApprovalCuti model -> DB (approval_cuti table), update PengajuanCuti status.
- **Reject cuti**: Sama dengan approval, dengan status 'ditolak'.
- **Hak cuti**: Route belum ada -> HakCuti model -> DB (hak_cuti table) untuk tracking jatah.
- **Monitoring cuti**: Route belum ada -> PengajuanCutiController[index] (belum implementasi) -> PengajuanCuti model dengan relasi.

# Database Structure

Entity inti dengan relasi:

- **users**: id, name, email, password, nik, jenis_kelamin, divisi_id, is_active. Relasi: belongsTo Divisi, hasMany PengajuanCuti, hasMany HakCuti, hasMany ApprovalCuti (sebagai approver).
- **divisi**: id, nama_divisi. Relasi: hasMany Users.
- **jenis_cuti**: id, nama_cuti, kode_cuti, durasi_default, is_tahunan, keterangan. Relasi: hasMany HakCuti, hasMany PengajuanCuti.
- **hak_cuti**: id, user_id, jenis_cuti_id, tahun, jatah, terpakai, sisa. Relasi: belongsTo User, belongsTo JenisCuti.
- **pengajuan_cuti**: id, kode_pengajuan, user_id, jenis_cuti_id, tanggal_mulai, tanggal_selesai, tanggal_masuk, jumlah_hari, alasan, status (enum: pending_lead, pending_hrd, pending_head, pending_direktur, disetujui, ditolak), current_approver_id, ditolak_oleh, alasan_penolakan, approved_at. Relasi: belongsTo User, belongsTo JenisCuti, hasMany ApprovalCuti, belongsTo User (currentApprover), belongsTo User (penolak).
- **approval_cuti**: id, pengajuan_cuti_id, approver_id, level_approval, status (approved/rejected), catatan, approved_at. Relasi: belongsTo PengajuanCuti, belongsTo User (approver). SoftDeletes.

Relasi utama: User -> Divisi, User -> PengajuanCuti -> JenisCuti, PengajuanCuti -> ApprovalCuti, User -> HakCuti -> JenisCuti.

# Role & Permission Map

- **Role** (dari RoleSeeder): karyawan, lead, head, hrd, direktur.
- **Hak akses**: Menggunakan Spatie Permission, tapi permission belum didefinisikan (HrdSeeder kosong).
- **Approval responsibility**:
    - karyawan: Mengajukan cuti.
    - lead: Approve level 1 untuk karyawan di divisinya.
    - hrd: Approve level 2, monitoring semua.
    - head: Approve level 3 untuk head divisi.
    - direktur: Approve final.

# Module Map

- **routes/web.php**: Route dasar dashboard, profile, auth.
- **routes/auth.php**: Route authentication Laravel Breeze.
- **app/Http/Controllers/PengajuanCutiController.php**: Controller untuk CRUD pengajuan cuti (belum implementasi).
- **app/Http/Controllers/ApprovalCutiController.php**: Controller untuk approval (belum implementasi).
- **app/Models/User.php**: Model User dengan HasRoles, relasi ke Divisi, PengajuanCuti, HakCuti.
- **app/Models/PengajuanCuti.php**: Model pengajuan dengan status dan relasi.
- **app/Models/ApprovalCuti.php**: Model approval dengan level dan status.
- **app/Models/HakCuti.php**: Model hak cuti untuk tracking jatah.
- **app/Models/JenisCuti.php**: Model jenis cuti.
- **app/Models/Divisi.php**: Model divisi.
- **database/seeders/RoleSeeder.php**: Seeder role karyawan, lead, head, hrd, direktur.
- **config/permission.php**: Config Spatie Permission standar.

# Workflow Approval Map

Berdasarkan status enum di pengajuan_cuti:

- Karyawan ajukan -> status: pending_lead -> Lead approve/reject.
- Jika approve -> pending_hrd -> HRD approve/reject.
- Jika approve -> pending_head -> Head approve/reject.
- Jika approve -> pending_direktur -> Direktur approve/reject.
- Final: disetujui atau ditolak.

Flow spesifik dari context:

- Karyawan -> Lead -> HRD -> Head
- Lead -> HRD -> Head
- Head -> HRD -> Direktur
- HRD -> Direktur

# Clean Tree

```
app/
  Http/Controllers/
    ApprovalCutiController.php
    PengajuanCutiController.php
  Models/
    ApprovalCuti.php
    Divisi.php
    HakCuti.php
    Jabatan.php (kosong)
    JenisCuti.php
    PengajuanCuti.php
    User.php
config/
  permission.php
database/
  migrations/
    ... (semua migration)
  seeders/
    RoleSeeder.php
    HrdSeeder.php
routes/
  auth.php
  web.php
resources/views/
  dashboard.blade.php
  welcome.blade.php
```

# Risks / Blind Spots

- Controller PengajuanCutiController dan ApprovalCutiController belum diimplementasi (hanya skeleton).
- Route untuk fitur cuti belum ada di web.php.
- Permission belum didefinisikan (HrdSeeder kosong).
- Tidak ada service layer atau repository pattern; logic mungkin langsung di controller.
- Jabatan model kosong, mungkin belum digunakan.
- Tidak ada validasi atau business logic di model.
- Workflow approval belum diimplementasi secara detail (current_approver_id dll ada, tapi logic belum).
