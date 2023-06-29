@section('title', 'Catalog')
<div class="clearfix row">
    
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-md-2" style="border-right: 1px solid lightgrey;">
                    <div class="header row">
                        <div class="col-md-12">
                            <label>Tanggal Upload</label>
                            <select name="" id="" class="form-control" >
                                <option value="" selected disabled>-- Sort By Date Upload --</option>
                                <option value="">Newest</option>
                                <option value="">Oldest</option>
                            </select>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <label>Harga</label>
                            <select name="" id="" class="form-control" >
                                <option value="" selected disabled>-- Sort By Harga --</option>
                                <option value="">Termurah</option>
                                <option value="">Termahal</option>
                            </select>
                            <br>
                        </div>
                        <div class="col-md-12">
                            <label>Nama Produk</label>
                            <select name="" id="" class="form-control" >
                                <option value="" selected disabled>-- Sort By Nama Produk --</option>
                                <option value="">A-Z</option>
                                <option value="">Z-A</option>
                            </select>
                            <br>
                        </div>                
                        <div class="col-md-12">
                            <label>Lainnya</label>
                            <select name="" id="" class="form-control" >
                                <option value="">-- Sort By --</option>
                                <option value="">Populer</option>
                                <option value="">Terdekat</option>
                                <option value="">Stok</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="header row">
                        <div class="col-md-4">
                            <label for="">Cari</label>
                            <input type="text" class="form-control" wire:model="keyword" placeholder="Pencarian Barcode, Nama, Supplier, Lokasi" />
                        </div>
                        <!-- <div class="col-md-2">
                            <label>Tanggal Upload</label>
                            <select name="" id="" class="form-control" >
                                <option value="" selected disabled>-- Sort By Date Upload --</option>
                                <option value="">Newest</option>
                                <option value="">Oldest</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label>Harga</label>
                            <select name="" id="" class="form-control" >
                                <option value="" selected disabled>-- Sort By Harga --</option>
                                <option value="">Termurah</option>
                                <option value="">Termahal</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Nama Produk</label>
                            <select name="" id="" class="form-control" >
                                <option value="" selected disabled>-- Sort By Nama Produk --</option>
                                <option value="">A-Z</option>
                                <option value="">Z-A</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label>Lainnya</label>
                            <select name="" id="" class="form-control" >
                                <option value="">-- Sort By --</option>
                                <option value="">Populer</option>
                                <option value="">Terdekat</option>
                                <option value="">Stok</option>
                            </select>
                        </div> -->
                    
                        <!-- <div class="col-md-2">
                            <label for="">&nbsp</label><br>
                            <div class="btn-group" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">View</button>
                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    
                                    
                                    <a href="javascript:void(0)" id="list-btn-catalog" wire:click="$emit('viewcatalog','1')" class="dropdown-item"><i class="fa fa-list-ul"></i> List</a>
                                    <a href="javascript:void(0)" id="card-btn-catalog" wire:click="$emit('viewcatalog','2')" value="1" class="dropdown-item"><i class="fa fa-square-o"></i> Card</a>
                                </div>
                            </div>
                            <span wire:loading>
                                <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                <span class="sr-only">{{ __('Loading...') }}</span>
                            </span>
                        </div> -->
                    </div>
                    <div class="body pt-0">

                        <!-- if($viewscatalog == 'card') -->
                        <div class="row" id="card-view-catalog">
                            @foreach($data as $k => $item)
                                <div class="card" style="width: 16rem; border: 1px solid lightgrey; margin: 4px;">
                                    <img class="card-img-top" src="https://pict.sindonews.net/dyn/850/pena/news/2022/02/02/700/674121/11-rahasia-avengers-endgame-yang-diungkapkan-marvel-ebh.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->nama_product }}</h5>
                                        <!-- <p style="position: absolute; bottom: 6px; left: 65px;" href="{{route('catalog.detail',$item->id)}}" class="btn btn-primary"><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</p> -->
                                        <p href="{{route('catalog.detail',$item->id)}}"><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</p>
                                        <p class="card-text">{{ @\App\Models\Supplier::where('id',$item->id_supplier)->first()->nama_supplier }}</p>
                                        <br>
                                        @if($insert == 0)
                                        <!-- <a style="position: absolute; bottom: 6px;" href="javascript:void(0)" wire:click="addproductpo({{$item->id}}, {{$item->id_supplier}})" class="btn btn-primary"><b>+</b></a> -->
                                        <a style="position: absolute; bottom: 6px;" href="javascript:void(0)" wire:click="$set('insert',{{$item->id}})" class="btn btn-primary"><b>+</b></a>
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
                        <!-- endif -->
                        

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

    <div wire:ignore.self class="modal fade" id="modal_set_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form wire:submit.prevent="changePassword">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa fa-sign-in"></i> Set Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true close-btn">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" class="form-control" wire:model="password" />
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger close-modal">Submit</button>
                    </div>
                </form>
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


