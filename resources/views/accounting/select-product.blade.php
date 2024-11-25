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
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Select a Product</h1>

                    <form action="{{ route('accounting.by-product') }}" method="GET">
                        <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Choose a Product</label>
                        <select id="product_id" name="product_id" class="block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white mb-4" required>
                            <option value="" disabled selected>-- Select a Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 focus:outline-none">
                            View Accounting
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
