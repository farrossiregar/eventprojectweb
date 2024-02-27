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
    <div class="page-heading-shows-events">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Tickets On Sale Now!</h2>
                    <span>Check out upcoming and past shows & events and grab your ticket right now.</span>
                </div>
            </div>
        </div>
    </div>

    <div class="ticket-details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-image">
                        <img src="{{ env('APP_DOM_DEV') }}/assets/images/event/{{$data->event_image}}" alt="">
                    </div>
                    <br><br>
                    <div class="left-image">
                        <h4><b>Deskripsi Event : </b></h4>
                        <br>
                        <p>{{ $data->event_desc }}</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="right-content">
                        <h4>{{$data->event_name}}</h4>
                        <span>{{ $data->event_stock }} Tickets still available</span>
                        
                        <ul>
                            <li>
                                <i class="fa fa-clock-o"></i> 
                                @if(date_format(date_create($data->event_date_start), 'd M Y') == date_format(date_create($data->event_date_end), 'd M Y'))
                                    {{ date_format(date_create($data->event_date_start), 'd M Y') }}, {{ date_format(date_create($data->event_date_start), 'H:i') }} to {{ date_format(date_create($data->event_date_end), 'H:i') }}
                                @else
                                    {{ date_format(date_create($data->event_date_start), 'd M Y H:i') }} to {{ date_format(date_create($data->event_date_end), 'd M Y H:i') }}
                                @endif
                            </li>
                            <li><i class="fa fa-map-marker"></i>{{ $data->event_loc }}</li>
                        </ul>
                        <div class="quantity-content">
                            <div class="left-content">
                                <h6>Standard Ticket</h6>
                                <p>IDR {{ format_idr($data->event_price) }} per ticket</p>
                            </div>
                            <div class="right-content">
                                <div class="quantity buttons_added">
                                    <input type="button" value="-" class="minus"><input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text" size="4" pattern="" inputmode=""><input type="button" value="+" class="plus">
                                </div>
                            </div>
                        </div>
                        <div class="total">
                            <!-- <h4>Total: IDR {{ format_idr($data->event_price) }}</h4> -->
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













