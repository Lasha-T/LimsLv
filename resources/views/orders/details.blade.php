<x-app-layout>
    <!-- Page Heading -->
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('admin.orders') }}">
                    {{ __('Orders') }}
                </a>
            </h2>      
            <h2 class="pr-7 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Order Details') }}
            </h2> 
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @include('products.partials.success-message')
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">
                    
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Order ID: ') }} {{ $order->id }}
                    </h2>                   

                    <div class="mt-4">
                        <p class="text-sm text-gray-900 dark:text-gray-100">
                            <strong>{{ __('Status: ') }}</strong>{{ ucfirst($order->status) }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>{{ __('Created At: ') }}</strong>{{ $order->created_at->format('M d, Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <strong>{{ __('Order Update: ') }}</strong>
                                @if ($order->products->isNotEmpty())
                                    {{ $order->products->last()->pivot->updated_at->format('M d, Y H:i') }}
                                @else
                                    {{ __('No Updates') }}
                                @endif
                        </p>
                    </div>

                    <table class="mt-6 min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Product
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Quantity
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($order->products as $product)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $product->pivot->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        ${{ number_format($product->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        ${{ number_format($product->price * $product->pivot->quantity, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-6 px-16 flex justify-end text-lg font-bold text-gray-900 dark:text-gray-100">
                        <p>{{ __('Total Price: ') }} ${{ number_format($order->products->sum(function ($product) {
                            return $product->price * $product->pivot->quantity;
                        }), 2) }}</p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.orders') }}" class="bg-gray-300 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-full hover:bg-gray-400 dark:hover:bg-gray-600">
                            {{ __('Back to Orders') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/ac.js') }}"></script>  
</x-app-layout>
