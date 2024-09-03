@extends('frontend.master')
@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Reset Password Form</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('pass.reset.update',$token) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password">

                            @error('password')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">

                            @error('password_confirmation')
                            <strong class="text-danger">{{ $message }}</strong>
                            @enderror

                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
