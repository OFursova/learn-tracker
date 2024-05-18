<?php

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    #[Validate('required|string|max:255')]
    public string $name = '';

    public function store(): void
    {
        $validated = $this->validate();

        Category::create(['name' => $validated['name']]);

        $this->name = '';

        $this->dispatch('category-stored');
    }
}; ?>

<div>
    <form wire:submit="store" class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')"/>
            <x-text-input wire:model="name" id="title" name="name" type="text" class="mt-1 block w-full"
                          autocomplete="name"/>
            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-secondary-button><a href="{{url()->previous()}}">{{ __('Back') }}</a></x-secondary-button>
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="category-stored">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</div>
