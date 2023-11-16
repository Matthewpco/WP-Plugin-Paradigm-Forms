<?php 
/* Template for plugin admin page form results */
?>
<style>
.pf-table {
    border-collapse: collapse;
    width: 90%;
}
.pf-table th, .pf-table td {
    text-align: left;
    padding: 8px;
}
.pf-table tr:nth-child(even) {
    background-color: #e4e4e6;
}
.pf-table th {
    background-color: #1587d1;
    color: white;
}
</style>

<table class="pf-table">
    <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Procedure of Interest</th>
        <th>Referral</th>
        <th>Message</th>
        <th>Delete Entry</th>
    </tr>

    <?php foreach ($results as $result): ?>
    <tr>
        <td><?php echo esc_html($result->first_name); ?></td>
        <td><?php echo esc_html($result->last_name); ?></td>
        <td><?php echo esc_html($result->phone_number); ?></td>
        <td><?php echo esc_html($result->email); ?></td>
        <td><?php echo esc_html($result->procedure_of_interest); ?></td>
        <td><?php echo esc_html($result->referral); ?></td>
        <td><?php echo esc_html($result->form_message); ?></td>
        <td>
            <form method="post">
                <input type="hidden" name="delete_entry" value="1">
                <input type="hidden" name="entry_id" value="<?php echo esc_attr($result->id); ?>">
                <input type="submit" value="Delete">
            </form>
        </td>
    </tr>
    <?php endforeach; ?>

</table>
<br>
<form method="post">
    <input type="hidden" name="delete_all" value="1">
    <input type="submit" value="Delete All Entries">
</form>
<?php
