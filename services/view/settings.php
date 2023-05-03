<?php
$categories = get_terms( 'category', array( 'hide_empty' => false ) );
$selected_categories = get_option( 'my_plugin_options', array() );
?>

<form id="fs-settings" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
    <?php settings_fields( 'my_plugin_options' ); ?>
    <h3>Select categories</h3>
    <input type="hidden" name="action" value="fs_settings">
    <select name="my_plugin_options[]" multiple class="form-control">
        <?php foreach ( $categories as $category ) { ?>
            <option value="<?php echo esc_attr( $category->term_id ); ?>" <?php echo selected( in_array( $category->term_id, $selected_categories ), true ); ?>><?php echo esc_html( $category->name ); ?></option>
        <?php } ?>
    </select>
    <?php submit_button(); ?>
</form>
