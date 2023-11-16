<?php
/*
Plugin Name: Paradigm Forms
Description: Creates shortcodes for full size and sidebar sized forms.
Plugin URI: https://github.com/Matthewpco/WP-Plugin-Modal-Form-Shortcode
Version: 1.8.0
Author: Gary Matthew Payne
Author URI: https://wpwebdevelopment.com/
License: GPL2
*/

// Use require_once to include your functions file
require_once plugin_dir_path(__FILE__) . '/php/admin-page.php';
require_once plugin_dir_path(__FILE__) . '/php/form-shortcodes.php';
require_once plugin_dir_path(__FILE__) . '/php/setup.php';


// Hooks
register_activation_hook(__FILE__, 'paradigm_forms_plugin_activation');
register_deactivation_hook(__FILE__, 'paradigm_forms_plugin_deactivation');
add_action('admin_post_download_csv', 'download_csv');
add_action('admin_post_nopriv_download_csv', 'download_csv');


// Enqueue JavaScript for AJAX form submission and styles
function paradigm_forms_enqueue_scripts() {
    wp_enqueue_script('paradigm-forms-scripts', plugin_dir_url(__FILE__) . 'js/paradigm-forms-scripts.js', array(), false, true);
    wp_localize_script('paradigm-forms-scripts', 'paradigm_forms_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('paradigm_forms_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'paradigm_forms_enqueue_scripts');


function download_csv() {
    $file = WP_CONTENT_DIR . '/submissions.csv';

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        flush(); // Flush system output buffer
        readfile($file);
        exit;
    }
}


// Handle AJAX form submission
function paradigm_forms_submit() {

    check_ajax_referer('paradigm_forms_nonce');
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $phone_number = sanitize_text_field($_POST['phone_number']);
    $email = sanitize_email($_POST['email']);
    $procedure_of_interest = sanitize_text_field($_POST['procedure_of_interest']);
    $referral = sanitize_text_field($_POST['referral']);
    $form_message = sanitize_text_field($_POST['form_message']);
    $to = get_option('paradigm_forms_email');

    if (!empty($_POST['fax'])) {
        // If data is entered into this hidden field this was likely a spam bot, so don't process the form
    } else {
        // This was likely a human, so process the form
        // send submission to database
        global $wpdb;
        $table_name = $wpdb->prefix . 'paradigm_forms';
        $wpdb->insert($table_name, array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'phone_number' => $phone_number,
            'email' => $email,
            'procedure_of_interest' => $procedure_of_interest,
            'referral' => $referral,
            'form_message' => $form_message
        ));

        // Check for errors
        if ($result === false) {
            error_log('Database insertion failed');
        } else {
            // If the insertion was successful, write the data to a CSV file
            $file = fopen(WP_CONTENT_DIR . '/submissions.csv', 'a'); // Open the file in append mode
            fputcsv($file, array($first_name, $last_name, $email, $phone_number, $procedure_of_interest, $referral, $form_message));
            fclose($file); // Close the file
        }

        add_filter( 'wp_mail_content_type', 'set_html_content_type' );
        add_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
        add_filter('wp_mail_from', 'set_from_email');
        $subject = 'New Form Submission';
        $message = 'First Name: ' . $first_name . '<br>';
        $message .= 'Last Name: ' . $last_name . '<br>';
        $message .= 'Phone Number: ' . $phone_number . '<br>';
        $message .= 'Email: ' . $email . '<br>';
        $message .= 'Procedure of Interest: ' . $procedure_of_interest . '<br>';
        $message .= 'Referral: ' . $referral . '<br>';
        $message .= 'Form Message: ' . $form_message . '<br>';
        wp_mail($to, $subject, $message);
        remove_filter('wp_mail_from', 'set_from_email');
        remove_filter( 'wp_mail_from_name', 'custom_wp_mail_from_name' );
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

        if (!$mail_result) {
            error_log('Email sending failed');
        }

        wp_die();
    }
}
add_action('wp_ajax_paradigm_forms_submit', 'paradigm_forms_submit');
add_action('wp_ajax_nopriv_paradigm_forms_submit', 'paradigm_forms_submit');