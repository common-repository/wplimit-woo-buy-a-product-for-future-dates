<?php
require_once( WPLIMIT_PLUG_PATH . 'wplimit-woo-bpfd-interface.php');

class wplimitWooBpfdFrontDateField implements wplimitWooBpfdExecutor{

	public function execute(){
		/**
		 * Date Field
		 */
		add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'wplimit_woo_bpfd_front_date_field' ) );

		/**
		 * Date Field Validation
		 */
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'wplimit_woo_bpfd_front_date_field_validation' ), 10, 3 );

		/**
		 * Save data to cart obj
		 */
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'wplimit_woo_bpfd_front_item_data' ), 10, 4 );

		/**
		 * Show date field data to cart and checkout
		 */
		add_filter( 'woocommerce_cart_item_name', array( $this, 'wplimit_woo_bpfd_front_cart_item_name' ), 10, 3 );

		/**
		 * Save date data in order details and email confirmation
		 */
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'wplimit_woo_bpfd_front_save_data_order_email' ), 10, 4 );

		/**
		 * Enqueue scripts
		 */
		add_action( 'wp_enqueue_scripts', array( $this, 'wplimit_woo_bpfd_front_enqueue' ) );

		/**
		 * Admin Enqueue scripts
		 */
		add_action( 'admin_enqueue_scripts', array( $this, 'wplimit_woo_bpfd_front_enqueue_admin' ) );
	}
	
	/**
	 * Date Field
	 */
	public function wplimit_woo_bpfd_front_date_field(){
		 global $post;
		 // Check for the custom field value
		 $product = wc_get_product( $post->ID );

	
		 $field = esc_attr( $product->get_meta( '_wplimit_woo_bpfd_panel_tab_data_enable' ) );

		 
		 if( $field ) {
			 ob_start(); ?>
				<div class="wplimit_woo_bpfd_date_field-wrapper">

					<label for="wplimit_woo_bpfd_date_field"><?php _e( 'Select Date:', 'wplimit' ); ?></label>

					<input placeholder="Place Date here" type="text" id="wplimit_woo_bpfd_date_field" name="_wplimit_woo_bpfd_date_field">

				</div>
			 <?php $output = ob_get_clean();
			 echo $output;
		 }
	}

	/**
	 * Date Field Validation
	 */
	public function wplimit_woo_bpfd_front_date_field_validation($passed, $product_id, $quantity){
		if( empty( $_POST['_wplimit_woo_bpfd_date_field'] ) ) {
			 // Fails validation
			 $passed = false;
			 wc_add_notice( __( 'Please select a date from below date field.', 'wplimit' ), 'error' );
		 }
		 return $passed;
	}

	/**
	 * Save data to cart obj
	 */
	public function wplimit_woo_bpfd_front_item_data($cart_item_data, $product_id, $variation_id, $quantity){

		if( ! empty( $_POST['_wplimit_woo_bpfd_date_field'] ) ) {
		 	// Add the item data
			$cart_item_data['_wplimit_woo_bpfd_date_field'] = esc_html( $_POST['_wplimit_woo_bpfd_date_field'] );
		}
		 return $cart_item_data;
	}

	/**
	 * Show date field data to cart and checkout
	 */
	public function wplimit_woo_bpfd_front_cart_item_name($name, $cart_item, $cart_item_key){
		
		 if( isset( $cart_item['_wplimit_woo_bpfd_date_field'] ) ) {
			 $name .= sprintf(
			 '<p class="wplimit-cart_item_name">Future Date: %s</p>',
			 esc_html( $cart_item['_wplimit_woo_bpfd_date_field'] )
			 );
		 }
		 return $name;
	}

	/**
	 * Save date data in order details and email confirmation
	 */
	public function wplimit_woo_bpfd_front_save_data_order_email( $item, $cart_item_key, $values, $order ) {
	 	foreach( $item as $cart_item_key=>$values ) {
			 if( isset( $values['_wplimit_woo_bpfd_date_field'] ) ) {
			 	$item->add_meta_data( __( 'Date of Future Order', 'wplimit' ), '<span class="wplimit-cart_item_name">' .  esc_attr( $values['_wplimit_woo_bpfd_date_field'] ) .'</span>', true );
			 }
		}
	}

	/**
	 * Enqueue scripts
	 */		
	public function wplimit_woo_bpfd_front_enqueue(){
		wp_enqueue_script( 'wplimit-woo-bpfd-front-date-field', WPLIMIT_PLUG_URL . 'inc/frontend/js/wplimit-woo-bpfd-front-date-field.js', array ( 'jquery' ), 1.1, true);

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_register_style( 'wplimit-jquery-ui-css', WPLIMIT_PLUG_URL . 'inc/frontend/css/jquery-ui.css' );
		wp_register_style( 'wplimit-styles', WPLIMIT_PLUG_URL . 'inc/frontend/css/wplimit-styles.css' );
    	wp_enqueue_style( 'wplimit-jquery-ui-css' );  
    	wp_enqueue_style( 'wplimit-styles' );  
	}

	/**
	 * Admin Enqueue scripts
	 */		
	public function wplimit_woo_bpfd_front_enqueue_admin(){
		wp_register_style( 'wplimit-styles', WPLIMIT_PLUG_URL . 'inc/backend/css/wplimit-styles-admin.css' );
    	wp_enqueue_style( 'wplimit-styles' );  
	}
}