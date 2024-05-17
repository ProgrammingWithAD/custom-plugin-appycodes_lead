<div class="wrap">
    <h1>Appycodes Lead Settings</h1>
    <form method="post" action="options.php">
        <?php settings_fields('appycodes_lead_settings'); ?>
        <?php do_settings_sections('appycodes_lead_settings'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">Email Notification</th>
                <td>
                    <input type="checkbox" name="appycodes_lead_email_notification" value="1" <?php checked(get_option('appycodes_lead_email_notification'), 1); ?>>
                    <p class="description">Enable or disable email notifications for new lead submissions.</p>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>