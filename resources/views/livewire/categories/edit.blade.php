<?php

use App\Models\Category;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    public Category $category;

    #[Validate('required|string|max:255')]
    public string $name = '';

    public function mount(): void
    {
        $this->name = $this->category->name;
    }

    public function update(): void
    {
        $validated = $this->validate();

        $this->category->update($validated);

        $this->dispatch('category-updated');
    }

    public function cancel(): void
    {
        $this->dispatch('category-edit-canceled');
    }
}; ?>

<div class="w-full">
    <form wire:submit="update">
        <textarea
            wire:model="name"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        ></textarea>

        <x-input-error :messages="$errors->get('name')" class="mt-2" />
        <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        <button class="mt-4 ml-4" wire:click.prevent="cancel">Cancel</button>
    </form>
</div>
