<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('purchases.create') }}">
                    {{ __('New') }} 
                </a>
            </h2>
            <h2 class="pr-7 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('View') }}
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
                        {{ __('Purchase History') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('List of all purchases') }}
                    </p> 

                    <table class="mt-6 space-y-6 min-w-full divide-y divide-gray-200 dark:divide-gray-700">
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
                                    Date
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($purchases as $purchase)
                                <tr>                                  
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $purchase->product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $purchase->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $purchase->purchase_price }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $purchase->purchase_date->format('d-m-Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $purchases->links() }}
                    </div>

                    @if ($purchases->isEmpty())
                        <p class="mt-6 text-gray-500 dark:text-gray-400">
                            {{ __('No purchases found.') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/ac.js') }}"></script>  
</x-app-layout>
