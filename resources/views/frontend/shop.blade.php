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
                        <li>Shop</li>
                    </ol>
                </div>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<!-- product-area-start -->
<div class="shop-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="shop-filter-wrap">
                    <div class="filter-item">
                        <div class="shop-filter-item category-widget">
                            <h2>Categories</h2>
                            <ul>
                                @foreach ($categories as $category)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{ $category->category_name }} <span>({{$category->rel_to_product->count()}})</span>
                                        <input type="radio" class="category_id" name="cat" value="{{ $category->id}}" {{ $category->id == @$_GET['category_id'] ? 'checked' : '' }}>
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Filter by price</h2>
                            <div class="shopWidgetWraper">
                                <div class="priceFilterSlider">
                                    <form class="clearfix">
                                        <div class="d-flex">
                                            <div class="col-lg-6 pe-2">
                                                <label for="" class="form-label">Min</label>
                                                <input id="min" type="text" class="form-control" placeholder="Min" value="{{ @$_GET['min'] }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="" class="form-label">Max</label>
                                                <input id="max" type="text" class="form-control" placeholder="Max" value="{{ @$_GET['max'] }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-4">
                                            <button type="button" class="form-control bg-light price_range">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Color</h2>
                            <ul>
                                @foreach ($colors as $color)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{ $color->color_name }} <span>({{$color->rel_to_inventory->count()}})</span>
                                        <input type="radio" class="color_id" name="color" value="{{ $color->id }}" {{ $color->id == @$_GET['color_id'] ? 'checked' : '' }}>
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="filter-item">
                        <div class="shop-filter-item">
                            <h2>Size</h2>
                            <ul>
                                @foreach ($sizes as $size)
                                <li>
                                    <label class="topcoat-radio-button__label">
                                        {{ $size->size_name }} <span>(10)</span>
                                        <input type="radio" class="size_id" name="size" value="{{ $size->id }}" {{ $size->id == @$_GET['size_id'] ? 'checked' : '' }}>
                                        <span class="topcoat-radio-button"></span>
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="filter-item">
                        <div class="shop-filter-item tag-widget">
                            <h2>Popular Tags</h2>
                            <ul>
                                @foreach ($tags as $tag)
                                <li>
                                    <button class="btn btn-light m-1 tag" type="button" value="{{ $tag->id }}">{{ $tag->tag_name }}</button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="shop-section-top-inner">
                    <div class="shoping-product">
                        <p>We found <span>{{ $products->count() }}</span> for you!</p>
                    </div>
                    <div class="short-by">
                        <ul>
                            <li>
                                Sort by:
                            </li>
                            <li>
                                <select name="sort" class="sort">
                                    <option value="">Default Sorting</option>
                                    <option value="1" {{ @$_Get['sort'] == 1?'selected':'' }}>Low To High</option>
                                    <option value="2" {{ @$_Get['sort'] == 2?'selected':'' }}>High To Low</option>
                                    <option value="3" {{ @$_Get['sort'] == 3?'selected':'' }}>A To Z</option>
                                    <option value="4" {{ @$_Get['sort'] == 4?'selected':'' }}>Z To a</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="product-wrap">
                    <div class="row align-items-center">
                        @foreach ($products as $product)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">{{ $product->product_name }}</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>120</span>
                                    </div>
                                    <div class="price">
                                        @if ($product->discount)
                                        <span class="present-price">&#2547;{{ App\Models\Inventory::where('product_id',$product->id)->first()->after_discount }}</span>
                                        <del class="old-price">&#2547;{{ App\Models\Inventory::where('product_id',$product->id)->first()->price }}</del>
                                        @else
                                        <span class="present-price">&#2547;{{ App\Models\Inventory::where('product_id',$product->id)->first()->price }}</span>
                                        @endif                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="{{ route('product.details', $product->slug) }}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product-area-end -->
@endsection


@section('footer_script')
<script>
    $('#search_btn').click(function() {
        var keyword = $('#search_input').val();
        var category_id = $("input:radio[class=category_id]:checked").val();

        var min = $('#min').val();
        var max = $('#max').val();

        var color_id = $("input:radio[class=color_id]:checked").val();
        var size_id = $("input:radio[class=size_id]:checked").val();
        var sort= $('.sort').val();

        var link = '{{ route('shop') }}' + '?keyword=' + keyword + '&category_id=' + category_id  +'&min=' + min + '&max=' + max + '&color_id=' + color_id + '&size_id=' + size_id +'&sort=' + sort;
        window.location.href = link;
    })
    $('.price_range').click(function() {
        var keyword = $('#search_input').val();
        var category_id = $("input:radio[class=category_id]:checked").val();

        var min = $('#min').val();
        var max = $('#max').val();

        var color_id = $("input:radio[class=color_id]:checked").val();
        var size_id = $("input:radio[class=size_id]:checked").val();
        var sort= $('.sort').val();

        var link = '{{ route('shop') }}' + '?keyword=' + keyword + '&category_id=' + category_id  +'&min=' + min + '&max=' + max + '&color_id=' + color_id + '&size_id=' + size_id +'&sort=' + sort;
        window.location.href = link;
    })
    $('.category_id').click(function() {
        var keyword = $('#search_input').val();
        var category_id = $("input:radio[class=category_id]:checked").val();

        var min = $('#min').val();
        var max = $('#max').val();

        var color_id = $("input:radio[class=color_id]:checked").val();
        var size_id = $("input:radio[class=size_id]:checked").val();
        var sort= $('.sort').val();

        var link = '{{ route('shop') }}' + '?keyword=' + keyword + '&category_id=' + category_id  +'&min=' + min + '&max=' + max + '&color_id=' + color_id + '&size_id=' + size_id +'&sort=' + sort;
        window.location.href = link;
    })
    $('.color_id').click(function() {
        var keyword = $('#search_input').val();
        var category_id = $("input:radio[class=category_id]:checked").val();

        var min = $('#min').val();
        var max = $('#max').val();

        var color_id = $("input:radio[class=color_id]:checked").val();
        var size_id = $("input:radio[class=size_id]:checked").val();
        var sort= $('.sort').val();

        var link = '{{ route('shop') }}' + '?keyword=' + keyword + '&category_id=' + category_id  +'&min=' + min + '&max=' + max + '&color_id=' + color_id + '&size_id=' + size_id +'&sort=' + sort;
        window.location.href = link;
    })
    $('.size_id').click(function() {
        var keyword = $('#search_input').val();
        var category_id = $("input:radio[class=category_id]:checked").val();

        var min = $('#min').val();
        var max = $('#max').val();

        var color_id = $("input:radio[class=color_id]:checked").val();
        var size_id = $("input:radio[class=size_id]:checked").val();
        var sort= $('.sort').val();

        var link = '{{ route('shop') }}' + '?keyword=' + keyword + '&category_id=' + category_id  +'&min=' + min + '&max=' + max + '&color_id=' + color_id + '&size_id=' + size_id +'&sort=' + sort;
        window.location.href = link;
    })
</script>
<script>
    $('.tag').click(function(){
        var tag_id = $(this).val();
        var link = '{{ route('shop') }}' + '?tag_id=' + tag_id;
        window.location.href = link;

    })
</script>

@endsection
