<x-app-layout>

    <div class="max-w-sm rounded overflow-hidden shadow-lg mx-auto">
        @if($expense->receipt)
        <a href="{{ '/storage/' . $expense->receipt }}" target="_blank">
            <img class="h-48 w-full object-cover object-top" src="{{ '/storage/' . $expense->receipt }}" alt="Expense Receipt">
        </a>
        @endif
        <div class="px-6 py-2">
          <div class="font-bold text-xl mb-2">{{$expense->title}}</div>
          <p class="text-gray-700 text-base">
           {{$expense->description}}
          </p>
          <hr>
          <p class="text-gray-700 text-base">
            Category: {{ Str::title($expense->category) }}
           </p>
           <hr>
          <p class="text-gray-700 text-base">
            Quantity: {{$expense->quantity}} units
          </p>
          <hr>
          <p class="text-gray-700 text-base">
            Unit Price: {{$expense->unit_price}}
          </p>
          <hr>
          <p class="text-gray-700 text-base">
            Total Cost: # {{$expense->getTotalCostAttribute()}}
          </p>
          <hr>
          <p class="text-gray-700 text-base">
            Date Created: {{$expense->created_at->format('Y-m-d')}}
          </p>
          <hr>
          <p class="text-gray-700 text-base">
            Status: {{ Str::title($expense->status) }}
          </p>
        </div>
        <div class="px-6 pb-2">
          <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
            <a href="{{ route('expense.index') }}" >
                <x-primary-button>Back</x-primary-button>
            </a>
          </span>
          {{-- @if (Auth::user()->hasRole('Administrator'))
          <span class="inline-block bg-gray-200 rounded-full px-2 py-1 text-sm font-semibold text-gray-500  mb-2"> --}}
            {{-- <a href="{{ route('expense.edit', $expense->id) }}" > 
              <form action="{{route('expense.update', $expense->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <input type="hidden" name="status" value="approved" />
                <button type="submit">Approve</button>
              </form>
                
             </a> 
          </span>
          <span class="inline-block bg-gray-200 rounded-full px-2 py-1 text-sm font-semibold text-gray-500  mb-2">
             {{-- <a href="{{ route('expense.edit', $expense->id) }}" >  --}}
              {{-- <form method="POST" action="{{ route('expense.update', $expense->id) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <input type="hidden" name="status" value="rejected" />
                <button type="submit">Reject</button>
              </form>
                 --}}
            {{-- </a>  --}}
          {{-- </span> --}}
          {{-- @if (Auth::user()->hasRole('Administrator'))
    <a href="{{ route('expense.update', ['expense' => $expense->id, 'status' => 'approved']) }}"
       class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
       onclick="event.preventDefault(); document.getElementById('approve-form').submit();">
        Approve
    </a>

    <form id="approve-form" action="{{ route('expense.update', ['expense' => $expense->id, 'status' => 'approved']) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form>

    <a href="{{ route('expense.updateStatus', ['expense' => $expense->id, 'status' => 'rejected']) }}"
       class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
       onclick="event.preventDefault(); document.getElementById('reject-form').submit();">
        Reject
    </a>

    <form id="reject-form" action="{{ route('expense.updateStatus', ['expense' => $expense->id, 'status' => 'rejected']) }}" method="POST" style="display: none;">
        @csrf
        @method('PATCH')
    </form> --}}
              
          {{-- @else --}}
          <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
            <a href="{{ route('expense.edit', $expense->id) }}" >
                <x-primary-button>Edit</x-primary-button>
            </a>
          </span>
          <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">
            <form action="{{ route('expense.destroy', $expense->id) }}" method="post">
                @method('delete')
                @csrf
                <x-primary-button>Delete</x-primary-button>
            </form>
          </span>
          {{-- @endif --}}
          
        </div>
      </div>
    </div>
</x-app-layout>