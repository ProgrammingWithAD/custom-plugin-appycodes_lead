<?php
// Filter leads by date
function appycodes_lead_filter_leads()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'appycodes_lead';

    $start_date = isset($_GET['start_date']) ? sanitize_text_field($_GET['start_date']) : '';
    $end_date = isset($_GET['end_date']) ? sanitize_text_field($_GET['end_date']) : '';

    $where = '';
    if (!empty($start_date) && !empty($end_date)) {
        $where = "WHERE created_at BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    } elseif (!empty($start_date)) {
        $where = "WHERE created_at >= '$start_date 00:00:00'";
    } elseif (!empty($end_date)) {
        $where = "WHERE created_at <= '$end_date 23:59:59'";
    }

    $leads = $wpdb->get_results("SELECT * FROM $table_name $where ORDER BY created_at DESC", ARRAY_A);

    return $leads;
}

// Enable/disable email notification
function appycodes_lead_email_notification($new_value, $old_value)
{
    return $new_value;
}
add_filter('pre_update_option_appycodes_lead_email_notification', 'appycodes_lead_email_notification', 10, 2);

// Export leads to CSV
function appycodes_lead_export_csv()
{
    if (isset($_GET['export_leads']) && $_GET['export_leads'] == 1) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'appycodes_lead';
        $leads = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

        // Set headers for Excel file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="leads_' . date('Y-m-d') . '.xls"');
        header("Pragma: no-cache");
        header("Expires: 0");

        // Output Excel file
        echo "ID\tName\tEmail\tCreated At\n";
        foreach ($leads as $lead) {
            echo $lead['id'] . "\t" . $lead['name'] . "\t" . $lead['email'] . "\t" . $lead['created_at'] . "\n";
        }

        exit;
    }
}
add_action('admin_init', 'appycodes_lead_export_csv');
