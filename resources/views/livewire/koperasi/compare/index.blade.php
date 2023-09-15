@section('title', 'Compare')
<div class="clearfix row">
   
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
              
                <div class="col-md-12">
                    <div class="row">
                        
                        <div id="card-deck" class="card-deck row" style="padding: 30px; min-height: 720px; min-width: 720px;">
                            @foreach($data as $item)
                            <div class="card col-md-4" style="border: 1px solid lightgrey;">
                                <img class="card-img-top" style="margin-top: 14px; border-radius: 8px; height: 175px;" src="{{ asset('assets/images/'.$item->image_source) }}" alt="{{ $item->nama_product }}">
                                <div class="card-body">
                                    <h5 class="card-title" style="text-align: left; font-size: 18px;">{{ $item->nama_product }}</h5>
                                    <h5 class="card-title" style="text-align: left; font-size: 12px;">{{ $item->nama_supplier }}</h5>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title" style="text-align: center; font-size: 30px;">Rp, {{ format_idr($item->price) }}</h5>
                                    <!-- <p class="card-text">This is a wider card with.</p> -->
                                </div>
                                
                                <div class="card-body">
                                    <p class="card-text" style="text-align: center;">Stok {{ $item->qty }} {{ $item->uom_id }}</p>
                                    <p class="card-text" style="text-align: center;">{{ $item->provinsi }}</p>
                                    <p class="card-text" style="text-align: center;">Terjual {{ $item->provinsi }} {{ $item->uom_id }}</p>
                                </div>
                                
                                <div class="card-footer">
                                    <small class="text-muted">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="btn btn-info">
                                                            <i class="fa fa-shopping-cart"></i> &nbsp; <b></b>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="btn btn-danger" wire:click="$emit('remove_product_compare', {{$item->id_product}})">
                                                            <i class="fa fa-close"></i> &nbsp; <b></b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </small>
                                </div>
                            </div>
                            @endforeach

                            @if(count($data) < 6)
                            <div class="card col-md-4">
                                <img class="card-img-top">
                                <div class="card-body">
                                    <div class="container h-100">
                                        <div class="row align-items-center h-100">
                                            <div class="col-6 mx-auto">
                                                <div class="row">
                                                    <div class="col-md-6"  wire:click="$emit('add_product_compare')">
                                                        <div style="cursor: pointer;">
                                                            <i style="font-size: 75px; align:center; color: lightblue;" class="fa fa-plus fa-8x"></i>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-md-4"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>



    <div wire:ignore.self class="modal fade" id="add_product_compare" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="row" >
                    <div class="col-md-12">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-search"></i> Search Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true close-btn">×</span>
                            </button>
                        </div>
                        
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" wire:model="keyword" placeholder="Cari Produk"/>
                                </div>
                                <div class="col-md-3">
                                    <span class="btn btn-info">
                                        <i class="fa fa-search"></i> Cari <b></b>
                                    </span>
                                </div>
                            </div>
                            <br><br>
                            <div class="table-responsive">
                                <table class="table table-hover m-b-0 c_list table-bordered">
                                    <thead style="background: #eee;">
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Produk</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Stok</th>
                                            <th class="text-center">Nama Supplier</th>
                                            <th class="text-center">Lokasi Supplier</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_detail as $k => $item)
                                        <tr>
                                            <td>{{$k+1}}</td>
                                            <td>{{ $item->nama_product }}</td>
                                            <td><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ \App\Models\Supplier::where('id', $item->id_supplier)->first()->nama_supplier }}</td>
                                            <td>{{ \App\Models\Supplier::where('id', $item->id_supplier)->first()->provinsi }}</td>
                                            <td>
                                                <a href="javascript:void(0)" wire:click="$emit('pick_product_compare',{{$item->id}})" class="btn btn-primary"><b>PILIH</b></a>
                                            </td>
                                        
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



@push('after-scripts') 
<script>

    Livewire.on('add_product_compare',()=>{
        $("#add_product_compare").modal('show');
    });

    Livewire.on('remove_product_compare',(data)=>{
        location.reload();
    });


    Livewire.on('pick_product_compare',(data)=>{
        $("#add_product_compare").modal('hide');
    });


    // Livewire.on('modal_detail_product',(data)=>{
    //     console.log(data);
    //     $("#modal_detail_product").modal('show');
    // });
    
    // untuk menangkap Event emit "refresh-page" yang dibuat di Component Edit.php
    // jika ada event refresh-page maka modal kita hide
    Livewire.on('refresh-page',()=>{
        $(".modal").modal("hide");
    });
</script>
@endpush

