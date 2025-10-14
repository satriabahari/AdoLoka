<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'flex justify-center items-center w-full px-4 py-3
                bg-gradient-to-r from-[#114177] via-[#006A9A] to-[#17A18A]
                text-white font-semibold text-sm uppercase tracking-widest
                rounded-md border border-transparent
                hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#006A9A]
                transition ease-in-out duration-150',
    ]) }}>
    {{ $slot }}
</button>
