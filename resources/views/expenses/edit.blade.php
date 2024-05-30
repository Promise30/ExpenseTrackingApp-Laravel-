<x-app-layout>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-dark text-lg font-bold">Edit expense</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('expense.update', $expense->id) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <!-- Title  -->
                <div class="mt-2">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" autofocus value="{{$expense->title}}" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>
                {{-- Description --}}
                <div class="mt-2">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-textarea placeholder="Add description" name="description" id="description" value="{{$expense->description}}" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- Quantity --}}
                <div class="mt-2">
                    <x-input-label for="quantity" :value="__('Quantity')" />
                    <x-number-input id="quantity" name="quantity" class="mt-1 block w-full"  value="{{$expense->quantity}}" />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>
                {{-- Unit Price --}}
                <div class="mt-2">
                    <x-input-label for="unit_price" :value="__('Unit Price')" />
                    <x-decimal-input id="unit_price" name="unit_price" class="mt-1 block w-full" value="{{$expense->unit_price}}" />
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
                        ]" class="mt-1 block w-full" selected="{{$expense->category}}" />
                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                </div>

                {{-- Receipt --}}

                <div class="mt-2">
                    @if ($expense->receipt)
                        <a href="{{ '/storage/' . $expense->receipt }}" class="text-dark" target="_blank">View
                            Receipt</a>
                    @endif
                    <x-input-label for="receipt" :value="__('Receipt (if any)')" />
                    <x-file-input name="receipt" id="receipt" />
                    <x-input-error :messages="$errors->get('receipt')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('expense.show', $expense->id) }}" class="mr-4">
                        <x-secondary-button>Back</x-secondary-button>
                    </a>
                    
                    <x-primary-button class="ml-3">
                        Update
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>