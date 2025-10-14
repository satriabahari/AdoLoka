<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Events extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    public array $events = [
        [
            'title' => 'Pasar Buah Jambi',
            'excerpt' => 'Jadikan Usahamu terkenal pada event tersebut',
            'image' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=1200&auto=format&fit=crop',
            'chips' => [
                ['text' => 'Lokal/Strategis', 'variant' => 'amber'],
                ['text' => 'UMKM/Perkebunan', 'variant' => 'emerald'],
                ['text' => 'Tahunan', 'variant' => 'teal', 'outlined' => true],
            ],
        ],
        [
            'title' => 'Car Free Night',
            'excerpt' => 'Jadikan Usahamu terkenal pada event tersebut',
            'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=1200&auto=format&fit=crop',
            'chips' => [
                ['text' => 'Lokal/Strategis', 'variant' => 'amber'],
                ['text' => 'UMKM/Kuliner', 'variant' => 'emerald'],
                ['text' => 'Mingguan', 'variant' => 'teal', 'outlined' => true],
            ],
        ],
        [
            'title' => 'Car Free Day',
            'excerpt' => 'Jadikan Usahamu terkenal pada event tersebut',
            'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1200&auto=format&fit=crop',
            'chips' => [
                ['text' => 'Lokal/Strategis', 'variant' => 'amber'],
                ['text' => 'UMKM/Kuliner', 'variant' => 'emerald'],
                ['text' => 'Mingguan', 'variant' => 'teal', 'outlined' => true],
            ],
        ],
    ];

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.events');
    }
}
