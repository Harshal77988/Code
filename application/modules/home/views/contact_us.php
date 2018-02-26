<section class="shopping-cart">
    <!-- .shopping-cart -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                    <li class="breadcrumb-item active">Contact Us</li>
                </ol>
            </div>
            
            <div class="col-md-12">
                <div class="map">
                    <!--  map  -->
                    <!-- The element that will contain our Google Map. This is used in both the Javascript and CSS above. -->
                    <div id="map"></div>
                    <!--  m/ap  -->
                </div> 
            </div>
            <div class="col-md-6 contact-info">
                <div class="contact-form">                    
                    <form method="post" id="commentform" class="comment-form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-bg">                 
                                    <!-- <h2>Contact Us</h2>
                                    <p>Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum.</p> -->
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="lable">Name <span>*</span></div>
                                <p class="comment-form-author">
                                    <?= form_input(array('class' => 'form-control', 'id' => 'author', 'placeholder' => 'Your Name', 'name' => 'author', 'autocomplete' => 'off', 'required' => 'required')) ?></p>
                            </div>
                            <div class="col-md-6">
                                <div class="lable">Email <span>*</span></div>
                                <p class="comment-form-author">
                                    <?= form_input(array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'E-Mail Address', 'name' => 'email', 'autocomplete' => 'off', 'required' => 'required')) ?></p>
                            </div>
                            <div class="col-md-12">
                                <div class="lable">Message <span>*</span></div>
                                <p class="comment-form-comment">
                                    <?= form_textarea(array('class' => 'form-control', 'id' => 'comment', 'placeholder' => 'Write your message', 'name' => 'comment', 'autocomplete' => 'off', 'required' => 'required')) ?>
                                </p>
                            </div>
                            <div class="col-md-12">
                                <p class="form-submit"><span class="loader"><?= form_submit(array('class' => 'btn btn-primary', 'id' => 'contactus_submit', 'name' => 'contactus_submit', 'value' => 'Submit')) ?></span></p> 
                            </div>
                        </div>                              
                    </form>
                    <div id="message_container"></div>
                </div>
            </div>
            <?php
              //print_r($post_info);
             $map = explode('-map-', $post_info[0]['map']);
            $mail = explode('-email-', $post_info[0]['email']);
            $phone = explode('-phone-', $post_info[0]['phone']);
            $times = explode('-settime-', $post_info[0]['time_hours']);
            ?>
            <div class="col-md-6 contact-info">
                <div class="col-md-12">
                    <div class="contact-bg">                 
                        <h2><?= (!empty($post_info[0]['heading']) ? $post_info[0]['heading'] : '') ?></h2>
                        <p><?= (!empty($post_info[0]['content']) ? $post_info[0]['content'] : '') ?></p>
                    </div>
                </div>
                <div class="col-sm-3 col-md-6">
                    <div class="contact-bg">                 
                        <h6>Office Address</h6><?= (!empty($post_info[0]['address']) ? $post_info[0]['address'] : '') ?>
                    </div>
                </div>
                <div class="col-sm-3 col-md-6">
                    <div class="contact-bg">                      
                        <h6>Email Address </h6>
                        <a href="mailto:<?= (!empty($post_info[0]['email']) && (!empty($mail)) ? $mail[0] : '') ?>"><?= (!empty($post_info[0]['email']) && (!empty($mail)) ? $mail[0] : '') ?></a>
                        <a href="mailto:<?= (!empty($post_info[0]['email']) && (!empty($mail)) ? $mail[1] : '') ?>"><?= (!empty($post_info[0]['email']) && (!empty($mail)) ? $mail[1] : '') ?></a><br>
                        
                    </div>
                </div>
                <div class="col-sm-3 col-md-6">
                    <div class="contact-bg">
                        <h6>Phone Number</h6><?= (!empty($post_info[0]['phone']) && (!empty($phone)) ? $phone[0] : '') ?>
                    </div>
                    <div class="contact-bg">
                        <h6>Fax</h6><?= (!empty($post_info[0]['phone']) && (!empty($phone)) ? $phone[1] : '') ?>
                    </div>
                </div>
                <div class="col-sm-3 col-md-6">
                    <div class="contact-bg">                        
                        <h6>Time Hours</h6>
                       <?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[0] : '') ?>: <?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[1] : '') ?><br/>
                       <?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[2] : '') ?>: <?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[3] : '') ?><br/>
                       <?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[4] : '') ?>: <?= (!empty($post_info[0]['time_hours']) && (!empty($times)) ? $times[5] : '') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.shopping-cart -->
</section>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCO2fJ8DfdyKRIvmxp96MAG6BeNiCX27lQ&amp;callback=initMap"></script>
<script type="text/javascript">
     var map;
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
          var lat="<?php echo (!empty($post_info) && (!empty($map)) ? $map[0] : '') ?>";
          var long="<?php echo (!empty($post_info) && (!empty($map)) ? $map[1] : '') ?>";
        // Basic options for a simple Google Map
        // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 11,
            scrollwheel: false,
            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(lat, long), // New York

            // How you would like to style the map. 
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{"featureType": "water", "elementType": "geometry", "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]}, {"featureType": "landscape", "elementType": "geometry", "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]}, {"featureType": "road.highway", "elementType": "geometry.fill", "stylers": [{"color": "#ffffff"}, {"lightness": 17}]}, {"featureType": "road.highway", "elementType": "geometry.stroke", "stylers": [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]}, {"featureType": "road.arterial", "elementType": "geometry", "stylers": [{"color": "#ffffff"}, {"lightness": 18}]}, {"featureType": "road.local", "elementType": "geometry", "stylers": [{"color": "#ffffff"}, {"lightness": 16}]}, {"featureType": "poi", "elementType": "geometry", "stylers": [{"color": "#f5f5f5"}, {"lightness": 21}]}, {"featureType": "poi.park", "elementType": "geometry", "stylers": [{"color": "#dedede"}, {"lightness": 21}]}, {"elementType": "labels.text.stroke", "stylers": [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]}, {"elementType": "labels.text.fill", "stylers": [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]}, {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"featureType": "transit", "elementType": "geometry", "stylers": [{"color": "#f2f2f2"}, {"lightness": 19}]}, {"featureType": "administrative", "elementType": "geometry.fill", "stylers": [{"color": "#fefefe"}, {"lightness": 20}]}, {"featureType": "administrative", "elementType": "geometry.stroke", "stylers": [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]}]
        };

        // Get the HTML DOM element that will contain your map 
        // We are using a div with id="map" seen below in the <body>
        var mapElement = document.getElementById('map');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, long),
            map: map,
            title: 'Snazzy!'
        });
    }
</script>