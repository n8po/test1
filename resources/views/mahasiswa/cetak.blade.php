<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        @media print { body { margin: 0; } }
    </style>
</head>
<body onload="window.print()">
    <h1>Data Mahasiswa</h1>
    <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Prodi</th>
                <th>Jurusan</th>
                <th>UKM</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswaList as $i => $m)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $m->nim }}</td>
                <td>{{ $m->nama }}</td>
                <td>{{ $m->kelas }}</td>
                <td>{{ $m->prodi }}</td>
                <td>{{ $m->jurusan }}</td>
                <td>{{ $m->UKM }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top:20px;">Total: {{ $mahasiswaList->count() }} mahasiswa</p>
</body>
</html>
