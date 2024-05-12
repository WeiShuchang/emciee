@extends('customer.base')

@section('page_title', 'Cancel Order')

@section('content')
<div class="container-fluid pt-5">
    <div class="row justify-content-center px-xl-5">
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Order Details</h4>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Products</h5>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($order->products as $product)
                    <div class="d-flex justify-content-between">
                        <p>{{ $product->name }} ({{ $product->pivot->quantity }})</p>
                        @php
                            $subtotal = $product->price * $product->pivot->quantity;
                            $total += $subtotal;
                        @endphp
                        <p>${{ number_format($subtotal, 2) }}</p>
                    </div>
                    @endforeach
                    <hr class="mt-0">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Total</h6>
                        <h6 class="font-weight-medium">${{ number_format($total, 2) }}</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <form action="{{ route('orders.cancel_user', ['order_id' => $order->id]) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="reason_for_cancelling">Reason For Cancelling</label>
                            <input type="text" class="form-control" id="reason_for_cancelling" name="reason_for_cancelling" placeholder="Enter Reason for Cancelling" required>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block">Cancel Order</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
