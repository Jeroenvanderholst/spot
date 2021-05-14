<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blueGray-800 leading-tight">
            {{ __('ETIM') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="h-96 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                
                @livewire('dynamic-update')

            </div>
        </div>
    </div>

</x-app-layout>
