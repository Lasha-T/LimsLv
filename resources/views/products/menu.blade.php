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
            @include('products.partials.success-message') 
        </div>
    </div> 

    <script src="{{ asset('js/ac.js') }}"></script>      
</x-app-layout>
