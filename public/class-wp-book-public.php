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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

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
				'id'          => '1',
				'author_name' => 'Jon Doe',
				'category'    => 'Thriller',
				'tag'         => 'english',
				'year'        => '2012',
				'publisher'   => 'Bloomberry',
			),
			$atts,
			'book'
		);

		$content  = '<h1> Book Info </H1>';
		$content .= '<p>ID: ' . $atts['id'] . ' </p><br>';
		$content .= '<p>Author: ' . $atts['author_name'] . ' </p><br>';
		$content .= '<p>Category: ' . $atts['category'] . ' </p><br>';
		$content .= '<p>Tag: ' . $atts['tag'] . ' </p><br>';
		$content .= '<p>Year: ' . $atts['year'] . ' </p><br>';
		$content .= '<p>Publisher: ' . $atts['publisher'] . ' </p><br>';

		return $content;
	}

	/**
	 * Registers custom gutenberg blocks.
	 *
	 * @since 1.0.0
	 */
	public function book_gutenberg_block() {

		wp_register_script(
			'custom-block-js',
			plugin_dir_url( __DIR__ ) . 'build/index.js',
			array( 'wp-blocks', 'wp-element', 'wp-editor' )
		);

		wp_register_style(
			'custom-block-editor-style',
			plugin_dir_url( __DIR__ ) . 'src/editor.css',
			array( 'wp-edit-blocks' )
		);

		wp_register_style(
			'custom-block-frontend-style',
			plugin_dir_url( __DIR__ ) . 'src/style.css',
			array( 'wp-edit-blocks' )
		);

		register_block_type(
			'wp-book/gutenberg-book-category',
			array(
				'editor_script' => 'custom-block-js',
				'editor_style'  => 'custom-block-editor-style',
				'style'         => 'custom-block-frontend-style',
			)
		);
	}

}

