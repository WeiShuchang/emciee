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
                            
                                <button type="button" class="btn btn-block btn-primary my-3 py-3" data-toggle="modal" data-target="#confirmationModal"><i class="fa fa-shopping-cart mr-1"></i> Checkout</button>
                         
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

  <!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Checkout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="checkoutForm" action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="fbName">Facebook Name</label>
                        <input type="text" class="form-control" id="fbName" name="fb_name" placeholder="Enter Facebook Name" value="{{ old('fb_name') }}">
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="number" class="form-control" id="phoneNumber" name="phone_number" placeholder="Enter Phone Number" value="{{ old('phone_number') }}">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="checkoutForm" class="btn btn-primary">Checkout</button>
                </form>
            </div>
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
