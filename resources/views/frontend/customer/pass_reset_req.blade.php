@extends('frontend.master')
@section('content')
<div class="container m-auto">
    <div class="row">
        <div class="col-lg-6 my-5">
            <div class="card">
                <div class="card-header">
                    <h3>Password Reset</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('invalid'))
                        <div class="alert alert-danger">{{ session('invalid') }}</div>
                    @endif
                    <form action="{{ route('pass.reset.req.send') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit">Send Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
