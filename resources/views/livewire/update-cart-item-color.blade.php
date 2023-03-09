<div class="flex items-center" x-data>
    <x-jet-secondary-button
        disabled
        x-bind:disabled="$wire.qty <= 1"
        wire:loading.attr="disabled"
        wire:target="decrement"
        wire:click="decrement" dusk="restarColor">
        -
    </x-jet-secondary-button>
    <span class="mx-2 text-gray-700">{{ $qty }}</span>
    <x-jet-secondary-button
        x-bind:disabled="$wire.qty >= $wire.quantity"
        wire:loading.attr="disabled"
        wire:target="increment"
        wire:click="increment" dusk="sumarColor">
        +
    </x-jet-secondary-button>
</div>
