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


#Call function incident_only on activate plugin
register_activation_hook( __FILE__, 'incident_plugin_activation' );
function incident_plugin_activation()
{
    if (!file_exists(get_template_directory().DIRECTORY_SEPARATOR.'templates')) {
        if(mkdir(get_template_directory().DIRECTORY_SEPARATOR.'templates', 0777, true)){
            incident_move_templates();
        }
    }
    else {
        incident_move_templates();
    }
}


#Call function incident_only on deactivate plugin
register_deactivation_hook( __FILE__, 'incident_plugin_deactivation' );
function incident_plugin_deactivation()
{
    incident_delete_templates();
}

#copy template files from plugin directory to theme directory
function incident_move_templates(){
    copy(dirname(__FILE__).'/templates/emergency-form.php', get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-form.php');
    copy(dirname(__FILE__).'/templates/emergency-map.php', get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-map.php');
    copy(dirname(__FILE__).'/templates/single-incident.php', get_template_directory().DIRECTORY_SEPARATOR.'single-incident.php');
}


#delete templates from theme directory
function incident_delete_templates(){
    if(file_exists(get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-form.php')){
        unlink(get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-form.php');
    }
    if(file_exists(get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-map.php')){
       unlink(get_template_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'emergency-map.php');
    }
    if(file_exists(get_template_directory().DIRECTORY_SEPARATOR.'single-incident.php')){
        unlink(get_template_directory().DIRECTORY_SEPARATOR.'single-incident.php');
    }
}


#call function to create new custom posts
#TODO - icon
add_action('init', 'incident_register_custom_posts_init');
function incident_register_custom_posts_init() {
    $products_labels = array(
        'name'               => 'Incident',
        'singular_name'      => 'Incident',
        'menu_name'          => 'Incident',
        'menu_icon'          => 'dashicons-plus-alt'
    );
    $products_args = array(
        'labels'             => $products_labels,
        'public'             => true,
        'capability_type'    => 'post',
        'has_archive'        => true,
        'supports'           => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' )
    );
    register_post_type('incident', $products_args);
}


#call function incident_to create new meta boxes
add_action('add_meta_boxes', 'incident_add_custom_meta_box');
function incident_add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
        'Custom Meta Box', // $title
        'incident_show_custom_meta_box', // $callback
        'incident', // $page
        'normal',
        'high');
}


// Fields Array
$prefix = 'custom_';
$custom_meta_fields = array(
    array(
        'label'=> 'Location',
        'desc'  => 'Location.',
        'id'    => $prefix.'location',
        'type'  => 'location'
    ),
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
    )
);


// The Callback from metabox - view
function incident_show_custom_meta_box() {
    global $custom_meta_fields;
    $screen = get_current_screen();
    $post_id = $screen->id;

// Use nonce for verification
    echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

    echo '<table class="form-table">';
    foreach ($custom_meta_fields as $field) {
        // get value of this field if it exists for this post
        $meta = get_post_meta($post_id, $field['id'], true);

        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
        switch($field['type']) {
            // text
            case 'location':
                echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'"  />
                    <br /><span class="description">'.$field['desc'].'</span>';
                break;

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
        } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>';
}


// Save the Data from new fields
add_action('save_post', 'incident_save_custom_meta');
function incident_save_custom_meta($post_id) {
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

add_action('admin_print_footer_scripts','incident_load_admin_footer_scripts');

function incident_load_admin_footer_scripts(){

    $screen = get_current_screen();

    if( is_object( $screen ) && $screen->post_type == "incident" )

    echo "
        <script type='text/javascript'>
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
    ";



}

#include required javascripts and stylesheets
add_action('admin_enqueue_scripts', 'incident_enqueue_admin_scripts');
function incident_enqueue_admin_scripts( $hook_suffix ){


    $custom_post_type = "incident";

    if( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ){

        $screen = get_current_screen();

        if( is_object( $screen ) && $screen->post_type == $custom_post_type ){

            wp_register_script('timepicker', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js');
            wp_register_style( 'timepicker', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css' );

            wp_enqueue_style('timepicker');
            wp_enqueue_script( 'timepicker' );

        }

    }

}


add_action( 'wp_enqueue_scripts', 'incident_add_scripts' );
function incident_add_scripts(){
    wp_register_script('jquery','https://code.jquery.com/jquery-3.1.1.min.js');
    wp_register_script('bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'bootstrap' );
}


add_action( 'wp_enqueue_scripts', 'incident_add_stylesheet' );
function incident_add_stylesheet(){
    wp_register_style('bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
    wp_enqueue_style( 'bootstrap' );

}


