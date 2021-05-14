@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-blueGray-700']) }}>
    {{ $value ?? $slot }}
</label>
