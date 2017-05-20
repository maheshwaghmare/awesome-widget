<?php

if( ! class_exists( 'Awesome_Widget_Loader' ) ) :

	class Awesome_Widget_Loader {

		/**
		 * Instance
		 *
		 * @since 1.0.0
		 * @var $instance
		 * @access private
		 */
		private static $instance;

		/**
		 * Initiator
		 */
		public static function get_instance(){
			if ( ! isset( self::$instance ) ) {
				self::$instance = new self;
			}
			return self::$instance;
		}

		/**
		 * Construct
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function __construct() {

			// Define constants.
			self::define_constants();

			// Include files.
			self::include_files();

			// Register widget.
			add_action( 'widgets_init', array( $this, 'register_awesome_widget' ) );
		}

		/**
		 * Define constants.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public static function define_constants() {
			define('AWESOME_WIDGET_VERSION', '1.0.0');
			define('AWESOME_WIDGET_FILE', trailingslashit(dirname(dirname(__FILE__))) . 'class-loader.php');
			define('AWESOME_WIDGET_DIR', plugin_dir_path( AWESOME_WIDGET_FILE ));
			define('AWESOME_WIDGET_URL', plugins_url('/', AWESOME_WIDGET_FILE ));
		}

		/**
		 * Include files.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public static function include_files() {
			require_once AWESOME_WIDGET_DIR . 'classes/class-awesome-widget.php';
		}

		/**
		 * Register the widget
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function register_awesome_widget() {
			register_widget( 'Awesome_Widget' );
		}
	}

	/**
	 * Kicking this off by calling 'get_instance()' method
	 */
	Awesome_Widget_Loader::get_instance();

endif;
