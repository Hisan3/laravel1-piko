@extends('layouts.admin')
@section('content')
@can('banner_access')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Banner List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($banners as $banner )
                    <tr>
                        <td>{{ $banner->title }}</td>
                        <td><img src="{{ asset('uploads/banner') }}/{{ $banner->banner_img }}" alt=""></td>
                        <td><a href="{{ route('banner.status',$banner->id) }}" class="btn btn-{{ $banner->status==1 ?'success':'light' }}">{{ $banner->status==1 ?'Active':'Deactivated' }}</a></td>
                        <td>
                            <a href="{{ route('banner.delete',$banner->id) }}" class="btn btn-danger">Delete</a>
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
                <h3>Add New Banner</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" >
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Banner Image</label>
                    <input type="file" class="form-control" name="banner_img" >
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Banner</button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endcan
@endsection
