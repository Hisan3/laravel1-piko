@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                   <tr>
                    <td>Category</td>
                    <td>{{ $product->rel_to_cat->category_name }}</td>
                   </tr>
                    <tr>
                        <td>Subcategory</td>
                        <td>{{ $product->rel_to_subcat->subcategory_name }}</td>
                    </tr>
                    <tr>
                        <td>Brand</td>
                        <td>{{ $product->rel_to_brand->brand_name }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $product->product_name }}</td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td>&#2547;{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td>{{ $product->discount }}%</td>
                    </tr>
                    <tr>
                        <td>After Discount</td>
                        <td>{{ $product->after_discount}}</td>
                    </tr>
                    <tr>
                        <td>Short Description</td>
                        <td>{{ $product->short_desp }}</td>
                    </tr>
                    <tr>
                        <td>Long Description</td>
                        <td>{!! $product->long_desp!!}</td>
                    </tr>
                    <tr>
                        <td>Additional Information</td>
                        <td>{!! $product->additional_info !!}</td>
                    </tr>
                    <tr>
                        <td>Tags</td>
                        <td>
                        @php
                           $explode = explode(',', $product->tags);
                           foreach ($explode as $tag_id) {
                            $tag = App\Models\Tag::find($tag_id);
                            echo '<span class="badge badge-primary">'.$tag->tag_name.'</span>'.' ';
                           }
                        @endphp
                        </td>
                    </tr>
                    <tr>
                        <td>Slug</td>
                        <td>{{ $product->slug }}</td>
                    </tr>
                    <tr>
                        <td>Preview</td>
                        <td>
                            <img width="100" src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td>Gallery</td>
                        <td>
                            @foreach (App\Models\Thumbnail::where('product_id',$product->id)->get() as $thumb )
                            <img width="100" src="{{ asset('uploads/product/thumbnail') }}/{{ $thumb->thumbnail }}" alt="">
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
