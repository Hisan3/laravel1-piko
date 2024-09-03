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
                                <li><a href="product.html">Product Page</a></li>
                                <li>Cart</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- cart-area-s2 start -->
        <div class="cart-area-s2 section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="single-page-title">
                            <h2>Your Cart</h2>
                            <p>There are {{ $carts->count() }} products in this list</p>
                        </div>
                    </div>
                </div>
                <div class="cart-wrapper">
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <form action="{{ route('cart.update') }}" method="POST">
                                @csrf
                                <div class="cart-item">
                                    <table class="table-responsive cart-wrap">
                                        <thead>
                                            <tr>
                                                <th class="images images-b">Product</th>
                                                <th class="ptice">Price</th>
                                                <th class="stock">Quantity</th>
                                                <th class="ptice total">Subtotal</th>
                                                <th class="remove remove-b">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                             $sub =0;
                                            ?>
                                            @foreach ($carts as $cart)
                                            <tr class="wishlist-item">
                                                <td class="product-item-wish">
                                                    <div class="check-box"><input type="checkbox"
                                                            class="myproject-checkbox">
                                                    </div>
                                                    <div class="images">
                                                        <span>
                                                            <img src="{{ asset('uploads/product/preview') }}/{{ $cart->rel_to_product->preview }}" alt="">
                                                        </span>
                                                    </div>
                                                    <div class="product">
                                                        <ul>
                                                            <li class="first-cart">{{ $cart->rel_to_product->product_name }}</li>
                                                            <li>
                                                                <div class="rating-product">
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <span>130</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="ptice">&#2547;{{ $cart->rel_to_inventory->where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->first()->after_discount }}</td>
                                                <td class="td-quantity">
                                                    <div class="quantity cart-plus-minus">
                                                        <input class="text-value" type="text" name="quantity[{{ $cart->id }}]" value="{{ $cart->quantity }}">
                                                        <div class="dec qtybutton">-</div>
                                                        <div class="inc qtybutton">+</div>
                                                    </div>
                                                </td>
                                                <td class="ptice">&#2547;{{ $cart->rel_to_inventory->where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->first()->after_discount * $cart->quantity }}</td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn"><a data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="" href="{{ route('cart.remove',$cart->id) }}"
                                                                data-bs-original-title="Remove from Cart"
                                                                aria-label="Remove from Cart"><i
                                                                    class="fi ti-trash"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php
                                            $sub += $cart->rel_to_inventory->where('product_id',$cart->product_id)->where('color_id',$cart->color_id)->where('size_id',$cart->size_id)->first()->after_discount * $cart->quantity  ;
                                           ?>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                                <div class="cart-action">
                                    <button class="theme-btn-s2" type="submit"><i class="fi flaticon-refresh"></i> Update Cart</button>
                                </div>
                            </form>
                        </div>
                        @php
                           if ($type) {
                            if ($type == 1) {
                                $discount = $sub * $amount/100;
                            }else {
                                $discount =$amount;
                            }
                           }else{
                                $discount = 0;
                           }
                        @endphp
                        <div class="col-lg-4 col-12">
                            <div class="mb-3" >
                                @if ($msg)
                                    <div class="alert alert-danger">{{ $msg }}</div>
                                @endif
                                <form class="apply-area" action="{{ route('cart') }}" method="GET">
                                <input type="text" name="coupon" class="form-control" placeholder="Enter your coupon" value="{{ @$_GET['coupon'] }}">
                                <button class="theme-btn-s2" type="submit">Apply</button>
                            </form>
                            </div>
                            <div class="cart-total-wrap">
                                <h3>Cart Totals</h3>
                                <div class="sub-total">
                                    <h4>Subtotal</h4>
                                    <span>&#2547;{{ $sub}}</span>
                                </div>
                                <div class="sub-total my-3">
                                    <h4>Discount</h4>
                                    <span>&#2547;{{ $discount }}</span>
                                </div>
                                <div class="total mb-3">
                                    <h4>Total</h4>
                                    <span>&#2547;{{ $sub-$discount }}</span>
                                </div>
                                @php
                                    session([
                                        'discount'=>$discount,
                                    ]);
                                @endphp
                                <a class="theme-btn-s2" href="{{ route('checkout') }}">Proceed To CheckOut</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- cart-area end -->
@endsection
