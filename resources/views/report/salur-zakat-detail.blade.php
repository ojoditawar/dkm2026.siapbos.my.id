<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail Penyaluran ZIS - {{ $salur_zakat->nomor }}</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;

            @bottom-center {
                content: "Halaman " counter(page) " dari " counter(pages);
                font-size: 10pt;
                font-family: 'Times New Roman', serif;
            }
        }

        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 16pt;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 12pt;
            margin: 0;
            font-weight: normal;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .info-left,
        .info-right {
            width: 48%;
        }

        .section-title {
            font-size: 12pt;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding: 8px;
            background-color: #e8f4f8;
            border: 1px solid #000;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 10pt;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .currency {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .total-row {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .grand-total-row {
            background-color: #e0e0e0;
            font-weight: bold;
            font-size: 11pt;
        }

        .footer {
            margin-top: 30px;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
            border: 1px solid #000;
            height: 80px;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            padding: 20px;
        }

        /* Page break settings */
        .page-break {
            page-break-before: always;
        }

        .no-page-break {
            page-break-inside: avoid;
        }

        /* Header hanya di halaman pertama */
        .first-page-only {
            page-break-inside: avoid;
        }

        /* Tabel data dengan pagination */
        .data-table {
            page-break-inside: auto;
        }

        .data-table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        .data-table thead {
            display: table-header-group;
            page-break-inside: avoid;
        }

        .data-table thead tr {
            page-break-after: avoid;
        }

        .data-table tbody {
            display: table-row-group;
        }

        /* Page number at bottom like Word footer */
        .page-number-footer {
            position: fixed;
            bottom: 5mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10pt;
            font-family: 'Times New Roman', serif;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <!-- Header dan Info Section - Hanya di halaman pertama -->
    <div class="first-page-only">
        <div class="header">
            <h1>Laporan Penyaluran ZIS</h1>
            <h2>{{ $salur_zakat->jenis  }}</h2>
        </div>

        <!-- Info Section -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #ddd;">
            <tbody>
                <tr>
                    <td style="width: 20%; padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Nomor</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $salur_zakat->nomor }}</td>
                </tr>
                <tr>
                    <td style="width: 20%; padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Keterangan</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $salur_zakat->keterangan }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Detail Penerima Section Title -->
        <div class="section-title">DAFTAR PENERIMA SANTUNAN</div>
    </div>

    @if(count($details) > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Penerima</th>
                <th width="15%">Jenis</th>
                <th width="20%">Jumlah Bantuan</th>
                <th width="25%">Alamat</th>
                <th width="10%">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $index => $detail)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $detail->detilAsnaf->nama ?? '-' }}</td>
                <td class="text-center">{{ $detail->jenis ?? '-' }}</td>
                <td class="currency">Rp {{ number_format($detail->satuan, 0, ',', '.') }}</td>
                <td>{{ $detail->alamat ?? '-' }}</td>
                <td></td>
            </tr>
            @endforeach
            <tr class="grand-total-row">
                <td colspan="3" class="text-center"><strong>TOTAL BANTUAN</strong></td>
                <td class="currency"><strong>Rp {{ number_format($total_bantuan, 0, ',', '.') }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
    @else
    <div class="no-data">
        Tidak ada data penerima untuk salur zakat ini
    </div>
    @endif

    <!-- Footer dengan Tanda Tangan -->
    <div style="text-align: right; margin-bottom: 1px;">
        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($salur_zakat->tanggal)->locale('id')->isoFormat('DD MMMM YYYY') }}
    </div>
    <div class="footer">
        <table class="signature-table" style=" margin-top: 1px;">
            <tr>
                <td>
                    <div>Disiapkan Oleh:</div>
                    <div style="margin-top: 75px; border-top: 1px solid #000; padding-top: 5px;">
                        <strong>Bendahara Masjid</strong>
                    </div>
                </td>
                <td>
                    <div>Diperiksa Oleh:</div>
                    <div style="margin-top: 75px; border-top: 1px solid #000; padding-top: 5px;">
                        <strong>Ketua DKM</strong>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Page number footer like Word -->
    <div class="page-number-footer">
        @php
        $totalRecords = count($details);
        $recordsPerPage = 25; // Estimasi record per halaman
        $totalPages = max(1, ceil($totalRecords / $recordsPerPage));
        @endphp
        Halaman 1 dari {{ $totalPages }}
    </div>
</body>

</html>