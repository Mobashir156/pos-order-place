@extends('main.master')

@section('content')
<main class="h-full overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Order List
        </h2>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <form method="get" action="{{ route('order.search') }}" style="display: flex;align-items: center;">
                @csrf
                <input type="date" name="search" class="block w-16 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                &nbsp;&nbsp;&nbsp;<button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">Search </button>
            </form>
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Product Name</th>
                            <th class="px-4 py-3">SKU</th>
                            <th class="px-4 py-3">Order Quantity</th>
                            <th class="px-4 py-3">Product price</th>
                            <th class="px-4 py-3">Selling Price</th>
                            <th class="px-4 py-3">Tax</th>
                            <th class="px-4 py-3">Grand Total</th>

                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($data as $product)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">{{ $product->product->product_name }}</td>
                                <td class="px-4 py-3">{{ $product->product->product_sku }}</td>
                                <td class="px-4 py-3">{{ $product->qty }}</td>
                                <td class="px-4 py-3">{{ $product->subtotal }}</td>
                                <td class="px-4 py-3">{{ $product->subtotal - $product->discount }}</td>
                                <td class="px-4 py-3">{{ $product->tax }}</td>
                                <td class="px-4 py-3"> {{ $product->total }} </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800">
                {{ $data->links() }}
            </div>
        </div>


    </div>
</main>
@endsection
