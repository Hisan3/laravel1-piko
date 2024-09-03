@extends('layouts.admin')

@section('content')
@can('brand_access')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Brand List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered " id="myTable">
                    <thead>
                        <tr>
                            <th>Brand Name</th>
                            <th>Brand Logo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($brands as $brand)
                        <tr>
                            <td>{{ $brand->brand_name }}</td>
                            <td><img width="100" src="{{ asset('uploads/brand') }}/{{ $brand->brand_logo }}" alt=""></td>
                            <td>
                                <a href="{{ route('brand.delete', $brand->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add new Brand</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Brand Name</label>
                    <input type="text" name="brand_name" class="form-control">
                    @error('brand_name')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Brand Logo</label>
                    <input type="file" name="brand_logo" name="form-control">
                    @error('brand_logo')
                    <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection

@section('footer_script')
<script>
    let table = new DataTable('#myTable');
</script>
@endsection

