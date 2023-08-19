@section('title', 'Catalog')
<div class="clearfix row">
    
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-md-2" style="border-right: 1px solid lightgrey;">
                    <div class="header row">
                        <div class="col-md-12">
                            <label>Sort By</label>
                            <select name="" id="" wire:model="sort_by" class="form-control" >
                                <option value="" selected disabled>-- Sort By --</option>
                                <option value="created_at" >Tanggal Upload</option>
                                <option value="price" >Harga</option>
                                <option value="nama_product" >Nama Produk</option>
                                <option value="qty" >Stok Tersedia</option>
                                <option value="popular" >Populer</option>
                            </select>
                            <br>
                        </div>

                        @if($sort_val_opt == true)
                        
                        <div class="col-md-12">
                            <select name="" id="" wire:model="sort_val" class="form-control" >
                                <option value="desc" selected>Z-A</option>
                                <option value="asc">A-Z</option>
                            </select>
                            <br>
                        </div>
                        @endif


                        <div class="col-md-12">
                            <label>View</label>
                            
                            <!-- <select name="" id="" wire:model="optview" class="form-control" >
                                <option value="list"><i class="fa fa-list"></i>List</option>
                                <option value="card"><i class="fa fa-file-image-o"></i>Card</option>
                            </select> -->
                            
                                @if($card)
                                    <a href="javascript:void(0)" wire:click="$set('card',false)" class="btn btn-info"><i class="fa fa-list"></i></a>
                                @else
                                    <a href="javascript:void(0)" wire:click="$set('card',true)" class="btn btn-info"><i class="fa fa-file-image-o"></i></a>
                                @endif
                            <br>
                        </div>


                        <!-- <div class="col-md-12">
                            <label>Tanggal Upload</label>
                            <select name="" id="" wire:model="date" class="form-control" >
                                <option value="" selected disabled>-- Sort By Date Upload --</option>
                                <option value="new">Newest</option>
                                <option value="old">Oldest</option>
                            </select>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <label>Harga</label>
                            <select name="" id="" wire:model="price" class="form-control" >
                                <option value="" selected disabled>-- Sort By Harga --</option>
                                <option value="lo">Termurah</option>
                                <option value="hi">Termahal</option>
                            </select>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <label>Nama Produk</label>
                            <select name="" id="" wire:model="name" class="form-control" >
                                <option value="" selected disabled>-- Sort By Nama Produk --</option>
                                <option value="az">A-Z</option>
                                <option value="za">Z-A</option>
                            </select>
                            <br>
                        </div>                
                        <div class="col-md-12">
                            <label>Lainnya</label>
                            <select name="" id="" wire:model="sortetc" class="form-control" >
                                <option value="">-- Sort By --</option>
                                <option value="populer">Populer</option>
                                <option value="terdekat">Terdekat</option>
                                <option value="stok">Stok</option>
                            </select>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="header row">
                        <div class="col-md-4">
                            <div class="row">
                                <label for="">Cari</label>
                                <input type="text" class="form-control" wire:model="keyword" placeholder="Pencarian Barcode, Nama, Supplier, Lokasi" />
                            </div>
                        </div>
                        
                    </div>
                    <div class="body pt-0">

                        @if(!$card)

                        <div class="table-responsive">
                            <table class="table table-hover m-b-0 c_list table-bordered">
                                <thead style="background: #eee;">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Barcode</th>
                                        <th class="text-center">Nama Produk</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Stok</th>
                                        <th class="text-center">Nama Supplier</th>
                                        <th class="text-center">Lokasi Supplier</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $k => $item)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>{{ $item->barcode }}</td>
                                        <td>{{ $item->nama_product }}</td>
                                        <td><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>{{ \App\Models\Supplier::where('id', $item->id_supplier)->first()->nama_supplier }}</td>
                                        <td>{{ \App\Models\Supplier::where('id', $item->id_supplier)->first()->provinsi }}</td>
                                        <td>
                                            <!-- <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_detail_product" wire:click="" class="btn btn-primary"><b><i class="fa fa-eye"></i></b></a> -->
                                            <a href="javascript:void(0)" wire:click="$emit('modal_detail_product',{{$item->id}})" wire:click="" class="btn btn-primary"><b><i class="fa fa-eye"></i></b></a>
                                        </td>
                                    
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @endif

                        @if($card)
                        <div class="row" id="card-view-catalog">
                            @foreach($data as $k => $item)
                                <div class="card" style="width: 16rem; border: 1px solid lightgrey; margin: 4px;">
                                    <div style="height: 180px; overflow: hidden;">
                                        <img class="card-img-top" src="{{ asset('assets/images/'.$item->image_source) }}" alt="Card image cap">
                                    </div>
                                    
                                    <div class="card-body">
                                        <a href="{{ route('user-supplier.produk',$item->id_supplier) }}" class="card-text">{{ @\App\Models\Supplier::where('id',$item->id_supplier)->first()->nama_supplier }}</a>
                                        <h6 class="card-title">{{ $item->nama_product }}</h6>
                                        <!-- <p style="position: absolute; bottom: 6px; left: 65px;" href="{{route('catalog.detail',$item->id)}}" class="btn btn-primary"><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</p> -->
                                        <div>
                                            <span style="float: left;">
                                                <a href="{{route('catalog.detail',$item->id)}}"><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</a>
                                            </span>
                                            <span style="float: right;">
                                                <b>Stok : {{ $item->qty }}</b>
                                            </span>
                                        </div>
                                        <!-- <p href="{{route('catalog.detail',$item->id)}}"><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</p>
                                        <p><b>Stok : {{ $item->qty }}</b></p> -->
                                        
                                        <br>
                                        @if($insert == 0)
                                        <!-- <a style="position: absolute; bottom: 6px;" href="javascript:void(0)" wire:click="addproductpo({{$item->id}}, {{$item->id_supplier}})" class="btn btn-primary"><b>+</b></a> -->
                                        <a style="position: absolute; bottom: 10px;" href="javascript:void(0)" wire:click="$set('insert',{{$item->id}})" class="btn btn-primary"><b>+</b></a>
                                        <a style="position: absolute; bottom: 10px; left: 60px;" href="javascript:void(0)" wire:click="$emit('modal_detail_product',{{$item->id}})" class="btn btn-primary"><b><i class="fa fa-eye"></i></b></a>
                                        @endif
                                        

                                        @if($insert == $item->id)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" wire:model="qty" />
                                                </div>
                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" wire:click="addproductpo({{$item->id}}, {{$item->id_supplier}})" class="btn btn-info"><i class="fa fa-save"></i></a>
                                                    <a href="javascript:void(0)" wire:click="$set('insert',0)" class="btn btn-danger"><i class="fa fa-close"></i></a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>
                        @endif
                        

                        @if($viewscatalog == 'list')
                        <!--  -->
                        @endif
                        <br />
                        {{$data->links()}}
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>



    <div wire:ignore.self class="modal fade" id="modal_detail_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                
                <div class="row" >
                    
                    <div class="col-md-12">
                        
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-eye"></i> Detail product</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true close-btn">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img class="card-img-top" style="width: 90%;" src="{{ asset('assets/images/'.$image_detail) }}" alt="Card image cap">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-">
                                                <h5 class="card-title"><b>{{ $title_detail }}</b></h5>
                                                <h3 class="font-color: red;"><b>Rp,{{ format_idr($price_detail) }}</b></h3>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_desc">{{ __('Deskripsi') }} </a></li>
                                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_disc">{{ __('Diskon') }} </a></li>
                                            </ul>
                                            <div class="tab-content px-0">
                                                <div class="tab-pane active show" id="tab_desc" style="overflow-y: scroll; overflow-x: hidden;">
                                                    <h6><b>Kelipatan Harga</b></h6>
                                                    <p>
                                                        {{ $deskripsi_detail }}  
                                                    </p>
                                                </div>
                                                <div class="tab-pane" id="tab_disc">
                                                    <h6><b>Kelipatan Harga</b></h6>
                                                    <hr />

                                                    <div class="table-responsive">
                                                        <table class="table table-striped m-b-0 c_list">
                                                            <thead>
                                                                <tr>
                                                                    <th>Jumlah (<)</th>   
                                                                    <th>Diskon (%)</th>                              
                                                                    <th>Potongan (Rp)</th>
                                                                    <th>Harga Jual (Rp)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                               
                                                                @foreach(@App\Models\SettingHarga::where('product_id',$this->selected_id)->get() as $k => $item)
                                                                    <tr>
                                                                        <td>{{$item->qty}}</td>
                                                                        <td>{{ $item->disc }}</td>
                                                                        <td>
                                                                            Rp. {{ @format_idr($item->disc_harga) }}
                                                                            
                                                                        </td>
                                                                        <td>
                                                                            Rp. {{ @format_idr($price-$item->disc_harga) }}
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
                            <div class="modal-footer">
                                <form wire:submit.prevent="beliproduct">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <span><b>Stok {{ $stock_detail }}</b></span>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" wire:model="qty" />
                                            <input type="hidden" class="form-control" wire:model="selected_id" />
                                        </div>
                                        <div class="col-md-4">
                                            <!-- <a href="javascript:void(0)" wire:click="addproductpo($item->id, $item->id_supplier)" class="btn btn-info"><h6><b>BELI</b></h6></a> -->
                                            
                                            <button wire:target="beliproduct" type="submit" class="btn btn-info"><h6><b>BELI</b></h6></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>



</div>

<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <livewire:product-supplier.upload />
        </div>
    </div>
</div>


@push('after-scripts') 
<script>
    Livewire.on('modal_detail_product',(data)=>{
        $("#modal_detail_product").modal('show');
    });
    
    // untuk menangkap Event emit "refresh-page" yang dibuat di Component Edit.php
    // jika ada event refresh-page maka modal kita hide
    Livewire.on('refresh-page',()=>{
        $(".modal").modal("hide");
    });
</script>
@endpush

