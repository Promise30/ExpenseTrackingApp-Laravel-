<x-app-layout>
    <div class="mt-2 w-full py-4 px-12">

        <table class="table-auto py-2 px-2 w-full ">
            <thead>
              <tr>
                <th class="text-center border-2 border-indigo-500/25">ID</th>
                <th class="text-center  border-2 border-indigo-500/15">Name</th>
                <th class="text-center  border-2 border-indigo-500/15">Email</th>
                <th class="text-center  border-2 border-indigo-500/15">Roles</th>
              </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-center  border-2 border-indigo-500/25">{{$user->id}}</td>
                    <td class="text-center  border-2 border-indigo-500/25">{{ Str::title($user->name) }}</td>
                    <td class="text-center  border-2 border-indigo-500/25">{{$user->email}}</td>
                    <td class="text-center border-2 border-indigo-500/25">
                        @if($user->roles->isNotEmpty())
                            {{$user->roles->pluck('name')->implode(', ')}}</td>
                        @else
                            No roles assigned
                        @endif
                    <td class="ml-4" >
                        <form method="get" action="{{ route('assignRole', ['user' => $user->id]) }}">
                            <x-primary-button>{{ __('Assign Role') }}</x-primary-button>
                        </form>
                    </td>
                </tr>
               
                @endforeach
            </tbody>
        </table>
        </div>
        {{-- <div class="flex justify-center">
            {{$users->links()}}
        </div> --}}

</x-app-layout>