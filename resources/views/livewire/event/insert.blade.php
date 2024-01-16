@section('title', __('Create Event'))
<style>
    .border-group{
        border: 1px solid lightgrey; border-radius: 5px; padding: 10px 0; width: 95%; margin: auto; margin-bottom: 5px;
    }
</style>
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                <form id="basic-form" method="post" wire:submit.prevent="save">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row form-group border-group">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{ __('Nama Event') }}</label>
                                        <input type="text" class="form-control" wire:model="nama_event" >
                                        @error('nama_event')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __('Deskripsi Event') }}</label>
                                        <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                                        @error('nama_event')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori Event</label>
                                        <select class="form-control">
                                            <option value="1">Event1</option>
                                            <option value="2">Event2</option>
                                        </select>
                                        @error('harga')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Tanggal Event') }}</label>
                                        <input type="date" class="form-control"  wire:model="harga" >
                                        @error('harga')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>{{ __('Tanggal Daftar Awal') }}</label>
                                                <input type="date" class="form-control" wire:model="description" >
                                                @error('description')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{ __('Tanggal Daftar Akhir') }}</label>
                                                <input type="date" class="form-control" wire:model="description" >
                                                @error('description')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                    </div>


                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row form-group border-group">
                                <div class="col-md-12">    
                                    <div class="form-group">
                                        <label>Venue</label>
                                        <select class="form-control">
                                            <option value="1">Online</option>
                                            <option value="2">Offline</option>
                                        </select>
                                        @error('harga')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Link') }}</label>
                                        <input type="text" class="form-control" wire:model="description" >
                                        @error('description')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>


                                    <div class="form-group">
                                        <label>{{ __('Lokasi') }}</label>
                                        <input type="text" class="form-control" wire:model="description" >
                                        @error('description')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>
                                                                
                                    <div class="form-group">
                                        <label>Tipe Event</label>
                                        <select class="form-control">
                                            <option value="1">Gratis</option>
                                            <option value="2">Berbayar</option>
                                        </select>
                                        @error('harga')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>{{ __('Harga') }}</label>
                                        <input type="text" class="form-control" wire:model="description" >
                                        @error('description')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>
                                
                                </div>
                            </div>


                            <div class="row form-group border-group">
                                <div class="col-md-12">    
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control">
                                        @error('image')
                                            <ul class="parsley-errors-list filled" id="parsley-id-29"><li class="parsley-required">{{ $message }}</li></ul>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <hr>
                    <a href="javascript:void(0)" onclick="history.back();"><i class="fa fa-arrow-left"></i> {{ __('Kembali') }}</a>
                    <button type="submit" class="btn btn-primary ml-3"><i class="fa fa-save"></i> {{ __('Simpan Produk') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>