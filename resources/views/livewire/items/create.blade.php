<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {

    #[Validate('required|string|max:255')]
    public string $title = '';

    #[Validate('nullable|string|url|max:255')]
    public string $url = '';

    #[Validate('nullable|sometimes|integer|exists:categories,id')]
    public ?int $categoryId = null;

    public function store(): void
    {
        $validated = $this->validate();

        auth()->user()->items()->create($validated);

        $this->title = '';
        $this->url = '';
        $this->categoryId = '';

        $this->dispatch('item-stored');
    }
}; ?>

<div>
    <form wire:submit="store" class="mt-6 space-y-6">
        <div>
            <x-input-label for="title" :value="__('Title')"/>
            <x-text-input wire:model="title" id="title" name="title" type="text" class="mt-1 block w-full"
                          autocomplete="title"/>
            <x-input-error :messages="$errors->get('title')" class="mt-2"/>
        </div>

        <div>
            <x-input-label for="url" :value="__('Url')"/>
            <x-text-input wire:model="url" id="url" name="url" type="text" class="mt-1 block w-full"
                          autocomplete="url"/>
            <x-input-error :messages="$errors->get('url')" class="mt-2"/>
        </div>

        <div>
            <x-input-label for="type" :value="__('Type')"/>
            <x-text-input wire:model="categoryId" id="category_id" name="category_id" type="number" class="mt-1 block w-full"
                          autocomplete="category_id"/>
            <x-input-error :messages="$errors->get('category_id')" class="mt-2"/>
        </div>

        <div class="flex items-center gap-4">
            <x-secondary-button><a href="{{url()->previous()}}">{{ __('Back') }}</a></x-secondary-button>
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="item-stored">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</div>
