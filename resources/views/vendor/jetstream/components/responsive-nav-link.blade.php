@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block pl-3 pr-4 py-2 border-l-4 border-green-400 text-base font-medium text-blueGray-700 bg-green-50 focus:outline-none focus:text-blueGray-800 focus:bg-green-100 focus:border-green-700 transition duration-150 ease-in-out'
            : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-blueGray-600 hover:text-gray-800 hover:bg-blueGray-050 hover:border-blueGray-300 focus:outline-none focus:text-blueGray-800 focus:bg-gray-050 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
