<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-outdoor-primary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-outdoor-primaryalt active:bg-outdoor-primary focus:outline-none focus:ring-2 focus:ring-outdoor-primaryalt focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
