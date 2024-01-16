<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            @if(\Auth::user()->profile_photo_path!="")
                <img src="{{ \Auth::user()->profile_photo_path }}" class="rounded-circle user-photo" alt="User Profile Picture">
            @endif
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ isset(\Auth::user()->name)?\Auth::user()->name :''}}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <li><a href="{{route('profile')}}"><i class="icon-user"></i>My Profile</a></li>
                    <li><a href="{{route('setting')}}"><i class="icon-settings"></i>Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="#" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="icon-power"></i>Logout</a></li>
                </ul>
            </div>
            {{-- <hr> --}}
            {{-- <ul class="row list-unstyled">
                <li class="col-4">
                    <small>Member</small>
                    <h6>{{format_idr(\App\Models\UserMember::count())}}</h6>
                </li>
                <li class="col-4">
                    <small>Koordinator</small>
                    <h6>{{format_idr(\App\Models\Koordinator::count())}}</h6>
                </li>
                <li class="col-4">
                    <small>Revenue</small>
                    <h6>0</h6>
                </li>
            </ul> --}}
        </div>
        <!-- Nav tabs -->
        
        @if(\Auth::user()->user_access_id==1)
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link {{(in_array(Request::segment(1),['setting','user', 'product-supplier', 'purchase-order']) ? 'active':'')}}" data-toggle="tab" href="#menu">Admin</a></li>
            <!-- <li class="nav-item"><a class="nav-link {{(in_array(Request::segment(1),['user-member']) ? 'active':'')}}" data-toggle="tab" href="#tab_anggota">Buyer</a></li> -->
            <!-- <li class="nav-item"><a class="nav-link {{(in_array(Request::segment(1),['transaksi','product','invoice-transaksi','purchase-order']) ? 'active':'')}}" data-toggle="tab" href="#tab_toko">Toko</a></li> -->
        </ul>
        @endif


        @if(\Auth::user()->user_access_id==7) <!-- Supplier -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link {{(in_array(Request::segment(1),['setting','user', 'product-supplier', 'purchase-order']) ? 'active':'')}}" data-toggle="tab" href="#menu">Data</a></li>
        </ul>
        @endif


        <!-- if(Request::segment(1) == 'catalog')
            
        endif -->
        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
         
            <div class="tab-pane {{(in_array(Request::segment(1),['setting','user']) ? 'active':'')}}" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">    
                        @if(\Auth::user()->user_access_id==1)<!--Administrator-->                   
                            <li class="{{ Request::segment(1) === 'dashboard' ? 'active' : null }}">
                                <a href="/"><i class="icon-home"></i> <span>Dashboard</span></a>
                            </li>
                            <li class="{{ (Request::segment(1) === 'user') ? 'active' : null }}">
                                <a href="{{route('users.index')}}"><i class="fa fa-bank"></i>User</a>
                            </li>
                            <li class="{{ (Request::segment(1) === 'log-activity') ? 'active' : null }}">
                                <a href="{{route('log-activity.index')}}"><i class="fa fa-history"></i>Log Activity</a>
                            </li>
                            <li class="{{ (Request::segment(1) === 'setting') ? 'active' : null }}">
                                <a href="{{route('setting')}}"><i class="fa fa-gear"></i>Pengaturan</a>
                            </li>
                        @endif

                    </ul>
                </nav>
            </div>    
            
            
           
        </div>          
    </div>
</div>
