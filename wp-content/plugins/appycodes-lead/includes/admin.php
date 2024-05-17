<?php
// Render admin page
function appycodes_lead_render_admin_page()
{
    $leads = appycodes_lead_filter_leads();
    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

    include(plugin_dir_path(__FILE__) . '/../templates/admin.php');
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


// Bulk actions
function appycodes_lead_bulk_actions()
{
    $action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
    $lead_ids = isset($_GET['lead_ids']) ? array_map('intval', $_GET['lead_ids']) : array();

    if ($action && !empty($lead_ids)) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'appycodes_lead';

        switch ($action) {
            case 'delete':
                $wpdb->query("DELETE FROM $table_name WHERE id IN (" . implode(',', $lead_ids) . ")");
                break;
        }
    }
}
