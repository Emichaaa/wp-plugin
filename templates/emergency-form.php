<?php
/**
 * Template Name: Form
 *
 * @package Incident
 */

get_header();

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty( $_POST['action'] )) {
	$title      =   'Incident';
	$lat		=   $_POST['lat'];
	$lng		=   $_POST['lng'];
	$inc_time   =   $_POST['incident_time'];
	$not_time   =   $_POST['notification_time'];
	$dang_level =   $_POST['dangerous_level'];
	$phone      =   $_POST['customer_phone'];
	//$img        =   $_POST[''];

#TODO thumbnails

	$new_post = array(
			'ID' => '',
			'post_title' => $title,
			'post_status' => 'publish',
			'meta_input' => array(
					'custom_location-lat'       => $lat,
					'custom_location-lng'       => $lng,
					'custom_text'               => $phone,
					'custom_select'             => $dang_level,
					'custom_date'               => $inc_time,
					'custom_date-notification'  => $not_time,
					'_thumbnail_id'             => $title
			)
	);

	$post_id = wp_insert_post($new_post);

	// This will redirect you to the newly created post
	$post = get_post($post_id);
	//wp_redirect($post->guid);
}
#TODO timepicker
?>


<form id="new_incident" name="new_incident" method="POST" action="">
	<div class="form-group">
		<label for="incident_location">Location:</label>
		<input type="text" class="form-control" name="incident_location" id="incident_location" placeholder="Ex. Sofia">
	</div>

	<div class="form-group">
		<field id="details">
			<input name="lat" type="text" value="" style="display: none">
			<input name="lng" type="text" value="" style="display: none">
		</field>
	</div>

	<div class="form-group">
		<label for="incident_time">Incident time:</label>
		<input type="text" class="timepicker form-control" name="incident_time" id="incident_time">
	</div>
	<div class="form-group">
		<label for="notification_time">Notification time:</label>
		<input type="text" class="timepicker form-control" name="notification_time" id="notification_time">
	</div>

	<div class="form-group">
		<select class="selectpicker show-menu-arrow" name="dangerous_level" id="dangerous_level">
			<option value="one" selected>Level One</option>
			<option value="two">Level Two</option>
			<option value="three">Level Three</option>
			<option value="four">Level Four</option>
			<option value="five">Level Five</option>
		</select>
	</div>

	<div class="form-group">
		<label for="customer_phone">Phone:</label>
		<input type="text" class="form-control bfh-phone" name="customer_phone" id="customer_phone" placeholder="5555555555" data-format="+1 (ddd) ddd-dddd">
	</div>

	<div class="fileinput fileinput-new" data-provides="fileinput">
		<span class="btn btn-default btn-file"><input name="image" type="file" /></span>
		<span class="fileinput-filename"></span>
	</div>

	<input type="hidden" name="action" value="post" />
	<?php wp_nonce_field( 'new_incident' ); ?>

	<button type="submit" class="btn btn-default">Submit</button>
</form>


<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAy0ToSXwXcKiePTSv48hRVL-9DnYQyZTA&sensor=false&amp;libraries=places"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="wp-content/plugins/incident/assets/js/jquery.geocomplete.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js'></script>
<script src='//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js'></script>


<script>

	//autocomplete google api function
	jQuery(function(){
		jQuery("#incident_location").geocomplete({

			details: "field#details",
			blur: true,
			geocodeAfterResult: true
		});

	});

	jQuery('.timepicker').timepicker({
		timeFormat: 'HH:mm ',
		interval: 1,
		minTime: '00',
		maxTime: '23',
		defaultTime: 'now',
		startTime: '00',
		dynamic: false,
		dropdown: true,
		scrollbar: true
	});

</script>