<x-app-layout>

    <div class="mr-4 py-4">
        <div class="form-group flex justify-end justify-content-end">
            <label class="mt-2" for="date_filter">Filter by Date: </label>

            <form method="get" action="{{route('expense.index')}}">
                <div class="input-group pl-2">
                    <select class="form-select" name="date_filter">
                        <option value="">All Dates</option>
                        <option value="today" {{ $dateFilter == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ $dateFilter == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                        <option value="this_week" {{ $dateFilter == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="last_week" {{ $dateFilter == 'last_week' ? 'selected' : '' }}>Last Week</option>
                        <option value="this_month" {{ $dateFilter == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="last_month" {{ $dateFilter == 'last_month' ? 'selected' : '' }}>Last Month</option>
                        <option value="this_year" {{ $dateFilter == 'this_year' ? 'selected' : '' }}>This Year</option>
                        <option value="last_year" {{ $dateFilter == 'last_year' ? 'selected' : '' }}>Last Year</option>
                        </select>
                        <x-primary-button>{{ __('Filter') }}</x-primary-button>
                </div>
            </form>

        </div>
    </div>
    <div class="mt-2 w-full py-4 px-12">
    <table class="table-auto py-2 px-2 w-full ">
        <thead>
          <tr>
            <th class="text-center border-2 border-indigo-500/25">ID</th>
            <th class="text-center  border-2 border-indigo-500/25">Title</th>
            <th class="text-center  border-2 border-indigo-500/25">Total Price</th>
            <th class="text-center  border-2 border-indigo-500/25">Date Created</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
            <tr>
                <td class="text-center  border-2 border-indigo-500/25">{{$expense->id}}</td>
                <td class="text-center  border-2 border-indigo-500/25">{{$expense->title}}</td>
                <td class="text-center  border-2 border-indigo-500/25"># {{$expense ->getTotalCostAttribute()}}</td>
                <td class="text-center  border-2 border-indigo-500/25">{{$expense->created_at->format('Y-m-d')}}</td>
                <td >
                    <form method="get" action="{{route('expense.show', $expense->id)}}">
                    <x-primary-button>{{ __('Show More') }}</x-primary-button>
                    </form>
                </td>

            </tr>
            @endforeach
            
        </tbody>
   
    </table>
    </div>
    <div class="flex justify-center">
        {{$expenses->links()}}
    </div>
    
</x-app-layout>