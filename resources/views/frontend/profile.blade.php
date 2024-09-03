@extends('frontend.master')
@section('content')
<div class="container py-5">
    <div class="row">
        @include('frontend.customer.side_bar')
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Profile</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.info.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="n" class="form-label" >Name</label>
                                    <input id="n" type="text" name="name" class="form-control" value="{{ Auth::guard('customer')->user()->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="m" class="form-label" >Email</label>
                                    <input  id="m" type="text" name="email" class="form-control" value="{{ Auth::guard('customer')->user()->email }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label" >New Password</label>
                                    <input type="password" name="password" class="form-control" >
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="" class="form-label" >Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="c" class="form-label" >Country</label>
                                    <input id="c" type="text" name="country" class="form-control" value="{{ Auth::guard('customer')->user()->country }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="ct" class="form-label" >City</label>
                                    <input id="ct" type="text" name="city" class="form-control" value="{{ Auth::guard('customer')->user()->city }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="ad" class="form-label" >Address</label>
                                    <input id="ad" type="text" name="address" class="form-control" value="{{ Auth::guard('customer')->user()->address }}">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="z" class="form-label" >Zip</label>
                                    <input id="z" type="text" name="zip" class="form-control" value="{{ Auth::guard('customer')->user()->zip }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="photo" class="form-label" >Photo</label>
                                    <input id="photo" type="file" name="photo" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
