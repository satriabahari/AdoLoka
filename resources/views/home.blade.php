<x-app-layout>
    <div class="max-w-7xl mx-auto bg-white">
        <div class="bg-white overflow-hidden shadow-sm">
            <x-hero />
            <x-category-card />
            {{-- <x-events-home :events="$events" /> --}}
            <x-products />
            <x-why />
            <x-feature />
            <x-faq />
        </div>
    </div>
</x-app-layout>
