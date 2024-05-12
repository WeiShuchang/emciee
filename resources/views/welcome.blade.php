@extends('base')

@section('page_title', 'Emciee')

@section('content')
    <div class="container-fluid mb-5">
        <div class="row border-top px-xl-5">
            <div class="col-lg-12">
                <div id="header-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" style="height: 500px;">
                            <img class="img-fluid" src="{{ asset('img/banner-1.jpg') }}" alt="Image">
                            
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
    @endsection