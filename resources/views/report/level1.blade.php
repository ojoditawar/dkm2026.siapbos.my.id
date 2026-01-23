<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Level 1</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px 10px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 11px;
        }

        @page {
            margin: 1cm;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>STRUKTUR AKUN LEVEL 1</h1>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Kode</th>
                <th width="85%">Nama</th>
            </tr>
        </thead>
        <tbody>
            @forelse($level1s as $item)
            <tr>
                <td>{{ $item->akun1 }}</td>
                <td>{{ $item->nama }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align:center; color:#999; font-style:italic;">
                    Tidak ada data
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

</body>

</html>