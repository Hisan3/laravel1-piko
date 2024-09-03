<div class="col-lg-3">
    <div class="card" style="width: 18rem;">
    <div class="card-header">
        <h3>{{ Auth::guard('customer')->user()->name }}-Profile</h3>
    </div>
    <div>
        <img  src="{{ asset('uploads/customer/') }}/{{ Auth::guard('customer')->user()->photo }}" alt="">
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item py-3"><a href="{{ route('my.order') }}">My Order</a></li>
        <li class="list-group-item py-3"><a href="">Wishlist</a></li>
        <li class="list-group-item py-3"><a href="{{ route('customer.logout') }}">Logout</a></li>
    </ul>
    </div>
</div>
