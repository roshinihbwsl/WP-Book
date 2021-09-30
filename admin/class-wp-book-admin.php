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
	 * Creates a new custom post type called Book.
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
		flush_rewrite_rules();
	}

	/**
	 * Creates a new custom hierarchical category called Book Category.
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses register_taxonomy()
	 */
	public static function new_ct_book_category() {
		$labels = array(
			'name'              => __( 'Book Categories', 'wp-book' ),
			'singular_name'     => __( 'Book Category', 'wp-book' ),
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

	/**
	 * Creates a new custom non-hierarchical category called Book Tag.
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses register_taxonomy()
	 */
	public static function new_ct_book_tag() {
		$labels = array(
			'name'              => __( 'Book Tags', 'wp-book' ),
			'singular_name'     => __( 'Book Tag', 'wp-book' ),
			'search_items'      => __( 'Search Book Tags', 'wp-book' ),
			'all_items'         => __( 'All Book Tags', 'wp-book' ),
			'parent_item'       => __( 'Parent Book Tag', 'wp-book' ),
			'parent_item_colon' => __( 'Parent Book Tag:', 'wp-book' ),
			'edit_item'         => __( 'Edit Book Tag', 'wp-book' ),
			'update_item'       => __( 'Update Book Tag', 'wp-book' ),
			'add_new_item'      => __( 'Add New Book Tag', 'wp-book' ),
			'new_item_name'     => __( 'New Book Tag Name', 'wp-book' ),
			'menu_name'         => __( 'Book Tag', 'wp-book' ),
		);
		$args   = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'book-tag' ),
		);
		register_taxonomy( 'book_tag', array( 'book' ), $args );
	}

	/**
	 * Callback for displaying the HTML of the custom meta box.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function cmb_book_info_html ($post, $metabox) {
		?>
		<form action='class-wp-book-admin.php' method='post'>
		<label><?php _e('Author Name:', 'wp-book') ?><br><input type='text' name='author' value='<?php echo get_metadata('book', $post->ID, 'Author', true); ?>'></label><br>
		<label><?php _e('Price:', 'wp-book') ?><br><input type='text' name='price' value='<?php echo get_metadata('book', $post->ID, 'Price', true); ?>'></label><br>
		<label><?php _e('Publisher:', 'wp-book') ?><br><input type='text' name='publisher' value='<?php echo get_metadata('book', $post->ID, 'Publisher', true); ?>'></label><br>
		<label><?php _e('Year:', 'wp-book') ?><br><input type='text' name='year' value='<?php echo get_metadata('book', $post->ID, 'Year', true); ?>'></label><br>
		<label><?php _e('Edition:', 'wp-book') ?><br><input type='text' name='edition' value='<?php echo get_metadata('book', $post->ID, 'Edition', true); ?>'></label><br>
		<label><?php _e('URL:', 'wp-book') ?><br><input type='text' name='url' value='<?php echo get_metadata('book', $post->ID, 'URL', true); ?>'></label><br>
		<?php wp_nonce_field( basename( __FILE__ ), 'cmb_book_nonce' ); ?>
		</form>
		<?php
	}

	/**
	 * Creates a new custom meta box called Book Information.
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses add_meta_box()
	 */
	public function new_cmb_book_info() {
		add_meta_box(
			'book_info',
			__('Book Information', 'wp-book' ),
			array($this, 'cmb_book_info_html'),
			'book',
			'side'
		);
	}

	/**
	 * Registers the meta table for custom meta box.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function cmb_register_metatable() {
		global $wpdb;
		$wpdb->bookmeta = $wpdb->prefix . 'book_meta';
	}

	/**
	 * Saves custom meta box Information in database.
	 *
	 * @since 1.0.0
	 * @access public
	 * @uses add_metadata(), update_metadata()
	 */
	public function save_cmb($post_id) {
		if ( isset( $_POST['cmb_book_nonce'] ) && wp_verify_nonce( $_POST['cmb_book_nonce'], basename( __FILE__ ) ) ) {
			if ( '' == get_metadata('book', $post_id, 'Author', true) ) {
				add_metadata( 'book', $post_id, 'Author', $_POST['author'] );
			}
			else {
				update_metadata( 'book', $post_id, 'Author', $_POST['author'] );
			}

			if ( '' == get_metadata('book', $post_id, 'Price', true) ) {
				add_metadata( 'book', $post_id, 'Price', $_POST['price'] );
			}
			else {
				update_metadata( 'book', $post_id, 'Price', $_POST['price'] );
			}

			if ( '' == get_metadata('book', $post_id, 'Publisher', true) ) {
				add_metadata( 'book', $post_id, 'Publisher', $_POST['publisher'] );
			}
			else {
				update_metadata( 'book', $post_id, 'Publisher', $_POST['publisher'] );
			}

			if ( '' == get_metadata('book', $post_id, 'Year', true) ) {
				add_metadata( 'book', $post_id, 'Year', $_POST['year'] );
			}
			else {
				update_metadata( 'book', $post_id, 'Year', $_POST['year'] );
			}

			if ( '' == get_metadata('book', $post_id, 'Edition', true) ) {
				add_metadata( 'book', $post_id, 'Edition', $_POST['edition'] );
			}
			else {
				update_metadata( 'book', $post_id, 'Edition', $_POST['edition'] );
			}

			if ( '' == get_metadata('book', $post_id, 'URL', true) ) {
				add_metadata( 'book', $post_id, 'URL', $_POST['url'] );
			}
			else {
				update_metadata( 'book', $post_id, 'URL', $_POST['url'] );
			}
		}
		
	}

	/**
	* Registers custom admin settings page.
	*
	* @since 1.0.0
	*/

	public function add_plugin_admin_menu() {
		add_submenu_page( 'edit.php?post_type=book', 'Book Options', 'Settings', 'manage_options', 'book-options', array($this, 'display_plugin_setup_page'));
	}

	/**
	* Callback for displaying the HTML of the admin settings page.
	*
	* @since 1.0.0
	*/
	public function display_plugin_setup_page() {
		?>
		<div class='wrap'>
			<h1>Book Settings</h1><br>
			<form action="options.php" method='post'>
			<?php settings_fields('book_settings_group'); ?>
				<label>
					Currency:<br>
					<select name='book_settings[currency]'>
  						<option value='Rupee' <?php if ( get_option('book_settings')['currency'] == 'Rupee' ) { echo 'selected';} ?>>Rupee</option>
  						<option value='Dollar' <?php if ( get_option('book_settings')['currency'] == 'Dollar' ) { echo 'selected';} ?>>Dollar</option>
  						<option value='Pound' <?php if ( get_option('book_settings')['currency'] == 'Pound' ) { echo 'selected';} ?>>Pound</option>
  						<option value='Yen' <?php if ( get_option('book_settings')['currency'] == 'Yen' ) { echo 'selected';} ?>>Yen</option>
					</select>	
				</label><br>
				<label>Number of books per page (On archive pages):<br><input type="text" name='book_settings[no_of_books]' value='<?php if ( is_array(get_option('book_settings'))) {echo get_option('book_settings')['no_of_books'];} ?>'></label>
				<?php submit_button('Save all changes', 'primary','submit', TRUE); ?>
			</form>
		</div>
		<?php
	}

	/**
	* Registers settings in the options table.
	*
	* @since 1.0.0
	* @uses register_setting()
	*/
	public function book_register_settings() {
		register_setting('book_settings_group', 'book_settings');
	}

	/**
	* Sets posts per page on Book archive page.
	*
	* @since 1.0.0
	*/
	public function book_archive_page( $query ) {
		if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'book' ) ) {
				$query->set( 'posts_per_page', get_option('book_settings')['no_of_books'] );
		}
	}

	/**
	* Adds dashboard widget to display top 5 categories.
	*
	* @since 1.0.0
	* @uses wp_add_dashboard_widget()
	*/
	public function book_register_dash_widget() {
        wp_add_dashboard_widget( 'book_dash_cat_widget', __( 'Top 5 Book Categories', 'wp-book' ), array( $this, 'book_render_dash_widget' ) );
    }

	/**
	* Renders HTML for dashboard category widget.
	*
	* @since 1.0.0
	*/
	function book_render_dash_widget() {

		$categories = get_terms( array(
			'taxonomy'   => 'book_category',
			'hide_empty' => false,
			'number'     => '5',
			'orderby'    => 'count',
			'order'      => 'DESC',
		) );
		foreach ( $categories as $category ) { ?>
            <li><a 
                href="<?php echo get_category_link( $category->term_id );?>">
                <?php echo $category->name; ?>
                </a>
                <span class="count"><?php echo $category->count; ?></span>
            </li>
        	<?php 
		}
	}

	/**
	* Send category list data form php to js by localizing script.
	*
	* @since 1.0.0
	* @uses wp_localize_script()
	*/
	function send_category_list_to_js() {

		$cats_name = array();
		$categories = get_categories( array(
			 'taxonomy' => 'book_category',
			 'hide_empty' => false
			  )
			 );

		foreach ( $categories as $category ) {
			array_push( $cats_name, $category->name );
		}

		wp_enqueue_script('block-cat-list', plugin_dir_url( __DIR__ ) . 'build/index.js');
		wp_localize_script('block-cat-list', 'wp_book_vars', array(
			'category' => $cats_name
		)
	);
		
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
				'editor_script'   => 'custom-block-js',
				'editor_style'    => 'custom-block-editor-style',
				'style'           => 'custom-block-frontend-style',
				'attributes'      => array(
					'selected' => array(
						'type' => 'string',
					),
				),
				'render_callback' => array( $this, 'block_render'),
			)
		);
	}

	public function block_render( $atts ) {
		$cat =  $atts['selected'];

		$args = array( 'book_category' => $cat, 'post_type' => 'book' );
	
		$catPost = get_posts($args);
		foreach ($catPost as $post) {
			echo '<h1>' . $post->post_title . '</h1>';
			echo '<p>' . $post->post_content . '</p>';
		}
	}	
}

