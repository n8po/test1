<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Anggota UKM</title>
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
    <h1>Data Anggota UKM</h1>
    <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Kelas</th>
                <th>Prodi</th>
                <th>Jurusan</th>
                <th>UKM</th>
                <th>Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggotaList as $i => $a)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $a->user->nama }}</td>
                <td>{{ $a->user->nim }}</td>
                <td>{{ $a->user->kelas }}</td>
                <td>{{ $a->user->prodi }}</td>
                <td>{{ $a->user->jurusan }}</td>
                <td>{{ $a->ukm->nama }}</td>
                <td>{{ $a->tanggal_bergabung->format('d-m-Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top:20px;">Total: {{ $anggotaList->count() }} anggota</p>
</body>
</html>
