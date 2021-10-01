<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/roshinihbwsl
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 * @author     Roshini S <roshini.s@hbwsl.com>
 */
class Wp_Book_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . 'index.js', plugin_dir_url( __DIR__ ) . 'build/index.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Registers shortcode.
	 *
	 * @since 1.0.0
	 * @uses add_shortcode()
	 */
	public function register_shortcode() {
		add_shortcode( 'book', array( $this, 'handle_shortcode' ) );
	}

	/**
	 * Handles shortcode.
	 *
	 * @param array  $atts is an array of arrtributes of the shortcode.
	 * @param string $content is content to be displayed.
	 * @since 1.0.0
	 */
	public function handle_shortcode( $atts = array(), $content = null ) {
		$atts = array_change_key_case( (array) $atts, CASE_LOWER );
		$atts = shortcode_atts(
			array(
				'id'        => '',
				'author'    => '',
				'category'  => '',
				'tag'       => '',
				'year'      => '',
				'publisher' => '',
			),
			$atts,
			'book'
		);

		$args = array( 'post_type' => 'book' );

		if ( '' !== $atts['id'] ) {
			$args['p'] = $atts['id'];
		}

		if ( '' !== $atts['author'] ) {
			$args['meta_query']['relation'] = 'AND';
			$args['meta_query'][]           = array(
				'key'   => 'book_author_name',
				'value' => $atts['author'],
			);
		}

		if ( '' !== $atts['publisher'] ) {
			$args['meta_query']['relation'] = 'AND';
			$args['meta_query'][]           = array(
				'key'   => 'publisher',
				'value' => $atts['publisher'],
			);
		}

		if ( '' !== $atts['year'] ) {
			$args['meta_query']['relation'] = 'AND';
			$args['meta_query'][]           = array(
				'key'   => 'year',
				'value' => $atts['year'],
			);
		}

		if ( '' !== $atts['category'] ) {
			$args['tax_query']['relation'] = 'AND';
			$args['tax_query'][]           = array(
				'taxonomy' => 'book_category',
				'field'    => 'name',
				'terms'    => $atts['category'],
			);
		}

		if ( '' !== $atts['tag'] ) {
			$args['tax_query']['relation'] = 'AND';
			$args['tax_query'][]           = array(
				'taxonomy' => 'book_tag',
				'field'    => 'name',
				'terms'    => $atts['tag'],
			);
		}

		$content = '';
		$query   = new WP_Query( $args );
		if ( $query->have_posts() == true ) {
			while ( $query->have_posts() == true ) {
				$query->the_post();
				$content .= '<div style="border: 2px solid grey; text-align: center">';
				$content .= '<p>Title: ' . get_the_title() . ' </p><br>';
				$content .= '<p>ID: ' . get_the_ID() . ' </p><br>';
				$content .= '<p>Author: ' . get_metadata( 'book', get_the_ID(), 'Author', true ) . ' </p><br>';
				$content .= '<p>Edition: ' . get_metadata( 'book', get_the_ID(), 'Edition', true ) . ' </p><br>';
				$content .= '<p>Year: ' . get_metadata( 'book', get_the_ID(), 'Year', true ) . ' </p><br>';
				$content .= '<p>Price: ' . get_metadata( 'book', get_the_ID(), 'Price', true ) . ' ' . get_option( 'book_settings' )['currency'] . '</p><br>';
				$content .= '<p>URL: ' . get_metadata( 'book', get_the_ID(), 'URL', true ) . '</p><br>';
				$content .= '<p>Publisher: ' . get_metadata( 'book', get_the_ID(), 'Publisher', true ) . ' </p><br>';
				$content .= '</div><br>';
			}
		}

		return $content;
	}


}

