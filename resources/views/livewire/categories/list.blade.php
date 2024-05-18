<?php

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public Collection $categories;

    public ?Category $editing = null;

    public function mount(): void
    {
        $this->categories = Cache::remember('categories', 3600,
            fn() => Category::select(['id', 'name'])->orderBy('name')->get()
        );

        $this->getCategories();
    }

    #[On('category-stored')]
    public function getCategories(): void
    {
        Cache::forget('categories');

        $this->categories = Cache::remember('categories', 3600,
            fn() => Category::select(['id', 'name', 'created_at', 'updated_at'])->orderBy('name')->get()
        );
    }

    public function edit(Category $category): void
    {
        $this->editing = $category;

        $this->getCategories();
    }

    #[On('category-edit-canceled')]
    #[On('category-updated')]
    public function disableEditing(): void
    {
        $this->editing = null;

        $this->getCategories();
    }

    public function delete(Category $category): void
    {
        $category->delete();

        $this->getCategories();
    }
}; ?>

<div class="mt-8 divide-y">
    <hr class="mb-4 shadow-sm">
    @foreach ($categories as $category)
        <div class="mt-2 p-4 bg-white shadow-sm rounded-lg flex justify-between space-x-2"
             wire:key="{{ $category->id }}">
            @if ($category->is($editing))
                <livewire:categories.edit :category="$category" :key="$category->id"/>
            @else
                <p class="text-lg text-gray-900">{{ $category->name }}</p>
            @endif

            <x-dropdown width="20">
                <x-slot name="trigger">
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <button class="ml-2" wire:click="edit({{ $category->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="24px" fill="#04a9bf"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                    </button>
                    <button class="ml-2" wire:click="delete({{ $category->id }})" wire:confirm="Are you sure to delete this category?">
                        <svg xmlns="http://www.w3.org/2000/svg" height="18px" viewBox="0 -960 960 960" width="24px" fill="#bf2506"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                    </button>
                </x-slot>
            </x-dropdown>
        </div>
    @endforeach
</div>
