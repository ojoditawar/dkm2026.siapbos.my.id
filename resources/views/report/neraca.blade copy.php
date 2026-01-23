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
        <div class="section-title">ASET</div>

        @if(!empty($data_neraca['aktiva']['aktiva_lancar']))
        @foreach($data_neraca['aktiva']['aktiva_lancar'] as $item)
        <div class="item-row">
            <div class="item-name">{{ $item['nama'] }}</div>
            <div class="item-amount">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</div>
        </div>
        @endforeach
        @endif

        @if(!empty($data_neraca['aktiva']['aktiva_tetap']))
        @foreach($data_neraca['aktiva']['aktiva_tetap'] as $item)
        <div class="item-row">
            <div class="item-name">{{ $item['nama'] }}</div>
            <div class="item-amount">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</div>
        </div>
        @endforeach
        @endif

        <div class="total-row">
            <div class="total-name">Total Aset</div>
            <div class="item-amount">Rp {{ number_format($data_neraca['aktiva']['total_aktiva'], 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- KEWAJIBAN -->
    <div class="section">
        <div class="section-title">KEWAJIBAN</div>

        @if(!empty($data_neraca['pasiva']['kewajiban']))
        @foreach($data_neraca['pasiva']['kewajiban'] as $item)
        <div class="item-row">
            <div class="item-name">{{ $item['nama'] }}</div>
            <div class="item-amount">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</div>
        </div>
        @endforeach
        @else
        <div class="no-data">Tidak ada data kewajiban</div>
        @endif

        <div class="total-row">
            <div class="total-name">Total Kewajiban</div>
            <div class="item-amount">Rp {{ number_format($data_neraca['pasiva']['kewajiban'] ? array_sum(array_column($data_neraca['pasiva']['kewajiban'], 'saldo')) : 0, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- EKUITAS -->
    <div class="section">
        <div class="section-title">EKUITAS</div>

        @if(!empty($data_neraca['pasiva']['ekuitas']))
        @foreach($data_neraca['pasiva']['ekuitas'] as $item)
        <div class="item-row">
            <div class="item-name">{{ $item['nama'] }}</div>
            <div class="item-amount">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</div>
        </div>
        @endforeach
        @else
        <div class="no-data">Tidak ada data ekuitas</div>
        @endif

        <div class="total-row">
            <div class="total-name">Total Ekuitas</div>
            <div class="item-amount">Rp {{ number_format($data_neraca['pasiva']['ekuitas'] ? array_sum(array_column($data_neraca['pasiva']['ekuitas'], 'saldo')) : 0, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Balance Check -->
    <div class="balance-check">
        @php
        $balanced = $data_neraca['aktiva']['total_aktiva'] == $data_neraca['pasiva']['total_pasiva'];
        @endphp
        <div class="balance-status {{ $balanced ? 'balanced' : 'unbalanced' }}">
            Status Neraca: {{ $balanced ? 'SEIMBANG' : 'TIDAK SEIMBANG' }}
        </div>
        @if(!$balanced)
        <div style="margin-top: 10px; color: #dc3545;">
            Selisih: Rp {{ number_format(abs($data_neraca['aktiva']['total_aktiva'] - $data_neraca['pasiva']['total_pasiva']), 0, ',', '.') }}
        </div>
        @endif
    </div>
</body>

</html>