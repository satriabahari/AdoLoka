@props([
    'title',
    'description' => null,
    'image' => null,
    'chips' => [],
    'event' => null, // ← model Event (disarankan)
])

@php
    // Jika diberi model, route binding pakai slug otomatis (getRouteKeyName = 'slug')
    $detailUrl = $event ? route('events.show', $event) : ($slug ? route('events.show', $slug) : '#');
@endphp

<div class="bg-white/95 rounded-2xl shadow-sm ring-1 ring-slate-100 overflow-hidden">
    <div class="grid md:grid-cols-[320px,1fr] items-stretch">
        {{-- Image --}}
        <div class="p-6 md:p-8">
            <a href="{{ $detailUrl }}" class="block">
                <div class="aspect-[4/3] w-full rounded-xl overflow-hidden ring-1 ring-slate-200">
                    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
                </div>
            </a>
        </div>

        {{-- Content --}}
        <div class="p-6 md:p-8 flex flex-col">
            <span class="text-xs font-semibold tracking-wider text-slate-500 mb-1">EVENT</span>
            <h2 class="text-3xl md:text-[34px] leading-tight font-extrabold text-sky-900">
                <a href="{{ $detailUrl }}" class="hover:underline underline-offset-4">{{ $title }}</a>
            </h2>

            @if ($description)
                <p class="text-slate-600 mt-3">{{ $description }}</p>
            @endif

            <div class="mt-4 flex flex-wrap gap-2">
                @foreach ($chips as $chip)
                    @if ($chip)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-700">
                            {{ $chip }}
                        </span>
                    @endif
                @endforeach
            </div>

            <div class="mt-5">
                <a href="{{ $detailUrl }}"
                    class="relative inline-flex items-center justify-center px-5 py-2.5 rounded-xl
                  text-sky-800 font-semibold ring-2 ring-sky-200 hover:ring-sky-300 bg-white/60 hover:bg-white transition">
                    Selengkapnya
                </a>
            </div>
        </div>
    </div>
</div>
