<x-app-layout>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-dark text-lg font-bold">Expense: {{ $expense->title }}</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-dark flex flex-col py-4">
                <p>Description: {{$expense->description}}</p>
                <hr>
                <p class="mt-2">Quantity: {{$expense->quantity}} units</p>
                <hr>
                <p class="mt-2">Unit Price: # {{$expense->unit_price}}</p>
                <hr>
                <p class="mt-2">Total Cost: # {{$expense->getTotalCostAttribute()}}</p>
                <hr>
                <p class="mt-2">Category: {{$expense->category}}</p>
                <hr>
                <p class="mt-2">Date Created: {{ $expense->created_at->format('Y-m-d H:i:s') }}</p>
                <hr>
                @if ($expense->receipt)
                <p class="mt-2">Receipt:
                    <a href="{{ '/storage/' . $expense->receipt }}" target="_blank">Receipt</a>
                </p>
                @endif
            </div>
        </div>
        <div class="flex justify-between mt-2 py-2">
            <div class="flex ">
                <a href="{{ route('expense.index') }}" class="mr-4">
                    <x-primary-button>Back</x-primary-button>
                </a>
                <a href="{{ route('expense.edit', $expense->id) }}" class="mr-2">
                    <x-primary-button>Edit</x-primary-button>
                </a>

                <form class="ml-2" action="{{ route('expense.destroy', $expense->id) }}" method="post">
                    @method('delete')
                    @csrf
                    <x-primary-button>Delete</x-primary-button>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>