<x-app-layout>
    <x-slot name="header">
        <div class="flex">
            <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('products.create') }}">
                    {{ __('Add') }}
                </a>
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
            <!-- Success Message -->
            @if(session('success'))
                <div id="success-alert" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" onclick="closeAlert()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title>
                            <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 00-1.414 1.414L8.828 10l-3.176 3.238a1 1 0 001.414 1.414L10 12.828l2.934 2.934a1 1 0 001.414-1.414L11.172 10l3.176-3.238z"/></svg>
                    </span>
                </div>
            @endif  
        </div>
    </div> 

    <script>
        function closeAlert() {
            const alertBox = document.getElementById('success-alert');
            if (alertBox) {
                alertBox.style.display = 'none'; // Hide the alert box
            }
        }
    </script>       
</x-app-layout>
