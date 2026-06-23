<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Kegiatan</title>
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
    <h1>Data Kegiatan UKM</h1>
    <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kegiatan</th>
                <th>UKM</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatanList as $i => $k)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $k->nama_kegiatan }}</td>
                <td>{{ $k->UKM ?? '-' }}</td>
                <td>{{ $k->tanggal ? \Carbon\Carbon::parse($k->tanggal)->format('d-m-Y') : '-' }}</td>
                <td>{{ $k->deskripsi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top:20px;">Total: {{ $kegiatanList->count() }} kegiatan</p>
</body>
</html>
