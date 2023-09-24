@section('title', 'Refund Product')
@section('sub-title', 'Insert')
<div class="row clearfix">
    <div class="col-md-6">
        <div class="card">
            <div class="body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <small>No Purchase Order</small>
                        <h6>{{$no_po}}</h6>
                        <hr class="py-0 my-0" />
                    </div>
                    <div class="form-group col-md-6 text-right">
                        <small>Status</small><br />
                        <span class="badge badge-info mr-0">Draft</span>
                    </div>
                </div>
              

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Total Produk</label>
                        <input type="number" class="form-control" wire:model="qty_po"  readonly/>
                        
                    </div>
                    <div class="form-group col-md-6">
                        <label>Jumlah Produk direfund</label>
                        <input type="number" class="form-control" wire:model="qty_ref" />
                        @error('id_supplier') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                   
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Harga Total</label>
                        <input type="number" class="form-control" wire:model="price_po"  readonly/>
                        
                    </div>
                    <div class="form-group col-md-6">
                        <label>Harga direfund</label>
                        <input type="number" class="form-control" wire:model="price_ref" />
                        @error('id_supplier') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label>Photo 1</label>
                        @if($image_ref)
                        <div style="height: 180px; overflow: hidden;">
                            <img class="card-img-top" src="{{ asset('assets/images/refund/'.$image_ref) }}" alt="Card image cap">
                        </div>
                        @endif
                        <input type="file" class="form-control" wire:model="image_ref" />
                        
                        @error('id_supplier') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Photo 2</label>
                        @if($image_ref2)
                        <div style="height: 180px; overflow: hidden;">
                            <img class="card-img-top" src="{{ asset('assets/images/refund/'.$image_ref2) }}" alt="Card image cap">
                        </div>
                        @endif
                        <input type="file" class="form-control" wire:model="image_ref2" />
                        
                        @error('id_supplier') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label>Photo 3</label>
                        @if($image_ref3)
                        <div style="height: 180px; overflow: hidden;">
                            <img class="card-img-top" src="{{ asset('assets/images/refund/'.$image_ref3) }}" alt="Card image cap">
                        </div>
                        @endif
                        <input type="file" class="form-control" wire:model="image_ref3" />
                        
                        @error('id_supplier') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                </div>

                <div class="form-group">
                    <label>Alasan Refund</label>
                    <textarea class="form-control" wire:model="alamat_penagihan"></textarea>
                    @error('alamat_penagihan') <span class="text-danger">{{ $message }}</span> @enderror
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
                    data : {!!json_encode($data_product)!!}
                });
            $('.select_product_po').on('change', function (e) {
                var data = $(this).select2("val");
                @this.set("product_id", data);
            });
    </script>
@endpush