@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lgl-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit Category</h3>
            </div>
            <div class="card-body">
                @if (session('update'))
                    <div class="alert alert-success">{{ session('update') }}</div>
                @endif
                <form action="{{ route('update.category', $category_info->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control" value="{{ $category_info->category_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" name="category_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @error('category_image')
                            <strong class="text text-danger">{{ $message }}</strong>
                        @enderror
                        <div class="my-2">
                            <img width="200" id="blah" src="{{ asset('uploads/category/') }}/{{ $category_info->category_image }}" alt="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection
