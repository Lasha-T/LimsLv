<x-app-layout>
    <!-- Page Heading -->
    <x-slot name="header">
        <div class="flex">      
            <h2 class="pr-7 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Active') }}
            </h2>
            <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('orders.finished') }}">
                    {{ __('Finished') }}
                </a>
            </h2> 
            <h2 class="pr-7 font-semibold text-xl  text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:text-gray-500 dark:focus:text-gray-400 leading-tight">
                <a href="{{ route('orders.canceled') }}">
                    {{ __('Canceled') }}
                </a>
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
                        {{ __('Active Orders') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Orders pending shipment and shipped') }}
                    </p>                     

                    <table class="mt-6 space-y-6 min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Order ID
                                </th>

                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Total Amount
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Status Updated
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-sm font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('orders.showDetails', ['order' => $order->id]) }}" class="text-blue-600 hover:underline" title="Order Details">
                                            {{ $order->id }}
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $order->user->name }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        ${{ number_format($order->total_amount, 2) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ ucfirst($order->status) }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{ $order->updated_at->format('M d, Y H:i') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        <form action="{{ route('order.updateStatus', $order->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <select name="status" 
                                                class="bg-gray-800 text-white border border-gray-600 p-1 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 text-sm pr-8 status-select"
                                                data-current-status="{{ $order->status }}" 
                                                onchange="showUpdateButton(this)"
                                                {{ auth()->user()->role !== 'admin' ? 'disabled' : '' }}> <!-- Conditionally disable for non-admins -->
                                                <option value="pending_shipment" {{ $order->status == 'pending_shipment' ? 'selected' : '' }}>Pending Sh.</option>
                                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                            </select>
                                            
                                            @if(auth()->user()->role === 'admin') <!-- Only show the button for admins -->
                                                <button type="submit" 
                                                    class="text-gray-500 dark:text-gray-400 border border-gray-500 dark:border-gray-400 rounded-full px-3 py-1 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition duration-200 ml-2 update-btn"
                                                    style="display: none;">
                                                    Update
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>

                    @if ($orders->isEmpty())
                        <p class="mt-6 text-gray-500 dark:text-gray-400">
                            {{ __('No orders found.') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>  
    <script src="{{ asset('js/ac.js') }}"></script> 
    <script>
        function showUpdateButton(selectElement) {
            var updateButton = selectElement.closest('form').querySelector('.update-btn');
            var currentStatus = selectElement.getAttribute('data-current-status');  // Get the original status
            var selectedStatus = selectElement.value;  // Get the selected status

            // Show the update button only if the selected status is different from the original one
            if (selectedStatus !== currentStatus) {
                updateButton.style.display = 'inline-block';
            } else {
                updateButton.style.display = 'none';
            }
        }
    </script>


</x-app-layout>
