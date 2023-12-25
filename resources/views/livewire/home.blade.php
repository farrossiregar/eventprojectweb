@section('title', 'Dashboard Admin')
@section('sub-title', 'Index')
<div class="clearfix row">
<div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state">
            <div class="body">
                <div class="icon">
                    <i class="fa fa-shopping-cart text-info"></i>
                </div>
                <div class="content">
                    <div class="text">Total Transaksi</div>
                    <h5 class="number">Rp. </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state">
            <div class="body">
                    <div class="icon text-warning">
                        <i class="fa fa-database"></i>
                    </div>
                <div class="content">
                    <div class="text">Supplier Active</div>
                    <h5 class="number"></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card top_counter currency_state">
            <div class="body">
                    <div class="icon text-danger">
                        <i class="fa fa-calendar"></i>
                    </div>
                <div class="content">
                    <div class="text">Buyer Active</div>
                    <h5 class="number"></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12">
        <div class="card top_counter currency_state">
            <div class="body">
                    <div class="icon">
                        <i class="fa fa-database text-success"></i>
                    </div>
                <div class="content">
                    <div class="text">Total QTY</div>
                    <h5 class="number"></h5>
                </div>
            </div>
        </div>
    </div>


    

    <div class="col-12 px-0 mx-0">
        <div class="card mb-2">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_transaksi">{{ __('Supplier Terbaru') }} </a></li>
                </ul>
                <div class="tab-content px-0">
                    <div class="tab-pane active show" id="tab_transaksi">
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0 c_list table-bordered">
                                <thead style="background: #eee;">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Status</th>
                                        <th>Nama Supplier</th>
                                        <th>Tanggal Join</th>
                                        <th>Tipe Supplier</th>
                                        <th>No Telp</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Models\Supplier::orderBy('id','DESC')->take(5)->get() as $k => $item)
                                    <tr>
                                        <td style="width: 50px;" class="text-center">{{$k+1}}</td>
                                        <td class="text-center">
                                            @if($item->status==0)
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                            @if($item->status==1)
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                           
                                        </td>

                                        <td>{{ $item->nama_supplier }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->tipe_supplier }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-navicon"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <a href="{{route('purchase-order.detail',$item->id)}}" class="dropdown-item"><i class="fa fa-info"></i> Detail</a>
                                                    @if($item->status==1)
                                                        <a href="{{route('purchase-order.insert-delivery-order',$item->id)}}" class="dropdown-item"><i class="fa fa-plus"></i> Delivery Order</a>
                                                    @endif
                                                </div>
                                            </div>    
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12" style="float: right;">
                                <a href="{{ route('user-supplier.index') }}" class="btn btn-info"><i class="fa fa-eye"></i> Lihat Lebih Banyak</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-12 px-0 mx-0">
        <div class="card mb-2">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_transaksi">{{ __('Buyer Terbaru') }} </a></li>
                </ul>
                <div class="tab-content px-0">
                    <div class="tab-pane active show" id="tab_transaksi">
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0 c_list table-bordered">
                                <thead style="background: #eee;">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Status</th>
                                        <th>Nama Buyer</th>
                                        <th>Tanggal Join</th>
                                        <th>No Telp</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(App\Models\Buyer::orderBy('id','DESC')->take(5)->get() as $k => $item)
                                    <tr>
                                        <td style="width: 50px;" class="text-center">{{$k+1}}</td>
                                        <td class="text-center">
                                            @if($item->status==0)
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                            @if($item->status==1)
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                           
                                        </td>

                                        <td>{{ $item->nama_buyer }}</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-navicon"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <a href="{{route('purchase-order.detail',$item->id)}}" class="dropdown-item"><i class="fa fa-info"></i> Detail</a>
                                                    @if($item->status==1)
                                                        <a href="{{route('purchase-order.insert-delivery-order',$item->id)}}" class="dropdown-item"><i class="fa fa-plus"></i> Delivery Order</a>
                                                    @endif
                                                </div>
                                            </div>    
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12" style="float: right;">
                                <a href="{{ route('user-buyer.index') }}" class="btn btn-info"><i class="fa fa-eye"></i> Lihat Lebih Banyak</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="col-12 px-0 mx-0">
        <div class="card mb-2">
            <div class="body">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_pembelian">{{ __('Produk Terbanyak Dibeli') }} </a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_penjualan">{{ __('Penjualan') }} </a></li>
                </ul>
                <div class="tab-content px-0">
                    <div class="tab-pane" id="tab_supplier">
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0 c_list table-bordered">
                                <thead style="background: #eee;">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Supplier</th>                                 
                                        <th>No Telepon</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Created At</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane active show" id="tab_pembelian">
                        <div class="table-responsive">
                            <div class="row mb-3">
                                <div class="col-2">
                                    <input type="text" class="form-control" placeholder="Pencarian" />
                                </div>
                                <div class="col-2">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_form_pembelian" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a>
                                </div>
                            </div>
                            <table class="table m-b-0 c_list table-hover table-bordered">
                                <thead>
                                    <tr style="background: #eee;">
                                        <th>No</th>
                                        <th>Requester</th>
                                        <th>PR Number</th>
                                        <th>PR Date</th>
                                        <th>PO Number</th>
                                        <th>PO Date</th>
                                        <th>DO Number</th>
                                        <th>Receipt Date</th>
                                        <th>Price</th>
                                        <th>Unit</th>
                                        <th>Total</th>
                                        <th>Total Margin</th>
                                        <th>Expired Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_penjualan">
                        <div class="table-responsive">
                            <table class="table table-striped m-b-0 c_list table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Transaksi</th>
                                        <th>Harga Jual</th>
                                        <th>QTY</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


<div class="modal fade" id="modal_autologin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-sign-in"></i> Autologin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true close-btn">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger close-modal">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <livewire:transaksi.upload />
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirm_delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-warning"></i> Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <p>Are you want delete this data ?</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">No</button>
                <button type="button" wire:click="delete()" class="btn btn-danger close-modal">Yes</button>
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
    <script type="text/javascript" src="{{ asset('assets/vendor/daterange/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendor/daterange/daterangepicker.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/daterange/daterangepicker.css') }}" />
    <script>
        Livewire.on('void',(id)=>{
            $("#modal_void").modal('show');
        });
        $('.tanggal_transaksi').daterangepicker({
            opens: 'left',
            locale: {
                cancelLabel: 'Clear'
            },
            autoUpdateInput: false,
        }, function(start, end, label) {
            @this.set("filter_created_start", start.format('YYYY-MM-DD'));
            @this.set("filter_created_end", end.format('YYYY-MM-DD'));
            $('.tanggal_transaksi').val(start.format('DD/MM/YYYY') + '-' + end.format('DD/MM/YYYY'));
        });
        
</script>
@endpush