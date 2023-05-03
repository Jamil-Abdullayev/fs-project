<?php
class Menu {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu_items' ) );
        add_action( 'admin_init', array( $this, 'my_plugin_register_settings' ) );
        add_action( 'wp_ajax_admin_post_fs_settings', array( $this, 'fs_settings' ) ); // updated action hook
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts() {
        wp_enqueue_script( 'fs-project', plugin_dir_url( __FILE__ ) . '../assets/js/app.js', array( 'jquery' ) );
        wp_localize_script( 'fs-project', 'fs_project_vars', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'fs_project_nonce' )
        ) );
    }

    public function fs_settings(){
        global $wpdb;
        $new_categories = $_POST['my_plugin_options'];
        $wpdb->query($wpdb->prepare("DELETE FROM wp_fs_categories"));
        foreach($new_categories as $key=>$value){
            $wpdb->query($wpdb->prepare("INSERT INTO wp_fs_categories (category_id) VALUES ('".$value."')"));
        }
        wp_die();
    }

    public function add_menu_items() {
        add_menu_page(
            'FS Project',
            'FS Project',
            'manage_options',
            'fs-project',
            array( $this, 'render_main_page' )
        );

        add_submenu_page(
            'fs-project',
            'Logs',
            'Logs',
            'manage_options',
            'fs-project-logs',
            array( $this, 'render_logs_page' )
        );

        add_submenu_page(
            'fs-project',
            'Settings',
            'Settings',
            'manage_options',
            'fs-project-settings',
            array( $this, 'render_settings_page' )
        );
    }

    public function render_main_page() {
        echo '<h1>FS Project</h1>';
    }

    public function render_logs_page() {
        global $wpdb;
        $logs = $wpdb->get_results( "SELECT * FROM wp_fs_logs" );
        require(plugin_dir_path( __FILE__ ) . '../services/view/logs.php');
    }

    public function render_settings_page() {
        require(plugin_dir_path( __FILE__ ) . '../services/view/settings.php');
    }

    public function my_plugin_register_settings() {
        register_setting( 'my_plugin_options', 'my_plugin_options', 'my_plugin_sanitize_options' );
    }

    public function my_plugin_sanitize_options($input) {
        return array_map('sanitize_text_field', $input);
    }

}
