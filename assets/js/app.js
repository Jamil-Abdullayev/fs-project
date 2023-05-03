
jQuery(document).ready(function($) {
    $('form#fs-settings').submit(function(event) {
        event.preventDefault();
        var data = {
            'action': 'admin_post_fs_settings',
            'my_plugin_options': $('select[name="my_plugin_options[]"]').val(),
            'nonce': fs_project_vars.nonce
        };
        console.log(fs_project_vars.ajax_url);
        $.post(fs_project_vars.ajax_url, data, function(response) {
            console.log(response);
        });
    });
 //saving settings


//deleting log

$('#delete-log').on('click', function(event) {
    event.preventDefault();
    var postId = $(this).data('id');
    var data = {
      'action': 'delete_fs_log',
      'post_id': postId,
      'nonce': fs_project_vars.nonce
    };

    $.post(fs_project_vars.ajax_url, data, function(response) {

      console.log(response);
      $("table tbody tr[data-delete="+postId+"]").remove();

    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Error: " + errorThrown);
      });
  });
});