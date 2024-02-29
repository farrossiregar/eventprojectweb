@section('title', $data->event_name)
@section('sub-title', 'Detail Event')
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
    <div class="main-banner" style="background-image:url({{ env('APP_DOM_DEV') }}/assets/images/event/{{$data->event_image}}); height: 420px; overflow: hidden; box-shadow: 10px 10px 5px #aaaaaa;">
        <div class="counter-content" style="background-color: rgba(0,0,0,0.5);">
            <ul>
                <li>Days<span id="days_event"></span></li>
                <li>Hours<span id="hours_event"></span></li>
                <li>Minutes<span id="minutes_event"></span></li>
                <li>Seconds<span id="seconds_event"></span></li>
            </ul>
        </div>
        <div class="container" style="background-color: rgba(0,0,0,0.5); margin-top: -120px;">
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


    
    <!-- *** Amazing Venus ***-->
    <div class="amazing-venues">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="left-content">
                        <h4>{{ $data->creator_company }}</h4>
                        <b>Tentang Kami:</b>
                        <!-- <p>ArtXibition Event Template is brought to you by Tooplate website and it included total 7 HTML pages. 
                        These are <a href="index.html">Homepage</a>, <a href="about.html">About</a>, 
                        <a href="rent-venue.html">Rent a venue</a>, <a href="shows-events.html">shows &amp; events</a>, 
                        <a href="event-details.html">event details</a>, <a href="tickets.html">tickets</a>, and <a href="ticket-details.html">ticket details</a>. 
                        You can feel free to modify any page as you like. If you have any question, please visit our <a href="https://www.tooplate.com/contact" target="_blank">Contact page</a>.</p>
                        <br>
                        <p>You can use this event template for your commercial or business website. You are not permitted to redistribute this template ZIP file on any template download website. If you need the latest HTML templates, you may visit <a href="https://www.toocss.com/" target="_blank">Too CSS</a> website that features a great collection of templates in different categories.</p> -->
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="right-content">
                        <h5><i class="fa fa-map-marker"></i> Kontak Kami !!!</h5>
                        <span>{{ $data->creator_address }}</span>
                        <!-- <div class="text-button"><a href="show-events-details.html">Need Directions? <i class="fa fa-arrow-right"></i></a></div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    

    <script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo date_format(date_create($data->event_date_start), 'M d, Y H:i:s'); ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
//   document.getElementById("demo").innerHTML = days + "d " + hours + "h "
//   + minutes + "m " + seconds + "s ";

  document.getElementById("days_event").innerHTML = days;
  document.getElementById("hours_event").innerHTML = hours;
  document.getElementById("minutes_event").innerHTML = minutes;
  document.getElementById("seconds_event").innerHTML = seconds;
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    $(".counter-content").css('display','none');
  }
}, 1000);
</script>




    
  












