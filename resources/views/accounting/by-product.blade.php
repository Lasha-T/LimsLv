<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('accounting.index') }}">
                    {{ __('View All') }}
                </a>
            </h2>
            <h2 class="pr-7 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('By Product') }} 
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">{{ __('Accounting for Product:') }} {{ $product->name }}</h2>
                    
                    <div class="mb-6">
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">Price: <span class="text-blue-600 dark:text-blue-400">{{ $product->price }}</span></p>
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">Current Stock: <span class="text-blue-600 dark:text-blue-400">{{ $product->stock }}</span></p>
                    </div>

                    <!-- Purchases -->
                    <h2 class="text-lg font-medium text-red-600 dark:text-red-400 mb-4">Purchases</h2>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Per Cost</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Total Cost</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Purchase Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($purchases as $purchase)
                                <tr class="text-red-600">
                                    <td class="px-6 py-4">{{ $purchase['quantity'] }}</td>
                                    <td class="px-6 py-4">{{ $purchase['total'] / $purchase['quantity'] }}</td>
                                    <td class="px-6 py-4">{{ $purchase['total'] }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($purchase['purchase_date'])->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Orders -->
                    <h2 class="text-lg font-medium text-green-600 dark:text-green-400 mb-4">Orders</h2>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Quantity</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Per Revenue</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Total Revenue</th>
                                <th class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">Order Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($orders as $order)
                                <tr class="text-green-600">
                                    <td class="px-6 py-4">{{ $order['quantity'] }}</td>
                                    <td class="px-6 py-4">{{ $order['total'] / $order['quantity'] }}</td>
                                    <td class="px-6 py-4">{{ $order['total'] }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($order['order_date'])->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Summary -->
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
