@extends('layouts.admin')
@section('content')
@can('tag_access')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>tag List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Tag Name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($tags as  $tag )
                    <tr>
                        <td>{{ $tag->tag_name }}</td>
                        <td><a href="{{ route('tag.delete',$tag->id) }}" class="btn btn-danger">Delete</a></td>
                    </tr>
                    @endforeach
                </table>
                <div class="my-2">
                    {{ $tags->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New tags</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('tag.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Tag Name</label>
                    <input type="text" name="tag_name" class="form-control">
                    @error('tag_name')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add category</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection
