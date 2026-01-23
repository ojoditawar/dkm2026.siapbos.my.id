<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Anggaran {{ $tahun ? $tahun->tahun : 'Semua Tahun' }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 10px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #666;
        }

        .level1-section {
            margin-bottom: 12px;
            page-break-inside: avoid;
        }

        .level1-header {
            background-color: #c1cbecde;
            color: black;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 11px;
            line-height: 1.1;
            margin-bottom: 2px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .level2-section {
            margin-left: 15px;
            margin-bottom: 6px;
        }

        .level2-header {
            background-color: #e8ebf0ff;
            color: black;
            padding: 4px 8px;
            font-weight: bold;
            font-style: italic;
            font-size: 10px;
            line-height: 1.0;
            margin-bottom: 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .level3-section {
            margin-left: 30px;
            margin-bottom: 4px;
        }

        .level3-header {
            background-color: #f3f4f6;
            color: black;
            padding: 3px 6px;
            font-weight: bold;
            font-size: 9px;
            line-height: 1.1;
            margin-bottom: 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 2px solid #dfdfe6ff;
        }

        .anggaran-item {
            background-color: white;
            padding: 4px 8px;
            border-left: 3px solid #e5e7eb;
            margin-bottom: 2px;
            font-size: 9px;
            line-height: 1.2;
            margin-left: 45px;
        }

        .anggaran-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3px;
        }

        .anggaran-uraian {
            font-weight: bold;
            color: #374151;
        }

        .anggaran-pagu {
            font-weight: bold;
            color: #059669;
            font-size: 10px;
        }

        .detail-items {
            margin-top: 3px;
            padding-left: 10px;
        }

        .detail-item {
            font-size: 8px;
            color: #6b7280;
            margin-bottom: 1px;
            display: flex;
            justify-content: space-between;
        }

        .akun-code {
            font-weight: bold;
            color: #1e40af;
        }

        .level3-header .akun-code {
            color: #2066f0cf;
        }

        .akun-name {
            margin-left: 8px;
        }

        .total-amount {
            font-weight: bold;
            color: #059669;
            font-size: 10px;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 9px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }

        .grand-total {
            background-color: #f0f9ff;
            border: 2px solid #0ea5e9;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            color: #0c4a6e;
        }

        @page {
            margin: 1.2cm;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        .no-data {
            font-style: italic;
            color: #666;
            margin-left: 15px;
            font-size: 9px;
        }

        .summary {
            background-color: #f8fafc;
            padding: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 20px;
            font-size: 9px;
        }

        .summary-item {
            display: inline-block;
            margin-right: 20px;
        }

        .currency {
            font-family: 'Courier New', monospace;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>LAPORAN ANGGARAN {{ $tahun ? strtoupper($tahun->tahun) : 'SEMUA TAHUN' }}</h1>
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    @forelse($groupedData as $level1Id => $level2Groups)
    @php
    $firstAnggaran = $level2Groups->flatten()->flatten()->first();
    $level1 = $firstAnggaran->level1;
    $level1Total = $level2Groups->flatten()->flatten()->sum(function($anggaran) {
    return $anggaran->getCalculatedGrandTotal();
    });
    @endphp

    <div class="level1-section">
        <div class="level1-header">
            <div>
                <span class="akun-code">{{ $level1->akun1 }}</span>
                <span class="akun-name">{{ $level1->nama }}</span>
            </div>
            <div class="total-amount currency">Rp {{ number_format($level1Total, 0, ',', '.') }}</div>
        </div>

        @forelse($level2Groups as $level2Id => $level3Groups)
        @php
        $firstLevel2Anggaran = $level3Groups->flatten()->first();
        $level2 = $firstLevel2Anggaran->level2;
        $level2Total = $level3Groups->flatten()->sum(function($anggaran) {
        return $anggaran->getCalculatedGrandTotal();
        });
        @endphp

        <div class="level2-section">
            <div class="level2-header">
                <div>
                    <span class="akun-code">{{ $level1->akun1 }}.{{ $level2->akun2 }}</span>
                    <span class="akun-name">{{ $level2->nama }}</span>
                </div>
                <div class="total-amount currency">Rp {{ number_format($level2Total, 0, ',', '.') }}</div>
            </div>

            @forelse($level3Groups as $level3Id => $anggarans)
            @php
            $firstLevel3Anggaran = $anggarans->first();
            $level3 = $firstLevel3Anggaran->level3;
            $level3Total = $anggarans->sum(function($anggaran) {
            return $anggaran->getCalculatedGrandTotal();
            });
            @endphp

            <div class="level3-section">
                <div class="level3-header">
                    <div>
                        <span class="akun-code">{{ $level1->akun1 }}.{{ $level2->akun2 }}.{{ $level3->akun3 }}</span>
                        <span class="akun-name">{{ $level3->nama }}</span>
                    </div>
                    <div class="total-amount currency">Rp {{ number_format($level3Total, 0, ',', '.') }}</div>
                </div>

                @foreach($anggarans as $anggaran)
                <div class="anggaran-item">
                    <div class="anggaran-header">
                        <div class="anggaran-uraian">{{ $anggaran->uraian }}</div>
                        <div class="anggaran-pagu currency">Rp {{ number_format($anggaran->getCalculatedGrandTotal(), 0, ',', '.') }}</div>
                    </div>

                    @if($anggaran->detailItems->count() > 0)
                    <div class="detail-items">
                        @foreach($anggaran->detailItems as $detail)
                        <div class="detail-item">
                            <span>{{ $detail->uraian_detail }} ({{ $detail->jumlah }} {{ $detail->satuan }})</span>
                            <span class="currency">@ Rp {{ number_format($detail->harga, 0, ',', '.') }} = Rp {{ number_format($detail->total, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($anggaran->keterangan)
                    <div style="font-style: italic; color: #6b7280; font-size: 8px; margin-top: 2px;">
                        Ket: {{ $anggaran->keterangan }}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @empty
            <div class="no-data">- Belum ada anggaran Level 3</div>
            @endforelse
        </div>
        @empty
        <div class="no-data">- Belum ada anggaran Level 2</div>
        @endforelse
    </div>
    @empty
    <div style="text-align:center; color:#999; font-style:italic; margin-top:50px;">
        Tidak ada data anggaran{{ $tahun ? ' untuk tahun ' . $tahun->tahun : '' }}
    </div>
    @endforelse

    @if($grandTotal > 0)
    <div class="grand-total">
        <div>TOTAL ANGGARAN {{ $tahun ? strtoupper($tahun->tahun) : 'KESELURUHAN' }}</div>
        <div class="currency" style="font-size: 14px; margin-top: 5px;">
            Rp {{ number_format($grandTotal, 0, ',', '.') }}
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Sistem: DKM 2025 - Laporan Anggaran</p>
    </div>

</body>

</html>