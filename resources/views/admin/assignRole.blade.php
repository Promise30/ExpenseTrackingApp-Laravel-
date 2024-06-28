<x-app-layout>
    @if (Session::has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: "{{ Session::get('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    @if (Session::has('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Warning!',
                    text: "{{ Session::get('message') }}",
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-dark mt-2 text-lg font-bold">Create new expense</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('storeAssignedRole') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <div class="mt-2">
                    <x-input-label for="role" :value="__('Role')" />
                    <x-select-input id="role" name="role" :options="[
                            'administrator' => 'Administrator',
                            'user' => 'User',
                        ]" class="mt-1 block w-full" selected="Select Role" />
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('admin') }}" class="mr-4">
                        <x-secondary-button>Back</x-secondary-button>
                    </a>
                    <x-primary-button class="ml-3">
                        Assign
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
            

</x-app-layout>