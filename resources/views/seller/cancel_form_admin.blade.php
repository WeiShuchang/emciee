@extends('seller.base')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5>Order Details</h5>
                    </div>
                    <div class="card-body">
                        <p>User: {{ $order->user->name }}</p>
                        <p>Facebook Name: {{ $order->fb_name }}</p>
                        <p>Phone Number: {{ $order->phone_number }}</p>
                        <h6>Products:</h6>
                        <ul>
                            @php
                                $totalPrice = 0;
                            @endphp
                            @foreach($order->products as $product)
                                @php
                                    $subtotal = $product->price * $product->pivot->quantity;
                                    $totalPrice += $subtotal;
                                @endphp
                                <li>{{ $product->name }} - Quantity: {{ $product->pivot->quantity }} - Price: ₱{{ number_format($subtotal, 2) }}</li>
                            @endforeach
                        </ul>
                        <p>Total Price: ₱{{ number_format($totalPrice, 2) }}</p>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('orders.cancel_admin', ['order_id' => $order->id]) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="reason_for_cancelling">Reason for Cancelling:</label>
                                <input type="text" class="form-control" id="reason_for_cancelling" name="reason_for_cancelling" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Cancel Order</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
