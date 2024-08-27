<x-app-layout>
    <!-- Page Heading -->
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('products.create') }}">
                    {{ __('Add') }}
                </a>
            </h2>
            <h2 class="pr-7 font-semibold text-xl text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('products.index') }}">
                    {{ __('View') }}
                </a>
            </h2>
            <h2 class="pr-7 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800">

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Edit Product') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Update the product details and save changes to the database.') }}
                    </p>         

                    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white">
                        </div>

                        <!-- Description Field -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <!-- Image Upload and Preview -->
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Image</label>
                            <div class="mb-4">
                                @if($product->image_path)
                                    <img id="imagePreview" src="{{ asset('storage/' . $product->image_path) }}" alt="Product Image" class="w-32 h-32 object-cover rounded-md">
                                @else
                                    <img id="imagePreview" src="" alt="Product Image" class="w-32 h-32 object-cover rounded-md hidden">
                                @endif
                            </div>
                            <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-gray-900 dark:text-gray-300 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>

                        <!-- Price Field -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                            <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $product->price) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white">
                        </div>

                        <!-- Stock Field -->
                        <div class="mb-4">
                            <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white">
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 dark:hover:bg-blue-400">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Script to handle image preview -->
    <script>
        document.getElementById('image').addEventListener('change', function() {
            const [file] = this.files;
            if (file) {
                const preview = document.getElementById('imagePreview');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>          
</x-app-layout>
