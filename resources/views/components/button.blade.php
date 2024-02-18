<button {{ $attributes->merge([
    'type' => 'button'
]) }} class="btn btn-outline-light">
    {{ $slot }}
</button>
