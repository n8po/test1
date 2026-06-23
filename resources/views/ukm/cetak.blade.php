<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak UKM</title>
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
    <h1>Data Unit Kegiatan Mahasiswa</h1>
    <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama UKM</th>
                <th>Deskripsi</th>
                <th>Jumlah Anggota</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ukmList as $i => $ukm)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $ukm->nama }}</td>
                <td>{{ Str::limit($ukm->deskripsi, 100) }}</td>
                <td>{{ $ukm->anggota_count ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top:20px;">Total: {{ $ukmList->count() }} UKM</p>
</body>
</html>
