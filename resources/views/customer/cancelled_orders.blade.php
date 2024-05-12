@extends('customer.base')

@section('page_title', 'Emciee')

@section('content')
    
    <!-- Displaying paginated products -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-12 table-responsive mb-5">
                <h3>Cancelled Orders</h3>
                @include('customer.messages')
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>ArtWorks</th>
                            <th>Total Cost</th>
                            <th>Reason</th>
                           
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
                                    {{$order->reason_for_cancelling}}
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
