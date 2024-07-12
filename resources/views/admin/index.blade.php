<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin List') }}
            </h2>
            <div class="-me-2 flex items-center">
                <a href="{{ route('admin.create') }}" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Session::has('message'))
                <div id="toast-message" class="p-4 mb-4 text-sm text-green-800 lg:rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">{{ Session::get('message') }}</span>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            var toast = document.getElementById('toast-message');
                            if (toast) {
                                toast.style.display = 'none';
                            }
                        }, 5000); // 5 seconds
                    });
                </script>
            @endif
            @if(Session::has('error'))
                <div id="toast-error" class="p-4 mb-4 text-sm text-red-800 lg:rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <span class="font-medium">{{ Session::get('error') }}</span>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        setTimeout(function() {
                            var toast = document.getElementById('toast-error');
                            if (toast) {
                                toast.style.display = 'none';
                            }
                        }, 5000); // 5 seconds
                    });
                </script>
            @endif
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Item
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $item)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <th scope="row" class="px-6 py-4 ">
                                    <p>
                                        Name : {{ $item->name }}
                                    </p>
                                    <p>
                                        Email : {{ $item->email }}
                                    </p>
                                </th>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-evenly">
                                        <!-- Edit Product -->
                                        <a href="#" class="font-medium text-yellow-600 dark:text-yellow-500 hover:underline">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                            </svg>
                                        </a>
                                        <!-- Delete Product -->
                                        <form action="{{ route('admin.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                </svg>
                                            </button>
                                        </form>                                         
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
