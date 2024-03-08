<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="submit" wire:submit.prevent="save">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model.defer="product.name" id="name" class="block mt-1 w-full" type="text"></x-text-input>
                            <x-input-error :messages="$errors->get('product.name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <div wire:ignore>
                                <textarea wire:model.defer="product.description" id="description" data-description="@this"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                            </div>
                            <x-input-error :messages="$errors->get('product.description')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="price" :value="__('price')"></x-input-label>
                            <x-text-input wire:model.defer="product.price" id="price" type="number" min="0" step="0.01"
                                class="block mt-1 w-full"></x-text-input>
                            <x-input-error :messages="$errors->get('product.price')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="categories" :value="__('Categories')"></x-input-label>
                            <x-select2 class="mt-1" id="categories" :options="$this->listForFields['categories']" wire:model="categories"
                                multiple></x-select2>
                            <x-input-error :messages="$errors->get('categories')" class="mt-2" />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="country" :value="__('Country')"></x-input-label>
                            <x-select2 class="mt-1" id="country" name="country" :options="$this->listForFields['countries']"
                                wire:model="product.country_id" />
                            <x-input-error :messages="$errors->get('product.country_id')" class="mt-2" />
                        </div>

                    <x-primary-button class="mt-4">
                        Create
                    </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
    <script>
        var ready = (callback) => {
            if (document.readyState != "loading") callback();
            else document.addEventListener("DOMContentLoaded", callback);
        }
        ready(() => {
            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {

                    editor.editing.view.change(writer => {
                        writer.setStyle('color', 'black', editor.editing.view.document.getRoot());
                    });

                    editor.model.document.on('change:data', () => {
                        @this.set('product.description', editor.getData());
                    })
                    Livewire.on('reinit', () => {
                        editor.setData('', '')
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@endpush

