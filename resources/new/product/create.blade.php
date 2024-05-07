@extends('main.master')

@section('content')
    <style>
        button.btn.btn-danger.remove-variant {
            background: #f21c6e;
            padding: 8px;
            border-radius: 10px;
            color: #fff;
        }
    </style>

    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Product Upload
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            @endif
            @if (Session::has('success'))
                <p>{{ Session::get('success') }}</p>
            @endif
        </h2>
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('product.submit') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <!-- Product Name -->
                    <div class="mb-4">
                        <label for="product_name" class="block text-sm text-gray-700 dark:text-gray-400">Product Name</label>
                        <input type="text" name="product_name" id="product_name"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input">
                        <!-- Error message -->
                        @error('product_name')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Variants -->
                    <div class="mb-4" id="variants-container">
                        <label class="block text-sm text-gray-700 dark:text-gray-400">Variants</label>
                        <div id="variants">
                            <div class="flex items-center mb-2">
                                <select name="variants[0][type]" class="form-select mr-2" style="width: 25%;">
                                    <option value="size">Size</option>
                                    <option value="color">Color</option>
                                </select>
                                <input type="text" name="variants[0][name]" placeholder="Variant Name"
                                    class="form-input mr-2" style="width: 25%;">
                                <input type="number" name="variants[0][price]" placeholder="Price" min="0"
                                    step="0.01" class="form-input mr-2" style="width: 25%;">

                            </div>
                        </div>
                        <button type="button" id="add-variant"
                            class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">Add
                            Variant</button>

                    </div>


                    <!-- Product SKU -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 dark:text-gray-400" for="product_sku">Product SKU</label>
                        <input type="text" name="product_sku" id="product_sku"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                            required>
                        @error('product_sku')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Product Unit -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 dark:text-gray-400" for="product_unit">Product
                            Unit</label>
                        <input type="text" name="product_unit" id="product_unit" placeholder="Ex. - kg, litters, pieces"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                            required>
                            @error('product_unit')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Product Unit Value -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 dark:text-gray-400" for="product_unit_value">Product Unit
                            Value</label>
                        <input type="text" name="product_unit_value" id="product_unit_value"
                            placeholder="Ex. - 1kg, 3litters, 5pieces"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                            required>
                            @error('product_unit_value')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Selling Price -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 dark:text-gray-400" for="selling_price">Selling
                            Price</label>
                        <input type="number" name="selling_price" id="selling_price"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                            required>
                            @error('selling_price')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Purchase Price -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 dark:text-gray-400" for="purchase_price">Purchase
                            Price</label>
                        <input type="number" name="purchase_price" id="purchase_price"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                            required>
                        @error('purchase_price')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Discount -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 dark:text-gray-400" for="discount">Discount (%)</label>
                        <input type="number" name="discount" id="discount"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                            min="0" max="100">
                            @error('discount')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tax -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 dark:text-gray-400" for="tax">Tax (%)</label>
                        <input type="number" name="tax" id="tax"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                            min="0" max="100">
                            @error('tax')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Product Image -->
                    <div class="mb-4">
                        <label class="block text-sm text-gray-700 dark:text-gray-400" for="product_image"
                            class="block text-sm text-gray-700 dark:text-gray-400">Product
                            Image</label>
                        <input type="file" name="product_image" id="product_image"
                            class="block w-full mt-1 text-sm border-gray-300 dark:text-gray-300 dark:bg-gray-700 focus:border-blue-400 focus:outline-none focus:shadow-outline-blue form-input"
                            accept="image/*">
                        <!-- Error message -->
                        @error('product_image')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-4">
                        <button type="submit"
                            class="w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg active:bg-blue-600 hover:bg-blue-700 focus:outline-none focus:shadow-outline-blue">Upload
                            Product</button>
                    </div>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variantsContainer = document.getElementById('variants');
            const addVariantButton = document.getElementById('add-variant');

            let variantIndex = 1;

            addVariantButton.addEventListener('click', function() {
                const variantInput = document.createElement('div');
                variantInput.classList.add('mb-2');

                variantInput.innerHTML = `
                <div class="flex items-center mb-2">
                    <select name="variants[${variantIndex}][type]" class="form-select mr-2" style="width: 25%;">
                        <option value="size">Size</option>
                        <option value="color">Color</option>
                    </select>
                    <input type="text" name="variants[${variantIndex}][name]" placeholder="Variant Name" class="form-input mr-2" style="width: 25%;">
                    <input type="number" name="variants[${variantIndex}][price]" placeholder="Price" min="0" step="0.01" class="form-input mr-2" style="width: 25%;">
                    <button type="button" class="btn btn-danger remove-variant">Remove</button>
                </div>
                `;

                variantsContainer.appendChild(variantInput);
                variantIndex++;
            });

            variantsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-variant')) {
                    event.target.parentElement.remove();
                }
            });
        });
    </script>
@endsection
