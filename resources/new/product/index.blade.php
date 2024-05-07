@extends('main.master')

@section('content')
    <main class="h-full overflow-y-auto">
        <div class="container px-6 mx-auto grid">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Product List
            </h2>
            <a class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple" href="{{ route('product.create') }}">
                <div class="flex items-center">
                  <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                  </svg>
                </div>
                <span>Create Product</span>
              </a>
            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Product Name</th>
                                <th class="px-4 py-3">SKU</th>
                                <th class="px-4 py-3">Unit</th>
                                <th class="px-4 py-3">Unit Value</th>
                                <th class="px-4 py-3">Selling Price</th>
                                <th class="px-4 py-3">Purchase Price</th>
                                <th class="px-4 py-3">Actions</th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($data as $product)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3">{{ $product->product_name }}</td>
                                    <td class="px-4 py-3">{{ $product->product_sku }}</td>
                                    <td class="px-4 py-3">{{ $product->product_unit }}</td>
                                    <td class="px-4 py-3">{{ $product->product_unit_value }}</td>
                                    <td class="px-4 py-3">{{ $product->selling_price }}</td>
                                    <td class="px-4 py-3">{{ $product->purchase_price }}</td>
                                    <td class="px-4 py-3"><a href="{{ route('product.edit', $product->id) }}">Edit</a>
                                        <form action="{{ route('product.delete', $product->id) }}" method=""post"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
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
