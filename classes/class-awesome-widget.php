<?php

/**
 * Register class.
 */
if( ! class_exists( 'Awesome_Widget' ) ) :

	class Awesome_Widget extends WP_Widget {

		function __construct() {

			$widget_options = array(
				'classname'   => 'awesome_widget',
				'description' => __( 'Awesome widget for building awesome blocks.', 'awesome-widget' ),
			);

			parent::__construct(
				'awesome_widget',
				__( 'Awesome Widget', 'awesome-widget' ),
				$widget_options
			);

			// Enqueue assets.
			add_action( 'wp_enqueue_scripts',    array( $this, 'enqueue_assets' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		}

		/**
		 * Enqueue assets.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function enqueue_assets() {

			// wp_enqueue_media();
			wp_enqueue_style(  'wp-color-picker');
			wp_enqueue_script( 'wp-color-picker');

			wp_enqueue_style( 'font-awesome', AWESOME_WIDGET_URL . 'assets/font-awesome-4.7.0/css/font-awesome.min.css' );
			wp_enqueue_style( 'awesome-widget', AWESOME_WIDGET_URL . 'assets/css/ac.css', array( 'wp-color-picker' ) );
			wp_enqueue_script( 'awesome-widget', AWESOME_WIDGET_URL . 'assets/js/ac.js', array( 'jquery-ui-accordion', 'wp-color-picker' ) );

			// Front end.
			wp_enqueue_style( 'awesome-widget-frontend', AWESOME_WIDGET_URL . 'assets/css/awesome-widget-frontend.css' );
		}

		/**
		 * Create the widget output
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function widget( $args, $instance ) {

			$widget_id = ! empty( $args['widget_id'] ) ? $args['widget_id'] : ''; 	// Widget ID.

			/**
			 * Basic options
			 *
			 * Get content from widgets.
			 * E.g. Title, Description, Image etc.
			 */
			$title                = ! empty( $instance['title'] ) ? $instance['title'] : ''; 					// Heading
			$heading              = ! empty( $instance['heading'] ) ? $instance['heading'] : ''; 					// Heading
			$featured_media       = ! empty( $instance['featured_media'] ) ? $instance['featured_media'] : ''; 	// Featured image / icon
			$featured_media_align = ! empty( $instance['featured_media_align'] ) ? $instance['featured_media_align'] : ''; 	// Featured image / icon
			$title_sep            = ! empty( $instance['title_sep'] ) ? $instance['title_sep'] : ''; 				// Title divider
			$title_align          = ! empty( $instance['title_align'] ) ? $instance['title_align'] : ''; 			// Title with image / icon
			$title_media          = ! empty( $instance['title_media'] ) ? $instance['title_media'] : ''; 			// Title with image / icon
			$title_media_align    = ! empty( $instance['title_media_align'] ) ? $instance['title_media_align'] : ''; 			// Title with image / icon
			$description          = ! empty( $instance['description'] ) ? $instance['description'] : ''; 			// Description
			$button               = ! empty( $instance['button'] ) ? $instance['button'] : ''; 					// Button one (repeater)

			// Added filters.
			$title = apply_filters( 'widget_title', $title ); // Title

			/**
			 * Styling options
			 */
			$container_bg         = ! empty( $instance['container_bg'] ) ? $instance['container_bg'] : ''; 	// Container background color.
			$container_bg_2       = ! empty( $instance['container_bg_2'] ) ? $instance['container_bg_2'] : ''; 	// Container background color.
			$has_box_bg			  = empty( $container_bg ) ? '' : 'has-box-bg';	// Has background.

			/**
			 * Generate <style> CSS
			 */
			?>

			<style type="text/css">
				<?php echo '.' . esc_attr( $widget_id ); ?> {
					background: <?php echo esc_html( $container_bg ); ?>; /* For browsers that do not support gradients */

					// Gradient
					// linear-gradient(-90deg, #0fb8ad, #2cb5e8).
					<?php if( $container_bg_2 ) { ?>
						background: -webkit-linear-gradient(-90deg, <?php echo esc_html( $container_bg ); ?>, <?php echo esc_html( $container_bg_2 ); ?>); /* For Safari 5.1 to 6.0 */
						background: -o-linear-gradient(-90deg, <?php echo esc_html( $container_bg ); ?>, <?php echo esc_html( $container_bg_2 ); ?>); /* For Opera 11.1 to 12.0 */
						background: -moz-linear-gradient(-90deg, <?php echo esc_html( $container_bg ); ?>, <?php echo esc_html( $container_bg_2 ); ?>); /* For Firefox 3.6 to 15 */
						background: linear-gradient(-90deg, <?php echo esc_html( $container_bg ); ?>, <?php echo esc_html( $container_bg_2 ); ?>); /* Standard syntax */
					<?php } ?>
				}

			</style>
			<?php

			/**
			 * HTML Markup
			 */

			// Before.
			echo $args['before_widget'];

			// Title
			echo $args['before_title'] . $title . $args['after_title'];

			?>
			<div class="awesome-widget <?php echo esc_attr( $widget_id ); ?> <?php echo esc_attr( $featured_media_align ); ?> <?php echo esc_attr( $has_box_bg ); ?>">

				<div class="featured">
					<?php if( 'image' == $featured_media ) { ?>
						<img src="<?php echo esc_url( AWESOME_WIDGET_URL . 'assets\images\img (13).png'); ?>" />
					<?php } else if( 'icon' == $featured_media ) { ?>
						<i class="fa fa-facebook"></i>
					<?php } ?>
				</div><!-- .featured -->

				<div class="content">

					<div class="heading <?php echo esc_attr( $title_media_align ); ?> <?php echo esc_attr( $title_align ); ?>">
						<div class="featured">
							<?php if( 'image' == $title_media ) { ?>
								<img src="<?php echo esc_url( AWESOME_WIDGET_URL . 'assets\images\img (13).png'); ?>" />
							<?php } else if( 'icon' == $title_media ) { ?>
								<i class="fa fa-facebook"></i>
							<?php } ?>
						</div><!-- .featured -->
						<div class="title"><?php echo esc_html( $heading ); ?></div>
					</div>

					<?php if( 'none' !== $title_sep ) { ?>
						<div class="separator"></div>
					<?php } ?>

					<?php if( $description ) { ?>
						<div class="description">
							<?php echo esc_html( $description ); ?>
						</div>
					<?php } ?>

					<?php if( $button ) { ?>
						<a class="button" href="#"> <?php echo esc_html( $button ); ?></a>
					<?php } ?>

				</div><!-- .content -->

			</div>

			<?php
			// echo '<p><pre>';
			// $featured_media . '<br/>';
			// echo '$heading: ' . $heading . '<br/>';
			// echo '$featured_media: ' . $featured_media . '<br/>';
			// echo '$featured_media_align: ' . $featured_media_align . '<br/>';
			// echo '$title_sep: ' . $title_sep . '<br/>';
			// echo '$title_align: ' . $title_align . '<br/>';
			// echo '$title_media: ' . $title_media . '<br/>';
			// echo '$title_media_align: ' . $title_media_align . '<br/>';
			// echo '$description: ' . $description . '<br/>';
			// echo '$button: ' . $button . '<br/>';
			// echo '$button: ' . $container_bg . '<br/>';
			// echo '$container_bg_2: ' . $container_bg_2 . '<br/>';
			// echo '</pre></p>';

			// After.
			echo $args['after_widget'];

		}

		/**
		 * Widget form.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function form( $instance ) {

			/**
			 * Basic options
			 *
			 * Get content from widgets.
			 * E.g. Title, Description, Image etc.
			 */
			$title                = ( isset( $instance['title'] ) ) ? $instance['title'] : ''; 						// Title
			$heading              = ( isset( $instance['heading'] ) ) ? $instance['heading'] : 'Block Heading'; 					// Heading
			$featured_media       = ( isset( $instance['featured_media'] ) ) ? $instance['featured_media'] : ''; 	// Featured image / icon
			$featured_media_align = ( isset( $instance['featured_media_align'] ) ) ? $instance['featured_media_align'] : ''; 	// Featured image / icon
			$title_sep            = ( isset( $instance['title_sep'] ) ) ? $instance['title_sep'] : ''; 				// Title divider
			$title_align          = ( isset( $instance['title_align'] ) ) ? $instance['title_align'] : ''; 			// Title with image / icon
			$title_media          = ( isset( $instance['title_media'] ) ) ? $instance['title_media'] : ''; 			// Title with image / icon
			$title_media_align    = ( isset( $instance['title_media_align'] ) ) ? $instance['title_media_align'] : ''; 			// Title with image / icon
			$description          = ( isset( $instance['description'] ) ) ? $instance['description'] : __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'awesome-widget' ); 			// Description
			$button               = ( isset( $instance['button'] ) ) ? $instance['button'] : 'Button'; 					// Button one (repeater)

			/**
			 * Styling options
			 */
			$container_bg         = ! empty( $instance['container_bg'] ) ? $instance['container_bg'] : ''; 	// Container background color.
			$container_bg_2       = ! empty( $instance['container_bg_2'] ) ? $instance['container_bg_2'] : ''; 	// Container background color.

			?>

        	<?php
			/**
			 * Title
			 */
			?>
			<p>
			  	<label for="<?php echo $this->get_field_id( 'title' ); ?>"> <?php esc_html_e( 'Title:', 'awesome-widget' ); ?><br/>
			  		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
			  	</label>
			</p>

			<div class="aw-accordion">

			    <?php
				/**
				 * # CONTAINER
				 */
				?>
				<div class="aw-accordion-section">
			        <h3><i class="dashicons dashicons-schedule"></i> <?php esc_html_e( 'Container Styling', 'awesome-widget' ); ?> </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'container_bg' ); ?>"> <?php esc_html_e( 'Background Color', 'awesome-widget' ); ?> <br/></label>
					  		<input class="aw-colorpicker" type="text" name="<?php echo $this->get_field_name( 'container_bg' ); ?>" id="<?php echo $this->get_field_id( 'container_bg' ); ?>" value="<?php echo esc_attr( $container_bg ); ?>" />
						</p>
						<p>
						  	<label for="<?php echo $this->get_field_id( 'container_bg_2' ); ?>">Background Color 2<br/></label>
					  		<input class="aw-colorpicker" type="text" name="<?php echo $this->get_field_name( 'container_bg_2' ); ?>" id="<?php echo $this->get_field_id( 'container_bg_2' ); ?>" value="<?php echo esc_attr( $container_bg_2 ); ?>" />
						</p>
			        </div>
			    </div>

				<?php
				/**
				 * Featured Media
				 */
				?>
				<div class="aw-accordion-section">
			        <h3> <i class="dashicons dashicons-admin-media"></i> <?php esc_html_e( 'Featured Media', 'awesome-widget' ); ?> </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'featured_media' ); ?>"> <?php esc_html_e( 'Featured Media:', 'awesome-widget' ); ?> <br/>
						  		<select class="widefat" name="<?php echo $this->get_field_name( 'featured_media' ); ?>" id="<?php echo $this->get_field_id( 'featured_media' ); ?>">
									<option value="none" <?php selected( $featured_media, 'none' ); ?>> <?php esc_html_e( 'None', 'awesome-widget' ); ?> </option>
									<option value="image" <?php selected( $featured_media, 'image' ); ?>> <?php esc_html_e( 'Image', 'awesome-widget' ); ?> </option>
									<option value="icon" <?php selected( $featured_media, 'icon' ); ?>> <?php esc_html_e( 'Icon', 'awesome-widget' ); ?> </option>
								</select>
						  	</label>
						</p>
						<p>
						  	<label for="<?php echo $this->get_field_id( 'featured_media_align' ); ?>"> <?php esc_html_e( 'Media Position:', 'awesome-widget' ); ?> <br/>
						  		<select class="widefat" name="<?php echo $this->get_field_name( 'featured_media_align' ); ?>" id="<?php echo $this->get_field_id( 'featured_media_align' ); ?>">
									<option value="left" <?php selected( $featured_media_align, 'left' ); ?>> <?php esc_html_e( 'Left', 'awesome-widget' ); ?> </option>
									<option value="top" <?php selected( $featured_media_align, 'top' ); ?>> <?php esc_html_e( 'Top', 'awesome-widget' ); ?> </option>
									<option value="right" <?php selected( $featured_media_align, 'right' ); ?>> <?php esc_html_e( 'Right', 'awesome-widget' ); ?> </option>
									<option value="bottom" <?php selected( $featured_media_align, 'bottom' ); ?>> <?php esc_html_e( 'Bottom', 'awesome-widget' ); ?> </option>
								</select>
						  	</label>
						</p>
			        </div>
			    </div>

			    <?php
				/**
				 * # HEADING
				 */
				?>
				<div class="aw-accordion-section">
			        <h3><i class="dashicons dashicons-editor-textcolor"></i> <?php esc_html_e( 'Heading', 'awesome-widget' ); ?> </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'heading' ); ?>"> <?php esc_html_e( 'Heading', 'awesome-widget' ); ?> <br/>
						  		<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'heading' ); ?>" id="<?php echo $this->get_field_id( 'heading' ); ?>" value="<?php echo esc_attr( $heading ); ?>" />
						  	</label>
						</p>
						<p>
						  	<label for="<?php echo $this->get_field_id( 'title_align' ); ?>"> <?php esc_html_e( 'Title Alignment:', 'awesome-widget' ); ?> <br/>
						  		<select class="widefat" name="<?php echo $this->get_field_name( 'title_align' ); ?>" id="<?php echo $this->get_field_id( 'title_align' ); ?>">
									<option value="text-left" <?php selected( $title_align, 'text-left' ); ?>> <?php esc_html_e( 'Left', 'awesome-widget' ); ?> </option>
									<option value="text-center" <?php selected( $title_align, 'text-center' ); ?>> <?php esc_html_e( 'Center', 'awesome-widget' ); ?> </option>
									<option value="text-right" <?php selected( $title_align, 'text-right' ); ?>> <?php esc_html_e( 'Right', 'awesome-widget' ); ?> </option>
								</select>
						  	</label>
						</p>
			        </div>
			    </div>

				<?php
				/**
				 * Heading Separator
				 */
				?>
				<div class="aw-accordion-section">
			        <h3> <i class="dashicons dashicons-minus"></i> <?php esc_html_e( 'Heading Separator', 'awesome-widget' ); ?> </h3>
			        <div class="aw-accordion-content">
			        	<p>
						  	<label for="<?php echo $this->get_field_id( 'title_sep' ); ?>"> <?php esc_html_e( 'Heading Separator:', 'awesome-widget' ); ?> <br/>

						  		<select class="widefat" name="<?php echo $this->get_field_name( 'title_sep' ); ?>" id="<?php echo $this->get_field_id( 'title_sep' ); ?>">
									<option value="none" <?php selected( $title_sep, 'none' ); ?>> <?php esc_html_e( 'None', 'awesome-widget' ); ?> </option>
									<option value="border-separator" <?php selected( $title_sep, 'border-separator' ); ?>> <?php esc_html_e( 'Border Separator', 'awesome-widget' ); ?> </option>
									<option value="icon-separator" <?php selected( $title_sep, 'icon-separator' ); ?>> <?php esc_html_e( 'Icon Separator', 'awesome-widget' ); ?> </option>
									<option value="image-separator" <?php selected( $title_sep, 'image-separator' ); ?>> <?php esc_html_e( 'Image Separator', 'awesome-widget' ); ?> </option>
									<option value="text-separator" <?php selected( $title_sep, 'text-separator' ); ?>> <?php esc_html_e( 'Text Separator', 'awesome-widget' ); ?> </option>
								</select>

						  	</label>
						</p>
			        </div>
			    </div>

			    <?php
				/**
				 * Heading Media
				 */
				?>
				<div class="aw-accordion-section">
			        <h3> <i class="dashicons dashicons-format-image"></i> <?php esc_html_e( 'Heading Media', 'awesome-widget' ); ?> </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'title_media' ); ?>"> <?php esc_html_e( 'Title Media:', 'awesome-widget' ); ?> <br/>

						  		<select class="widefat" name="<?php echo $this->get_field_name( 'title_media' ); ?>" id="<?php echo $this->get_field_id( 'title_media' ); ?>">
									<option value="none" <?php selected( $title_media, 'none' ); ?>> <?php esc_html_e( 'None', 'awesome-widget' ); ?> </option>
									<option value="image" <?php selected( $title_media, 'image' ); ?>> <?php esc_html_e( 'Image', 'awesome-widget' ); ?> </option>
									<option value="icon" <?php selected( $title_media, 'icon' ); ?>> <?php esc_html_e( 'Icon', 'awesome-widget' ); ?> </option>
								</select>

						  	</label>
						</p>
						<p>
						  	<label for="<?php echo $this->get_field_id( 'title_media_align' ); ?>"> <?php esc_html_e( 'Media Direction:', 'awesome-widget' ); ?> <br/>
						  		<select class="widefat" name="<?php echo $this->get_field_name( 'title_media_align' ); ?>" id="<?php echo $this->get_field_id( 'title_media_align' ); ?>">
									<option value="left" <?php selected( $title_media_align, 'left' ); ?>> <?php esc_html_e( 'Left', 'awesome-widget' ); ?> </option>
									<option value="right" <?php selected( $title_media_align, 'right' ); ?>> <?php esc_html_e( 'Right', 'awesome-widget' ); ?> </option>
								</select>
						  	</label>
						</p>
			        </div>
			    </div>

			    <?php
				/**
				 * Description
				 */
				?>
				<div class="aw-accordion-section">
			        <h3> <i class="dashicons dashicons-editor-paragraph"></i> <?php esc_html_e( 'Description', 'awesome-widget' ); ?> </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'description' ); ?>"> <?php esc_html_e( 'Description:', 'awesome-widget' ); ?> <br/>
						  		<textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo esc_attr( $description ); ?></textarea>
						  	</label>
						</p>
			        </div>
			    </div>

				<?php
				/**
				 * Button
				 */
				?>
				<div class="aw-accordion-section">
			        <h3> <i class="dashicons dashicons-external"></i> <?php esc_html_e( 'Button', 'awesome-widget' ); ?> </h3>
			        <div class="aw-accordion-content">
			        	<p>
						  	<label for="<?php echo $this->get_field_id( 'button' ); ?>"> <?php esc_html_e( 'Button:', 'awesome-widget' ); ?> <br/>
						  		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'button' ); ?>" name="<?php echo $this->get_field_name( 'button' ); ?>" value="<?php echo esc_attr( $button ); ?>" />
						  	</label>
						</p>
			        </div>
			    </div>

			</div>

			<?php
		}

		/**
		 * Update database with new info
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function update( $new_instance, $old_instance ) {
			$instance = array_merge( $old_instance, $new_instance);
			return $new_instance;
		}
	}

endif;
