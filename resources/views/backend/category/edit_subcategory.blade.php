@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Add New Subcategory</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('exists'))
                <div class="alert alert-warning">{{ session('exists') }}</div>
                @endif
                <form action="{{ route('subcategory.update', $subcategory_info->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Select Category</label>
                        <select name="category_id" class="form-control" id="">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option {{ $category->id  == $subcategory_info->category_id?'selected':''}} value="{{ $category->id }}">{{ $category->category_name }} </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control" value="{{ $subcategory_info->subcategory_name }}">
                        @error('subcategory_name')
                        <strong class="text-danger">{{ $message }}</strong>
                         @enderror
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-primary">Add SubCategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
