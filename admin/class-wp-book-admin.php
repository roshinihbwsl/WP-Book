<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/roshinihbwsl
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @author     Roshini S <roshini.s@hbwsl.com>
 */
class Wp_Book_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Creates a new custom post type called Book
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses register_post_type()
	 */
	public static function new_cpt_book() {
		$opts['labels']['name']          = __( 'Books', 'wp-book' );
		$opts['labels']['singular_name'] = __( 'Book', 'wp-book' );

		$opts['has_archive'] = true;
		$opts['public']      = true;

		register_post_type( 'book', $opts );
	}

	/**
	 * Creates a new custom hierarchical category called Book Category
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses register_taxonomy()
	 */
	public static function new_ct_book_category() {
		$labels = array(
			'name'              => __( 'Book Category', 'wp-book' ),
			'singular_name'     => __( 'Book Categories', 'wp-book' ),
			'search_items'      => __( 'Search Book Categories', 'wp-book' ),
			'all_items'         => __( 'All Book Categories', 'wp-book' ),
			'parent_item'       => __( 'Parent Book Category', 'wp-book' ),
			'parent_item_colon' => __( 'Parent Book Category:', 'wp-book' ),
			'edit_item'         => __( 'Edit Book Category', 'wp-book' ),
			'update_item'       => __( 'Update Book Category', 'wp-book' ),
			'add_new_item'      => __( 'Add New Book Category', 'wp-book' ),
			'new_item_name'     => __( 'New Book Category Name', 'wp-book' ),
			'menu_name'         => __( 'Book Category', 'wp-book' ),
		);
		$args   = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'book-category' ),
		);
		register_taxonomy( 'book_category', array( 'book' ), $args );
	}
}

