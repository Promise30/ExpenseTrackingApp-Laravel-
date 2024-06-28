<x-app-layout>
    {{-- @if(Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif --}}
    @if (session('alert_type') && session('alert_message'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '{{ session('alert_type') == 'success' ? 'Success' : 'Error' }}',
                text: '{{ session('alert_message') }}',
                icon: '{{ session('alert_type') }}',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    {{-- Filter by status --}}
    <form method="GET" action="{{route('expense.index')}}">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
        <div class="mb-4 md:mb-0 ml-2 mt-2">
            <label for="search" class="block text-sm font-medium text-gray-700">Search by Title</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="block w-full rounded-md border-gray-300 pr-12 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Search...">
                <x-primary-button type="submit" class="ml-3 flex-shrink-0">Search</x-primary-button>
            </div>
        </div>
    
        <div class="flex flex-col md:flex-row md:items-center ">
            <div class="mb-4 md:mb-0 md:mr-4">
                <label for="status_filter" class="block text-sm font-medium text-gray-700">Filter by Status</label>
                <div class="mt-1">
                    <select id="status_filter" name="status_filter" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $statusFilter == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $statusFilter == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
            </div>
    
            <div>
                <label for="date_filter" class="block text-sm font-medium text-gray-700">Filter by Date</label>
                <div class="mt-1">
                    <select id="date_filter" name="date_filter" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
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
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4 flex justify-end">
        <x-primary-button type="submit">Filter</x-primary-button>
    </div>

    </form>
    <div class="mt-2 w-full py-4 px-12">

    <table class="table-auto py-2 px-2 w-full ">
        <thead>
          <tr>
            <th class="text-center border-2 border-indigo-500/25">ID</th>
            <th class="text-center  border-2 border-indigo-500/15">Title</th>
            <th class="text-center  border-2 border-indigo-500/15">Status</th>
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
                <td class="text-center  border-2 border-indigo-500/25">{{ Str::title($expense->status) }}</td>
                <td class="text-center  border-2 border-indigo-500/25">{{$expense ->getTotalCostAttribute()}}</td>
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
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</x-app-layout>