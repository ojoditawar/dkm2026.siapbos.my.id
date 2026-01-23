<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posisi Saldo Kas - Tahun {{ $tahun }}</title>
    <style>
        @page {
            size: A4 portrait;
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
            /* border-bottom: 2px solid #000; */
            padding-bottom: 8px;
        }

        /* .sub-header {
            text-align: center;
            font-size: 8pt;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        } */

        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 14pt;
            margin: 5px 0;
            font-weight: normal;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 10pt;
        }

        .info-left,
        .info-right {
            width: 48%;
        }

        .table-container {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14pt;
            font-weight: bold;
            margin: 20px 0 10px 0;
            padding: 5px;
            background-color: #f0f0f0;
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
            padding: 6px;
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

        .summary-section {
            margin-top: 20px;
            border: 2px solid #000;
            padding: 10px;
        }

        .summary-table {
            width: 100%;
            margin-bottom: 0;
        }

        .summary-table th,
        .summary-table td {
            padding: 8px;
            font-size: 11pt;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 200px;
            text-align: center;
            border: 1px solid #000;
            padding: 10px;
            height: 80px;
        }

        .page-break {
            page-break-before: always;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            padding: 20px;
        }

        /* Page number footer */
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

        /* Print-specific styles */
        @media print {
            .page-number-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                text-align: center;
                font-size: 10pt;
                font-family: 'Times New Roman', serif;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Laporan Posisi Saldo Kas</h1>
        <h2 style="font-size: 10pt;"> Periode: {{ $periode }}</h2>
    </div>


    <!-- Info Section -->
    <!-- <div class="info-section">
        <div class="info-left">
            <strong>Tanggal Cetak:</strong> {{ $tanggal_cetak }}<br>
            <strong>Periode:</strong> {{ $periode }}
        </div>
        <div class="info-right">
            <strong>Total Jenis Kas:</strong> {{ count($total_saldo_per_jenis) }}<br>
            <strong>Grand Total Saldo:</strong> Rp {{ number_format($grand_total_saldo, 0, ',', '.') }}
        </div>
    </div> -->

    <!-- Saldo Kas Section -->
    <div class="section-title">POSISI SALDO AWAL KAS AWAL TAHUN</div>

    @if(count($saldo_data) > 0)
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="40%">Jenis Kas</th>
                <th width="20%">Bank/Rekening</th>
                <th width="20%">Jumlah Saldo</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($saldo_data as $jenisKas => $saldos)
            @foreach($saldos as $index => $saldo)
            <tr>
                @if($index == 0)
                <td rowspan="{{ count($saldos) }}" class="text-center">{{ $no++ }}</td>
                <td rowspan="{{ count($saldos) }}"><strong>{{ $jenisKas }}</strong></td>
                @endif
                <td>{{ $saldo->bank ?? '-' }}</td>
                <td class="currency">Rp {{ number_format($saldo->jumlah, 0, ',', '.') }}</td>
                <td>{{ $saldo->keterangan ?? '-' }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" class="text-right"><strong>Subtotal {{ $jenisKas }}:</strong></td>
                <td class="currency"><strong>Rp {{ number_format($total_saldo_per_jenis[$jenisKas], 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
            @endforeach
            <tr class="grand-total-row">
                <td colspan="3" class="text-center"><strong>GRAND TOTAL SALDO KAS</strong></td>
                <td class="currency"><strong>Rp {{ number_format($grand_total_saldo, 0, ',', '.') }}</strong></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    @else
    <div class="no-data">
        Tidak ada data saldo kas untuk tahun {{ $tahun }}
    </div>
    @endif

    <!-- Ringkasan Transaksi Section -->
    <div class="section-title">
        RINGKASAN TRANSAKSI
        @if($tanggal_mulai && $tanggal_sampai)
        dari {{ \Carbon\Carbon::parse($tanggal_mulai)->isoFormat('DD MMM YYYY') }} s/d {{ \Carbon\Carbon::parse($tanggal_sampai)->isoFormat('DD MMM YYYY') }}
        @else
        TAHUN {{ $tahun }}
        @endif
    </div>

    <div class="summary-section">
        <table class="summary-table">
            <tr>
                <td width="50%"><strong>Saldo Awal Tahun:</strong></td>
                <td width="50%" class="currency"><strong>Rp {{ number_format($grand_total_saldo, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td><strong>Total Pemasukan:</strong></td>
                <td class="currency text-success"><strong>Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td><strong>Total Pengeluaran:</strong></td>
                <td class="currency text-danger"><strong>Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}</strong></td>
            </tr>
            <tr class="grand-total-row">
                <td><strong>SALDO AKHIR:</strong></td>
                <td class="currency"><strong>Rp {{ number_format($saldo_akhir, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- Transaksi Terbaru Section -->
    @if(count($bukti_data) > 0)
    <div class="page-break"></div>
    <div class="section-title">TRANSAKSI TERBARU (50 Terakhir)</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nomor/Tanggal</th>
                <th width="35%">Uraian</th>
                <th width="20%">Pemasukan</th>
                <th width="20%">Pengeluaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bukti_data as $index => $bukti)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <div style="font-size: 9pt; line-height: 1.2;">
                        <strong>{{ $bukti->nomor ?? $bukti->kode ?? '-' }}</strong><br>
                        <span style="color: #666;">{{ $bukti->tanggal ? \Carbon\Carbon::parse($bukti->tanggal)->isoFormat('DD MMMM YYYY') : '-' }}</span>
                    </div>
                </td>
                <td>{{ $bukti->uraian ?? '-' }}</td>
                <td class="currency">
                    @if(substr($bukti->nomor, 0, 3) == 'PEN')
                    Rp {{ number_format($bukti->jumlah, 0, ',', '.') }}
                    @else
                    -
                    @endif
                </td>
                <td class="currency">
                    @if(substr($bukti->nomor, 0, 3) == 'BEL')
                    Rp {{ number_format($bukti->jumlah, 0, ',', '.') }}
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Mutasi Kas Section -->
    @if(isset($mutasi_detail_data) && count($mutasi_detail_data) > 0)
    <div class="page-break"></div>
    <div class="section-title">MUTASI KAS</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Nomor Mutasi</th>
                <th width="30%">Level3 (Jenis Kas)</th>
                <th width="15%">Jumlah</th>
                <th width="10%">D/K</th>
                <th width="15%">Nilai Akhir</th>
                <th width="10%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mutasi_detail_data as $index => $detail)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $detail['mutasi_nomor'] }}</td>
                <td>{{ $detail['level3_nama'] }}</td>
                <td class="currency">{{ number_format($detail['jumlah_parsed'], 0, ',', '.') }}</td>
                <td class="text-center">
                    <span style="color: {{ $detail['kolom'] == 'D' ? 'green' : 'red' }}; font-weight: bold;">
                        {{ $detail['kolom'] }}
                    </span>
                </td>
                <td class="currency" style="color: {{ $detail['kolom'] == 'D' ? 'green' : 'red' }};">
                    {{ $detail['kolom'] == 'K' ? '-' : '' }}{{ number_format($detail['jumlah_parsed'], 0, ',', '.') }}
                </td>
                <td class="text-center">
                    {{ $detail['kolom'] == 'D' ? 'Bertambah' : 'Berkurang' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary Mutasi -->
    @if(isset($mutasi_saldo_per_level3) && count($mutasi_saldo_per_level3) > 0)
    <div class="section-title">RINGKASAN PERUBAHAN SALDO PER JENIS KAS</div>
    <table>
        <thead>
            <tr>
                <th width="60%">Jenis Kas</th>
                <th width="40%">Total Perubahan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mutasi_saldo_per_level3 as $jenisKas => $perubahan)
            <tr>
                <td>{{ $jenisKas }}</td>
                <td class="currency" style="color: {{ $perubahan >= 0 ? 'green' : 'red' }};">
                    {{ $perubahan >= 0 ? '+' : '' }}{{ number_format($perubahan, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
            <tr class="grand-total-row">
                <td class="text-center"><strong>TOTAL PERUBAHAN</strong></td>
                <td class="currency"><strong>{{ number_format($total_perubahan_mutasi ?? 0, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
    @endif
    @endif

    <!-- Footer dengan Tanda Tangan -->
    <table style="width: 100%; margin-top: 30px; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; text-align: center; border: 1px solid #000; padding: 10px; height: 80px; vertical-align: top;">
                <div>Disiapkan Oleh:</div>
                <div style="margin-top: 50px; border-top: 1px solid #000; padding-top: 5px;">
                    <strong>Bendahara Masjid</strong>
                </div>
            </td>
            <td style="width: 50%; text-align: center; border: 1px solid #000; padding: 10px; height: 80px; vertical-align: top;">
                <div>Diperiksa Oleh:</div>
                <div style="margin-top: 50px; border-top: 1px solid #000; padding-top: 5px;">
                    <strong>Ketua DKM</strong>
                </div>
            </td>
        </tr>
    </table>

</body>

</html>