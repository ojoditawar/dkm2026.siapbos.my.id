<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
            {{ $this->form }}
        </div>

        <!-- Report Content -->
        @if(!empty($data_neraca))
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Laporan Neraca
                    @if($masjid_id)
                    - {{ App\Models\Masjid::find($masjid_id)?->nama }}
                    @endif
                </h3>
                <p class="text-sm text-gray-600">
                    Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}
                </p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- AKTIVA -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">AKTIVA</h4>

                        <!-- Aktiva Lancar -->
                        @if(!empty($data_neraca['aktiva']['aktiva_lancar']))
                        <div class="mb-6">
                            <h5 class="font-medium text-gray-800 mb-3">Aktiva Lancar</h5>
                            <div class="space-y-2">
                                @foreach($data_neraca['aktiva']['aktiva_lancar'] as $item)
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-sm">{{ $item['kode'] }} - {{ $item['nama'] }}</span>
                                    <span class="text-sm font-medium">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Aktiva Tetap -->
                        @if(!empty($data_neraca['aktiva']['aktiva_tetap']))
                        <div class="mb-6">
                            <h5 class="font-medium text-gray-800 mb-3">Aktiva Tetap</h5>
                            <div class="space-y-2">
                                @foreach($data_neraca['aktiva']['aktiva_tetap'] as $item)
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-sm">{{ $item['kode'] }} - {{ $item['nama'] }}</span>
                                    <span class="text-sm font-medium">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Total Aktiva -->
                        <div class="border-t pt-3 mt-4">
                            <div class="flex justify-between items-center font-bold text-lg">
                                <span>TOTAL AKTIVA</span>
                                <span>Rp {{ number_format($data_neraca['aktiva']['total_aktiva'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- PASIVA -->
                    <div>
                        <h4 class="text-lg font-semibold text-gray-900 mb-4 border-b pb-2">PASIVA</h4>

                        <!-- Kewajiban -->
                        @if(!empty($data_neraca['pasiva']['kewajiban']))
                        <div class="mb-6">
                            <h5 class="font-medium text-gray-800 mb-3">Kewajiban</h5>
                            <div class="space-y-2">
                                @foreach($data_neraca['pasiva']['kewajiban'] as $item)
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-sm">{{ $item['kode'] }} - {{ $item['nama'] }}</span>
                                    <span class="text-sm font-medium">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Ekuitas -->
                        @if(!empty($data_neraca['pasiva']['ekuitas']))
                        <div class="mb-6">
                            <h5 class="font-medium text-gray-800 mb-3">Ekuitas</h5>
                            <div class="space-y-2">
                                @foreach($data_neraca['pasiva']['ekuitas'] as $item)
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-sm">{{ $item['kode'] }} - {{ $item['nama'] }}</span>
                                    <span class="text-sm font-medium">Rp {{ number_format($item['saldo'], 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Total Pasiva -->
                        <div class="border-t pt-3 mt-4">
                            <div class="flex justify-between items-center font-bold text-lg">
                                <span>TOTAL PASIVA</span>
                                <span>Rp {{ number_format($data_neraca['pasiva']['total_pasiva'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Balance Check -->
                <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                    @php
                    $balanced = $data_neraca['aktiva']['total_aktiva'] == $data_neraca['pasiva']['total_pasiva'];
                    @endphp
                    <div class="flex items-center justify-between">
                        <span class="font-medium">Status Neraca:</span>
                        <span class="font-bold {{ $balanced ? 'text-green-600' : 'text-red-600' }}">
                            {{ $balanced ? 'SEIMBANG' : 'TIDAK SEIMBANG' }}
                        </span>
                    </div>
                    @if(!$balanced)
                    <div class="mt-2 text-sm text-red-600">
                        Selisih: Rp {{ number_format(abs($data_neraca['aktiva']['total_aktiva'] - $data_neraca['pasiva']['total_pasiva']), 0, ',', '.') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data laporan</h3>
                <p class="mt-1 text-sm text-gray-500">Klik tombol "Generate Laporan" untuk membuat laporan neraca.</p>
            </div>
        </div>
        @endif
    </div>
</x-filament-panels::page>