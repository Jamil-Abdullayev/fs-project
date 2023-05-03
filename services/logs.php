<?php 
class Logs {

    public function __construct() {
        add_action( 'save_post', array($this, 'get_new_post_id') );
        add_action('wp_ajax_delete_fs_log',array($this, 'delete_fs_log'));
    }

    public function get_new_post_id( $post_id ) {
        global $wpdb;

        $categories = $wpdb->get_col( "SELECT category_id FROM wp_fs_categories" );

        if ( ! has_category( $categories, $post_id ) ) {
            return;
        }

        $post_url = get_permalink( $post_id );
        $wpdb->insert(
            'wp_fs_logs',
            array(
                'post_id' => $post_id,
                'post_url' => $post_url,
                'date' => date('Y-m-d h:i:sa')
            )
        );

        $data = "Success";
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }

    public function delete_fs_log(){
        $post_id = $_POST['post_id'];

        global $wpdb;
        $wpdb->delete(
            'wp_fs_logs',
            array(
                'id' => $post_id,
            )
        );

        $data = "Success";
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        wp_die();
    }
}