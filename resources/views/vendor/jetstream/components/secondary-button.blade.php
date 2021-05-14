<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-blueGray-300 rounded-md font-semibold text-xs text-blueGray-700 uppercase tracking-widest shadow-sm hover:text-blueGray-500 focus:outline-none focus:border-green-300 focus:shadow-outline-blue active:text-blueGray-800 active:bg-blueGray-100 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
