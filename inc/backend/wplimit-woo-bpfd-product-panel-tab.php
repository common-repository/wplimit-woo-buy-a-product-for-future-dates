<?php 
require_once( WPLIMIT_PLUG_PATH . 'wplimit-woo-bpfd-interface.php');

class wplimitWooBpfdPanelTab implements wplimitWooBpfdExecutor{

	public function execute(){
		// Tab
		add_filter( 'woocommerce_product_data_tabs', array( $this, 'wplimit_product_data_tabs' ) );
		// Field
		add_action( 'woocommerce_product_data_panels', array( $this, 'wplimit_woo_bpfd_panel_tab_data' ) );
		// Save
		add_action( 'woocommerce_process_product_meta', array( $this, 'wplimit_woo_bpfd_panel_tab_save_data' ) );
	}

	// Tab
	public function wplimit_product_data_tabs($product_data_tabs){
		$product_data_tabs['wplimit_woo_bpfd_panel_tab'] = array(
			'label' => __( 'WPLimit Future Dates', 'wplimit' ),
			'target' => 'wplimit_woo_bpfd_panel_tab_data',
		);
		return $product_data_tabs;
	}

	// Field
	public function wplimit_woo_bpfd_panel_tab_data(){
		global $woocommerce, $post;
		?>
		<div id="wplimit_woo_bpfd_panel_tab_data" class="panel woocommerce_options_panel">
			<?php
			woocommerce_wp_checkbox( array( 
				'id'            => '_wplimit_woo_bpfd_panel_tab_data_enable', 
				// 'wrapper_class' => 'show_if_simple', 
				'label'         => __( 'Enable The Date Field', 'wplimit' ),
				'description'   => __( 'Please enable this feature to show the date fields in the details page', 'wplimit' ),
				'default'  		=> '0',
				'desc_tip'    	=> false,
			) );
			?>
		</div>
		<?php
	}

	// Save
	public function wplimit_woo_bpfd_panel_tab_save_data( $post_id ) {
		 $product = wc_get_product( $post_id );

		 $enable = isset( $_POST['_wplimit_woo_bpfd_panel_tab_data_enable'] ) ? esc_attr( $_POST['_wplimit_woo_bpfd_panel_tab_data_enable'] ) : '';

		 $product->update_meta_data( '_wplimit_woo_bpfd_panel_tab_data_enable', sanitize_text_field( $enable ) );
		 $product->save();
	}
}