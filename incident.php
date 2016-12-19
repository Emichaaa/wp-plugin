<?php

/*
Plugin Name: Incident
Plugin URI: http://google.com
Description: Incident Plugin.
Version: 1.0
Author: EmiCha
Author URI: http://google.com
License: A "Slug" license name e.g. GPL2
*/


#Call function only on activate plugin
register_activation_hook( __FILE__, 'plugin_activation' );
function plugin_activation()
{
    if (!file_exists(get_template_directory().DIRECTORY_SEPARATOR.'templates')) {
        if(mkdir(get_template_directory().DIRECTORY_SEPARATOR.'templates', 0777, true)){
            move_templates();
        }
    }
    else {
        move_templates();
    }
}


#Call function only on deactivate plugin
register_deactivation_hook( __FILE__, 'plugin_deactivation' );
function plugin_deactivation()
{
    delete_templates();
}

#copy template files from plugin directory to theme directory
function move_templates(){
    copy(dirname(__FILE__).'/templates/emergency-form.php', get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-form.php');
    copy(dirname(__FILE__).'/templates/emergency-map.php', get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-map.php');
}


#delete templates from theme directory
function delete_templates(){
    if(file_exists(get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-form.php')){
        unlink(get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-form.php');
    }
    if(file_exists(get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-map.php')){
       unlink(get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-map.php');
    }

}


#call function to create new custom posts
#TODO - icon
add_action('init', 'register_custom_posts_init');
function register_custom_posts_init() {
    $products_labels = array(
        'name'               => 'Incidents',
        'singular_name'      => 'Incidents',
        'menu_name'          => 'Incidents',
    );
    $products_args = array(
        'labels'             => $products_labels,
        'public'             => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' )
    );
    register_post_type('incidents', $products_args);
}


#call function to create new meta boxes
add_action('add_meta_boxes', 'add_custom_meta_box');
function add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
        'Custom Meta Box', // $title
        'show_custom_meta_box', // $callback
        'incidents', // $page
        'normal',
        'high');
}


// Fields Array
#TODO image
$prefix = 'custom_';
$custom_meta_fields = array(
    array(
        'label'=> 'Phone',
        'desc'  => 'Phone.',
        'id'    => $prefix.'text',
        'type'  => 'phone'
    ),
    array(
        'label'=> 'Dangerous level',
        'desc'  => 'Dangerous level.',
        'id'    => $prefix.'select',
        'type'  => 'select',
        'options' => array (
            'one' => array (
                'label' => 'Level One',
                'value' => 'one'
            ),
            'two' => array (
                'label' => 'Level Two',
                'value' => 'two'
            ),
            'three' => array (
                'label' => 'Level Three',
                'value' => 'three'
            ),
            'four' => array (
                'label' => 'Level Four',
                'value' => 'four'
            ),
            'five' => array (
                'label' => 'Level Five',
                'value' => 'five'
            )
        )
    ),array(
        'label' => 'Incident time',
        'desc'  => 'Incident time.',
        'id'    => $prefix.'date',
        'type'  => 'date'
    )
    ,array(
        'label' => 'Notificaton time',
        'desc'  => 'Notificaton time.',
        'id'    => $prefix.'date-notification',
        'type'  => 'date-notification'
    ),array(
        'name'  => 'Image',
        'desc'  => 'Upload image.',
        'id'    => $prefix.'image',
        'type'  => 'image'
    )
);


// The Callback from metabox - view
function show_custom_meta_box() {
    global $custom_meta_fields, $post;
// Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            // text
            case 'phone':
                echo '<input type="tel" name="'.$field['id'].'" id="'.$field['id'].'"  />
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;

            // select
            case 'select':
                echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                foreach ($field['options'] as $option) {
                    echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                }
                echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                break;

            // date
            case 'date':
                echo '<input type="text" class="timepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
			        <br /><span class="description">'.$field['desc'].'</span>';
                break;

            // date-notification
            case 'date-notification':
                echo '<input type="text" class="timepicker" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
			        <br /><span class="description">'.$field['desc'].'</span>';
                break;

            // image
            case 'image':
                if ($meta) { $image = wp_get_attachment_image_src($meta, 'medium');}
                echo    '<input name="'.$field['id'].'" type="hidden" class="custom_upload_image" value="'.$meta.'" />
                    <input class="custom_upload_image_button button" type="file" value="Choose Image" />
                    <small> <a href="#" class="custom_clear_image_button">Remove Image</a></small>
                    <br clear="all" /><span class="description">'.$field['desc'].'</span>';
                break;
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>';
}


// Save the Data from new fields
add_action('save_post', 'save_custom_meta');
function save_custom_meta($post_id) {
    global $custom_meta_fields;

    // verify nonce
    if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__)))
        return $post_id;
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id))
            return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // loop through fields and save the data
    foreach ($custom_meta_fields as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    } // end foreach
}


#include jQuery script to visualization the timepicker
add_action('admin_head','add_custom_scripts');
function add_custom_scripts() {
    global $custom_meta_fields, $post;

    $output = '<script type="text/javascript">
                jQuery(function() {';

    foreach ($custom_meta_fields as $field) { // loop through the fields looking for certain types
        if($field['type'] == 'date')
            $output .= "jQuery('.timepicker').timepicker({
                            timeFormat: 'HH:mm ',
                            interval: 1,
                            minTime: '00',
                            maxTime: '23',
                            defaultTime: 'now',
                            startTime: '00',
                            dynamic: false,
                            dropdown: true,
                            scrollbar: true
                        });";
    }
    $output .= '});
        </script>';
    echo $output;
}


#include required javascripts and stylesheets
add_action('init', 'init_scripts');
function init_scripts(){

    wp_register_script('timepicker', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js');
    wp_register_style( 'timepicker', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css' );

    wp_enqueue_style('timepicker');
    wp_enqueue_script( 'timepicker' );

}
