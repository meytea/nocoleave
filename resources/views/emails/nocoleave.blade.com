<h2>NocoLeave</h2>

<p>{{ $pesan }}</p>

<hr>

<table>
    <tr>
        <td><b>Nama</b></td>
        <td>: {{ $pengajuanCuti->user->name }}</td>
    </tr>

    <tr>
        <td><b>Jenis Cuti</b></td>
        <td>: {{ $pengajuanCuti->jenisCuti->nama_cuti }}</td>
    </tr>

    <tr>
        <td><b>Tanggal</b></td>
        <td>: {{ $pengajuanCuti->tanggal_mulai }} s/d {{ $pengajuanCuti->tanggal_selesai }}</td>
    </tr>

    <tr>
        <td><b>Status</b></td>
        <td>: {{ ucfirst(str_replace('_', ' ', $pengajuanCuti->status)) }}</td>
    </tr>
</table>

<p>
Silakan login ke aplikasi NocoLeave untuk melihat detail pengajuan cuti.
</p>