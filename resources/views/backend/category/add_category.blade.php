@extends('layouts.admin')

@section('content')
@can('category_access')

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('check.delete') }}" method="POST">
        @csrf
            <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3>Category List</h3>
               <button type="submit" class="btn btn-danger">Delete Checked</button>
            </div>
            <div class="card-body">
                <table class="table tabel-bordered">
                    <tr>
                        <th><div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" id="chkSelectAll">
                                Check All
                            <i class="input-frame"></i></label>
                        </div>
                        </th>
                        <th>SL</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($categories as $sl=>$category)
                    <tr>
                        <td>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input chkDel" name="category_id[]" value="{{ $category->id }}">
                                <i class="input-frame"></i></label>
                            </div>
                        </td>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $category->category_name }}</td>
                        <td>
                            <img width="100" src="{{ asset('uploads/category') }}/{{ $category->category_image }}" alt="">
                        </td>
                        <td>
                            <a href="{{ route('edit.category',$category->id) }}" class="btn btn-primary btn-icon">
                                <i data-feather="edit"></i>
                            </a>
                            <a data-link={{ route('delete.category',$category->id) }} class="btn btn-danger btn-icon del">
                                <i data-feather="trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Category List is Empty</td>
                    </tr>
                    @endforelse
                </table>
            </div>
        </div>
        </form>
    </div>

    @can('add_category')

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add new category</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('store.category') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" name="category_name" class="form-control">
                        @error('category_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Image</label>
                        <input type="file" name="category_image" class="form-control" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @error('category_image')
                        <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        <div class="my-2">
                            <img src="" width="200" id="blah" alt="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
</div>
@endcan
@endsection

@section('footer_script')
<script>
    $("#chkSelectAll").on('click', function(){
     this.checked ? $(".chkDel").prop("checked",true) : $(".chkDel").prop("checked",false);
    });
</script>
<script>
    $('.del').click(function(){
        var link = $(this).attr('data-link');
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            window.location.href =link;
        }
        });

    });

</script>
@if (session('delete'))
<script>
     Swal.fire({
      title: "Deleted!",
      text: {{ session('delete') }},
      icon: "success"
    });
</script>
@endif



@endsection
