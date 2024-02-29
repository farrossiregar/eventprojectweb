@section('title', 'Purchase ' . $data->event_name)
<div class="ticket-details-page">
    <form class="form-auth-small" method="POST" wire:submit.prevent="purchase" action="" >
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-image">
                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="exampleInputName">Nama</label><span class="text-danger">*
                                <input type="text" class="form-control" wire:model="buyer_name">
                                @error('buyer_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label for="exampleInputName">NIK</label><span class="text-danger">*
                                <input type="text" class="form-control" wire:model="buyer_nik">
                                @error('buyer_nik') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label for="exampleInputName">E-mail</label><span class="text-danger">*
                                <input type="email" class="form-control" wire:model="buyer_phone">
                                @error('buyer_phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group col-md-8">
                                <label for="exampleInputName">Nomor Telepon</label><span class="text-danger">*
                                <input type="text" class="form-control" wire:model="buyer_phone">
                                @error('buyer_phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                    

                        <h5><b>Metode Pembayaran</b></h5>
                        <span>{{ $data->event_stock }} Tiket tersedia</span>
                        
                        
                        <input type="radio" name="metode_pembayaran" id="" wire:model="payment_method"> Transfer Bank - BCA <br>
                        <input type="radio" name="metode_pembayaran" id="" wire:model="payment_method"> Transfer Bank - Mandiri <br>
                        <input type="radio" name="metode_pembayaran" id="" wire:model="payment_method"> Transfer Bank - BRI <br>
                        <input type="radio" name="metode_pembayaran" id="" wire:model="payment_method"> QRIS - BCA <br>
                        <input type="radio" name="metode_pembayaran" id="" wire:model="payment_method"> QRIS - Mandiri <br>
                        <input type="radio" name="metode_pembayaran" id="" wire:model="payment_method"> Indomaret <br>
                        
                        <br><br> 

                        <div class="quantity-content">
                            <div class="left-content">
                                <h6>Jumlah Pembelian</h6>
                                <p>IDR {{ format_idr($data->event_price) }} per ticket</p>
                            </div>
                            <div class="right-content">
                                <div class="quantity buttons_added">
                                    <input type="button" value="-" class="minus" wire:model="amount"><input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode=""><input type="button" value="+" class="plus">
                                </div>
                            </div>
                        </div>
                        <div class="total">
                            <h4>Total: IDR {{ format_idr($total_price) }}</h4>
                            <!-- <div class="main-dark-button"><a href="#">Beli Tiket</a></div> -->
                            <br>
                            <button type="submit" class="main-dark-button">{{ __('Beli Tiket') }}</button>
                            
                            
                        </div>
                        <div class="warn">
                            <p style="color:red;">*Maksimal Pembelian 10 Tiket</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



<div class="amazing-venues">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="left-content">
                    <h4>{{ $data->creator_company }}</h4>
                    <b>Tentang Kami:</b>
                  
                </div>
            </div>
            <div class="col-lg-3">
                <div class="right-content">
                    <h5><i class="fa fa-map-marker"></i> Kontak Kami !!!</h5>
                    <span>{{ $data->creator_address }}</span>
                    
                </div>
            </div>
        </div>
    </div>
</div>


    
    
    