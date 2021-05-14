@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php

//werkt dit? 
$classes = ($active ?? false)
            ? 'relative items-center px-1 pt-2 pb-2 border-b-2 border-green-400 text-sm font-medium leading-5 text-blueGray-900 focus:outline-none focus:border-green-700 transition duration-150 ease-in-out'
            : 'relative items-center px-1 pt-2 pb-2 border-b-2 border-transparent text-sm font-medium leading-5 text-blueGray-500 hover:text-gray-700 hover:border-green-300 focus:outline-none focus:text-blueGray-700 focus:border-green-300 transition duration-150 ease-in-out';
// tot hier toegevoegd

switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '48':
        $width = 'w-48';
        break;
}
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
            style="display: none;"
            @click="open = false">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
