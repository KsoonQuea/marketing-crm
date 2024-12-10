<div x-data="{
    @if($attributes->get('suggestions') !== 'empty')
    suggestions: @entangle($attributes->get('suggestions')),
    @endif
}"
>
    <input
            @error($attributes->get('data'))
            {{ $attributes->merge(['class' => 'is-invalid']) }}
            @else
                {{ $attributes }}
                @enderror
                x-ref="{{ $attributes->get('id') }}"
            autocomplete="off"
            list="{{ $attributes->get('id') }}-list"
    >
    @if($attributes->get('suggestions') !== 'empty')
        <datalist id="{{ $attributes->get('id') }}-list">
            <template x-for="suggest in suggestions">
                <option :value="suggest">
            </template>
        </datalist>
    @endif
    @error($attributes->get('data'))
    <span class="text-danger tw-text-xs">{{ $message }}</span>
    @enderror
</div>
