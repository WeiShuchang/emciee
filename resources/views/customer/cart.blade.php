@extends('customer.base')

@section('page_title', 'Emciee')

@section('content')
    
    <!-- Displaying paginated products -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                @include('customer.messages')
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                            $totalPrice = 0;
                        @endphp
                        @foreach($paginatedProducts as $product)
                            <tr>
                                <td class="align-middle">{{ $product->name }}</td>
                                <td class="align-middle">${{ $product->price }}</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <input type="text" class="form-control form-control-sm bg-secondary text-center" value="{{ $product->pivot->quantity }}" disabled>
                                    </div>
                                </td>
                                <td class="align-middle">${{ $product->price * $product->pivot->quantity }}</td>
                                <td class="align-middle">
                                    <form action="{{ route('cart.remove', ['productId' => $product->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @php
                                $totalPrice += $product->price * $product->pivot->quantity;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <!-- Displaying order details -->
                @if($cartOrders->isEmpty())
                    <!-- Display a message or content when there are no orders -->
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Your Cart is Empty</h4>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">Please add products to your cart to proceed to checkout.</p>
                        </div>
                    </div>
                @endif

                @foreach($cartOrders as $order)
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Order Summary</h4>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Products</h6>
                                <h6 class="font-weight-medium">Total</h6>
                            </div>
                            @foreach($order->products as $product)
                                <div class="d-flex justify-content-between mb-1">
                                    <span>{{ $product->name }}</span>
                                    <span>${{ $product->price * $product->pivot->quantity }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total Price</h5>
                                <h5 class="font-weight-bold">${{ $totalPrice }}</h5>
                            </div>
                            <form action="{{ route('checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                            </form>
                        </div>
                          <!-- Pagination links -->
                <div>
                    {{ $paginatedProducts->links('vendor.pagination.default') }}
                </div>
                    </div>
                @endforeach
              
            </div>
        </div>
    </div>

    <!-- Cart End -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the alert message element
            let alertMessage = document.getElementById("alert-message");

            // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
            setTimeout(function() {
                // Hide the alert by changing its display style to "none"
                alertMessage.style.display = "none";
            }, 4000);
        });
    </script>
@endsection
