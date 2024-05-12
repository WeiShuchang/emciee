@extends('seller.base')

@section('page_title', 'Emciee - Orders')

@section('content')

<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                       Shipped Orders
                    </h2>
                    @include('seller.messages')
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Facebook Name</th>
                                    <th>Phone Number</th>
                                    <th>Products Count</th>
                                    <th>Total Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shippedProducts as $order)
                                    <tr>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->fb_name }}</td>
                                        <td>{{ $order->phone_number }}</td>
                                        <td>{{ $order->products()->count() }}</td>
                                        <td>
                                            @php
                                                $totalPrice = 0;
                                                foreach ($order->products as $product) {
                                                    $totalPrice += $product->price * $product->pivot->quantity;
                                                }
                                                echo '₱' . number_format($totalPrice, 2);
                                            @endphp
                                        </td>
                                        <td>
                                            <a href="{{ route('view_checkedout_details', ['order' => $order]) }}" class="btn btn-sm btn-primary">View Details</a>
                                            <a href="{{ route('seller.mark_delivered', ['order_id' => $order->id]) }}" class="btn btn-sm btn-success">Delivered</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
