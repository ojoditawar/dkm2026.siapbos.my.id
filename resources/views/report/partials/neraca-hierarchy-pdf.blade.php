@foreach($items as $item)
<div class="item-row" style="
        @if($item['level'] == 1) font-weight: bold; font-size: 13px; margin-top: 10px; background-color: #f8f9fa; padding: 5px;
        @elseif($item['level'] == 2) font-weight: 600; font-size: 12px; margin-left: 15px; padding: 3px;
        @else margin-left: 30px; font-size: 11px; padding: 2px;
        @endif
    ">
    <div class="item-name">{{ $item['kode'] }} - {{ $item['nama'] }}</div>
    <div class="item-amount">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</div>
</div>

@if(!empty($item['children']))
@include('report.partials.neraca-hierarchy-pdf', ['items' => $item['children']])
@endif
@endforeach