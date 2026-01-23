<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pagu Anggaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }

        .header h2 {
            font-size: 14px;
            margin: 5px 0;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .level1-header {
            background-color: #e8f4fd;
            font-weight: bold;
            padding-left: 10px;
        }

        .level2-header {
            background-color: #f0f8ff;
            font-weight: bold;
            padding-left: 10px;
        }

        .detail-row {
            padding-left: 10px;
            font-style: italic;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            background-color: #ffffcc;
            font-weight: bold;
        }

        .grand-total {
            background-color: #ffcccc;
            font-weight: bold;
            font-size: 14px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>RENCANA KERJA ANGGARAN DKM MASJID AL-KAUTSAR</h1>
        <h2>Tahun {{ $tahun ? $tahun->tahun : 'Semua Tahun' }}</h2>

    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 50%">Uraian</th>
                <th style="width: 20%">Alokasi Pagu</th>
                <th style="width: 25%">Realisasi</th>
                <th style="width: 25%">Bertambah/Berkurang</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $totalPerLevel1 = 99;
            @endphp

            @foreach($groupedData as $level1Id => $level1Group)
            @php
            $level1 = $level1Group->first()->first()->level1;
            $level1Total = $level1Group->flatten()->sum('jumlah');
            @endphp

            <tr class="level1-header">
                <td class="text-center">{{ $no++ }}</td>
                <td><strong>{{ $level1->nama }}</strong></td>
                <td class="text-right"><strong>{{ number_format($level1Total, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>0</strong></td>
                <td class="text-right"><strong>0</strong></td>
            </tr>

            @foreach($level1Group as $level2Id => $level2Group)
            @php
            $level2 = $level2Group->first()->level2;
            $level2Total = $level2Group->sum('jumlah');
            @endphp

            <tr class="level2-header">
                <td></td>
                <td>{{ $level2->nama }}</td>
                <td class="text-right">{{ number_format($level2Total, 0, ',', '.') }}</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
            </tr>

            @foreach($level2Group as $pagu)
            <tr>
                <td></td>
                <td class="detail-row">{{ $pagu->uraian }}</td>
                <td class="text-right">{{ number_format($pagu->jumlah, 0, ',', '.') }}</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
            </tr>

            @if($pagu->paguDetils && $pagu->paguDetils->count() > 0)
            @foreach($pagu->paguDetils as $detail)
            <tr style="font-size: 10px; color: #666;">
                <td></td>
                <td class="detail-row" style="padding-left: 10px;">
                    - {{ $detail->uraian_detail }}
                    ({{ $detail->jumlah }} {{ $detail->satuan }} × Rp {{ number_format($detail->harga, 0, ',', '.') }})
                </td>
                <td class="text-right">{{ number_format($detail->total, 0, ',', '.') }}</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
            </tr>
            @endforeach
            @endif
            @endforeach
            @endforeach
            @endforeach

            <tr class="grand-total">
                <td colspan="2" class="text-center"><strong>Surplus Defisit Anggaran</strong></td>
                <td class="text-right"><strong>{{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>0</strong></td>
                <td class="text-right"><strong>0</strong></td>
            </tr>
        </tbody>
    </table>



    <div class="signature">
        <p>{{ now()->format('d F Y') }}</p>
        <p>Mengetahui,</p>
        <br><br><br>
        <p>_________________________</p>
        <p>Kepala Bagian Keuangan</p>
    </div>

    <div class="footer">
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>



</html>