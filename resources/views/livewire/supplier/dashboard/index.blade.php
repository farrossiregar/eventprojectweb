@section('title', 'Dashboard Supplier')
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
                    <div class="text">Lunas</div>
                    <h5 class="number">Rp. </h5>
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
                    <div class="text">Belum Lunas</div>
                    <h5 class="number">Rp. </h5>
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
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_transaksi">{{ __('Transaksi Terbaru') }} </a></li>
                </ul>
                <div class="tab-content px-0">
                    <div class="tab-pane active show" id="tab_transaksi">
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0 c_list table-bordered">
                                <thead style="background: #eee;">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Status</th>
                                        <th>No Purchase Order</th>
                                        @if(Auth::user()->user_access_id == 1 || Auth::user()->user_access_id == 8)
                                        <th>Supplier</th>
                                        @endif
                                        <th>Tanggal Transaksi</th>
                                        <th>Total Produk</th>
                                        <th>Total Qty</th>
                                        <th class="text-right">Biaya Pengiriman</th>
                                        <th class="text-right">Total Nominal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $k => $item)
                                    <tr>
                                    <td style="width: 50px;" class="text-center">{{$k+1}}</td>
                                    <td class="text-center">
                                        @if($item->status==0)
                                            <span class="badge badge-warning">Draft</span>
                                        @endif
                                        @if($item->status==1)
                                            <span class="badge badge-success">PO Submitted</span>
                                        @endif
                                        @if($item->status==2)
                                            <span class="badge badge-default">Invoice</span>
                                        @endif
                                        @if($item->status==3)
                                            <span class="badge badge-success">Paid</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->user_access_id == 1)
                                        <td><a href="{{route('purchase-order-administration.detail',$item->id)}}">{{$item->no_po}}</a></td>
                                    @elseif(Auth::user()->user_access_id == 7)
                                        <td><a href="{{route('purchase-order-supplier.detail',$item->id)}}">{{$item->no_po}}</a></td>
                                    @else
                                        <td><a href="{{route('purchase-order.detail',$item->id)}}">{{$item->no_po}}</a></td>
                                    @endif

                                    @if(Auth::user()->user_access_id == 1 || Auth::user()->user_access_id == 8)
                                    <td>
                                        {{isset($item->supplier->nama_supplier) ? $item->supplier->nama_supplier : '-'}}
                                        @if(isset($item->supplier->nama_supplier))
                                            <a href="javascript:void(0)" title="{!!$item->supplier->nama_supplier .'&#013;'. $item->supplier->alamat_supplier!!}"><i class="fa fa-info-circle"></i></a>
                                        @endif
                                    </td>
                                    @endif
                                    <td>{{date('d M Y H:i',strtotime($item->created_at))}}</td>
                                    <td class="text-center">{{$item->total_product}}</td>
                                    <td class="text-center">{{$item->total_qty}}</td>
                                    <td class="text-right">{{format_idr($item->biaya_pengiriman)}}</td>
                                    <td class="text-right">Rp. {{format_idr($item->total_pembayaran)}}</td>
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
                                <a href="{{ route('purchase-order-supplier.index') }}" class="btn btn-info"><i class="fa fa-eye"></i> Lihat Lebih Banyak</a> 
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
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_pembelian">{{ __('Top 5 Produk') }} </a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_penjualan">{{ __('Top 5 Buyer') }} </a></li>
                </ul>
                <div class="tab-content px-0">
                    <div class="tab-pane" id="tab_pembelian">
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0 c_list table-bordered">
                                <thead style="background: #eee;">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Barcode</th>
                                        <th>Tipe Produk</th>
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
                                        <th>Buyer</th>
                                        <th>Total Transaksi</th>
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
    </div>


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