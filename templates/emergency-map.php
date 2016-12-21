<?php
/**
 * Template Name: Map
 *
 * @package Incident
 */

get_header();


$args = array(
    'posts_per_page'   => -1,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_type'        => 'incidents',
    'post_status'      => 'publish'
);
$posts_array = get_posts( $args );
var_dump($posts_array);?>


    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 400px;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
	<div class="row">
		<div class="col-sm-5 col-sm-offset-2 col-md-6 col-md-offset-0">
            <div id="map"></div>
        </div>
	</div>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: {lat: -33, lng: 151}
            });

            var image = 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png';
            var beachMarker = new google.maps.Marker({
                position: {lat: -33.890, lng: 151.274},
                map: map,
                icon: image
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy0ToSXwXcKiePTSv48hRVL-9DnYQyZTA&callback=initMap"
            async defer></script>

<?php get_footer(); 