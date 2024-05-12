@extends('customer.base')

@section('page_title', 'Emciee')

@section('content')
    
    <!-- Displaying paginated products -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <h3>Orders</h3>
                @include('customer.messages')
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>ArtWorks</th>
                            <th>Total Cost</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach($userOrders as $order)
                            @php
                                $totalPrice = 0; // Reset total price for each order
                            @endphp
                            <tr>
                                <td class="" style="text-align:left;">
                                    <!-- List of orders -->
                                    <ul>
                                        @foreach($order->products as $product)
                                            <li>{{ $product->name }} - ₱{{ $product->price }} X {{ $product->pivot->quantity }} </li>
                                            @php
                                                $totalPrice += $product->price * $product->pivot->quantity;
                                            @endphp
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="align-middle">
                                    ₱{{ $totalPrice }}
                                </td>
                                <td class="align-middle">
                                    @if($order->status == 'checked out' && !$order->cancelled && !$order->is_shipped && !$order->is_delivered)
                                        Parcel is being prepared for delivery
                                    @elseif($order->status == 'checked out' && !$order->cancelled && $order->is_shipped && !$order->is_delivered)
                                        Parcel is out for delivery
                                    @elseif($order->status == 'checked out' && !$order->cancelled && !$order->is_shippped && $order->is_delivered)
                                        Parcel Delivered
                                    @else
                                        {{ $order->status }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    @if($order->status == 'checked out' && !$order->cancelled && !$order->is_shipped && !$order->is_delivered)
                                        <a href="{{ route('orders.cancel_view', ['order_id' => $order->id]) }}" class="btn btn-block btn-danger my-3 py-3"> Cancel</a>
                                    @elseif($order->status == 'checked out' && !$order->cancelled && !$order->is_shipped && $order->is_delivered && !$order->rating)
                                    <a href="{{ route('orders.rate_view', ['order_id' => $order->id]) }}" class="btn btn-block btn-success my-3 py-3"> Rate </a>
                                    @elseif($order->status == 'checked out' && !$order->cancelled && !$order->is_shipped && $order->is_delivered && $order->rating)
                                    <a href="{{ route('orders.rate_view', ['order_id' => $order->id]) }}" class="btn btn-block btn-secondary my-3 py-3 disabled" > Rated </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination links -->
                <div>
                    {{ $userOrders->links('vendor.pagination.default') }}
                </div>
            </div>
        </div>
    </div>
@endsection
