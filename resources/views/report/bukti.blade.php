<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi - {{ $bukti->nomor }}</title>
    <style>
        @page {
            size: 148mm 105mm;
            margin: 4mm;
            orientation: landscape;
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .kuitansi-container {
            /* width: 100%;
            max-width: 148mm;
            margin: 0 auto;
            border: 1px solid #000;
            padding: 6mm;
            box-sizing: border-box; */
        }

        .header {
            text-align: center;
            margin-bottom: 4px;
            border-bottom: 1px solid #000;
            padding-bottom: 8px;
        }

        .header h1 {
            /* margin-bottom: 2px; */
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 10pt;
            margin: 3px 0 0 0;
            font-weight: normal;
        }

        .content {
            margin-bottom: 5px;
        }

        .row {
            display: flex;
            margin-bottom: 6px;
            align-items: baseline;
        }

        .label {
            width: 100px;
            font-weight: bold;
            flex-shrink: 0;
            font-size: 9pt;
            margin-bottom: 1mm;
        }

        .colon {
            width: 20px;
            flex-shrink: 0;
        }

        .value {
            flex: 1;
            border-bottom: 1px dotted #000;
            min-height: 20px;
            padding-bottom: 2px;
        }

        .amount-section {
            margin: 5px 0;
            padding: 8px;
            border: 1px solid #000;
            background-color: #f9f9f9;
        }

        .amount-row {
            display: flex;
            margin-bottom: 5px;
        }

        .amount-label {
            width: 80px;
            font-weight: bold;
            font-size: 9pt;
        }

        .amount-value {
            flex: 1;
            text-align: right;
            font-weight: bold;
            font-size: 12pt;
        }

        .terbilang {
            margin-top: 6px;
            font-style: italic;
            text-align: center;
            padding: 6px;
            border: 1px dashed #666;
            background-color: #fff;
            font-size: 8pt;
        }

        /* TABEL TANDA TANGAN */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6mm;
            table-layout: fixed;
            /* PAKSA LEBAR TETAP */
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            padding: 0 2mm;
            box-sizing: border-box;
        }

        .signature-label {
            font-weight: bold;
            margin-bottom: 2mm;
            font-size: 8pt;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin: 6mm auto 2mm;
            width: 55mm;
            /* Lebar garis tanda tangan */
        }

        .signature-name {
            margin: 0;
            font-style: italic;
            color: #555;
            font-size: 7.5pt;
            font-weight: bold;
        }

        .date-place {
            text-align: right;
            margin-bottom: 0px;
            font-size: 8pt;
        }

        .print-info {
            font-size: 8pt;
            color: #666;
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        @media print {
            .print-info {
                display: none;
            }
        }

        .tanggal-row {
            width: 100%;
            margin: 2mm 0;
            padding: 0;
        }

        .tanggal-label {
            font-size: 8.5pt !important;
            font-weight: normal;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: clip;
            width: 100%;
            line-height: 1.2;
            font-family: 'DejaVu Sans', sans-serif;
        }
    </style>
</head>

<body>
    <div class="kuitansi-container">
        <div class="header">
            <h1>KUITANSI</h1>
            <h2>
                @php
                $prefix = strtoupper(substr($bukti->nomor ?? $bukti->kode, 0, 3));
                $label = $prefix === 'BEL' ? 'TANDA TERIMA PEMBAYARAN' : 'TANDA TERIMA PENERIMAAN';
                @endphp
                {{ $label }}
            </h2>
        </div>

        <div class="content">
            <div class="row">
                <div class="tanggal-row">
                    <div class="tanggal-label">
                        Nomor : {{ $bukti->nomor ?? $bukti->kode }}
                    </div>
                </div>

                <div class="tanggal-row">
                    <div class="tanggal-label">
                        @php
                        $prefix = strtoupper(substr($bukti->nomor ?? $bukti->kode, 0, 3));
                        $label = $prefix === 'BEL' ? 'Dibayarkan kepada' : 'Sudah terima dari';
                        @endphp
                        {{ $label }} : {{ $bukti->penerima ?? '-' }}
                    </div>
                </div>

                <div class="tanggal-row">
                    <div class="tanggal-label">
                        Untuk pembayaran : {{ $bukti->uraian }}
                    </div>
                </div>


                <!-- @if($bukti->keterangan)
                <div class="tanggal-row">
                    <div class="tanggal-label">
                        Keterangan : {{ $bukti->keterangan }}
                    </div>
                </div>
                @endif -->
            </div>

            <div class="amount-section">
                <div class="tanggal-row">
                    <div class="tanggal-label">
                        Jumlah Rp.: {{ number_format($bukti->jumlah, 0, ',', '.') }} ( <strong>Terbilang:</strong> {{ \App\Services\TerbilangService::rupiah($bukti->jumlah) }})
                    </div>
                </div>
            </div>

            <div class="date-place">
                <p>{{ \Carbon\Carbon::parse($bukti->tanggal)->locale('id')->isoFormat('DD MMMM YYYY') }}</p>
            </div>

            <table class="signature-table">
                <tr>
                    <td>
                        <div class="signature-label">Yang Menerima</div>
                        <br>
                        <br>
                        <br>
                        <br>

                        <!-- <div class="signature-line"></div> -->
                        <p class="signature-name">
                            ( @php
                            $prefix = strtoupper(substr($bukti->nomor ?? $bukti->kode, 0, 3));
                            if ($prefix === 'BEL') {
                            // Jika pengeluaran, tampilkan nama penerima
                            echo $bukti->penerima ?? '-';
                            } else {
                            // Jika penerimaan, tampilkan "Bendahara Masjid"
                            echo 'Bendahara Masjid';
                            }
                            @endphp
                            )
                        </p>
                    </td>
                    <td>
                        <div class="signature-label">Yang Menyerahkan</div>
                        <br>
                        <br>
                        <br>
                        <br>

                        <!-- <div class="signature-line"></div> -->
                        <!-- <p class="signature-name">( {{ auth()->user()->name ?? 'Admin' }} )</p> -->
                        <p class="signature-name">
                            ( @php
                            $prefix = strtoupper(substr($bukti->nomor ?? $bukti->kode, 0, 3));
                            if ($prefix === 'PEN') {
                            // Jika pengeluaran, tampilkan nama penerima
                            echo $bukti->penerima ?? '-';
                            } else {
                            // Jika penerimaan, tampilkan "Bendahara Masjid"
                            echo 'Bendahara Masjid';
                            }
                            @endphp
                            )
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Footer -->
            <!-- <div class="footer">
                Dicetak pada: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('DD MMMM YYYY HH:mm') }} | Sistem Keuangan DKM
            </div> -->
        </div>
</body>

</html>