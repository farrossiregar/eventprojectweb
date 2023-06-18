@section('title', 'Purchase Order')
@section('sub-title', "#".$data->no_po)
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="form-group col-md-2">
                        <small>No Purchase Order</small> 
                        @if($data->status==0)
                            <span class="badge badge-warning mr-0">Draft</span>
                        @endif
                        @if($data->status==1)
                            <span class="badge badge-success mr-0">Submitted</span>
                        @endif<br />
                        @if($data->status==2)
                            <span class="badge badge-warning mr-0">Waiting for Payment</span>
                        @endif<br />
                        @if($data->status==3)
                            <span class="badge badge-info mr-0">Payment Sent</span>
                        @endif<br />
                        @if($data->status==4)
                            <span class="badge badge-success mr-0">Payment Confirmed</span>
                        @endif<br />

                        {{$data->no_po}}
                    </div>
                    <div class="form-group col-md-3">   
                        @if($data->status==0)
                            <small>Supplier</small> 
                            @if(!$data->id_supplier)
                                <select class="form-control" wire:model="id_supplier">
                                    <option value=""> -- Pilih -- </option>
                                    @foreach($suppliers as $item)
                                        <option value="{{$item->id}}">{{$item->nama_supplier}}</option>
                                    @endforeach
                                </select>
                                @error('id_supplier') <span class="text-danger">{{ $message }}</span> @enderror
                            @else
                                @if(\App\Models\PurchaseOrderDetail::where('id_po', $data->id)->first())
                                    <label>{{isset($data->supplier->nama_supplier) ? $data->supplier->nama_supplier : ''}}</label>
                                    <hr class="py-0 my-0" />
                                @else   
                                    <select class="form-control" wire:model="id_supplier">
                                        <option value=""> -- Pilih -- </option>
                                        @foreach($suppliers as $item)
                                            <option value="{{$item->id}}">{{$item->nama_supplier}}</option>
                                        @endforeach
                                    </select>
                                    @error('id_supplier') <span class="text-danger">{{ $message }}</span> @enderror
                                @endif
                            @endif
                        @else
                            <small>Supplier</small><br />
                            <label>{{isset($data->supplier->nama_supplier) ? $data->supplier->nama_supplier : ''}}</label>
                            <hr class="py-0 my-0" />
                        @endif
                    </div>
                    <div class="form-group col-md-3">
                        @if($data->status==0)
                            <small>Alamat Pengiriman</small>
                            @if(!$data->id_supplier)
                                <input type="text" class="form-control" wire:model="alamat_penagihan" />
                                @error('alamat_penagihan') <span class="text-danger">{{ $message }}</span> @enderror
                            @else
                                <small>Alamat Pengiriman</small><br />
                                <label>{{$alamat_penagihan}}</label>
                                <hr class="py-0 my-0" />
                            @endif
                        @else
                            <small>Alamat Pengiriman</small><br />
                            <label>{{$data->alamat_penagihan}}</label>
                            <hr class="py-0 my-0" />
                        @endif
                    </div>
                    <div class="form-group col-md-2">
                        @if($data->status==0)
                            <small>Purchase Date</small>
                            <input type="text" class="form-control" value="<?php echo date('d/m/Y'); ?>"/>
                            @error('purchase_order_date') <span class="text-danger">{{ $message }}</span> @enderror
                        @else
                            <small>Purchase Date</small><br />
                            <label>{{$data->purchase_order_date ? date('d/M/Y',strtotime($data->purchase_order_date)) : '-'}}</label>
                            <hr class="py-0 my-0" />
                        @endif
                    </div>
                    <!-- <div class="form-group col-md-6">
                        @if($data->status==0)
                            <label>Delivery Order Number</label>
                            <input type="text" class="form-control" wire:model="delivery_order_number" />
                            @error('delivery_order_number') <span class="text-danger">{{ $message }}</span> @enderror
                        @else
                            <small>Delivery Order Number</small><br />
                            <label>{{$data->delivery_order_number}}</label>
                            <hr class="py-0 my-0" />
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        @if($data->status==0)
                            <label>Delivery Order Date</label>
                            <input type="date" class="form-control" wire:model="delivery_order_date" />
                            @error('delivery_order_date') <span class="text-danger">{{ $message }}</span> @enderror
                        @else
                            <small>Delivery Order Date</small><br />
                            <label>{{$data->delivery_order_date ? date('d/M/Y',strtotime($data->delivery_order_date)) : '-'}}</label>
                            <hr class="py-0 my-0" />
                        @endif
                    </div> -->
                </div>
                <!-- <h6>Produk</h6> -->
                <hr class="mt-0 pt-0" />
                <div class="table-responsive">
                    <table class="table c_list table-hover table-bordered">
                        <thead>
                            <tr style="background: #eee;">
                                <th>No</th>
                                <th>Barcode</th>
                                <th>Produk</th>
                                <th class="text-center">UOM</th>
                                <th class="text-center">QTY</th>
                                <th class="text-center">Diskon (%)</th>
                                <th class="text-center">Diskon (Rp)</th>
                                <th class="text-right">Harga</th>
                                <th class="text-right"></th>
                                @if($data->status==0)
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if($data->status==0)
                                <tr>
                                    <td></td>
                                    <td colspan="2">
                                        <div wire:ignore>
                                            <select class="form-control select_product_po">
                                                <option value=""> -- Barcode / Produk -- </option>
                                            </select>
                                        </div>
                                        @error('product_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        {{ $product_uom_id }}
                                        <!-- <input type="text" wire:model="product_uom_id"> -->
                                        <!-- <select class="form-control" wire:model="product_uom_id">
                                            <option value=""> --- UOM --- </option>
                                            @foreach(\App\Models\ProductUom::get() as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach 
                                        </select> -->
                                        @error('product_uom_id') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model="qty" min="0" />
                                        @error('qty') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model="disc_p" min="0" />
                                        @error('diskon') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" wire:model="disc" min="0" />
                                        @error('diskon') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>
                                        {{ format_idr($price) }}
                                        <!-- <input type="number" class="form-control text-right" min="0" wire:model="price" /> -->
                                        @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                                    </td>
                                    <td>{{(($price && $qty) ? format_idr($price*$qty) : '')}}</td>
                                    <td>
                                        <span wire:loading wire:target="addProduct">
                                            <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                                            <span class="sr-only">{{ __('Loading...') }}</span>
                                        </span>
                                        <a href="javascript:void(0)" wire:loading.remove wire:target="addProduct" class="btn btn-info btn-sm" wire:click="addProduct"><i class="fa fa-plus"></i></a>
                                    </td>
                                </tr>
                            @endif
                            @php($total=0)
                            @php($total_qty=0)
                            @php($sub_total=0)
                            @foreach($data->details as $k => $item)
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>{{isset($item->product->barcode) ? $item->product->barcode : '-'}}</td>
                                    <td>{{isset($item->product->nama_product) ? $item->product->nama_product : '-'}}</td>
                                    <td class="text-center">
                                        @if($data->status==0)
                                            @livewire('purchase-order.editable',['field'=>'product_uom_id','data'=>(isset($item->uom->name) ? $item->uom->name : ''),'id'=>$item->id],key('product_uom_id'.$item->id))
                                        @else
                                            {{isset($item->uom->name) ? $item->uom->name : '-'}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($data->status==0)
                                            @livewire('purchase-order.editable',['field'=>'qty','data'=>$item->qty,'id'=>$item->id],key('qty'.$item->id))
                                        @else
                                            {{$item->qty}}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($data->status==0)
                                            @livewire('purchase-order.editable',['field'=>'disc','data'=>$item->disc,'id'=>$item->id],key('disc'.$item->id))
                                        @else
                                            {{$item->diskon}}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if($data->status==0)
                                            @livewire('purchase-order.editable',['field'=>'price','data'=>$item->price,'id'=>$item->id],key('price'.$item->id))
                                        @else
                                            {{format_idr($item->price)}}
                                        @endif
                                    </td>
                                    <td class="text-right">{{format_idr($item->price*$item->qty)}}</td>
                                    <td class="text-center">
                                        @if($data->status==0)
                                            <a href="javascript:void(0)" class="text-danger" wire:click="deleteProduct({{$item->id}})"><i class="fa fa-close"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @php($total += $item->price)
                                @php($total_qty += $item->qty)
                                @php($sub_total += $item->qty * ($item->price-$item->disc))
                            @endforeach
                        </tbody>
                        @if($data->details->count()==0)
                            <tr>
                                <td class="text-center" colspan="7"><i>Data kosong</i></td>
                            </tr>
                        @endif
                        <tfoot style="background: #eee;">
                            <tr>
                                <th colspan="7" class="text-right">Sub Total</th>
                                <th class="text-right">{{format_idr($sub_total)}}</th>
                                <th></th>
                            </tr>
                            <!-- <tr>
                                <th colspan="7" class="text-right">Biaya Pengiriman</th>
                                <th class="text-right">
                                    @if($data->status==0)
                                        <input type="text" class="form-control text-right" wire:model="biaya_pengiriman" /> 
                                    @else
                                        {{format_idr($data->biaya_pengiriman)}}
                                    @endif
                                </th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="7" class="text-right">Pajak</th>
                                <th class="text-right">
                                    @if($data->status==0)
                                        <input type="text" class="form-control  text-right" wire:model="pajak" />
                                    @else
                                        {{format_idr($data->ppn)}}
                                    @endif
                                </th>
                                <th></th>
                            </tr> -->
                            <tr>
                                <th colspan="7" class="text-right">Total</th>
                                <th class="text-right">{{format_idr($sub_total+$biaya_pengiriman+$pajak)}}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    @if($data->status==0)
                        <div>
                            <label>Catatan</label> 
                            <textarea class="form-control" wire:model="catatan"></textarea>
                        </div>
                    @else
                        <small>Catatan</small><br />
                        <label>{{$data->catatan}}</label>
                        <hr class="py-0 my-0" />
                    @endif
                </div>
                <hr />
                <div class="form-group">
                    <a href="{{route('purchase-order.index')}}" class="mr-3"><i class="fa fa-arrow-left"></i> Kembali</a>
                    @if($data->status==0)
                        <button type="button" class="btn btn-warning" wire:click="saveAsDraft"><i class="fa fa-save"></i> Save as Draft</button>
                        <button type="button" class="btn btn-info" wire:click="submit"><i class="fa fa-check-circle"></i> Issued</button>
                    @endif
                    @if($data->status==2)
                        <button type="button" class="btn btn-info" wire:click="sendpayment"><i class="fa fa-send-o"></i> Confirm Payment</button>
                    @endif
                </div>
            </div>
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

        select_product_po = $('.select_product_po').select2({
            placeholder: " -- Barcode / Product -- ",
            data : {!!json_encode($data_product)!!},
            tokenSeparators: [',', '.','/']
        });
        $('.select_product_po').on('change', function (e) {
            var data = $(this).select2("val");
            @this.set("product_id", data);
        });
    </script>
@endpush