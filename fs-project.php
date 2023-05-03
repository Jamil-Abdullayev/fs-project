<?php
/*
Plugin Name: FS Project
Plugin URI: https://www.fs-code.com/
Description: Posts publishing plugin.
Version: 1.0
Author: Jamil
Author URI: https://www.fs-code.com/
License: GPL2
*/

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
require_once('services/menu.php');
require_once('services/logs.php');

class FS_Project_Plugin {

    public function __construct() {
        register_activation_hook( __FILE__, array( $this, 'onActivation' ) );
        register_deactivation_hook( __FILE__, array( $this, 'onDeactivation' ) );
        new Menu();
        new Logs();
    }


    public function onActivation() {
        // creating tables
        $tables = array(
            'CREATE TABLE wp_fs_logs (
                id INT(11) NOT NULL AUTO_INCREMENT,
                post_id INT(11) NOT NULL,
                post_url TEXT NOT NULL,
                date DATETIME NOT NULL,
                PRIMARY KEY (id)
            ) ENGINE=InnoDB;',

            'CREATE TABLE wp_fs_categories (
                id INT(11) NOT NULL AUTO_INCREMENT,
                category_id INT(11) NOT NULL,
                PRIMARY KEY (id)
            ) ENGINE=InnoDB;',
        );
        dbDelta( $tables );
    }

    public function onDeactivation() {
        $tables = array(
            "DROP TABLE IF EXISTS wp_fs_logs;",
            "DROP TABLE IF EXISTS wp_fs_categories;"
        );
        dbDelta( $tables );
    }
}

new FS_Project_Plugin();