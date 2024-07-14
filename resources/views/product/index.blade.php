<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Product') }}
            </h2>
            <div class="-me-2 flex items-center">
                <a href="{{ route('product.create') }}" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
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
            <div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Item
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->isEmpty())
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center">
                                        No Data
                                    </td>
                                </tr>
                                @else
                                    @foreach($products as $item)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" data-modal-target="product-form-{{ $item->id }}" data-modal-toggle="product-form-{{ $item->id }}">
                                            <th scope="row" class="px-6 py-4">
                                                <p>
                                                    Name : {{ $item->name }}
                                                </p>
                                                <p>
                                                    Qty : {{ $item->quantity }}
                                                </p>
                                                <p>
                                                    Price : RM{{ $item->price }}
                                                </p>
                                            </th>
                                        </tr>
                                        <div id="product-form-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div class="flex items-center justify-between p-4 md:p-5 rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Select an option
                                                    </h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="product-form-{{ $item->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                
                                                <!-- Modal footer -->
                                                <div class="flex items-center justify-between p-4 md:p-5 rounded-b gap-2">
                                                    <!-- Edit Form Button -->
                                                    <a href="{{ route('product.edit', $item->id) }}" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>
                                                    <!-- Delete Form Button -->
                                                    <form action="{{ route('product.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
