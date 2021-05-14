@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-blueGray-050 border-blueGray-300 focus:border-blueGray-800 focus:ring focus:ring-blueGrayo-200 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
