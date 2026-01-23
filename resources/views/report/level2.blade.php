<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Struktur Akun</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 11px;
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

        .level1-section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .level1-header {
            background-color: #c4cee5ff;
            color: black;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 12px;
            line-height: 1.1;
            margin-bottom: 2px;
        }

        .level2-section {
            margin-left: 20px;
            margin-bottom: 8px;
        }

        .level2-header {
            background-color: #eff1f4ff;
            color: black;
            padding: 4px 8px;
            font-weight: normal;
            font-style: italic;
            font-size: 11px;
            line-height: 1.0;
            letter-spacing: 0.5px;
            margin-bottom: 0.5px;
        }

        .level3-section {
            margin-left: 40px;
            margin-bottom: 8px;
        }

        .level3-item {
            background-color: #f1f5f9;
            padding: 4px 8px;
            border-left: 3px solid #64748b;
            margin-bottom: 2px;
            font-size: 10px;
        }

        .akun-code {
            font-weight: bold;
            color: #1e40af;
        }

        .akun-name {
            margin-left: 10px;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 10px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        @page {
            margin: 1.5cm;
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
            margin-left: 20px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>LAPORAN STRUKTUR AKUN LEVEL2</h1>
        <!-- <p>Level 1 → Level 2 → Level 3</p> -->
    </div>

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

            <!-- @forelse($level2->level3s as $level3)
            <div class="level3-section">
                <div class="level3-item">
                    <span class="akun-code">{{ $level1->akun1 }}.{{ $level2->akun2 }}.{{ $level3->akun3 }}</span>
                    <span class="akun-name">{{ $level3->nama }}</span>
                </div>
            </div>
            @empty
            <div class="no-data">- Belum ada Level 3</div>
            @endforelse -->
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
        <p>Sistem: DKM 2025</p>
    </div>

</body>

</html>