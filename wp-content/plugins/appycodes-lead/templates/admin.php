<div class="wrap">
    <h1>Appycodes Lead</h1>
    <br>
    <form method="get">
        <input type="hidden" name="page" value="appycodes-lead">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>"><br><br>
        &nbsp;<label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
        <input type="submit" value="Filter">
    </form>&nbsp;&nbsp;
    <form method="get" action="<?php echo admin_url('admin.php'); ?>">
        <input type="hidden" name="page" value="appycodes-lead">
        <select name="action">
            <option value="">Bulk Actions</option>
            <option value="delete">Delete</option>
        </select>
        <input type="submit" value="Apply" class="button">
        <table class="widefat">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leads as $lead) : ?>
                    <tr>
                        <td><input type="checkbox" name="lead_ids[]" value="<?php echo $lead['id']; ?>"></td>
                        <td><?php echo $lead['id']; ?></td>
                        <td><?php echo $lead['name']; ?></td>
                        <td><?php echo $lead['email']; ?></td>
                        <td><?php echo $lead['created_at']; ?></td>
                        <td><a href="<?php echo add_query_arg(array('action' => 'delete', 'lead_id' => $lead['id'])); ?>" onclick="return confirm('Are you sure you want to delete this lead?')">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>

    <br>
    <!-- Add Export CSV link -->
    <div class="export-csv">
        <a href="<?php echo admin_url('admin.php?page=appycodes-lead&export_leads=1'); ?>" class="button button-primary">Export Leads to CSV</a>
    </div>
</div>