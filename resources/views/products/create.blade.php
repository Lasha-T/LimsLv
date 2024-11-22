<x-app-layout>
    <!-- Page Heading -->
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add') }}
            </h2>
            <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('products.index') }}">
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
                        {{ __('Add Product') }}
                    </h2>
            
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Create a new product and add it to the database.') }}
                    </p>         

                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white">
                        </div>

                        <!-- Description Field -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                            <textarea name="description" id="description" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white"></textarea>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Product Image</label>                         
                            <img id="imagePreview" src="#" alt="Image Preview" class="mb-2 hidden w-32 h-32 object-cover rounded-md">
                            <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full text-gray-900 dark:text-gray-300 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" >
                        </div>    

                        <!-- Price Field -->
                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                            <input type="number" name="price" id="price" step="0.01" class="mt-1 block w-full border-gray-300 dark:border-gray-700 rounded-md shadow-sm dark:bg-gray-900 dark:text-white">
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 dark:hover:bg-blue-400">
                                Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Script to handle image preview -->
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    </script>      
</x-app-layout>
