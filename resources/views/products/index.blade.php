<x-app-layout>

    <x-slot name="header">
    <div class="flex">
        <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
            <a href="{{ route('products.create') }}" >
                {{ __('Add Product') }}
            </a>
        </h2>
        <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
            
            {{ __('View Products') }} 
        </h2>
    </div>
    </x-slot>
</x-app-layout>
