@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Color-list</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Color Name</th>
                        <th>Color</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($colors as $color )
                    <tr>
                        <td>{{ $color->color_name }}</td>
                        <td><span class="badge py-3" style="background:{{ $color->color_code }}; color:transparent ;">Primary</span></td>
                        <td>
                            <a href="{{ route('color.delete',$color->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">
                <h3>Size-list</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Size Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($sizes as $size )
                    <tr>
                        <td>{{ $size->size_name }}</td>
                        <td>
                            <a href="{{ route('size.delete',$size->id) }}" class="btn btn-danger">Delete</a>
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
                <h3>Add color</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('color.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Color Name</label>
                        <input type="text" name="color_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Color Code</label>
                        <input type="color" class="form-control" name="color_code">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Color</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3>Add Size</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('size.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Size</label>
                        <input type="text" name="size_name" class="form-control">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Size</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
