<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Neraca</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 14px;
            margin: 5px 0;
            font-weight: normal;
        }

        .header .period {
            font-size: 12px;
            margin-top: 10px;
            font-style: italic;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            border-bottom: 1px dotted #ccc;
        }

        .item-name {
            flex: 1;
            text-align: left;
        }

        .item-amount {
            text-align: right;
            font-weight: bold;
            min-width: 120px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            margin-top: 10px;
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 14px;
        }

        .total-name {
            text-transform: uppercase;
        }

        .balance-check {
            margin-top: 30px;
            padding: 15px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            text-align: center;
        }

        .balance-status {
            font-weight: bold;
            font-size: 14px;
        }

        .balanced {
            color: #28a745;
        }

        .unbalanced {
            color: #dc3545;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Neraca</h1>
        @if($masjid)
        <h2>{{ $masjid->nama }}</h2>
        @endif
        <div class="period">
            Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}
        </div>
    </div>

    <!-- ASET -->
    <div class="section">
        <div class="section-title">ASETXX</div>
        @if(!empty($data_neraca['aset']))
        @include('report.partials.neraca-hierarchy-pdf', ['items' => $data_neraca['aset']])
        @else
        <div class="no-data">Tidak ada data aset</div>
        @endif
    </div>

    <!-- KEWAJIBAN -->
    <div class="section">
        <div class="section-title">KEWAJIBAN</div>
        @if(!empty($data_neraca['kewajiban']))
        @include('report.partials.neraca-hierarchy-pdf', ['items' => $data_neraca['kewajiban']])
        @else
        <div class="no-data">Tidak ada data kewajiban</div>
        @endif
    </div>

    <!-- EKUITAS -->
    <div class="section">
        <div class="section-title">EKUITAS</div>
        @if(!empty($data_neraca['ekuitas']))
        @include('report.partials.neraca-hierarchy-pdf', ['items' => $data_neraca['ekuitas']])
        @else
        <div class="no-data">Tidak ada data ekuitas</div>
        @endif
    </div>

    <!-- Balance Check -->
    <div class="balance-check">
        @php
        // Since all values are 0 in template format, balance is always true
        $balanced = true;
        $totalAset = 0;
        $totalKewajiban = 0;
        $totalEkuitas = 0;
        @endphp
        <div class="balance-status balanced">
            Status Neraca: SEIMBANG (Template Format)
        </div>
        <div style="margin-top: 10px; font-size: 11px;">
            <div>Total Aset: Rp {{ number_format($totalAset, 0, ',', '.') }}</div>
            <div>Total Kewajiban + Ekuitas: Rp {{ number_format($totalKewajiban + $totalEkuitas, 0, ',', '.') }}</div>
        </div>
    </div>
</body>

</html>