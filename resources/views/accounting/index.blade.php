<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('View All') }}
            </h2>
            <h2 class="pr-7 font-semibold text-xl text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('accounting.select-product') }}">
                    {{ __('By Product') }} 
                </a>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Transaction History') }}</h2>
                    <table class="mt-6 space-y-6 min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Date
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($accountingData as $item)
                                <tr class="{{ $item->type === 'Purchase' ? 'text-red-600' : 'text-green-600' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->product_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->date)->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>                     
                    </table>
                    
                    <div class="mt-4">
                        {{ $accountingData->links() }}
                    </div>

                    @if ($accountingData->isEmpty())
                        <p class="mt-6 text-gray-500 dark:text-gray-400">
                            {{ __('No Accounting Data found.') }}
                        </p>
                    @endif
                    
                    <!-- Totals Section -->
                    <div class="mt-6 space-y-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Total for Purchases:</span>
                            <span class="text-sm font-bold text-red-600">{{ number_format($totalPurchases, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Total for Orders:</span>
                            <span class="text-sm font-bold text-green-600">{{ number_format($totalOrders, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">Profit:</span>
                            <span class="text-sm font-bold text-blue-600">{{ number_format($profit, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
