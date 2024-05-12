
<style>
    /* Table styles */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    /* Card styles */
    .card {
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .card-header {
        padding: 15px;
        background-color: #f2f2f2;
        border-bottom: 1px solid #ddd;
    }

    .card-title {
        margin-bottom: 0;
        font-size: 20px;
        font-weight: bold;
    }

    .card-body {
        padding: 15px;
    }

</style>

<div class="page-body" style="margin-top:10px">
    <div class="container-xl">
        <!-- Delivered Orders Table -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Delivered Orders</h3>
                </div>
                <div class="table-responsive">
                    <table class="table">
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
                            <!-- Iterate through deliveredProducts to populate table rows -->
                            @foreach($deliveredProducts as $order)
                            <tr>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->fb_name }}</td>
                                <td>{{ $order->phone_number }}</td>
                                <td>
                                    <!-- Calculate and format total price -->
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
                                    <!-- List products and quantities -->
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
                </div>
            </div>
        </div>

        <!-- Total Price Card -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Total Price</h3>
                </div>
                <div class="card-body">
                    <h4>
                        <!-- Calculate and display total price of all orders -->
                        @php
                        $totalPriceAllOrders = 0;
                        foreach ($deliveredProducts as $order) {
                        foreach ($order->products as $product) {
                        $totalPriceAllOrders += $product->price * $product->pivot->quantity;
                        }
                        }
                        echo '₱' . number_format($totalPriceAllOrders, 2);
                        @endphp
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
