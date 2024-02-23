@section('title', 'Detail Event Project Stalavista')
@section('sub-title', 'Index')
<!-- ***** Preloader Start ***** -->
<!-- <div id="js-preloader" class="js-preloader">
      <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div> -->
    <!-- ***** Preloader End ***** -->
    

   

    <!-- ***** About Us Page ***** -->
  

    <div class="ticket-details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-image">
                        
                    </div>
                    
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                        <h4>Metode Pembayaran</h4>
                        <span>{{ $data->event_stock }} Tickets still available</span>
                        
                        
                        <input type="radio" name="" id=""> Transfer Bank - BCA <br>
                        <input type="radio" name="" id=""> Transfer Bank - Mandiri <br>
                        <input type="radio" name="" id=""> Transfer Bank - BRI <br>
                        <input type="radio" name="" id=""> QRIS - BCA <br>
                        <input type="radio" name="" id=""> QRIS - Mandiri <br>
                        <input type="radio" name="" id=""> Indomaret <br>
                        
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
                            <h4>Total: IDR {{ format_idr($data->event_price) }}</h4>
                            <div class="main-dark-button"><a href="#">Beli Tiket</a></div>
                        </div>
                        <div class="warn">
                            <!-- <p>*You Can Only Buy 10 Tickets For This Show</p> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
    
    

    <!-- jQuery -->
    <script src="{{ asset('assets/js/jquery-2.1.0.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/popper.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/js/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/imgfix.min.js') }}"></script> 
    <script src="{{ asset('assets/js/mixitup.js') }}"></script> 
    <script src="{{ asset('assets/js/accordions.js') }}"></script>
    <script src="{{ asset('assets/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('assets/js/quantity.js') }}"></script>
    
    <!-- Global Init -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>













