<?php

// Create forms admin page to display submitted data and settings
function paradigm_forms_admin_menu() {
    add_menu_page(
        'Paradigm Forms',
        'Paradigm Forms',
        'edit_pages',
        'paradigm-forms',
        'paradigm_forms_admin_page'
    );
}
add_action('admin_menu', 'paradigm_forms_admin_menu');


function set_from_email() {
    return 'Paradigm@' . $_SERVER['SERVER_NAME'];
}
add_filter('wp_mail_from', 'set_from_email');

// This function sets the email Content-Type to text/html
function set_html_content_type() {
    return 'text/html';
}

// This function sets the From name
function custom_wp_mail_from_name() {
    return 'Paradigm'; // replace with your name or your site's name
}

function paradigm_forms_admin_init() {
    // Register settings
    register_setting('paradigm_forms', 'pf_enable_forms_display');
    register_setting('paradigm_forms', 'paradigm_forms_email');

    // Add settings section
    add_settings_section('paradigm_forms_section', 'Paradigm Forms Settings and Submissions', null, 'paradigm_forms');

    // Add settings fields
    add_settings_field('pf_enable_forms_display', 'Enable form display', 'paradigm_forms_display_callback', 'paradigm_forms', 'paradigm_forms_section');
    add_settings_field('paradigm_forms_email', 'Send Submissions To Email:', 'paradigm_forms_email_callback', 'paradigm_forms', 'paradigm_forms_section');
}

add_action('admin_init', 'paradigm_forms_admin_init');

// Create custom database table on plugin activation
function paradigm_forms_plugin_activation() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'paradigm_forms';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        first_name varchar(255) NOT NULL,
        last_name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone_number varchar(255) NOT NULL,
        procedure_of_interest varchar(255) NOT NULL,
        referral varchar(255) NOT NULL,
        form_message varchar(255) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
$setup_path = plugin_dir_path(__FILE__) . 'paradigm-forms.php';

// Delete custom database table on plugin deactivation
function paradigm_forms_plugin_deactivation() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'paradigm_forms';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}