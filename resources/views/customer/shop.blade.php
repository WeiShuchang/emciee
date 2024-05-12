@extends('customer.base')

@section('page_title', 'Emciee')

@section('content')


<!-- Shop Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
       
        <!-- Shop Product Start -->
        <div class="col-lg-12 col-md-12">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <form action="{{ route('search') }}" method="GET" class="w-100">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search by name or category" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(isset($products))
                        @if($products->count() > 0)
                            <p class="mb-0 ml-3">
                                Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} results
                            </p>
                        @else
                            <p class="mb-0 ml-3">No results found.</p>
                        @endif
                </div>
                @foreach($products as $product)
                <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                    <div class="card product-item border-0 mb-4">
                        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                            <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                            <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                            <p>Art Type: {{ $product->arttype->name }}</p> <!-- Display the art type name -->
                            <div class="d-flex justify-content-center">
                                <h6>₱{{ $product->price }}</h6>
                            </div>
                            <div class="d-flex justify-content-center">
                                <p>Stocks: {{$product->stock}}</p>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-center bg-light border">
                            <a href="{{route('product.show', $product->id)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- ...More product items... -->
            </div>
            <div class="col-12 pb-1">
            <div>
                {{ $products->appends(['search' => request('search'), 'arttype' => request('arttype')])->links('vendor.pagination.default') }}
            </div>


            @endif
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>
<!-- Shop End -->


@endsection
