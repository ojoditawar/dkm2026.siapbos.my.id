<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Buku Besar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
        }

        .info {
            margin-bottom: 20px;
        }

        .info-row {
            margin-bottom: 5px;
        }

        .rekening-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .rekening-header {
            background-color: #f0f0f0;
            padding: 8px;
            font-weight: bold;
            border: 1px solid #000;
            margin-bottom: 0;
        }

        .entries-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .entries-table th,
        .entries-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .entries-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .entries-table .number {
            text-align: right;
        }

        .entries-table .center {
            text-align: center;
        }

        .summary-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>LAPORAN BUKU BESAR</h1>
        @if($masjid)
        <h2>{{ $masjid->nama }}</h2>
        @if($masjid->alamat)
        <p style="margin: 5px 0; font-size: 11px;">{{ $masjid->alamat }}</p>
        @endif
        @endif
        <h2>Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}</h2>
    </div>

    <div class="info">
        <div class="info-row">
            <strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i:s') }}
        </div>
        @if($rekening_id)
        <div class="info-row">
            <strong>Filter Rekening:</strong> Ya
        </div>
        @endif
    </div>

    @if(empty($bukuBesar))
    <div style="text-align: center; margin-top: 50px; font-style: italic;">
        Tidak ada data transaksi untuk periode yang dipilih
    </div>
    @else
    @foreach($bukuBesar as $index => $item)
    @if($index > 0)
    <div class="page-break"></div>
    @endif

    <div class="rekening-section">
        <div class="rekening-header">
            {{ $item['rekening']->jenis ?? $item['rekening']->akun }} - {{ $item['rekening']->nama }}
        </div>

        <table class="entries-table">
            <thead>
                <tr>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 15%;">No. Transaksi</th>
                    <th style="width: 35%;">Uraian</th>
                    <th style="width: 12%;">Debet</th>
                    <th style="width: 12%;">Kredit</th>
                    <th style="width: 14%;">Saldo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item['entries'] as $entry)
                <tr>
                    <td class="center">{{ \Carbon\Carbon::parse($entry['tanggal'])->format('d/m/Y') }}</td>
                    <td class="center">{{ $entry['no_trans'] }}</td>
                    <td>{{ $entry['uraian'] }}</td>
                    <td class="number">
                        @if($entry['debet'] > 0)
                        {{ number_format($entry['debet'], 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="number">
                        @if($entry['kredit'] > 0)
                        {{ number_format($entry['kredit'], 0, ',', '.') }}
                        @endif
                    </td>
                    <td class="number">{{ number_format($entry['saldo'], 0, ',', '.') }}</td>
                </tr>
                @endforeach

                <!-- Summary Row -->
                <tr class="summary-row">
                    <td colspan="3" class="center"><strong>TOTAL</strong></td>
                    <td class="number"><strong>{{ number_format($item['total_debet'], 0, ',', '.') }}</strong></td>
                    <td class="number"><strong>{{ number_format($item['total_kredit'], 0, ',', '.') }}</strong></td>
                    <td class="number"><strong>{{ number_format($item['saldo_akhir'], 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
    @endforeach
    @endif

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>