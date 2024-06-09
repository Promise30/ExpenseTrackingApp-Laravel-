{{-- <x-app-layout>



<div class=" mt-4 w-full flex justify-center align-content-center">
    <h2>Your Notifications</h2>
</div>

<ul class="list-none w-full mt-4 px-4">
    {{-- @forelse (auth()->user()->unreadNotifications as $notification) 
    @forelse ($notifications as $notification)
    <li class="rounded-md hover:bg-violet-400 w-full px-2 mb-2 border-solid border-2 border-gray-200 text-center">
        <div class="alert alert-info">
            <a href="{{route('notification.read', $notification->id)}}">
                {{ $notification->data['message'] }}
            </a>
            {{-- {{$notification->markAsRead()}} 
         Add more details or links if necessary 
        </div>
    </li>

    @empty
    <div class="w-full flex justify-center items-center mt-8">
        <h2>You do not have any unread notifications</h2>
    </div>
    @endforelse
    {{$notifications->links()}}
     {{auth()->user()->unreadNotifications->links()}} 
    @if(auth()->user()->unreadNotifications->count() != 0) 
    <div class="w-full flex justify-center items-center mt-4">
        <a href="{{ route('notification.readAll') }}">
            <x-secondary-button>
                Mark all as read
            </x-secondary-button>
        </a>
    </div>
    
    @endif 
</ul>


</x-app-layout> --}}

<x-app-layout>

    <style>
        .unread-notification {
            background-color: #0B03E9; /* Yellow background for unread notifications */
        }

        .read-notification {
            opacity: 0.4; /* Reduce opacity for read notifications */
        }
    </style>

    <div class="mt-4 mb-8 w-full flex justify-center align-content-center">
        <h2>Your Notifications</h2>
    </div>

    <ul class="list-none w-full mt-4 px-4">
        @forelse ($notifications as $notification)
        <li class="rounded-md w-full px-2 mb-2 border-solid border-2 border-gray-200 text-center hover:bg-violet-200">
            {{-- @if($notification->read_at)
                read-notification
            @else
                unread-notification
            @endif --}}
        
            <div class="alert alert-info">
                <a href="{{route('notification.read', $notification->id)}}">
                    {{ $notification->data['message'] }}
                </a>
            </div>
        </li>
        @empty
        <div class="w-full flex justify-center items-center mt-8">
            <h2>You do not have any unread notifications</h2>
        </div>
        @endforelse
        {{$notifications->links()}}
        @if(auth()->user()->unreadNotifications->count() != 0) 
        <div class="w-full flex justify-center items-center mt-4">
            <a href="{{ route('notification.readAll') }}">
                <x-secondary-button>
                    Mark all as read
                </x-secondary-button>
            </a>
        </div>
        @endif 
    </ul>

</x-app-layout>
