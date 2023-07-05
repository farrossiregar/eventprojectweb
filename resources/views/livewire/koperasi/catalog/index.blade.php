@section('title', 'Catalog')
<div class="clearfix row">
    
    <div class="col-lg-12">
        <div class="card">
            <div class="row">
                <div class="col-md-2" style="border-right: 1px solid lightgrey;">
                    <div class="header row">
                        <div class="col-md-12">
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
                        </div>
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

                        <!-- if($viewscatalog == 'card') -->
                        <div class="row" id="card-view-catalog">
                            @foreach($data as $k => $item)
                                <div class="card" style="width: 16rem; border: 1px solid lightgrey; margin: 4px;">
                                    <img class="card-img-top" src="{{ asset('assets/images/'.$item->image_source) }}" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->nama_product }}</h5>
                                        <!-- <p style="position: absolute; bottom: 6px; left: 65px;" href="{{route('catalog.detail',$item->id)}}" class="btn btn-primary"><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</p> -->
                                        <p href="{{route('catalog.detail',$item->id)}}"><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</p>
                                        <p><b>Stok : {{ $item->qty }}</b></p>
                                        <p class="card-text">{{ @\App\Models\Supplier::where('id',$item->id_supplier)->first()->nama_supplier }}</p>
                                        <br>
                                        @if($insert == 0)
                                        <!-- <a style="position: absolute; bottom: 6px;" href="javascript:void(0)" wire:click="addproductpo({{$item->id}}, {{$item->id_supplier}})" class="btn btn-primary"><b>+</b></a> -->
                                        <a style="position: absolute; bottom: 10px;" href="javascript:void(0)" wire:click="$set('insert',{{$item->id}})" class="btn btn-primary"><b>+</b></a>
                                        <a style="position: absolute; bottom: 10px; left: 60px;" href="javascript:void(0)" data-toggle="modal" data-target="#modal_detail_product" wire:click="" class="btn btn-primary"><b><i class="fa fa-eye"></i></b></a>
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
                                        <img class="card-img-top" style="width: 100%;" src="https://pict.sindonews.net/dyn/850/pena/news/2022/02/02/700/674121/11-rahasia-avengers-endgame-yang-diungkapkan-marvel-ebh.jpg" alt="Card image cap">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-">
                                                <h4 class="card-title">Detail Product</h4>
                                                <h7><b>Tersedia 20</b></span>
                                                <br>
                                                <h5 class="font-color: red;">Rp. 12000</h5>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <h5>Deskripsi Produk :</h5>
                                            <p>
                                                Sari Roti Roti BANTAL, ada rasa coklat, coklat keju, srikaya Sari Roti Roti BANTAL, ada rasa coklat, coklat keju, srikaya
                                            </p>
                                            <p>
                                            Sari Roti Roti BANTAL, ada rasa coklat, coklat keju, srikaya    
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" wire:model="qty" />
                                    </div>
                                    <div class="col-md-6">
                                        <a href="javascript:void(0)" wire:click="addproductpo({{$item->id}}, {{$item->id_supplier}})" class="btn btn-info"><i class="fa fa-save"></i></a>
                                    </div>
                                </div>
                                
                            </div>
                        
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


