@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Inventory List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered" >
                    <tr>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>After Discount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($inventories as $inventory )
                    <tr class="{{ $inventory->quantity<=5?'bg-light':'' }}">
                        <td>{{  $inventory->rel_to_color->color_name}}</td>
                        <td>{{  $inventory->rel_to_size->size_name}}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>{{ $inventory->price }}</td>
                        <td>{{ $inventory->after_discount }}</td>
                        <td>
                            @if ($inventory->quantity<=5)
                                <span class="badge badge-warning">Stock Out</span>
                                @else
                                <span class="badge badge-success">Stock In</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('inventory.delete',$inventory->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Inventory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('inventory.store',$product->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" disabled class="form-control" value="{{ $product->product_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="">Select Color</label>
                        <select name="color_id" class="form-control">
                            <option value="">Select Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Select size</label>
                        <select name="size_id" class="form-control">
                            <option value="">Select Size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Quantity</label>
                        <input type="number" name="quantity" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="">Price</label>
                        <input type="number" name="price" class="form-control">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Quantity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection


