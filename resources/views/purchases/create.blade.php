<x-app-layout>
    <!-- Page Heading -->
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New') }}
            </h2>
            <h2 class="pr-7 font-semibold text-xl text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('purchases.index') }}">
                    {{ __('View') }} 
                </a>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('New Purchase') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Select a product and specify the quantity to restock.') }}
                    </p>         

                    <form method="POST" action="{{ route('purchases.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <!-- Product Dropdown -->
                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product</label>
                            <select name="product_id" id="product_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required >
                                <option value="" disabled selected>Choose a product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Product Details -->
                        <div id="productDetails" class="mb-4 hidden">
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                <img id="productImage" class="w-16 h-16 object-cover rounded-md border-2 border-gray-300 dark:border-gray-700 mb-2 hidden" alt="Product Image">                                
                                <strong>Sell Price:</strong> $<span id="productPrice"></span><br>
                                <strong>Current Stock:</strong> <span id="productStock"></span>
                            </p>
                        </div>

                        <!-- Quantity Input -->
                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                            <input type="number" name="quantity" id="quantity" min="1" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required >
                        </div>

                        <!-- Purchase Price -->
                        <div class="mb-4">
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purchase Price</label>
                            <input type="number" id="purchase_price" name="purchase_price" step="0.01" class="block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white" required >
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 dark:hover:bg-blue-400">
                                Purchase
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to show product details dynamically -->
    <script>
        document.getElementById('product_id').addEventListener('change', function(event) {
            const selectedProductId = event.target.value;
    
            // Hide details if no product is selected
            if (!selectedProductId) {
                document.getElementById('productDetails').classList.add('hidden');
                return;
            }
    
            const products = @json($products); // Products data passed from the controller
            const selectedProduct = products.find(product => product.id == selectedProductId);
    
            if (selectedProduct) {
                // Set product image or fallback if no image is available
                const productImage = document.getElementById('productImage');
                if (selectedProduct.image_path) {
                    productImage.src = `/storage/${selectedProduct.image_path}`;
                    productImage.alt = selectedProduct.name;
                    productImage.classList.remove('hidden');
                } else {
                    productImage.src = '';
                    productImage.alt = 'No Image Available';
                    productImage.classList.add('hidden');
                }
    
                document.getElementById('productPrice').textContent = selectedProduct.price;
                document.getElementById('productStock').textContent = selectedProduct.stock;
                document.getElementById('productDetails').classList.remove('hidden');
            }
        });
    </script>
    
</x-app-layout>
