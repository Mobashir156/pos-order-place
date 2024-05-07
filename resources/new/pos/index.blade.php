<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/public/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public//assets/css/style.css') }}" />
    <title>Test Job Pos</title>
</head>
<body>
    <div class="page-wrapper pos-pg-wrapper ms-0" style="min-height: 919px;">
        <div class="content pos-design p-0">
            <div class="row align-items-start pos-wrapper">
                <div class="col-md-12 col-lg-8">
                    <div class="pos-categories tabs_wrapper">
                        <div class="pos-products">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-3">Product Section</h5>
                            </div>
                            <!-- Search Form -->
                            <form method="GET" id="search-form" action="">
                                <input type="search" name="search" class="form-control" id="search-input" placeholder="Search Product Name/sku/" value="{{ request('search') }}">
                            </form>

                            <!-- Product List -->
                            <div class="row" id="product-list">
                                @include('main.partial.products', ['products' => $products])
                            </div>
                            <nav aria-label="Page navigation">
                                <ul class="pagination mb-0" id="pagination-links">
                                    <li class="page-item" id="previous-page"><a class="page-link" href="javascript:void(0);"><i class="fas fa-arrow-left-long me-2"></i>Previous</a></li>
                                    @foreach ($products->links()->elements[0] as $key => $value)
                                        <li class="page-item"><a class="page-link" href="{{ $value }}">{{ $key }}</a></li>
                                    @endforeach
                                    <li class="page-item"><a class="page-link" href="{{ $products->nextPageUrl() }}">Next<i class="fas fa-arrow-right-long ms-2"></i></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 ps-0">
                    <aside class="product-order-list">
                        <div class="product-added block-section">
                            <div class="head-text d-flex align-items-center justify-content-between">
                                <h6 class="d-flex align-items-center mb-0">Billing Section</h6>
                            </div>
                            <div class="block-section">
                                <div class="order-total table-responsive">
                                    <table class="table table-responsive table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>QTY</th>
                                                <th>Price</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cart-items">

                                        </tbody>
                                    </table>
                                </div>

                            </div>


                            <div class="order-total table-responsive">
                                <table class="table table-responsive table-borderless">
                                    <tbody>
                                        <tr>
                                            <td>Sub Total</td>
                                            <td id="sub-total" class="text-end">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Product discount</td>
                                            <td id="product-discount" class="text-end">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Tax</td>
                                            <td id="tax" class="text-end">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td class="danger">Discount</td>
                                            <td id="dis" class="danger text-end">$0.00</td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td id="total" class="text-end">$0.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="d-grid btn-block">
                            <form method="POST" action="/order">
                                @csrf
                                <button type="submit" class="btn btn-secondary" style="width: 100%;">
                                    Place Order
                                </button>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            function updateProductList(url) {
                $.ajax({
                    url: url,
                    success: function(response) {
                        $('#product-list').html(response);
                        history.pushState(null, null, url);
                    }
                });
            }

            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                var url = $(this).attr('action') + '?' + $(this).serialize();

                updateProductList(url);
            });

            // Pagination functionality
            $(document).on('click', '#pagination-links a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');

                updateProductList(url);
            });
        });
    </script>




</body>

</html>
