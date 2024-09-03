@extends('layouts.admin')

@section('content')
@can('user_access')
<div class="row">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <h3>User List</h3>
            </div>
            <div class="card-body">
                @if (session('del'))
                    <div class="alert alert-success">{{ session('del')}}</div>
                @endif
                <table class="table table-bordererd">
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Photo</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($users as $sl=>$user )
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email}}</td>
                        <td>
                            @if ($user->image == null)
                            <img src="{{ Avatar::create($user->name)->toBase64() }}" />
                            @else
                            <img width="150" src="{{asset('uploads/user') }}/{{$user->image}}" alt=""></td>
                            @endif
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('user.delete',$user->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection
