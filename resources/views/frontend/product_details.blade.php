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
                    <li><a href="product.html">Product</a></li>
                    <li>Product Single</li>
                </ol>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- product-single-section  start-->
<div class="product-single-section section-padding">
<div class="container">
    <div class="product-details">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="product-single-img">
                    <div class="product-active owl-carousel">
                        @foreach ($galleries as $gallery)
                        <div class="item">
                            <img src="{{ asset('uploads/product/thumbnail/') }}/{{ $gallery->thumbnail }}" alt="">
                        </div>
                        @endforeach
                    </div>
                    <div class="product-thumbnil-active  owl-carousel">
                        @foreach ($galleries as $gallery)
                        <div class="item">
                            <img src="{{ asset('uploads/product/thumbnail/') }}/{{ $gallery->thumbnail }}" alt="">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <form action="{{ route('add.cart',$product_info->id) }}" method="POST">
                    @csrf
                <div class="product-single-content">
                    <h2>{{ $product_info->product_name }}</h2>
                    <div class="price">
                        @if ($product_info->discount)
                        <span class="present-price">&#2547;{{ App\Models\Inventory::where('product_id',$product_info->id)->first()->after_discount }}</span>
                        <del class="old-price">&#2547;{{ App\Models\Inventory::where('product_id',$product_info->id)->first()->price }}</del>
                        @else
                        <span class="present-price">&#2547;{{ App\Models\Inventory::where('product_id',$product_info->id)->first()->price }}</span>
                        @endif
                    </div>
                    @php
                        $avg = 0;
                        $total_review = $reviews->count();
                        if ($total_review == 0) {
                            $avg = 0;
                        }else{
                            $avg = round($total_star/$total_review);
                        }
                    @endphp
                    <div class="rating-product">
                        @for ($i=1; $i<=$avg; $i++)
                        <i class="fi flaticon-star"></i>
                        @endfor
                        <span>({{ $total_review }})</span>Reviews
                    </div>
                    <p>{{ $product_info->short_desp }}</p>
                    <div class="product-filter-item color">
                        <div class="color-name">
                            <span>Color :</span>
                            <ul>
                                @foreach ($available_colors as $color)
                                @if ($color->rel_to_color->color_name == 'NA')
                                <li class="color1"><input class="colors_id" checked id="colors{{ $color->color_id }}" type="radio" name="color_id"
                                    value="{{ $color->color_id }}" >
                                    <label for="colors{{ $color->color_id }}" style="background: #ddd">NA</label>
                                </li>
                                @else
                                <li class="color1"><input class="colors_id" id="colors{{ $color->color_id }}" type="radio" name="color_id"
                                    value="{{ $color->color_id }}" >
                                    <label for="colors{{ $color->color_id }}" style="background: {{ $color->rel_to_color->color_code}}"></label>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="product-filter-item color filter-size">
                        <div class="color-name">
                            <span>Sizes:</span>
                            <ul id="sizes">
                                @foreach ($available_sizes as $size )
                                @if ($size->rel_to_size->size_name == 'NA')
                                <li class="color">
                                    <input class="sizes" id="sizes{{ $size->size_id }}"  checked type="radio" name="size_id" value="{{ $size->size_id }}">
                                    <label for="sizes{{ $size->size_id }}">NA</label>
                                </li>
                                @else
                                <li class="color">
                                    <input class="sizes" id="sizes{{ $size->size_id }}" type="radio" name="size_id" value="{{ $size->size_id }}">
                                    <label for="sizes{{ $size->size_id }}">{{ $size->rel_to_size->size_name }}</label>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="pro-single-btn">
                        <div class="quantity cart-plus-minus">
                            <input class="text-value" name="quantity" type="text" value="1">
                        </div>
                        @auth('customer')
                        <button  type="submit" class="theme-btn-s2 border-0">Add to cart</button>
                        @else
                        <a href="{{ route('customer.login') }}" class="theme-btn-s2">Add to cart</a>
                        @endauth
                        <a href="#" class="wl-btn"><i class="fi flaticon-heart"></i></a>
                    </div>
                    <ul class="important-text">
                        <li class="stock">

                        </li>
                        <li><span>SKU:</span>FTE569P</li>
                        <li><span>Categories:</span><a class="badge bg-success">{{ $product_info->rel_to_cat->category_name }}</a>
                            </li>
                        <li><span>Tags:</span>
                            @php
                             $explode = explode(',', $product_info->tags);
                            @endphp
                            @foreach ($explode as $tag_id)
                                @php
                                    $tag = App\Models\Tag::find($tag_id);
                                @endphp
                                <a class="badge bg-primary">{{ $tag->tag_name }}</a>
                            @endforeach
                        </li>
                    </ul>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="product-tab-area">
        <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="descripton-tab" data-bs-toggle="pill"
                    data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton"
                    aria-selected="true">Description</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings"
                    type="button" role="tab" aria-controls="Ratings" aria-selected="false">Reviews
                    (3)</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="Information-tab" data-bs-toggle="pill"
                    data-bs-target="#Information" type="button" role="tab" aria-controls="Information"
                    aria-selected="false">Additional info</button>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="descripton" role="tabpanel"
                aria-labelledby="descripton-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="Descriptions-item">
                                {!!$product_info->long_desp!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
                <div class="container">
                    <div class="rating-section">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <div class="comments-area">
                                    <div class="comments-section">
                                        <h3 class="comments-title">{{ $reviews->count() }} reviews </h3>
                                        <ol class="comments">
                                            @foreach ($reviews as $review)
                                            <li class="comment even thread-even depth-1" id="comment-1">
                                                <div id="div-comment-1">
                                                    <div class="comment-theme">
                                                        <div class="comment-image" >
                                                            @if ($review->rel_to_Customer->photo == null)
                                                            <img width="100" height="100" src="{{ Avatar::create($review->rel_to_Customer->name)->toBase64() }}" />
                                                            @else
                                                            <img width="100" height="100" src="{{ asset('uploads/customer') }}/{{ $review->rel_to_Customer->photo }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="comment-main-area">
                                                        <div class="comment-wrapper">
                                                            <div class="comments-meta">
                                                                <h4>{{ $review->rel_to_Customer->name }}</h4>
                                                                <span class="comments-date">{{ $review->updated_at->diffforHumans() }}</span>
                                                                <div class="rating-product">
                                                                    @for ($i=1; $i<=$review->star; $i++)
                                                                    <i class="fi flaticon-star"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <div class="comment-area">
                                                                <p> {{ $review->review }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </li>
                                            @endforeach
                                        </ol>
                                    </div> <!-- end comments-section -->
                                    @auth('customer')
                                    @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customer')->id())->where('product_id', $product_info->id)->exists())
                                    @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customer')->id())->whereNotNull('review')->first()== false)
                                    <div class="col col-lg-10 col-12 review-form-wrapper">
                                        <div class="review-form">
                                            <h4>Add a review</h4>
                                            <form action="{{ route('review.store', $product_info->id) }}" method="POST">
                                                @csrf
                                                <div class="give-rat-sec">
                                                    <div class="give-rating">
                                                        <label>
                                                            <input type="radio" name="stars" value="1">
                                                            <span class="icon">★</span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="stars" value="2">
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="stars" value="3">
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="stars" value="4">
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                        </label>
                                                        <label>
                                                            <input type="radio" name="stars" value="5">
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                            <span class="icon">★</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div>
                                                    <textarea name="review" class="form-control"
                                                        placeholder="Write Comment..."></textarea>
                                                </div>
                                                <div class="name-input">
                                                    <input type="text" class="form-control" placeholder="Name" value="{{ Auth::guard('customer')->user()->name}}">
                                                </div>
                                                <div class="name-email">
                                                    <input type="email" class="form-control" placeholder="Email" value="{{ Auth::guard('customer')->user()->email}}">
                                                </div>
                                                <div class="rating-wrapper">
                                                    <div class="submit">
                                                        <button type="submit" class="theme-btn-s2">Post
                                                            review</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                     @else
                                    <h3 class="bg-info text-center py-2">You already reviewed</h3>
                                    @endif
                                    @else
                                    <h3 class="bg-info text-center py-2">You didn't purchase this product</h3>
                                    @endif
                                    @else
                                    <h3 class="bg-info text-center py-2">Please Login to review</h3>
                                    @endauth
                                </div> <!-- end comments-area -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
                <div class="container">
                    <div class="Additional-wrap">
                        <div class="row">
                            <div class="col-12">
                             {!! $product_info->additional_info !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="related-product">
    <div class="container">
        <div class="cart-prodact">
            <h2>You May be Interested in…</h2>
            <div class="row">
                @forelse($related_products as $related_product )
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <div class="product-item">
                        <div class="image">
                            <img src="{{ asset('uploads/product/preview') }}/{{ $related_product->preview }}" alt="">
                            <div class="tag new">New</div>
                        </div>
                        <div class="text">
                            <h2><a href="{{ route('product.details', $related_product->slug) }}">{{ $related_product->product_name }}</a></h2>
                            <div class="rating-product">
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <i class="fi flaticon-star"></i>
                                <span>130</span>
                            </div>
                            <div class="price">
                                @if ($related_product->discount)
                                <span class="present-price">&#2547;{{ App\Models\Inventory::where('product_id',$related_product->id)->first()->after_discount }}</span>
                                <del class="old-price">&#2547;{{ App\Models\Inventory::where('product_id',$related_product->id)->first()->price }}</del>
                                @else
                                <span class="present-price">&#2547;{{ App\Models\Inventory::where('product_id',$related_product->id)->first()->price }}</span>
                                @endif
                            </div>
                            <div class="shop-btn">
                                <a class="theme-btn-s2" href="{{ route('product.details', $related_product->slug) }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <h3 class="text-center">No related Product Found</h3>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>
<!-- product-single-section  end-->

@endsection

@section('footer_script')
<script>
    $('.colors_id').click(function(){
        var color_id = $(this).val();
        var product_id = '{{ $product_info->id }}';
        $.ajaxSetup({
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':'/getSizes',
        'type':'POST',
        data:{'color_id':color_id, 'product_id':product_id},
        success:function(data){
            $('#sizes').html(data);

            //stock
            $('.sizes').click(function() {
            var size_id = $(this).val();
            var product_id = '{{ $product_info->id }}';
            var color_id = $('input[class="colors_id"]:checked').val();
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
            'url':'/getStock',
            'type':'POST',
            data:{'color_id':color_id, 'product_id':product_id, 'size_id':size_id},
            success:function(data){
                $('.stock').html(data);
            }
            });
        });
        }

    });

})
</script>
@if (session('cart_added'))
<script>
Swal.fire({
  position: "top-end",
  icon: "success",
  title: "{{ session('cart_added') }}",
  showConfirmButton: false,
  timer: 1500
});
</script>

@endif
@endsection
