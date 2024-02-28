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
    

    <!-- ***** Main Banner Area Start ***** -->
    <div class="main-banner" style="background-image:url({{ env('APP_DOM_DEV') }}/assets/images/event/{{$data->event_image}});">
        <div class="counter-content" style="background-color: rgba(0,0,0,0.5);">
            <ul>
                <li>Days<span id="days"></span></li>
                <li>Hours<span id="hours"></span></li>
                <li>Minutes<span id="minutes"></span></li>
                <li>Seconds<span id="seconds"></span></li>
            </ul>
        </div>
        <div class="container" style="background-color: rgba(0,0,0,0.5);">
            <div class="row">
                <div class="col-lg-12">
                    <div class="main-content">
                        <!-- <div class="next-show">
                            <i class="fa fa-arrow-up"></i>
                            <span>Next Show</span>
                        </div> -->
                        <!-- <h6>Opening on Thursday, March 31st</h6> -->
                        <h2>{{$data->event_name}}</h2>
                        <!-- <div class="main-white-button">
                            <a href="ticket-details.html">Beli Tiket</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ***** Main Banner Area End ***** -->
   

    <!-- ***** About Us Page ***** -->
    <!-- <div class="page-heading-shows-events" style="background-image:url({{ env('APP_DOM_DEV') }}/assets/images/event/{{$data->event_image}});">
        <div style="background-color: rgba(0,0,0,0.5);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Tiket tersedia</h2>
                        <span>Check out tiket sebelum kehabisan.</span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="ticket-details-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="left-image">
                        <img src="{{ env('APP_DOM_DEV') }}/assets/images/event/{{$data->event_image}}" alt="">
                    </div>
                    <br><br>
                    <div class="left-image">
                        <h3><b>Deskripsi Event : </b></h3>
                        <br>
                        <?php echo html_entity_decode($data->event_desc); ?>
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



    <div class="subscribe">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading" style="color: white;">
                        
                        <h1 style="color: white;">Event Lainnya dari Creator</h1>
                    </div>
                </div>
               
                @foreach($creator_event as $item)
                <div class="col-lg-3">
                    <div class="venue-item">
                        <div class="thumb">
                            <img src="{{ env('APP_DOM_DEV') }}/assets/images/event/{{$data->event_image}}" alt="{{ $item->event_name }}">
                        </div>
                        <div class="down-content">
                            <div class="left-content">
                                <div class="main-white-button">
                                    <a href="ticket-details.html">Beli Tiket</a>
                                </div>
                            </div>
                            <div class="right-content">
                                <h4>{{ $item->event_name }}</h4>
                                <ul>
                                    <li><i class="fa fa-user"></i>{{ $item->event_stock }} tiket tersisa</li>
                                </ul>
                                <div class="price">
                                    <span><em>IDR {{ format_idr($item->event_price) }}</em></span>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    
    


    <script>
        (function ($) {
            // console.log('<?php echo date_format(date_create($data->event_date_start), 'M d, Y H:i:s'); ?>');
            "use strict";

            $('.owl-show-events').owlCarousel({
                items:4,
                loop:true,
                dots: true,
                nav: true,
                autoplay: true,
                margin:30,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:2
                    },
                    1000:{
                        items:4
                    }
                }
            })

            const second = 1000,
            minute = second * 60,
            hour = minute * 60,
            day = hour * 24;

            let countDown = new Date('Mar 31, 2024 09:30:00').getTime(),
            
            // let countDown = new Date('<?php echo date_format(date_create($data->event_date_start), 'M d, Y H:i:s'); ?>').getTime(),
            x = setInterval(function() {    

            let now = new Date().getTime(),
                distance = countDown - now;

            document.getElementById('days').innerText = Math.floor(distance / (day)),
            document.getElementById('hours').innerText = Math.floor((distance % (day)) / (hour)),
            document.getElementById('minutes').innerText = Math.floor((distance % (hour)) / (minute)),
            document.getElementById('seconds').innerText = Math.floor((distance % (minute)) / second);

            //do something later when date is reached
            //if (distance < 0) {
            //  clearInterval(x);
            //  'IT'S MY BIRTHDAY!;
            //}

            }, second)

           

        })(window.jQuery);
    </script>

    
  












