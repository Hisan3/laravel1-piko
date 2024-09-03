@extends('layouts.admin')

@section('content')
@can('product_access')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Product List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="myTable">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Product</th>
                            <th>Discount</th>
                            <th>Preview</th>
                            <th>Gallery</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product )
                    <tr>
                        <td>{{ $product->rel_to_cat->category_name }}</td>
                        <td>{{  $product->product_name}}</td>
                        <td>{{ $product->discount }}%</td>
                        <td><img width="100" src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt=""></td>
                        <td>
                            @foreach (App\Models\Thumbnail::where('product_id',$product->id)->get() as $thumb )
                                <img width="100" src="{{ asset('uploads/product/thumbnail') }}/{{ $thumb->thumbnail }}" alt="">
                            @endforeach
                        </td>
                        <td>
                            <a title="Inventory" href="{{ route('inventory', $product->id) }}" class="btn btn-primary text-white btn-icon del">
                                <i data-feather="file-text"></i>
                            </a>

                            <a title="View" href="{{ route('product.view', $product->id) }}" class="btn btn-info text-white btn-icon del">
                                <i data-feather="eye"></i>
                            </a>

                            <a title="Delete" href="{{ route('product.delete', $product->id) }}" class="btn btn-danger btn-icon del">
                                <i data-feather="trash"></i>
                            </a>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection

@section('footer_script')
<script>
    $(document).ready( function () {
    $('#myTable').DataTable();
    } );

</script>

@endsection
