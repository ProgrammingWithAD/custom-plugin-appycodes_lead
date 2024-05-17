<?php
/*
Plugin Name: Appycodes Lead
Plugin URI: https://example.com/appycodes-lead
Description: A plugin for lead generation
Version: 1.0.0
Author: Your Name
Author URI: https://example.com
*/

// Register activation and deactivation hooks
register_activation_hook(__FILE__, 'appycodes_lead_activate');
register_deactivation_hook(__FILE__, 'appycodes_lead_deactivate');

// Include the file containing the functions
require_once(plugin_dir_path(__FILE__) . 'includes/functions.php');


// Activation hook function
function appycodes_lead_activate()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'appycodes_lead';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        created_at DATETIME NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deactivation hook function
function appycodes_lead_deactivate()
{
    // Clean up tasks, if any
}

// Enqueue scripts and styles
function appycodes_lead_enqueue_scripts()
{
    wp_enqueue_style('appycodes-lead-style', plugins_url('assets/css/style.css', __FILE__));
    wp_enqueue_script('appycodes-lead-script', plugins_url('assets/js/script.js', __FILE__), array('jquery'), '1.0.0', true);
    wp_localize_script('appycodes-lead-script', 'appycodes_lead_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('appycodes_lead_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'appycodes_lead_enqueue_scripts');

// Add shortcode for the form
function appycodes_lead_shortcode()
{
    ob_start();
    include(plugin_dir_path(__FILE__) . 'templates/form.php');
    return ob_get_clean();
}
add_shortcode('appycodes_lead_form', 'appycodes_lead_shortcode');

// AJAX handler for form submission
function appycodes_lead_submit_form()
{
    check_ajax_referer('appycodes_lead_nonce', 'nonce');

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);

    if (empty($name) || empty($email)) {
        wp_send_json_error(array('message' => 'Please fill all the fields.'));
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'appycodes_lead';
    $data = array(
        'name' => $name,
        'email' => $email,
        'created_at' => current_time('mysql')
    );

    $wpdb->insert($table_name, $data);

    $admin_email = get_option('admin_email');
    $subject = 'New Lead Submission';
    $message = "Name: $name\nEmail: $email";

    // Send email to admin
    wp_mail($admin_email, $subject, $message);

    // Send email to user
    wp_mail($email, $subject, 'Thank you for your submission.');

    wp_send_json_success(array('message' => 'Form submitted successfully.'));
}
add_action('wp_ajax_appycodes_lead_submit_form', 'appycodes_lead_submit_form');
add_action('wp_ajax_nopriv_appycodes_lead_submit_form', 'appycodes_lead_submit_form');

function appycodes_lead_admin_menu()
{
    $parent_slug = 'appycodes-lead';
    $capability = 'manage_options';

    $hook = add_menu_page(
        'Appycodes Lead',
        'Appycodes Lead',
        $capability,
        $parent_slug,
        'appycodes_lead_admin_page',
        'dashicons-email-alt'
    );

    add_submenu_page(
        $parent_slug,
        'Leads',
        'Leads',
        $capability,
        $parent_slug,
        'appycodes_lead_admin_page'
    );



    add_submenu_page(
        $parent_slug,
        'Settings',
        'Settings',
        $capability,
        'appycodes-lead-settings',
        'appycodes_lead_settings_page'
    );
}
add_action('admin_menu', 'appycodes_lead_admin_menu');

// Admin page callback
function appycodes_lead_admin_page()
{
    $leads = appycodes_lead_filter_leads(); // Get the list of leads
    include(plugin_dir_path(__FILE__) . 'templates/admin.php'); // Pass $leads to the template
}


// Export Leads page callback
function appycodes_lead_export_page()
{
    // No need to export CSV here, just display the export button
    include(plugin_dir_path(__FILE__) . 'templates/export.php');
}

// Settings page callback
function appycodes_lead_settings_page()
{
?>
    <div class="wrap">
        <h1>Appycodes Lead Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('appycodes_lead_settings_group'); ?> <!-- Ensure this matches your registered settings group name -->
            <?php do_settings_sections('appycodes_lead_settings'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">Email Notification</th>
                    <td>
                        <?php $email_notification = get_option('appycodes_lead_email_notification', 0); ?>
                        <input type="checkbox" name="appycodes_lead_email_notification" value="1" <?php checked($email_notification, 1); ?>>
                        <p class="description">Enable or disable email notifications for new lead submissions.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Changes'); ?>
        </form>
    </div>
<?php
}

// Inside the appycodes_lead_settings_init() function
function appycodes_lead_settings_init()
{
    register_setting('appycodes_lead_settings_group', 'appycodes_lead_email_notification');
}


// Delete a lead
function appycodes_lead_delete_lead()
{
    try {
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['lead_id'])) {
            $lead_id = intval($_GET['lead_id']);
            global $wpdb;
            $table_name = $wpdb->prefix . 'appycodes_lead';
            $result = $wpdb->delete($table_name, array('id' => $lead_id));

            if ($result === false) {
                throw new Exception("Failed to delete lead with ID: $lead_id");
            }

            wp_redirect(admin_url('admin.php?page=appycodes-lead'));
            exit;
        }
    } catch (Exception $e) {
        // Handle the exception (e.g., log the error, display an error message)
        echo 'Error: ' . $e->getMessage();
    }
}
add_action('admin_init', 'appycodes_lead_delete_lead');
add_action('admin_init', 'appycodes_lead_settings_init');
