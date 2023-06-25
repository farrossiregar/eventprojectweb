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
                    
                        <div class="col-md-2">
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
                        </div>
                    </div>
                    <div class="body pt-0">

                        <!-- if($viewscatalog == 'card') -->
                        <div class="row" id="card-view-catalog">
                            @foreach($data as $k => $item)
                                <div class="card" style="width: 16rem; border: 1px solid lightgrey; margin: 4px;">
                                    <img class="card-img-top" src="https://pict.sindonews.net/dyn/850/pena/news/2022/02/02/700/674121/11-rahasia-avengers-endgame-yang-diungkapkan-marvel-ebh.jpg" alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->nama_product }}</h5>
                                        <p class="card-text">{{ @\App\Models\Supplier::where('id',$item->id_supplier)->first()->nama_supplier }}</p>
                                        <br>
                                        <a style="position: absolute; bottom: 6px; left: 65px;" href="{{route('catalog.detail',$item->id)}}" class="btn btn-primary"><b>Rp, {{ format_idr($item->price) }}</b>/{{ @strtolower($item->uom->name) }}</a>
                                        <a style="position: absolute; bottom: 6px;" href="javascript:void(0)" wire:click="addproductpo({{$item->id}}, {{$item->id_supplier}})" class="btn btn-primary"><b>+</b></a>
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>
                        <!-- endif -->
                        

                        @if($viewscatalog == 'list')
                        <div class="table-responsive" id="list-view-catalog" style="min-height:400px;">
                        
                            <table class="table table-hover m-b-0 c_list">
                                <thead style="background: #eee;">
                                <tr>
                                        <th>No</th>
                                        <th>Barcode</th>
                                        <th>Nama Produk</th>
                                        <th>Supplier</th>
                                        <th>Kategori Produk</th>
                                        <th>UOM</th>
                                        <th class="text-center">Stok</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-right">Diskon</th>
                                        <th class="text-right">Lokasi</th>
                                        <th class="text-right">Uploaded At</th>
                                        <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php($number= $data->total() - (($data->currentPage() -1) * $data->perPage()) )
                                    @foreach($data as $k => $item)
                                        @php($bg_minimum_stok="transparent")
                                        
                                        <tr>
                                            <td style="width: 50px;">{{$k+1}}</td>
                                            <!-- <td class="text-center">
                                                @if($item->status==1)
                                                    <span class="badge badge-success">Aktif</span>
                                                @endif
                                                @if($item->status==0 || $item->status=="")
                                                    <span class="badge badge-default">Tidak Aktif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{$item->type}}</td> -->
                                            <td>@livewire('product-supplier.editable',['field'=>'barcode','data'=>$item->barcode,'id'=>$item->id],key('barcode'.$item->id))</td>
                                            <td>@livewire('product-supplier.editable',['field'=>'nama_product','data'=>$item->nama_product,'id'=>$item->id],key('nama_product'.$item->id))</td>
                                            <td></td>
                                            <td></td>
                                            <td>@livewire('product-supplier.editable',['field'=>'product_uom_id','data'=>(isset($item->uom->name) ? $item->uom->name : ''),'id'=>$item->id],key('uom'.$item->id))</td>
                                            <td class="text-center">@livewire('product-supplier.editable',['field'=>'qty','data'=>$item->qty,'id'=>$item->id],key('qty'.$item->id))</td>
                                            <td class="text-right">
                                                @livewire('product-supplier.editable',['field'=>'price','data'=>$item->price,'id'=>$item->id],key('price'.$item->id))
                                            </td>
                                            <td class="text-right">{{$item->diskon ? format_idr($item->disc) : '-'}}</td>    
                                            <td></td>
                                            <td class="text-right">{{date_format(date_create($item->created_at), 'd M Y')}}</td>    
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-navicon"></i></a>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" href="{{route('product-supplier.detail',$item->id)}}"><i class="fa fa-search-plus"></i> Detail</a>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" wire:click="delete({{$item->id}})"><i class="fa fa-trash"></i> Hapus</a>
                                                    </div>
                                                </div>    
                                            </td>
                                        </tr>
                                        @php($number--)
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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


