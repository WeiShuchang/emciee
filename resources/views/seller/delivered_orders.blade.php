@extends('seller.base')

@section('page_title', 'Emciee - Delivered Orders')

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
                        Delivered Orders
                    </h2>
                    <a href="{{ route('export.pdf') }}" class="btn btn-primary">Export to PDF</a>
                    @include('seller.messages')
                </div>
            </div>
        </div>
    </div>
    
    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('seller.orders.search') }}" method="GET">
                <div class="input-group mb-3">
                    <!-- Dropdown for Users -->
                    <select class="form-select" name="user">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    <!-- Dropdown for Products -->
                    <select class="form-select" name="product">
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>

            <!-- Display the number of search results -->
            <div class="alert alert-info" role="alert">
                Total search results: {{ $deliveredProducts->total() }}
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
                                    <th>Total Price</th>
                                    <th>Rating</th>
                                    <th>Products & Quantities</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deliveredProducts as $order)
                                    <tr>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->fb_name }}</td>
                                        <td>{{ $order->phone_number }}</td>
                                        <td>
                                            @php
                                                $totalPrice = 0;
                                                foreach ($order->products as $product) {
                                                    $totalPrice += $product->price * $product->pivot->quantity;
                                                }
                                                echo '₱' . number_format($totalPrice, 2);
                                            @endphp
                                        </td>
                                        <td>{{ $order->rating }}</td>
                                        <td>
                                            @foreach($order->products as $product)
                                                <ul>
                                                    <li>{{ $product->name }} ({{ $product->pivot->quantity }})</li>
                                                </ul>  
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                        {{ $deliveredProducts->appends(request()->query())->links('vendor.pagination.default') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="chart-container d-flex justify-content-center align-items-center" style="position: relative; height:40vh;">
        <canvas id="productChart"></canvas>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Retrieve data for the chart
    let productData = [];
    @foreach($deliveredProducts as $order)
        @foreach($order->products as $product)
            productData.push({
                name: "{{ $product->name }}",
                quantity: {{ $product->pivot->quantity }}
            });
        @endforeach
    @endforeach

    // Merge data based on product name
    let mergedProductData = {};
    productData.forEach(product => {
        if (!mergedProductData[product.name]) {
            mergedProductData[product.name] = product.quantity;
        } else {
            mergedProductData[product.name] += product.quantity;
        }
    });

    // Extract product names and quantities
    let productNames = Object.keys(mergedProductData);
    let productQuantities = Object.values(mergedProductData);

    // Render chart
    var ctx = document.getElementById('productChart').getContext('2d');
    var productChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: productNames,
            datasets: [{
                label: 'Quantity',
                data: productQuantities,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantity'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Product'
                    }
                }
            }
        }
    });
</script>


@endsection
