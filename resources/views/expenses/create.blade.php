<x-app-layout>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-dark mt-2 text-lg font-bold">Create new expense</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('expense.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- Title  -->
                <div class="mt-2">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                {{-- Description --}}
                <div class="mt-2">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-textarea placeholder="Add description" name="description" id="description" value="" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- Quantity --}}
                <div class="mt-2">
                    <x-input-label for="quantity" :value="__('Quantity')" />
                    <x-number-input id="quantity" name="quantity" class="mt-1 block w-full" value="" />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>
                {{-- Unit Price --}}
                <div class="mt-2">
                    <x-input-label for="unit_price" :value="__('Unit Price')" />
                    <x-decimal-input id="unit_price" name="unit_price" class="mt-1 block w-full" value="" />
                    <x-input-error :messages="$errors->get('unit_price')" class="mt-2" />
                </div>
                {{-- Category --}}
                <div class="mt-2">
                    <x-input-label for="category" :value="__('Category')" />
                    <x-select-input id="category" name="category" :options="[
                            'food' => 'Food',
                            'utilities' => 'Utilities',
                            'transportation' => 'Transportation',
                            'leisure' => 'Leisure',
                            'others' => 'Others'
                        ]" class="mt-1 block w-full" selected="Select Category" />
                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                </div>

                {{-- Receipt --}}

                <div class="mt-2">
                    <x-input-label for="receipt" :value="__('Receipt (if any)')" />
                    <x-file-input name="receipt" id="receipt" />
                    <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('expense.index') }}" class="mr-4">
                        <x-secondary-button>Back</x-secondary-button>
                    </a>
                    <x-primary-button class="ml-3">
                        Create
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>