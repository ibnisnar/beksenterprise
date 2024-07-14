<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Form Details : ' . $date) }}
            </h2>
            <div class="-me-2 flex items-center">
                <a href="{{ route('forms.index') }}" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
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
                                @foreach($forms as $form)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer"  data-modal-target="info-form--{{ $form->id }}" data-modal-toggle="info-form--{{ $form->id }}">
                                        <th scope="row" class="px-6 py-4">
                                            <p>
                                                Status : {{ $form->status }}
                                            </p>
                                            <p>
                                                Product : {{ $form->product->name }}
                                            </p>
                                            <p>
                                                Qty : {{ $form->quantity }}
                                            </p>
                                            <p>
                                                Discount : RM{{ number_format($form->discount, 2) }}
                                            </p>
                                            <p>
                                                Remark : {{ $form->remark }}
                                            </p>
                                            <p>
                                                Total : RM{{ number_format($form->product->price * $form->quantity - $form->discount, 2) }}
                                            </p>
                                        </th>
                                    </tr>
                                    <div id="info-form--{{ $form->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <!-- Modal header -->
                                                <div class="flex items-center justify-between p-4 md:p-5 rounded-t">
                                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                        Select an option
                                                    </h3>
                                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="info-form--{{ $form->id }}">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                
                                                <!-- Modal footer -->
                                                <div class="flex items-center justify-between p-4 md:p-5 rounded-b gap-2">
                                                    <!-- Edit Form Button -->
                                                    <a href="{{ route('forms.edit', $form->id) }}" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Edit</a>
                                                    <!-- Delete Form Button -->
                                                    <form action="{{ route('forms.destroy', $form->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this form?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-dropdown-toggle]').forEach(function(element) {
                element.addEventListener('click', function() {
                    const dropdownId = this.getAttribute('data-dropdown-toggle');
                    const dropdownElement = document.getElementById(dropdownId);
                    if (dropdownElement) {
                        dropdownElement.classList.toggle('hidden');
                    }
                });
            });
        });
    </script>
</x-app-layout>
