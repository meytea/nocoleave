<h1>INDEX DIVISI DI ADMIN</h1>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Divisi</th>
        <th>Deskripsi</th>
    </tr>

    @foreach($divisis as $divisi)
    <tr>
        <td>{{ $divisi->id }}</td>
        <td>{{ $divisi->nama_divisi }}</td>
        <td>{{ $divisi->deskripsi }}</td>
    </tr>
    @endforeach
</table>