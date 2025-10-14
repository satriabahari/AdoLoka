<x-app-layout>
    <div class="container mx-auto px-4 pt-10 pb-16">
        <a href="{{ route('home') }}"
            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-sky-200 text-sky-700 bg-white shadow-sm hover:bg-sky-50 transition mb-6">
            <span class="inline-block -ml-1">←</span> Back
        </a>

        <h1 class="text-4xl md:text-5xl font-extrabold text-sky-900 tracking-wide drop-shadow-[0_2px_0_#cfe8ff] mb-8">
            Event Mendatang
        </h1>

        <div class="space-y-8">
            @foreach ($events as $event)
                <x-event-card :event="$event" :title="$event->title" :description="$event->description" :image="$event->image_url"
                    :chips="[
                        $event->category ?? null,
                        isset($event->type) ? ucfirst($event->type) : null,
                        $event->is_strategic_location ?? false ? 'Lokasi Strategis' : null,
                    ]" />
            @endforeach

        </div>
    </div>
</x-app-layout>
