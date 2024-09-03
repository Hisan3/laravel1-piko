@extends('frontend.master')
@section('content')
<!-- wpo-checkout-area start-->
<div class="wpo-checkout-area section-padding">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="single-page-title">
                <h2>Your Checkout</h2>
                <p>There are 4 products in this list</p>
            </div>
        </div>
    </div>
    <form action="{{ route('order.confirm') }}" method="POST">
        @csrf
        <div class="checkout-wrap">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="caupon-wrap s3">
                        <div class="biling-item">
                            <div class="coupon coupon-3">
                                <h2>Billing Address</h2>
                            </div>
                            <div class="billing-adress">
                                <div class="contact-form form-style">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <input type="text" placeholder="First Name*" id="fname1"
                                                name="fname">
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <input type="text" placeholder="Last Name*" id="fname2"
                                                name="lname">
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <select name="country_id" id="Country" class="form-control country">
                                                <option  >Select Country</option>
                                                @foreach ($countries as $country )
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <select name="city_id" id="city" class="form-control city">
                                                <option >Select City</option>

                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <input type="text" placeholder="Postcode / ZIP*" id="Post2"
                                                name="zip">
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <input type="text" placeholder="Company Name*" id="Company"
                                                name="company">
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <input type="text" placeholder="Email Address*" id="email4"
                                                name="email">
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-12">
                                            <input type="number" placeholder="Phone*" id="email2"
                                                name="phone">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <input type="text" placeholder="Address*" id="Adress"
                                                name="address">
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-12">
                                            <div class="note-area">
                                                <textarea name="notes"
                                                    placeholder="Additional Information"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="biling-item-3">
                                <input id="toggle4" value="1" type="checkbox" name="ship_check">
                                <label class="fontsize" for="toggle4">Ship to a Different Address?</label>
                                <div class="billing-adress" id="open4">
                                    <div class="contact-form form-style">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="First Name*" id="fname6"
                                                    name="shipping_fname">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Last Name*" id="fname7"
                                                    name="shipping_lname">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <select name="shipping_country_id" id="ship_country" class="form-control ">
                                                    <option >Country</option>
                                                    @foreach ($countries as $country )
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <select name="shipping_city_id" id="ship_city" class="form-control ">
                                                    <option > Select City</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Postcode / ZIP*" id="Post1"
                                                    name="shipping_zip">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Company Name*" id="Company1"
                                                    name="shipping_company">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="text" placeholder="Email Address*" id="email5"
                                                    name="shipping_email">
                                            </div>
                                            <div class="col-lg-6 col-md-12 col-12">
                                                <input type="number" placeholder="Phone*" id="phone1"
                                                    name="shipping_phone">
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-12">
                                                <input type="text" placeholder="Address*" id="Adress1"
                                                    name="shipping_address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="cout-order-area">
                        <h3>Your Order</h3>
                        <div class="oreder-item">
                            <div class="title">
                                <h2>Products <span>Subtotal</span></h2>
                            </div>
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($carts as $cart)
                            <div class="oreder-product">
                                <div class="images">
                                    <span>
                                        <img src="{{ asset('uploads/product/preview/') }}/{{ $cart->rel_to_product->preview }}" alt="">
                                    </span>
                                </div>
                                <div class="product">
                                    <ul>
                                        <li class="first-cart">{{ $cart->rel_to_product->product_name }}</li>
                                        <li>
                                        <li>&#2547;{{ $cart->rel_to_inventory->where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->first()->after_discount }} X {{ $cart->quantity  }}</li>
                                            <div class="rating-product">
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <i class="fi flaticon-star"></i>
                                                <span>15</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <span>&#2547;{{  $cart->rel_to_inventory->where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->first()->after_discount * $cart->quantity }}</span>
                            </div>
                            @php
                            $total += $cart->rel_to_inventory->where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->first()->after_discount * $cart->quantity;
                            @endphp
                            @endforeach

                            <!-- Shipping -->
                            <div class="mt-3 mb-3">
                                <div class="title s2">
                                    <h2>Discount<span>&#2547;{{ round(session('discount')) }}</span></h2>
                                </div>
                                <div class="title border-0">
                                    <h2>Delivery Charge</h2>
                                </div>
                                <ul>
                                    <li class="free">
                                        <input id="Free" data-discount={{ session('discount') }} class="charge" type="radio" name="charge" value="70" >
                                        <label for="Free">Inside City: <span>&#2547;70</span></label>
                                    </li>
                                    <li class="free">
                                        <input id="Local" data-discount={{ session('discount') }} class="charge" type="radio" name="charge" value="100">
                                        <label for="Local">Outside City: <span>&#2547;100</span></label>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" value="{{ round(session('discount')) }}" name="discount">
                            <input type="hidden" value="{{ round($total - session('discount')) }}" name="sub_total">
                            <div class="title s2">
                                <h2>Total<span >&#2547;<span class="final">{{ round($total - session('discount'))}}</span></span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="caupon-wrap s5">
                        <div class="payment-area">
                            <div class="row">
                                <div class="col-12">
                                    <div class="payment-option" id="open5">
                                        <h3>Payment</h3>
                                        <div class="payment-select">
                                            <ul>
                                                <li class="">
                                                    <input id="remove" type="radio" name="payment"
                                                        value="1">
                                                    <label for="remove">Cash on Delivery</label>
                                                </li>
                                                <li class="">
                                                    <input id="add" type="radio" name="payment" checked="checked" value="2">
                                                    <label for="add">Pay With SSLCOMMERZ</label>
                                                </li>
                                                <li class="">
                                                    <input id="getway" type="radio" name="payment"
                                                        value="3">
                                                    <label for="getway">Pay With STRIPE</label>
                                                </li>
                                            </ul>
                                        </div>
                                        <input type="hidden" name="customer_id" value="{{ Auth::guard('customer')->id() }}">
                                        <div id="open6" class="payment-name active">
                                            <div class="contact-form form-style">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <div class="submit-btn-area text-center">
                                                            <button class="theme-btn" type="submit">Place
                                                                Order</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
<!-- wpo-checkout-area end-->

@endsection

@section('footer_script')
<script>
    $('.charge').click(function(){
        var charge = $(this).val();
        var discount = $(this).attr('data-discount');
        var total = '{{ $total }}';
        var final_total = parseInt(total) + parseInt(charge )- parseInt((discount));
        $('.final').html(final_total);
    });
</script>
<script>
    $(document).ready(function() {
    $('.country').select2();
});
</script>
<script>
    $('.country').change(function(){
        var country_id = $(this).val();
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            'url':'/getCity',
            'type':'POST',
            data:{'country_id':country_id},
            success:function(data){
                $('.city').html(data);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
    $('.city').select2();
});
</script>
<script>
    $(document).ready(function() {
    $('#ship_country').select2();
});
</script>
<script>
    $('#ship_country').change(function(){
        var country_id = $(this).val();
        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        $.ajax({
            'url':'/getCity',
            'type':'POST',
            data:{'country_id':country_id},
            success:function(data){
                $('#ship_city').html(data);
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
    $('#ship_city').select2();
});
</script>
@endsection
