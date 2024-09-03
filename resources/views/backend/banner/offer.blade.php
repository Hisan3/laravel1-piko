@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Offer List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($offers as $offer )
                    <tr>
                        <td>{{ $offer->title }}</td>
                        <td><img src="{{ asset('uploads/offer') }}/{{ $offer->offer_img }}" alt=""></td>
                        <td><a href="{{ route('offer.status',$offer->id) }}" class="btn btn-{{ $offer->status==1 ?'success':'light' }}">{{ $offer->status==1 ?'Active':'Deactivated' }}</a></td>
                        <td>
                            <a href="{{ route('offer.delete',$offer->id) }}" class="btn btn-danger">Delete</a>
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
                <h3>Add OFFER Slide</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('offer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Title</label>
                        <input type="text" class="form-control" name="title" >
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Offer Image</label>
                        <input type="file" class="form-control" name="offer_img" >
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Offer</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
