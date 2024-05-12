@extends('seller.base')

@section('page_title', 'Emciee - Checked Out Details')

@section('content')

<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Order #{{ $order->id }} by {{$order->user->name}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Invoice for Order #{{ $order->id }}</h3>
                            <div class="row">
                                <div class="col-6">
                                    <p class="h3">Company</p>
                                    <address>
                                        
                                        Emciee Inc.<br>
                                        emcieeartshop.com
                                    </address>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="h3">Client</p>
                                    <address>
                                        {{ $order->user->name }}<br>

                                        {{ $order->user->email }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                               
                            </div>
                            <table class="table table-transparent table-responsive">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 1%"></th>
                                        <th>Product</th>
                                        <th class="text-center" style="width: 1%">Qnt</th>
                                        <th class="text-end" style="width: 1%">Unit</th>
                                        <th class="text-end" style="width: 1%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $totalAmount = 0;
                                    @endphp
                                    @foreach($order->products as $index => $product)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <p class="strong mb-1">{{ $product->name }}</p>
                                            <div class="text-muted">{{ $product->description }}</div>
                                        </td>
                                        <td class="text-center">{{ $product->pivot->quantity }}</td>
                                        <td class="text-end">₱{{ number_format($product->price, 2) }}</td>
                                        <td class="text-end">₱{{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
                                    </tr>
                                    @php
                                    $totalAmount += $product->price * $product->pivot->quantity;
                                    @endphp
                                    @endforeach
                                  
                                    <tr>
                                        <td colspan="4" class="font-weight-bold text-uppercase text-end">Total Due</td>
                                        <td class="font-weight-bold text-end">₱{{ number_format($totalAmount , 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-muted text-center mt-5">Thank you very much for doing business with us. We look forward to working with you again!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                @foreach($order->products as $product)
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $product->name }}</h3>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid mb-2">
                            <div>{{ $product->description }}</div>
                            <div>Price: ${{ number_format($product->price, 2) }}</div>
                            <div>Quantity: {{ $product->pivot->quantity }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
