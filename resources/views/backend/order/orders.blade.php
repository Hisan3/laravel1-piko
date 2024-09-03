@extends('layouts.admin')
@section('content')
@can('order_access')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Orders List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Order ID</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders  as $sl=>$order)
                    <tr>
                        <td>{{ $sl+1 }}</td>
                        <td>{{ $order->order_id }}</td>
                        <td>&#2547;{{ $order->total }}</td>
                        <td>{{ $order->created_at->format('d-M-Y') }}</td>
                        <td>
                            @if ($order->status == 1)
                            <span class="badge bg-secondary">Placed</span>
                            @elseif ($order->status == 2)
                            <span class="badge bg-primary">Processing</span>
                            @elseif ($order->status == 3)
                            <span class="badge bg-warning">Shipping</span>
                            @elseif ($order->status == 4)
                            <span class="badge bg-info">Ready to Deliver</span>
                            @elseif ($order->status == 5)
                            <span class="badge bg-success">Delievered</span>
                            @elseif ($order->status == 0)
                            <span class="badge bg-danger">Canceled</span>
                         @endif
                        </td>
                        <td>
                            <form action="{{ route('change.order.status', $order->id) }}" method="POST">
                            @csrf
                            <div class="btn-group">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  Change Status
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <button name="status" value="1" class="dropdown-item" type="submit">Placed</button>
                                  <button name="status" value="2" class="dropdown-item" type="submit">Processing</button>
                                  <button name="status" value="3" class="dropdown-item" type="submit">Shipping</button>
                                  <button name="status" value="4" class="dropdown-item" type="submit">Ready to Deliver</button>
                                  <button name="status" value="5" class="dropdown-item" type="submit">Delievered</button>
                                  <button name="status" value="0" class="dropdown-item" type="submit">Canceled</button>
                                </div>
                            </div>
                            </form>
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
