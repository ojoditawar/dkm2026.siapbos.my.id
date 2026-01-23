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
        <h1>RENCANA KERJA ANGGARAN MASJID </h1>
        <h1>DKM MASJID AL-KAUTSAR</h1>
        <h2>Tahun {{ $tahunValue }}</h2>

    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 50%">Uraian</th>
                <th style="width: 20%">Alokasi Pagu</th>
                <th style="width: 35%">Alokasi Tahun Lalu</th>
                <th style="width: 10%">Bertambah/Berkurang</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            $totalPerLevel1 = 0;
            @endphp

            @foreach($groupedData as $rekId => $rekGroup)
            @php
            $rek = $rekGroup->first()->first()->first()->rek;

            $rekTotal = 0;
            foreach($rekGroup as $subRekGroup) {
            foreach($subRekGroup as $rekeningGroup) {
            foreach($rekeningGroup as $pagu) {
            $rekTotal += $pagu->paguDetils->sum('total');
            }
            }
            }
            @endphp

            <tr class="level1-header">
                <td class="text-center">{{ $no++ }}</td>
                <td><strong>{{ $rek->nama }}</strong></td>
                <td class="text-right"><strong>{{ number_format($rekTotal, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>0</strong></td>
                <td class="text-right"><strong>0</strong></td>
            </tr>

            @foreach($rekGroup as $subRekId => $subRekGroup)
            @php
            $subRek = $subRekGroup->first()->first()->subRek;
            $subRekTotal = 0;
            foreach($subRekGroup as $rekeningGroup) {
            foreach($rekeningGroup as $pagu) {
            $subRekTotal += $pagu->paguDetils->sum('total');
            }
            }
            @endphp

            <tr class="level2-header">
                <td></td>
                <td>{{ $subRek->nama }}</td>
                <td class="text-right">{{ number_format($subRekTotal, 0, ',', '.') }}</td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
            </tr>

            @foreach($subRekGroup as $rekeningId => $rekeningGroup)
            @php
            $rekening = $rekeningGroup->first()->reken;
            $rekeningTotal = 0;

            foreach($rekeningGroup as $pagu) {
            $rekeningTotal += $pagu->paguDetils->sum('total');
            }
            @endphp

            <tr class="level3-header"> <!-- level rekening -->
                <td></td>
                <td style="padding-left: 10px;"><em>{{ $rekening->nama }}</em></td>
                <td class="text-right"><em>{{ number_format($rekeningTotal, 0, ',', '.') }}</em></td>
                <td class="text-right">0</td>
                <td class="text-right">0</td>
            </tr>

            @foreach($rekeningGroup as $pagu)
            @php
            $paguTotal = $pagu->paguDetils->sum('total');
            @endphp


            @if($pagu->paguDetils && $pagu->paguDetils->count() > 0)
            @foreach($pagu->paguDetils as $detail)
            <tr style="font-size: 10px; color: #666;">
                <td></td>
                <td class="detail-row" style="padding-left: 20px;">
                    - {{ $detail->uraian_detail }}
                    ({{ $detail->jumlah }} × {{ $detail->frek }} {{ $detail->satuan }} × Rp {{
                        number_format($detail->harga, 0, ',', '.') }})
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
            @endforeach

            <tr class="grand-total">
                <td colspan="2" class="text-center"><strong>Surplus Defisit Anggaran</strong></td>
                <td class="text-right"><strong>
                        @if($grandTotal < 0) ({{ number_format(abs($grandTotal), 0, ',' , '.' ) }}) @else {{
                            number_format($grandTotal, 0, ',' , '.' ) }} @endif </strong>
                </td>
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