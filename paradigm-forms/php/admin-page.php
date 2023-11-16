<?php

function paradigm_forms_admin_page() {
    // Check if the user has editor permissions
    if (!current_user_can('edit_pages')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }    

    global $wpdb;
    $table_name = $wpdb->prefix . 'paradigm_forms';
    
    // Check if the form was submitted
    if (isset($_POST['delete_all'])) {
        // Delete all entries from the table
        $wpdb->query("TRUNCATE TABLE $table_name");
    } elseif (isset($_POST['delete_entry'])) {
        // Delete individual entry
        $entry_id = intval($_POST['entry_id']);
        $wpdb->delete($table_name, array('id' => $entry_id));
    }

    $results = $wpdb->get_results("SELECT * FROM $table_name");

    ?>
    <div class="wrap">
        <form method="post" action="options.php">
            
            <?php
            settings_fields('paradigm_forms');
            do_settings_sections('paradigm_forms');
            submit_button();
            ?>
            <div style="display: flex; align-items: center;">
                <h2 style="margin-right: 20px;">Download form submissions</h2>
                <a href="<?php echo admin_url('admin-post.php?action=download_csv'); ?>" class="button">Download CSV</a>
            </div>

        </form>
        
    </div>

    <?php

    // Conditional for enabling form display
    if (get_option('pf_enable_forms_display')) {
        include 'admin-page-template.php';
    }
 
}

function paradigm_forms_display_callback() {
    $enable_forms_display = get_option('pf_enable_forms_display');
    echo '<input type="checkbox" name="pf_enable_forms_display" value="1" ' . checked($enable_forms_display, 1, false) . ' />';
}

function paradigm_forms_email_callback() {
    $paradigm_forms_email = get_option('paradigm_forms_email');
    echo '<input type="email" id="paradigm_forms_email" name="paradigm_forms_email" value="' . esc_attr($paradigm_forms_email) . '">';
}
