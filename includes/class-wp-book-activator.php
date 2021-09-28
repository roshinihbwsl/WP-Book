<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/roshinihbwsl
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     Roshini S <roshini.s@hbwsl.com>
 */
class Wp_Book_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'book_meta';
		if ( $wpdb->get_var( $wpdb->prepare( 'show tables like %s', $table_name ) ) !== $table_name ) {
			$sql = "CREATE TABLE {$table_name} (
			meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			book_id bigint(20) unsigned NOT NULL,
			meta_key varchar(255),
			meta_value longtext,
			PRIMARY KEY (meta_id)
			);";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );
		}

		add_option( 'book_settings', array( 'currency' => 'Rupee', 'no_of_books' => 10) );
	}

}
