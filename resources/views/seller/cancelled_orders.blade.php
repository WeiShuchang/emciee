@extends('seller.base')

@section('page_title', 'Emciee - Cancelled Orders')

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
                        Cancelled Orders
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
                                    
                                    <th>Products Count</th>
                                    <th>Total Price</th>
                                    <th>Reason for Cancel</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cancelledProducts as $order)
                                    <tr>
                                        <td>{{ $order->user->name }}</td>
                                     
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
                                        <td>{{ $order->reason_for_cancelling }}</td>
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
