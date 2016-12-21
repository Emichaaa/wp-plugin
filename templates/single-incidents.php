<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<?php
/**
 * Template Name: Map
 *
 * @package Incident
 */

get_header();


$meta 			= get_post_meta( get_the_ID());
$img_post_id 	= $meta['_thumbnail_id'][0];
$danger_level	= $meta['custom_select'][0];
$lat			= $meta['custom_location-lat'][0];
$lng			= $meta['custom_location-lng'][0];
$phone			= $meta['custom_text'][0];
$incident_time	= $meta['custom_date'][0];
$notification	= $meta['custom_date-notification'][0];

$image="https://cdn3.iconfinder.com/data/icons/medicine-4-1/512/hospital_map_marker-512.png";
#change marker icon for different incedents

if(isset($type_incident) && !empty($type_incident)){
	switch($type_incident){
		case '1':
			$image="url";
			break;
		case '2':
			$image="url";
			break;
		case '3':
			$image="url";
			break;
	}
}

?>


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
		.single-featured-image-header {
			width: 300px;
			height: auto;
		}
	</style>

	<div class="row">
		<div class="col-sm-5 col-sm-offset-3 col-md-6 col-md-offset-3">
			<div id="map"></div>
		</div>
	</div>

	<script>

		function initMap() {
			var map = new google.maps.Map(document.getElementById('map'), {
				zoom: 15,
				center: {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>},
				scrollwheel: false
			});

			var contentString = '<div id="content">'+
					'<div id="Notice">'+
					'</div>'+
					'<h1 id="Heading" class="Heading">Incident</h1>'+
					'<div id="bodyContent">'+
					'<p>Incident time : <b><?php echo $incident_time; ?></b></p>'+
					'<p>Incident notification : <b><?php echo $notification; ?></b></p>'+
					'<p>Dangerous level : <b><?php echo $danger_level; ?></b></p>'+
					'<p>Phone:<a href="tel : <?php echo $phone; ?>"><b><?php echo $phone; ?></b></a></p>'+
					'</div>'+
					'</div>';

			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			var image = {
				url: "<?php echo $image; ?>",
				scaledSize: new google.maps.Size(32, 32),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(0, 32)
			};
			var marker = new google.maps.Marker({
				position: {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>},
				map: map,
				icon: image
			});
			marker.addListener('click', function() {
				infowindow.open(map, marker);
			});
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAy0ToSXwXcKiePTSv48hRVL-9DnYQyZTA&callback=initMap&language=en"
			async defer></script>

<?php get_footer(); ?>

