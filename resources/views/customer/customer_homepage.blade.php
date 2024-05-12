@extends('customer.base')

@section('page_title', 'Emciee')

@section('content')
<style>
    .zoom-on-hover {
    transition: transform 0.3s ease;
}

.zoom-on-hover:hover {
    transform: scale(1.1);
}

</style>
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-12">
            @include('customer.messages')
            @if($cancelledOrders >= 1)
            <div class="alert alert-danger" role="alert" id="" style="display:flex; justify-content:center;">
                You have Cancelled Orders!
                <form action="{{route('hide_notif_cancelled')}}" method="post">
                    @csrf
                    <button type="submit" class="btn-primary" href="">View</button>
                </form>
            </div>
            @endif
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 500px;">
                            <img class="img-fluid" src="{{ asset('img/banner-1.jpg') }}" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                
                            </div>
                        </div>
                        <div class="carousel-item" style="height: 500px;">
                            <img class="img-fluid" src="{{ asset('img/banner-2.jpg') }}" alt="Image">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-prev-icon mb-n2"></span>
                        </div>
                    </a>
                    <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                        <div class="btn btn-dark" style="width: 45px; height: 45px;">
                            <span class="carousel-control-next-icon mb-n2"></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

        <!-- Featured Start -->
        <div class="container-fluid pt-5" id="trendy">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->

    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Trandy Products</span></h2>
        </div>
     

        <div class="row px-xl-5 pb-3">
        @foreach($products as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0" style="height: 350px;">
                    <img class="img-fluid w-100 h-100 zoom-on-hover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{ $product->name }}</h6>
                    <div class="d-flex justify-content-center">
                        <h6>₱{{ $product->price }}</h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-center bg-light border">
                    <a href="{{route('product.show', $product->id)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                </div>
            </div>
        </div>
        @endforeach

        

            

          
          
        </div>
    </div>
   

    @if($cancelledOrders >= 1)
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
@endif


  



    <script>
         document.addEventListener("DOMContentLoaded", function() {
        // Get the alert message element
        let alertMessage = document.getElementById("alert-message");

        // Set timeout to hide the alert after 5000 milliseconds (5 seconds)
        setTimeout(function() {
            // Hide the alert by changing its display style to "none"
            alertMessage.style.display = "none";
        }, 4000);
    });

    $(document).ready(function(){
        // Show modal when document is ready (remove this if not desired)
        $('#viewDeliveredModal').modal('show');

        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });

        $(".zoom").hover(function(){
            $(this).addClass('transition');
        }, function(){
            $(this).removeClass('transition');
        });

        // Hide success message after 5 seconds
        let alertMessage = document.getElementById("alert-message");
        setTimeout(function() {
            alertMessage.style.display = "none";
        }, 5000); 
    });

    $(document).ready(function(){
        // Function to close the modal when the close button is clicked
        $('#closeModalButtonJS').click(function(){
            $('#viewDeliveredModal').modal('hide');
        });
    });

    </script>

  
    @endsection