@section('title', $data->barcode .' / '.$data->nama_product)
@section('parentPageTitle', 'Produk')
<div class="row clearfix">
    <div class="col-md-6 px-0 mx-0">
        <div class="card mb-2">
            <div class="body">
                <h6><b>Detail Produk</b></h6>
                <hr />
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th style="border:0">Kode Produksi</th>
                                <td style="border:0"> : </td>
                                <td style="border:0">@livewire('product-supplier.editable',['field'=>'barcode','data'=>$data->barcode,'id'=>$data->id],key('barcode'.$data->id))</td>
                            </tr>
                            <tr>
                                <th>Produk</th>
                                <td> : </td>
                                <td>@livewire('product-supplier.editable',['field'=>'nama_product','data'=>$data->nama_product,'id'=>$data->id],key('nama_product'.$data->id))</td>
                            </tr>
                            <tr>
                                <th>Deskripsi Produk</th>
                                <td> : </td>
                                <td>
                                    <textarea name="" id="" cols="30" rows="6" class="form-control" wire:model="desc_product" >
                                        {{ $data->desc_product }}
                                    </textarea>
                                </td>
                            </tr>
                          
                            <tr>
                                <th>UOM</th>
                                <td> : </td>
                                <td>{{isset($data->uom->name) ? $data->uom->name : '-'}}</td>
                            </tr>
                            <tr>
                                <th>Kategori Produk</th>
                                <td> : </td>
                                <td></td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td style="width:10px;"> : </td>
                                <td>{{$data->qty}}</td>
                            </tr>
                            <tr>
                                <th>Stok Terjual</th>
                                <td style="width:10px;"> : </td>
                                <td>{{$data->qty_moving}}</td>
                            </tr>
                            <tr>
                                <th>Minimum Stok</th>
                                <td style="width:10px;"> : </td>
                                <td>@livewire('product.editable',['field'=>'minimum_stok','data'=>$data->minimum_stok,'id'=>$data->id],key('minimum_stok'.$data->id))</td>
                            </tr>
                            <tr>
                                <th>Last Update</th>
                                <td style="width:10px;"> : </td>
                                <td>{{date('d-M-Y',strtotime($data->updated_at))}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        @if(strlen($data->barcode)>10 and is_numeric($data->barcode))
                            <div>
                                <label>Barcode</label>
                                <a href="" class="ml-3" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                {!! DNS1D::getBarcodeHTML($data->barcode, 'EAN13')!!}
                                <label>
                                    070222456789
                                </label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 pr-0 mx-0"  style="height: 290px;">
        <div class="row">
            <div class="card col-md-12">
                <div class="body">  
                    <h6><b>Kalkulator Harga</b></h6>
                    <hr />
                    <form id="basic-form" method="post" wire:submit.prevent="update">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" class="form-control" wire:model="price" />
                                    <!-- <small class="text-info">*harga jual sebelum pajak</small> -->
                                </div>
                                <!-- <div class="form-group mb-0">
                                    <label class="fancy-checkbox">
                                        <input type="checkbox" wire:model="is_ppn" value="1">
                                        <span>Pajak {{$ppn ? "(" .format_idr($ppn) .")" : ''}}</span>
                                    </label>
                                </div> -->
                                <!-- <div class="form-group">
                                    <label class="mb-0">Harga Produksi : {{format_idr($harga_produksi)}}</label><br />
                                    <small class="text-info">*Harga Jual Dasar + Pajak)</small>
                                </div> -->
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Harga Jual (Rp)</label>
                                    <input type="number" class="form-control" wire:model="harga_jual" />
                                </div>
                                <div class="form-group">
                                    <label>Diskon (Rp)</label>
                                    <input type="number" class="form-control" wire:model="diskon" />
                                </div>
                            </div> -->
                            <div class="col-md-9">
                                <label>Harga Jual</label>
                                <!-- <h2 class="text-info">Rp. {{@format_idr($harga_jual - $diskon)}}</h2> -->
                                <span><h2 class="text-info">Rp. {{@format_idr($price)}}</h2></span>
                            </div>
                            <div class="col-md-12">
                                <hr />
                                <button type="submit" wire:loading.remove wire:target="update" class="btn btn-sm btn-info"><i class="fa fa-save"></i> Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="body">  
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
                                    <th>
                                        <a href="javascript:void(0)" wire:click="$set('insert',true)" class="btn btn-info"><i class="fa fa-plus"></i></a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($insert)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" wire:model="qty" />
                                            @error('qty') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            {{ $disc_p }}
                                            <!-- <input type="text" class="form-control" wire:model="disc_p" /> -->
                                            @error('disc_p') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <!-- {{$disc}} -->
                                            <input type="text" class="form-control" wire:model="disc"/>
                                            @error('disc') <span class="text-danger">{{ $message }}</span> @enderror

                                            
                                        </td>
                                        <td>
                                            {{ format_idr($price - $disc) }}
                                            <!-- <input type="text" class="form-control" wire:model="disc_p" /> -->
                                            @error('disc_p') <span class="text-danger">{{ $message }}</span> @enderror
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" wire:click="updateSettingHarga" class="btn btn-info"><i class="fa fa-save"></i></a>
                                            <a href="javascript:void(0)" wire:click="$set('insert',false)" class="btn btn-danger"><i class="fa fa-close"></i></a>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($setting_harga as $k => $item)
                                    <tr>
                                        <td>{{$item->qty}}</td>
                                        <td>{{ $item->disc }}</td>
                                        <td>
                                            Rp. {{ @format_idr($item->disc_harga) }}
                                            
                                        </td>
                                        <td>
                                            Rp. {{ @format_idr($price-$item->disc_harga) }}
                                        </td>
                                        <td>
                                            <a class="dropdown-item text-danger" href="javascript:void(0)" wire:click="delete({{$item->id}})"><i class="fa fa-trash"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <div class="card col-md-6">
                
            </div> -->
        </div>
        
    </div>
    <div class="col-12 px-0 mx-0">
        <div class="card mb-2">
            <div class="body">
                <ul class="nav nav-tabs">
                    <!-- <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_pembelian">{{ __('Pembelian') }} </a></li> -->
                    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tab_penjualan">{{ __('Penjualan') }} </a></li>
                </ul>
                <div class="tab-content px-0">
                    
                    <div class="tab-pane active show" id="tab_penjualan">
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
                                @foreach($penjualan as $k => $item)
                                    <tr>
                                        <td>{{$k+1}}</td>
                                        <td>
                                            @if(isset($item->id_po))
                                                <a href="{{route('purchase-order.detail',$item->id_po)}}" target="_blank">{{$item->id_po}}</a>
                                            @endif
                                        </td>
                                        <td>{{format_idr($item->price)}}</td>
                                        <td>{{format_idr($item->qty)}}</td>
                                        <td>{{format_idr($item->total)}}</td>
                                        <td>{{date('d-M-Y',strtotime($item->created_at))}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form_pembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @livewire('product-supplier.form-pembelian',['data'=>$data->id])
        </div>
    </div>
</div>

@push('after-scripts')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/css/select2.min.css') }}"/>
    <script src="{{ asset('assets/vendor/select2/js/select2.min.js') }}"></script>
    <script>
        setTimeout(() => {
            select__2 = $('.select_anggota').select2();
            $('.select_anggota').on('change', function (e) {
                var data = $(this).select2("val");
                @this.set("user_member_id", data);
            });
        }, 1000);
    </script>
@endpush