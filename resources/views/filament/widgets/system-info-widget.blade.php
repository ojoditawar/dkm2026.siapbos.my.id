<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            🖥️ System Information & Cache Management
        </x-slot>
        
        <x-slot name="headerEnd">
            <div class="flex gap-2">
                <button 
                    onclick="clearCache()" 
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                >
                    🗑️ Clear Cache
                </button>
                <button 
                    onclick="optimizeApp()" 
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                >
                    ⚡ Optimize
                </button>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">PHP Version</h3>
                <p class="text-lg font-semibold text-blue-600 dark:text-blue-400">{{ $phpVersion }}</p>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Laravel Version</h3>
                <p class="text-lg font-semibold text-red-600 dark:text-red-400">{{ $laravelVersion }}</p>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Cache Driver</h3>
                <p class="text-lg font-semibold text-green-600 dark:text-green-400">{{ ucfirst($cacheDriver) }}</p>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Session Driver</h3>
                <p class="text-lg font-semibold text-purple-600 dark:text-purple-400">{{ ucfirst($sessionDriver) }}</p>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Queue Driver</h3>
                <p class="text-lg font-semibold text-orange-600 dark:text-orange-400">{{ ucfirst($queueDriver) }}</p>
            </div>
            
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100">Memory Usage</h3>
                <p class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ round(memory_get_usage(true) / 1024 / 1024, 2) }} MB</p>
            </div>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">Cache Management</h4>
            <p class="text-sm text-blue-700 dark:text-blue-300">
                Gunakan tombol <strong>Clear Cache</strong> untuk membersihkan semua cache aplikasi, atau 
                <strong>Optimize</strong> untuk mengoptimalkan performa aplikasi dengan membuat cache baru.
            </p>
        </div>
    </x-filament::section>

    <script>
        function clearCache() {
            if (confirm('Apakah Anda yakin ingin menghapus semua cache aplikasi?')) {
                fetch('{{ route("filament.dkm.clear-cache") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Cache berhasil dihapus!');
                        location.reload();
                    } else {
                        alert('❌ Gagal menghapus cache: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('❌ Terjadi kesalahan: ' + error.message);
                });
            }
        }
        
        function optimizeApp() {
            if (confirm('Apakah Anda yakin ingin mengoptimalkan aplikasi?')) {
                fetch('{{ route("filament.dkm.optimize-app") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('⚡ Aplikasi berhasil dioptimalkan!');
                        location.reload();
                    } else {
                        alert('❌ Gagal mengoptimalkan aplikasi: ' + data.message);
                    }
                })
                .catch(error => {
                    alert('❌ Terjadi kesalahan: ' + error.message);
                });
            }
        }
    </script>
</x-filament-widgets::widget>
