@extends('layouts.admin')

@section('content')
@can('subcategory_access')


<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>SubCategory List</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($categories as $category )
                        <div class="col-lg-12 my-2">
                            <div class="card">
                                <div class="card-header">
                                    <h3>{{ $category->category_name }}</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Sl</th>
                                            <th>SubCategory Name</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach (App\Models\SubCategory::where('category_id',$category->id)->get() as $sl=>$subcategory )
                                            <tr>
                                                <td>{{ $sl+1 }}</td>
                                                <td>{{ $subcategory->subcategory_name}}</td>
                                                <td>
                                                    <a href="{{ route('edit.subcategory', $subcategory->id) }}" class="btn btn-primary btn-icon">
                                                        <i data-feather="edit"></i>
                                                    </a>
                                                    <a href="{{ route('delete.subcategory', $subcategory->id) }}" class="btn btn-danger btn-icon del">
                                                        <i data-feather="trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
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
                <form action="{{ route('subcategory.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Select Category</label>
                        <select name="category_id" class="form-control" id="">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control" id="">
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
@endcan
@endsection
