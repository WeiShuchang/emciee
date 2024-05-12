@extends('customer.base')

@section('page_title', 'Rate Order')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Rate Order</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('orders.rate', ['order_id' => $order->id]) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="rating" class="col-md-4 col-form-label text-md-right">Rating (1-5)</label>

                            <div class="col-md-6">
                                <input id="rating" type="number" class="form-control @error('rating') is-invalid @enderror" name="rating" min="1" max="5" required autofocus>

                                @error('rating')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit Rating
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
