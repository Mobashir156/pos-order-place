@foreach ($products as $product)
    <div class="col-sm-2 col-md-6 col-lg-3 col-xl-3">
        <div class="product-info default-cover card"
            data-product-id="{{ $product->id }}"
            data-product-name="{{ $product->product_name }}"
            data-product-price="{{ $product->selling_price }}">
            <a href="javascript:void(0);" class="img-bg">
                <img src="/public/{{ Storage::url($product->product_image) }}" alt="Products">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check feather-16">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg></span>
            </a>
            <h6 class="product-name"><a href="javascript:void(0);">{{ $product->product_name }}</a></h6>
            <div class="d-flex align-items-center justify-content-center price">
                <span style="font-size: 24px">
                    ${{ $product->selling_price - $product->discount }}
                </span>
                @if ($product->discount != 0)
                    <p class="main-price">$ {{ $product->selling_price }}</p>
                @endif
            </div>
        </div>
    </div>
@endforeach
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        function addToCart(productId, productName, productPrice) {
            $.ajax({
                url: '/add-to-cart/' + productId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    updateCartDisplay(response.cartItems);

                    updateBillingSection(response.cartItems, response.tax, response.discount,
                        response.prodiscount);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        function updateCartDisplay(cartItems) {
            var cartHtml = '';
            cartItems.forEach(function(item) {
                cartHtml += '<tr>' +
                    '<td>' + item.name + '</td>' +
                    '<td>' + item.quantity + '</td>' +
                    '<td>$' + parseFloat(item.price).toFixed(2) + '</td>' +
                    '<td><button class="btn btn-danger delete-product" data-product-id="' + item.id +
                    '">Delete</button></td>' +
                    '</tr>';
            });
            $('#cart-items').html(cartHtml);
        }

        function updateBillingSection(cartItems, tax, discount, prodiscount) {
            var subtotal = 0;
            cartItems.forEach(function(item) {
                subtotal += parseFloat(item.price) * item.quantity;
            });
            $('#sub-total').text('$' + subtotal.toFixed(2));
            $('#tax').text('$' + parseFloat(tax).toFixed(2));
            $('#product-discount').text('$' + parseFloat(discount).toFixed(2));
            $('#dis').text('$' + parseFloat(prodiscount).toFixed(2));
            var total = subtotal + parseFloat(tax) - parseFloat(prodiscount);
            $('#total').text('$' + total.toFixed(2));
        }
        $('.product-info').click(function() {
            var productId = $(this).data('product-id');
            var productName = $(this).data('product-name');
            var productPrice = $(this).data('product-price');
            addToCart(productId, productName, productPrice);
        });

        $(document).on('click', '.delete-product', function() {
            var productId = $(this).data('product-id');
            deleteProductFromCart(productId);
        });

        function deleteProductFromCart(productId) {

            $.ajax({
                url: '/delete-from-cart/' + productId,
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    updateCartDisplay(response.cartItems);

                    updateBillingSection(response.cartItems, response.tax, response.discount);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
</script>

