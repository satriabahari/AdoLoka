@props(['active'])

@php
    $classes =
        $active ?? false
            ? 'inline-flex md:flex hidden items-center px-1 pt-1 border-b-2 border-primary text-sm font-medium leading-5 text-neutral-900 focus:outline-none focus:border-sky-700 transition duration-150 ease-in-out'
            : 'inline-flex md:flex hidden items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-neutral-700 hover:text-neutral-700 hover:border-neutral-300 focus:outline-none focus:text-neutral-700 focus:border-neutral-300 hover:border-sky-400 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
