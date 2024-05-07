@extends('customer.base')

@section('page_title', 'Emciee')

@section('content')

<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5 pl-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner border">
                    <div class="carousel-item active">
                        <img class="w-100 h-100" style="object-fit: cover; max-height: 500px;" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 py-5">
            @include('customer.messages')
            <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star-half-alt"></small>
                    <small class="far fa-star"></small>
                </div>
                <small class="pt-1">(50 Reviews)</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4">${{ $product->price }}</h3>
            <p class="mb-4">{{ $product->description }}</p>
        
            <form id="add-to-cart-form" action="{{ route('cart.add', ['product' => $product->id]) }}" method="POST">
                @csrf
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <input type="number" class="form-control bg-secondary text-center" name="quantity" id="quantity" value="1">
                    </div>
                    <button type="button" class="btn btn-primary px-3" data-toggle="modal" data-target="#confirmationModal"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                </div>
            </form>

            
            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                <div class="d-inline-flex">
                    <!-- Add social media sharing buttons here -->
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Adding to Cart</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to add <span id="quantityConfirmation"></span> item(s) to your cart?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" form="add-to-cart-form" class="btn btn-primary">Add to Cart</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the quantity input element
        let quantityInput = document.getElementById("quantity");
        
        // Get the quantity confirmation element
        let quantityConfirmation = document.getElementById("quantityConfirmation");

        // Set the quantity confirmation text to match the quantity input
        quantityConfirmation.textContent = quantityInput.value;

        // Update the quantity confirmation text when quantity changes
        quantityInput.addEventListener("change", function() {
            quantityConfirmation.textContent = quantityInput.value;
        });

        // Hide the alert message element after a certain time
        let alertMessage = document.getElementById("alert-message");
        setTimeout(function() {
            alertMessage.style.display = "none";
        }, 4000);
    });
</script>

@endsection
