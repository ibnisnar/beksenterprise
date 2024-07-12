<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        // Get all forms with their related products
        $forms = App\Models\Form::with('product')->get();

        // Calculate total profit
        $totalProfit = $forms->reduce(function ($carry, $form) {
            $price = $form->product->price * $form->quantity;
            $discountedPrice = $price - $form->discount;
            return $carry + $discountedPrice;
        }, 0);

        // Calculate cash and loan amounts
        $cashAmount = $forms->where('status', 'cash')->reduce(function ($carry, $form) {
            $price = $form->product->price * $form->quantity;
            $discountedPrice = $price - $form->discount;
            return $carry + $discountedPrice;
        }, 0);

        $loanAmount = $forms->where('status', 'loan')->reduce(function ($carry, $form) {
            $price = $form->product->price * $form->quantity;
            $discountedPrice = $price - $form->discount;
            return $carry + $discountedPrice;
        }, 0);

        // Calculate profit rate
        $totalAmount = abs($cashAmount) + abs($loanAmount);
        $profitRate = $totalAmount ? ($totalProfit / $totalAmount) * 100 : 0;
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
                        <dl>
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Profit</dt>
                            <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">
                                RM{{ number_format($totalProfit ?: 0, 2) }}
                            </dd>
                        </dl>
                        <div>
                            <span class="bg-green-100 text-green-800 text-xs font-medium inline-flex items-center px-2.5 py-1 rounded-md dark:bg-green-900 dark:text-green-300">
                                <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13V1m0 0L1 5m4-4 4 4"/>
                                </svg>
                                Profit rate {{ number_format($profitRate) }}%
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 py-3">
                        <a href="">
                            <dl>
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Cash</dt>
                                <dd class="leading-none text-xl font-bold text-green-500 dark:text-green-400">
                                    RM{{ number_format($cashAmount ?: 0, 2) }}
                                </dd>
                            </dl>
                        </a>
                        <a href="">
                            <dl>
                                <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Loan</dt>
                                <dd class="leading-none text-xl font-bold text-red-600 dark:text-red-500">
                                    -RM{{ number_format($loanAmount ?: 0, 2) }}
                                </dd>
                            </dl>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
