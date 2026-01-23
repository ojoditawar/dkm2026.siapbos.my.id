@foreach($items as $item)
<div class="mb-2">
    <!-- Level 1: Rek (Main Category) -->
    <div class="flex justify-between items-center py-2 px-2 
            @if($item['level'] == 1) font-bold text-base bg-gray-100 border-l-4 border-blue-500
            @elseif($item['level'] == 2) font-semibold text-sm bg-gray-50 border-l-4 border-green-400 ml-4
            @else text-sm ml-8 border-l-2 border-gray-300 pl-4
            @endif">
        <span class="text-gray-800">
            {{ $item['kode'] }} - {{ $item['nama'] }}
        </span>
        <span class="text-gray-900 font-medium">
            Rp {{ number_format($item['saldo'], 0, ',', '.') }}
        </span>
    </div>

    <!-- Recursive children -->
    @if(!empty($item['children']))
    @include('filament.pages.partials.neraca-hierarchy', ['items' => $item['children']])
    @endif
</div>
@endforeach