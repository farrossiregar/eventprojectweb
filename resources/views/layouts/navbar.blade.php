<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-btn">
            <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
        </div>
        <div class="navbar-brand">    
            @if(get_setting('logo'))<a href="/"><img src="{{ get_setting('logo') }}" style="height:28px;width:auto;"  class="img-responsive logo"></a>@endif
        </div>
        <div class="navbar-right">
            <form id="navbar-search" class="navbar-form search-form">
                <div id="navbar-menu float-left">
                    <ul class="nav navbar-nav">
                        <!---Administrator-->
                        @if(\Auth::user()->user_access_id==1)
                           
                            <li><a href="{{route('home') }}" class="text-info icon-menu px-1">Dashboard</a></li>
                            <li><a href="{{ route('event.index') }}" class="text-info icon-menu px-1">Event</a></li>
                            <li><a href="{{ route('event.index') }}" class="text-info icon-menu px-1">Transaksi</a></li>
                            <li><a href="{{ route('event.index') }}" class="text-info icon-menu px-1">Materi</a></li>
                        @endif
                        
                        @if(\Auth::user()->user_access_id==6)
                            <!-- <li><a href="route('kasir.index')" class="text-info icon-menu px-1">Dashboard</a></li>
                            <li class="dropdown">
                                <a href="#" class="text-info dropdown-toggle icon-menu px-1" data-toggle="dropdown">Produk</a>
                                <ul class="dropdown-menu user-menu menu-icon">
                                    <li><a href="{{ route('product.index') }}">Stok</a></li>
                                    <li><a href="{{ route('konsinyasi.index') }}">Konsinyasi</a></li>
                                </ul>
                            </li>
                            <li><a href="route('kasir.index')" class="text-info icon-menu px-1">Kasir</a></li> -->
                        @endif

                        <!-- Supplier -->
                        @if(\Auth::user()->user_access_id==7)
                            <li><a href="{{ route('supplier.index') }}" class="text-info icon-menu px-1">Dashboard</a></li>
                            <li><a href="{{ route('product-supplier.index') }}" class="text-info icon-menu px-1">Produk</a></li>
                            <li><a href="{{ route('purchase-order-supplier.index') }}" class="text-info icon-menu px-1">Purchase Order</a></li>
                            <li><a href="{{ route('delivery-order.index') }}" class="text-info icon-menu px-1">Delivery Order</a></li>
                            <li><a href="{{ route('refund-product.index') }}" class="text-info icon-menu px-1">Refund</a></li>
                          
                            <!-- <li><a href="route('kasir.index')" class="text-info icon-menu px-1">Kasir</a></li> -->
                        @endif

                    </ul>
                </div>
            </form>
            <div id="navbar-menu">
                <ul class="nav navbar-nav">
                    <li class="d-none d-sm-inline-block d-md-none d-lg-inline-block">
                        {{\Auth::user()->name}} <small>({{\Auth::user()->access->name}})</small>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown"><i class="icon-equalizer"></i></a>
                        <ul class="dropdown-menu user-menu menu-icon">
                            <li class="menu-heading">ACCOUNT SETTINGS</li>
                            <li><a href="{{route('profile')}}"><i class="icon-note"></i> <span>My Profile</span></a></li>
                            @if(\Auth::user()->user_access_id==1)
                                <li><a href="{{route('setting')}}"><i class="icon-equalizer"></i> <span>Setting</span></a></li>
                                <li><a href="{{route('back-to-admin')}}" class="text-danger"><i class="fa fa-arrow-right"></i> <span>Back to Admin</span></a></li>
                                <li><a href="{{route('qrcode')}}" target="_blank"><i class="fa fa-qrcode"></i> <span>QRCode</span></a></li>
                            @endif
                        </ul>
                    </li>
                    <li><a href="" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="icon-menu"><i class="icon-login"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
