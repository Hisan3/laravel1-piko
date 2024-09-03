@extends('frontend.master')
@section('content')
<div class="container py-5">
    <div class="row">
        @include('frontend.customer.side_bar')
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h3>My Orders</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Order</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($myorders as $sl=>$myorder)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $myorder->order_id }}</td>
                            <td>{{ $myorder->total }}</td>
                            <td>
                                @if ($myorder->status == 1)
                                   <span class="badge bg-secondary">Placed</span>
                                   @elseif ($myorder->status == 2)
                                   <span class="badge bg-primary">Processing</span>
                                   @elseif ($myorder->status == 3)
                                   <span class="badge bg-warning">Shipping</span>
                                   @elseif ($myorder->status == 4)
                                   <span class="badge bg-info">Ready to Deliver</span>
                                   @elseif ($myorder->status == 5)
                                   <span class="badge bg-success">Delievered</span>
                                   @elseif ($myorder->status == 0)
                                   <span class="badge bg-danger">Canceled</span>
                                @endif
                            </td>
                            <td>{{ $myorder->created_at }}</td>
                            <td>
                                <a href="{{ route('download.invoice',$myorder->id) }}" class="btn btn-success">Download Invoice</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
