<x-app-layout>
    @php
        // Ambil satu gambar saja (poster utama)
        $image = $event->getFirstMediaUrl('poster') ?: $event->image_url;
    @endphp

    {{-- HERO SECTION --}}
    <section class="relative h-[220px] md:h-[280px] w-full overflow-hidden">
        <img src="{{ $image }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/30 to-black/50"></div>

        <div class="relative h-full max-w-6xl mx-auto px-4 flex items-end pb-6">
            <div class="w-full">
                <div class="flex items-center justify-between">
                    <a href="{{ route('events') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 hover:bg-white/30 text-white backdrop-blur ring-1 ring-white/30 transition">
                        ← Back
                    </a>

                </div>

                <h1 class="mt-4 text-3xl md:text-5xl font-extrabold text-white drop-shadow">{{ $event->title }}</h1>

                <div class="mt-3">
                    <span
                        class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold
                                 bg-sky-600/80 text-white shadow-sm">
                        KATEGORI EVENT: {{ ucfirst($event->type) }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- BODY --}}
    <section class="max-w-6xl mx-auto px-4 py-10 md:py-12">
        <div class="grid md:grid-cols-[1fr,360px] gap-8 items-start">
            {{-- LEFT CONTENT --}}
            <div>
                <h2 class="text-3xl md:text-4xl font-bold text-sky-900">{{ $event->title }}</h2>

                <div class="mt-4">
                    <h3 class="text-slate-700 font-semibold mb-1">Deskripsi</h3>
                    <p class="text-slate-600 leading-relaxed">
                        {{ $event->description }}
                    </p>
                </div>

                {{-- BADGE + CTA --}}
                <div class="mt-6 flex flex-col sm:flex-row sm:items-center gap-4">
                    <span
                        class="inline-flex items-center px-4 py-2 rounded-full bg-sky-100 text-sky-800 font-semibold ring-1 ring-sky-200">
                        Waktu Event : {{ $event->date_range }}
                    </span>

                    <a href="#"
                        class="inline-flex items-center justify-center px-6 py-2.5 rounded-xl font-semibold text-sky-800
                              ring-2 ring-sky-200 hover:ring-sky-300 bg-white hover:bg-sky-50 transition">
                        Daftar
                    </a>
                </div>
            </div>

            {{-- RIGHT IMAGE CARD (sama seperti hero) --}}
            <div class="relative">
                <div class="rounded-2xl p-3 bg-gradient-to-br from-sky-200 to-emerald-200 shadow-xl">
                    <div class="rounded-xl overflow-hidden bg-white ring-1 ring-black/5">
                        <img src="{{ $image }}" alt="{{ $event->title }}"
                            class="w-full h-[220px] md:h-[260px] object-cover">
                    </div>
                </div>
            </div>
        </div>

        {{-- SKIP: UMKM TERKAIT --}}

        {{-- LOCATION --}}
        <div class="mt-10 md:mt-12">
            <h3 class="text-xl font-semibold text-slate-800 mb-2">Lokasi:</h3>
            <p class="text-slate-600 mb-4">{{ $event->location }}</p>

            <div class="rounded-xl overflow-hidden shadow-xl ring-1 ring-black/5 max-w-3xl">
                <iframe class="w-full h-[320px] md:h-[380px]"
                    src="https://maps.google.com/maps?q={{ urlencode($event->location) }}&t=&z=15&ie=UTF8&iwloc=&output=embed"
                    style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</x-app-layout>
