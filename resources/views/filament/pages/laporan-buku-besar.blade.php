<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
            {{ $this->form }}
        </div>

        <!-- Report Content -->
        @if(!empty($data_buku_besar))
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Laporan Buku Besar
                    @if($masjid_id)
                    - {{ App\Models\Masjid::find($masjid_id)?->nama }}
                    @endif
                </h3>
                <p class="text-sm text-gray-600">
                    Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}
                </p>
            </div>

            <div class="p-6 space-y-8">
                @foreach($data_buku_besar as $account)
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <!-- Account Header -->
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-semibold text-gray-900">
                                    {{ $account['rekening']->akun }} - {{ $account['rekening']->nama }}
                                </h4>
                                <p class="text-sm text-gray-600">
                                    Jenis: {{ $account['rekening']->jenis }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-600">Saldo Akhir:</div>
                                <div class="font-semibold {{ $account['saldo_akhir'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format(abs($account['saldo_akhir']), 0, ',', '.') }}
                                    {{ $account['saldo_akhir'] < 0 ? '(K)' : '' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Transactions Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Trans</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uraian</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Debet</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Kredit</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($account['entries'] as $entry)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($entry['tanggal'])->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $entry['no_trans'] }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $entry['uraian'] }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-900">
                                        @if($entry['debet'] > 0)
                                        Rp {{ number_format($entry['debet'], 0, ',', '.') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-900">
                                        @if($entry['kredit'] > 0)
                                        Rp {{ number_format($entry['kredit'], 0, ',', '.') }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right font-medium {{ $entry['saldo'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format(abs($entry['saldo']), 0, ',', '.') }}
                                        {{ $entry['saldo'] < 0 ? '(K)' : '' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900">TOTAL</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right font-bold text-gray-900">
                                        Rp {{ number_format($account['total_debet'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right font-bold text-gray-900">
                                        Rp {{ number_format($account['total_kredit'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-right font-bold {{ $account['saldo_akhir'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format(abs($account['saldo_akhir']), 0, ',', '.') }}
                                        {{ $account['saldo_akhir'] < 0 ? '(K)' : '' }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endforeach

                <!-- Summary -->
                @if(count($data_buku_besar) > 1)
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-4">Ringkasan</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ count($data_buku_besar) }}</div>
                            <div class="text-sm text-gray-600">Rekening Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">
                                Rp {{ number_format(collect($data_buku_besar)->sum('total_debet'), 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-600">Total Debet</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">
                                Rp {{ number_format(collect($data_buku_besar)->sum('total_kredit'), 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-600">Total Kredit</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <div class="text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data laporan</h3>
                <p class="mt-1 text-sm text-gray-500">Klik tombol "Generate Laporan" untuk membuat laporan buku besar.</p>
            </div>
        </div>
        @endif
    </div>
</x-filament-panels::page>