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
			add_action( 'wp_enqueue_scripts',   array( $this, 'enqueue_assets' ) );
			add_action( 'admin_enqueue_scripts',array( $this, 'enqueue_assets' ) );
		}

		/**
		 * Enqueue assets.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		function enqueue_assets() {
			wp_enqueue_style( 'awesome-widget', AWESOME_WIDGET_URL . 'assets/css/ac.css' );
			wp_enqueue_script( 'awesome-widget', AWESOME_WIDGET_URL . 'assets/js/ac.js', array( 'jquery-ui-accordion' ) );
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
			$title          = apply_filters( 'widget_title', $instance['title'] ); 							// Title
			$heading        = ! empty( $instance['heading'] ) ? $instance['heading'] : ''; 					// Heading
			$featured_media = ! empty( $instance['featured_media'] ) ? $instance['featured_media'] : ''; 	// Featured image / icon
			$title_sep      = ! empty( $instance['title_sep'] ) ? $instance['title_sep'] : ''; 				// Title divider
			$title_media    = ! empty( $instance['title_media'] ) ? $instance['title_media'] : ''; 			// Title with image / icon
			$description    = ! empty( $instance['description'] ) ? $instance['description'] : ''; 			// Description
			$button         = ! empty( $instance['button'] ) ? $instance['button'] : ''; 					// Button one (repeater)

			/**
			 * Styling options
			 */
			$container_bg         = ! empty( $instance['container_bg'] ) ? $instance['container_bg'] : ''; 	// Container background color.

			/**
			 * Generate <style> CSS
			 */
			?>

			<style type="text/css">
				<?php echo '.' . esc_attr( $widget_id ); ?> {
					background-color: <?php echo $container_bg; ?>;
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
			<div class="awesome-widget <?php echo esc_attr( $widget_id ); ?>" style="text-align: center;">

				<!-- Heading -->
				<h3><?php echo esc_html( $heading ); ?></h3>

				<!-- Heading separator -->
				<span class="separator"></span>

				<!-- Description -->
				<div class="awesome-widget-description">
					<?php echo esc_html( $description ); ?>
				</div>

				<!-- Button -->
				<a class="awesome-widget-button" href="#"> <?php echo esc_html( $button ); ?></a>

				<p>
					<pre>
					<?php
					echo '$title: ' . $title . '<br/>';
					echo '$heading: ' . $heading . '<br/>';
					echo '$featured_media: ' . $featured_media . '<br/>';
					echo '$title_sep: ' . $title_sep . '<br/>';
					echo '$title_media: ' . $title_media . '<br/>';
					echo '$description: ' . $description . '<br/>';
					echo '$button: ' . $button . '<br/>';
					echo '$button: ' . $container_bg . '<br/>';
					?>
					</pre>
				</p>

			</div>
			<?php

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
			$title          = ! empty( $instance['title'] ) ? $instance['title'] : ''; 						// Title
			$heading        = ! empty( $instance['heading'] ) ? $instance['heading'] : 'Block Heading'; 					// Heading
			$featured_media = ! empty( $instance['featured_media'] ) ? $instance['featured_media'] : ''; 	// Featured image / icon
			$title_sep      = ! empty( $instance['title_sep'] ) ? $instance['title_sep'] : ''; 				// Title divider
			$title_media    = ! empty( $instance['title_media'] ) ? $instance['title_media'] : ''; 			// Title with image / icon
			$description    = ! empty( $instance['description'] ) ? $instance['description'] : __( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'awesome-widget' ); 			// Description
			$button         = ! empty( $instance['button'] ) ? $instance['button'] : 'Button'; 					// Button one (repeater)

			/**
			 * Styling options
			 */
			$container_bg         = ! empty( $instance['container_bg'] ) ? $instance['container_bg'] : ''; 	// Container background color.

			?>

        	<?php
			/**
			 * Title
			 */
			?>
			<p>
			  	<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:<br/>
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
			        <h3><i class="dashicons dashicons-schedule"></i> Container Styling </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'container_bg' ); ?>">Background Color<br/>
						  		<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'container_bg' ); ?>" id="<?php echo $this->get_field_id( 'container_bg' ); ?>" value="<?php echo esc_attr( $container_bg ); ?>" />
						  	</label>
						</p>
			        </div>
			    </div>

				<?php
				/**
				 * Featured Media
				 */
				?>
				<div class="aw-accordion-section">
			        <h3> <i class="dashicons dashicons-admin-media"></i> Featured Media </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'featured_media' ); ?>">Featured Media:<br/>

						  		<select class="widefat" name="<?php echo $this->get_field_name( 'featured_media' ); ?>" id="<?php echo $this->get_field_id( 'featured_media' ); ?>">
									<option value="image" <?php selected( $featured_media, 'image' ); ?>>Image</option>
									<option value="icon" <?php selected( $featured_media, 'icon' ); ?>>Icon</option>
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
			        <h3><i class="dashicons dashicons-editor-textcolor"></i> Heading </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'heading' ); ?>">Heading<br/>
						  		<input class="widefat" type="text" name="<?php echo $this->get_field_name( 'heading' ); ?>" id="<?php echo $this->get_field_id( 'heading' ); ?>" value="<?php echo esc_attr( $heading ); ?>" />
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
			        <h3> <i class="dashicons dashicons-minus"></i> Heading Separator </h3>
			        <div class="aw-accordion-content">
			        	<p>
						  	<label for="<?php echo $this->get_field_id( 'title_sep' ); ?>">Heading Separator:<br/>

						  		<select class="widefat" name="<?php echo $this->get_field_name( 'title_sep' ); ?>" id="<?php echo $this->get_field_id( 'title_sep' ); ?>">
									<option value="border-separator" <?php selected( $title_sep, 'border-separator' ); ?>>Border Separator</option>
									<option value="icon-separator" <?php selected( $title_sep, 'icon-separator' ); ?>>Icon Separator</option>
									<option value="image-separator" <?php selected( $title_sep, 'image-separator' ); ?>>Image Separator</option>
									<option value="text-separator" <?php selected( $title_sep, 'text-separator' ); ?>>Text Separator</option>
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
			        <h3> <i class="dashicons dashicons-format-image"></i> Heading Media  </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'title_media' ); ?>">Heading Media:<br/>

						  		<select class="widefat" name="<?php echo $this->get_field_name( 'title_media' ); ?>" id="<?php echo $this->get_field_id( 'title_media' ); ?>">
									<option value="image" <?php selected( $title_media, 'image' ); ?>>Image</option>
									<option value="icon" <?php selected( $title_media, 'icon' ); ?>>Icon</option>
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
			        <h3> <i class="dashicons dashicons-editor-paragraph"></i> Description </h3>
			        <div class="aw-accordion-content">
						<p>
						  	<label for="<?php echo $this->get_field_id( 'description' ); ?>">Description:<br/>
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
			        <h3> <i class="dashicons dashicons-external"></i> Button </h3>
			        <div class="aw-accordion-content">
			        	<p>
						  	<label for="<?php echo $this->get_field_id( 'button' ); ?>">Button:<br/>
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
