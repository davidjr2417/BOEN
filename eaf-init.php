<?php
class eafw_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'ea_form',
			'description' => 'Display event attendance form to your visitors.',
		);
		parent::__construct( 'ea_form', 'Event Attendance Form Widget', $widget_ops );
	}

	/**
	 * Outputs of the widget
	 */
	public function widget( $args, $instance ) {


		wp_enqueue_style( 'component', plugin_dir_url( __FILE__ ).'css/component.css' );


		wp_enqueue_script( 'jquery');



		wp_enqueue_script( 'eafw-functions-js', plugin_dir_url( __FILE__ ) . 'js/eafw-functions.js', array( 'jquery' ), '', true );


		wp_enqueue_script( 'eafw-ajax', plugin_dir_url( __FILE__ ) . 'js/eafw-ajax.js', array( 'jquery' ), '', true );



		wp_localize_script( 'eafw-ajax', 'eafw_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		echo $args['before_widget'];

		// widget title
		if ( ! empty( $instance['title'] ) ) {
			echo  $args['after_title'];
		}

		include('eaf-template.php');
		echo $args['after_widget'];
	}

	/**
	 * Outputs Form For Admin
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ) ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
		
	}

	/**
	 * Processing widget options on save
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}


?>