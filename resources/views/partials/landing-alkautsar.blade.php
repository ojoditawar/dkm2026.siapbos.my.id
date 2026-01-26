<section class="space-y-6">
    {{-- HERO --}}
    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl border border-neutral-200 p-6 dark:border-neutral-700">
            <div class="flex items-center gap-3">
                <span class="inline-flex rounded-full border border-neutral-200 px-3 py-1 text-xs dark:border-neutral-700">
                    Aplikasi Masjid
                </span>
                <span class="text-sm text-neutral-500 dark:text-neutral-400">
                    Transparan, rapi, mudah diakses
                </span>
            </div>

            <h1 class="mt-4 text-3xl font-bold">
                Selamat datang di Portal Masjid Al-Kautsar
            </h1>

            <p class="mt-2 text-neutral-600 dark:text-neutral-300">
                Portal layanan jamaah, jadwal kegiatan, serta grafik anggaran dan realisasi.
            </p>

            <div class="mt-5 flex flex-wrap gap-2">
                <a href="#portal" class="rounded-lg bg-neutral-900 px-4 py-2 text-sm font-semibold text-white dark:bg-white dark:text-neutral-900">
                    Jelajahi Portal
                </a>
                <a href="#keuangan" class="rounded-lg border border-neutral-200 px-4 py-2 text-sm font-semibold dark:border-neutral-700">
                    Lihat Grafik
                </a>
            </div>

            <div class="mt-6 grid gap-3 sm:grid-cols-3">
                <div class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                    <div class="font-bold">Portal Layanan</div>
                    <div class="text-sm text-neutral-500 dark:text-neutral-400">Infaq, Zakat, Donasi, dll</div>
                </div>
                <div class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                    <div class="font-bold">Jadwal</div>
                    <div class="text-sm text-neutral-500 dark:text-neutral-400">Kegiatan & Shalat</div>
                </div>
                <div class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                    <div class="font-bold">Keuangan</div>
                    <div class="text-sm text-neutral-500 dark:text-neutral-400">Anggaran vs Realisasi</div>
                </div>
            </div>
        </div>

        {{-- IMAGE --}}
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <img
                src="{{ asset('images/Alkautsar3.png') }}"
                alt="Masjid Al-Kautsar"
                class="h-full w-full object-cover" />
            <div class="absolute bottom-4 left-4 rounded-xl bg-black/50 px-4 py-3 text-white backdrop-blur">
                <div class="font-semibold">Masjid Al-Kautsar</div>
                <div class="text-xs text-white/80">Ganti gambar sesuai foto masjid Anda.</div>
            </div>
        </div>
    </div>

    {{-- PORTAL --}}
    <section id="portal" class="space-y-3">
        <div>
            <h2 class="text-lg font-bold">Portal</h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Shortcut layanan utama jamaah dan pengurus.</p>
        </div>

        <div class="grid gap-3 md:grid-cols-3">
            @php
            $portal = [
            ['label'=>'Infaq', 'href'=>'/infaq', 'desc'=>'Infaq harian/pekanan & rekap', 'icon'=>'💳'],
            ['label'=>'Zakat', 'href'=>'/zakat', 'desc'=>'Kalkulator zakat & penyaluran', 'icon'=>'🕌'],
            ['label'=>'Donasi', 'href'=>'/donasi', 'desc'=>'Donasi program masjid', 'icon'=>'🎁'],
            ['label'=>'Jadwal Shalat', 'href'=>'/jadwal-shalat', 'desc'=>'Jadwal shalat harian', 'icon'=>'🕋'],
            ['label'=>'Inventaris', 'href'=>'/inventaris', 'desc'=>'Aset & perlengkapan masjid', 'icon'=>'📦'],
            ['label'=>'Pengumuman', 'href'=>'/pengumuman', 'desc'=>'Info kegiatan & perubahan jadwal', 'icon'=>'📣'],
            ];
            @endphp

            @foreach ($portal as $p)
            <a href="{{ $p['href'] }}"
                class="group rounded-xl border border-neutral-200 p-4 transition hover:bg-neutral-50 dark:border-neutral-700 dark:hover:bg-neutral-900">
                <div class="text-2xl">{{ $p['icon'] }}</div>
                <div class="mt-2 font-semibold">{{ $p['label'] }}</div>
                <div class="text-sm text-neutral-500 dark:text-neutral-400">{{ $p['desc'] }}</div>
                <div class="mt-3 text-sm font-semibold text-neutral-700 group-hover:underline dark:text-neutral-200">
                    Buka
                </div>
            </a>
            @endforeach
        </div>
    </section>

    {{-- KEUANGAN --}}
    <section id="keuangan" class="space-y-3">
        <div>
            <h2 class="text-lg font-bold">Grafik Keuangan</h2>
            <p class="text-sm text-neutral-500 dark:text-neutral-400">Anggaran vs Realisasi (ambil dari endpoint JSON).</p>
        </div>

        <div class="grid gap-3 lg:grid-cols-2">
            <div class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                <div class="flex items-baseline justify-between">
                    <div class="font-semibold">Anggaran vs Realisasi</div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400" id="periodeLabel">Periode: -</div>
                </div>
                <div class="mt-3">
                    <canvas id="budgetChart" height="140"></canvas>
                </div>
            </div>

            <div class="rounded-xl border border-neutral-200 p-4 dark:border-neutral-700">
                <div class="flex items-baseline justify-between">
                    <div class="font-semibold">Serapan Anggaran</div>
                    <div class="text-xs text-neutral-500 dark:text-neutral-400">Realisasi ÷ Anggaran</div>
                </div>
                <div class="mt-3">
                    <canvas id="absorptionChart" height="140"></canvas>
                </div>
            </div>
        </div>
    </section>
</section>