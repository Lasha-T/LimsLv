<x-app-layout>
    <!-- Page Heading -->
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('products.create') }}">
                    {{ __('Add') }}
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
                        {{ __('Product List') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Full list of products saved in the database.') }}
                    </p>                     

                    <table class="mt-6 space-y-6 min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Price
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Image
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Action
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($products as $product)
                                <tr>                                  
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $product->description }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $product->price }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $product->stock }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        @if ($product->image_path)
                                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded-md">
                                        @else
                                            {{ __('No Image') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="text-gray-500 dark:text-gray-400 border border-gray-500 dark:border-gray-400 rounded-full px-3 py-1 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition duration-200">
                                            Edit
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-500 dark:text-gray-400 border border-gray-500 dark:border-gray-400 rounded-full px-3 py-1 hover:bg-red-600 hover:text-white hover:border-red-600 transition duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination Links -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>                    
                </div>
            </div>
        </div>
    </div>  
    <script src="{{ asset('js/ac.js') }}"></script>  
</x-app-layout>
