@extends('layouts.admin')
@section('content')
@can('coupon_access')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Coupon Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons  as $coupon )
                        <tr>
                            <td>{{ $coupon->coupon_name }}</td>
                            <td>{{ $coupon->type==1?'Percentage':'Solid'}}</td>
                            <td>{{ $coupon->amount }}</td>
                            <td>
                            @if (Carbon\Carbon::now() > $coupon->validity)
                                <span class="badge badge-warning">Expired {{ Carbon\Carbon::now() ->diffInDays($coupon->validity)}} in days</span>
                            @else
                            <span class="badge badge-success">Remaining {{ Carbon\Carbon::now() ->diffInDays($coupon->validity)}} in days</span>
                            @endif
                            </td>
                            <td>
                                <a href="{{ route('coupon.del',$coupon->id) }}" class="btn btn-danger">Delete</a>
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
                <h3>Add New Coupon</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('coupon.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Name</label>s
                        <input type="text" name="coupon_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Type</label>
                        <select name="type" class="form-control" >
                            <option value="">Select</option>
                            <option value="1">Percentage</option>
                            <option value="2">Solid</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Discount Amount</label>s
                        <input type="number" name="amount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Validity</label>
                        <input type="date" name="validity" class="form-control">
                    </div>
                    <div mb-3>
                        <button type="submit" class="btn btn-primary">Add Coupon</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
@endcan
@endsection
