@extends('layouts.admin')

@section('content')

<div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Welcome, {{Auth::user()->name}}</h3>
            </div>
            <div class="card-body">
                <p>Admin Panel</p>
            </div>
        </div>
    </div>
</div>

@endsection