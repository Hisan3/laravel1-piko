@extends('layouts.admin')
@section('content')
@can('banner_subs')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Subscriber List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sl</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($subscriber_lists as $sl=>$subscriber)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $subscriber->email }}</td>
                            <td>
                                <a href="" class="btn btn-primary">Send Newsletter</a>
                                <a href="{{ route('subscriber.delete',$subscriber->id) }}" class="btn btn-danger">Delete</a>
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
                <h3>Update Text</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('subtext.update',$sub_texts->first()->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Text</label>
                        <input type="text" name="text" class="form-control" value="{{ $sub_texts->first()->text }}">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endcan
@endsection
