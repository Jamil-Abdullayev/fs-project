<h1>Logs:</h1>

<table class="wp-list-table widefat fixed striped table-view-list">
  <thead>
    <tr>
      <th scope="col">Post Url</th>
      <th scope="col">DateTime</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
<?php foreach($logs as $log){ ?>
    <tr data-delete=<?php echo $log->id; ?>>
      <td><a href="<?php echo $log->post_url; ?>"><?php echo $log->post_url; ?></a></td>
      <td><?php echo $log->date; ?></td>
      <td><button id="delete-log" data-id="<?php echo $log->id; ?>">Delete</button></td>
    </tr>
<?php } ?>

</tbody>
</table>