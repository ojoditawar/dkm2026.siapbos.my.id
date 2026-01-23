<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Akun Level 3</title>
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
        }

        .level3-section {
            margin-left: 30px;
            margin-bottom: 4px;
        }

        .level3-item {
            background-color: 'white';
            padding: 3px 6px;
            border-left: 2px solid #dfdfe6ff;
            margin-bottom: 1px;
            font-size: 9px;
            line-height: 1.1;
        }

        .akun-code {
            font-weight: bold;
            color: #1e40af;
        }

        .level3-item .akun-code {
            color: #2066f0cf;
        }

        .akun-name {
            margin-left: 8px;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 9px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
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
    </style>
</head>

<body>

    <div class="header">
        <h1>STRUKTUR AKUN LEVEL 3</h1>

    </div>

    <!-- @php
    $totalLevel1 = $level1s->count();
    $totalLevel2 = $level1s->sum(function($level1) { return $level1->level2s->count(); });
    $totalLevel3 = $level1s->sum(function($level1) {
    return $level1->level2s->sum(function($level2) {
    return $level2->level3s->count();
    });
    });
    @endphp -->

    <!-- <div class="summary">
        <div class="summary-item"><strong>Total Level 1:</strong> {{ $totalLevel1 }}</div>
        <div class="summary-item"><strong>Total Level 2:</strong> {{ $totalLevel2 }}</div>
        <div class="summary-item"><strong>Total Level 3:</strong> {{ $totalLevel3 }}</div>
    </div> -->

    @forelse($level1s as $level1)
    <div class="level1-section">
        <div class="level1-header">
            <span class="akun-code">{{ $level1->akun1 }}</span>
            <span class="akun-name">{{ $level1->nama }}</span>
        </div>

        @forelse($level1->level2s as $level2)
        <div class="level2-section">
            <div class="level2-header">
                <span class="akun-code">{{ $level1->akun1 }}.{{ $level2->akun2 }}</span>
                <span class="akun-name">{{ $level2->nama }}</span>
            </div>

            @forelse($level2->level3s as $level3)
            <div class="level3-section">
                <div class="level3-item">
                    <span class="akun-code">{{ $level1->akun1 }}.{{ $level2->akun2 }}.{{ $level3->akun3 }}</span>
                    <span class="akun-name">{{ $level3->nama }}</span>
                </div>
            </div>
            @empty
            <div class="no-data">- Belum ada Level 3</div>
            @endforelse
        </div>
        @empty
        <div class="no-data">- Belum ada Level 2</div>
        @endforelse
    </div>
    @empty
    <div style="text-align:center; color:#999; font-style:italic; margin-top:50px;">
        Tidak ada data struktur akun
    </div>
    @endforelse

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        <p>Sistem: DKM 2025 - Laporan Struktur Lengkap</p>
    </div>

</body>

</html>