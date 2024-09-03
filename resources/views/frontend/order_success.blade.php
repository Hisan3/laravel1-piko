@extends('frontend.master')
@section('content')
<!-- start wpo-page-title -->
<section class="wpo-page-title">
<h2 class="d-none">Hide</h2>
<div class="container">
<div class="row">
    <div class="col col-xs-12">
        <div class="wpo-breadcumb-wrap">
            <ol class="wpo-breadcumb-wrap">
                <li><a href="index.html">Home</a></li>
                <li>Order Successful</li>
            </ol>
        </div>
    </div>
</div> <!-- end row -->
</div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- start error-404-section -->
<section class="error-404-section section-padding">
<div class="container">
<div class="row">
    <div class="col col-xs-12">
        <div class="content clearfix">
            <div class="error text-center">
                <img height="200" src="{{ asset('front/images/order_success.webp') }}" alt>
            </div>
            <div class="error-message">
                <h3>Congratulation! Your Order Successfully Added</h3>
                <a href="{{ route('index') }}" class="theme-btn">Back to home</a>
            </div>
        </div>
    </div>
</div> <!-- end row -->
</div> <!-- end container -->
</section>
<!-- end error-404-section -->
@endsection
