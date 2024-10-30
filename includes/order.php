<?php
if( is_admin() ) {

	/* Start of: WordPress Administration */

	// HTML template for disabled Filter Orders by Date widget on Store Exporter screen
	function jigo_ce_orders_filter_by_date() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		$current_month = date( 'F' );
		$last_month = date( 'F', mktime( 0, 0, 0, date( 'n' )-1, 1, date( 'Y' ) ) );
		$order_dates_from = '-';
		$order_dates_to = '-';

		ob_start(); ?>
<p><label><input type="checkbox" id="orders-filters-date" /> <?php _e( 'Filter Orders by Order Date', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></p>
<div id="export-orders-filters-date" class="separator">
	<ul>
		<li>
			<label><input type="radio" name="order_dates_filter" value="current_month" disabled="disabled" /> <?php _e( 'Current month', 'jigo_ce' ); ?> (<?php echo $current_month; ?>)</label>
		</li>
		<li>
			<label><input type="radio" name="order_dates_filter" value="last_month" disabled="disabled" /> <?php _e( 'Last month', 'jigo_ce' ); ?> (<?php echo $last_month; ?>)</label>
		</li>
		<li>
			<label><input type="radio" name="order_dates_filter" value="last_quarter" disabled="disabled" /> <?php _e( 'Last quarter', 'jigo_ce' ); ?> (Nov. - Jan.)</label>
		</li>
		<li>
			<label><input type="radio" name="order_dates_filter" value="manual" disabled="disabled" /> <?php _e( 'Manual', 'jigo_ce' ); ?></label>
			<div style="margin-top:0.2em;">
				<input type="text" size="10" maxlength="10" id="order_dates_from" name="order_dates_from" value="<?php echo $order_dates_from; ?>" class="text" disabled="disabled" /> to <input type="text" size="10" maxlength="10" id="order_dates_to" name="order_dates_to" value="<?php echo $order_dates_to; ?>" class="text" disabled="disabled" />
				<p class="description"><?php _e( 'Filter the dates of Orders to be included in the export. Default is the date of the first order to today.', 'jigo_ce' ); ?></p>
			</div>
		</li>
	</ul>
</div>
<!-- #export-orders-filters-date -->
<?php
		ob_end_flush();

	}

	// HTML template for disabled Filter Orders by Customer widget on Store Exporter screen
	function jigo_ce_orders_filter_by_customer() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		ob_start(); ?>
<p><label><input type="checkbox" id="orders-filters-customer" /> <?php _e( 'Filter Orders by Customer', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></p>
<div id="export-orders-filters-customer" class="separator">
	<select id="order_customer" name="order_customer" disabled="disabled">
		<option value=""><?php _e( 'Show all customers', 'jigo_ce' ); ?></option>
	</select>
	<p class="description"><?php _e( 'Filter Orders by Customer (unique e-mail address) to be included in the export. Default is to include all Orders.', 'jigo_ce' ); ?></p>
</div>
<!-- #export-orders-filters-customer -->
<?php
		ob_end_flush();

	}

	// HTML template for disabled Filter Orders by User Role widget on Store Exporter screen
	function jigo_ce_orders_filter_by_user_role() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		$user_roles = jigo_ce_get_user_roles();

		ob_start(); ?>
<p><label><input type="checkbox" id="orders-filters-user_role" /> <?php _e( 'Filter Orders by User Role', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></p>
<div id="export-orders-filters-user_role" class="separator">
	<ul>
<?php if( $user_roles ) { ?>
	<?php foreach( $user_roles as $key => $user_role ) { ?>
		<li><label><input type="checkbox" name="order_filter_user_role[<?php echo $key; ?>]" value="<?php echo $key; ?>" disabled="disabled" /> <?php echo ucfirst( $user_role['name'] ); ?></label></li>
	<?php } ?>
<?php } else { ?>
		<li><?php _e( 'No User Roles have been found.', 'jigo_ce' ); ?></li>
<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the User Roles you want to filter exported Orders by. Default is to include all User Role options.', 'jigo_ce' ); ?></p>
</div>
<!-- #export-orders-filters-user_role -->
<?php
		ob_end_flush();

	}

	// HTML template for disabled Order Items Formatting on Store Exporter screen
	function jigo_ce_orders_items_formatting() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		ob_start(); ?>
<tr class="export-options order-options">
	<th><label for="order_items"><?php _e( 'Order items formatting', 'jigo_ce' ); ?></label></th>
	<td>
		<ul>
			<li>
				<label><input type="radio" name="order_items" value="combined" disabled="disabled" />&nbsp;<?php _e( 'Place Order Items within a grouped single Order row', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label>
				<p class="description"><?php _e( 'For example: <code>Order Items: SKU</code> cell might contain <code>SPECK-IPHONE|INCASE-NANO|-</code> for 3 Order items within an Order', 'jigo_ce' ); ?></p>
			</li>
			<li>
				<label><input type="radio" name="order_items" value="unique" disabled="disabled" />&nbsp;<?php _e( 'Place Order Items on individual cells within a single Order row', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label>
				<p class="description"><?php _e( 'For example: <code>Order Items: SKU</code> would become <code>Order Item #1: SKU</code> with <codeSPECK-IPHONE</code> for the first Order item within an Order', 'jigo_ce' ); ?></p>
			</li>
			<li>
				<label><input type="radio" name="order_items" value="individual" disabled="disabled" />&nbsp;<?php _e( 'Place each Order Item within their own Order row', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label>
				<p class="description"><?php _e( 'For example: An Order with 3 Order items will display a single Order item on each row', 'jigo_ce' ); ?></p>
			</li>
		</ul>
		<p class="description"><?php _e( 'Choose how you would like Order Items to be presented within Orders.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<?php
		ob_end_flush();

	}

	// HTML template for disabled Max Order Items widget on Store Exporter screen
	function jigo_ce_orders_max_order_items() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		$max_size = 10;

		ob_start(); ?>
<tr id="max_order_items_option" class="export-options order-options">
	<th>
		<label for="max_order_items"><?php _e( 'Max unique Order items', 'jigo_ce' ); ?>: </label>
	</th>
	<td>
		<input type="text" id="max_order_items" name="max_order_items" size="3" class="text" value="<?php echo esc_attr( $max_size ); ?>" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
		<p class="description"><?php _e( 'Manage the number of Order Item colums displayed when the \'Place Order Items on individual cells within a single Order row\' Order items formatting option is selected.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<?php
		ob_end_flush();

	}

	// HTML template for disabled Filter Orders by Order Status widget on Store Exporter screen
	function jigo_ce_orders_filter_by_status() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		$order_statuses = jigo_ce_get_order_statuses();

		ob_start(); ?>
<p><label><input type="checkbox" id="orders-filters-status" /> <?php _e( 'Filter Orders by Order Status', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></p>
<div id="export-orders-filters-status" class="separator">
	<ul>
<?php foreach( $order_statuses as $order_status ) { ?>
		<li>
			<label><input type="checkbox" name="order_filter_status[<?php echo $order_status->name; ?>]" value="<?php echo $order_status->name; ?>" disabled="disabled" /> <?php echo ucfirst( $order_status->name ); ?></label>
			<span class="description">(<?php echo $order_status->count; ?>)</span>
		</li>
<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the Order Status you want to filter exported Orders by. Default is to include all Order Status options.', 'jigo_ce' ); ?></p>
</div>
<!-- #export-orders-filters-status -->
<?php
		ob_end_flush();

	}

	// HTML template for disabled Filter Orders by Product Category widget on Store Exporter screen
	function jigo_ce_orders_filter_by_product_category() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		$args = array(
			'hide_empty' => 1
		);
		$product_categories = jigo_ce_get_product_categories( $args );

		ob_start(); ?>
<p><label><input type="checkbox" id="orders-filters-category" /> <?php _e( 'Filter Orders by Product Category', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></p>
<div id="export-orders-filters-category" class="separator">
	<ul>
<?php if( !empty( $product_categories ) ) { ?>
	<?php foreach( $product_categories as $product_category ) { ?>
		<li>
			<label><input type="checkbox" name="order_filter_category[]" value="<?php echo $product_category->term_id; ?>" title="<?php printf( __( 'Term ID: %d', 'jigo_ce' ), $product_category->term_id ); ?>" disabled="disabled" /> <?php echo jigo_ce_format_product_category_label( $product_category->name, $product_category->parent_name ); ?></label>
		</li>
	<?php } ?>
<?php } else { ?>
		<li><?php _e( 'No Product Categories have been found.', 'jigo_ce' ); ?></li>
<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the Product Categories you want to filter exported Orders by. Default is to include all Product Categories.', 'jigo_ce' ); ?></p>
</div>
<!-- #export-orders-filters-category -->
<?php
		ob_end_flush();

	}

	// HTML template for disabled Filter Orders by Product Tag widget on Store Exporter screen
	function jigo_ce_orders_filter_by_product_tag() {

		$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
		$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

		$args = array(
			'hide_empty' => 1
		);
		$product_tags = jigo_ce_get_product_tags( $args );

		ob_start(); ?>
<p><label><input type="checkbox" id="orders-filters-tag" /> <?php _e( 'Filter Orders by Product Tag', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></p>
<div id="export-orders-filters-tag" class="separator">
	<ul>
<?php if( !empty( $product_tags ) ) { ?>
	<?php foreach( $product_tags as $product_tag ) { ?>
		<li>
			<label><input type="checkbox" name="order_filter_tag[]" value="<?php echo $product_tag->term_id; ?>" title="<?php printf( __( 'Term ID: %d', 'jigo_ce' ), $product_tag->term_id ); ?>" disabled="disabled" /> <?php echo $product_tag->name; ?></label>
			<span class="description">(<?php echo $product_tag->count; ?>)</span>
		</li>
	<?php } ?>
<?php } else { ?>
		<li><?php _e( 'No Product Tags have been found.', 'jigo_ce' ); ?></li>
<?php } ?>
	</ul>
	<p class="description"><?php _e( 'Select the Product Tags you want to filter exported Orders by. Default is to include all Product Tags.', 'jigo_ce' ); ?></p>
</div>
<!-- #export-orders-filters-tag -->
<?php
		ob_end_flush();

	}

	// HTML template for disabled Order Sorting widget on Store Exporter screen
	function jigo_ce_order_sorting() {

		ob_start(); ?>
<p><label><?php _e( 'Order Sorting', 'jigo_ce' ); ?></label></p>
<div>
	<select name="order_orderby" disabled="disabled">
		<option value="ID"><?php _e( 'Order ID', 'jigo_ce' ); ?></option>
		<option value="title"><?php _e( 'Order Name', 'jigo_ce' ); ?></option>
		<option value="date"><?php _e( 'Date Created', 'jigo_ce' ); ?></option>
		<option value="modified"><?php _e( 'Date Modified', 'jigo_ce' ); ?></option>
		<option value="rand"><?php _e( 'Random', 'jigo_ce' ); ?></option>
	</select>
	<select name="order_order" disabled="disabled">
		<option value="ASC"><?php _e( 'Ascending', 'jigo_ce' ); ?></option>
		<option value="DESC"><?php _e( 'Descending', 'jigo_ce' ); ?></option>
	</select>
	<p class="description"><?php _e( 'Select the sorting of Orders within the exported file. By default this is set to export Orders by Order ID in Desending order.', 'jigo_ce' ); ?></p>
</div>
<?php
		ob_end_flush();

	}

	// HTML template for disabled Custom Orders widget on Store Exporter screen
	function jigo_ce_orders_custom_fields() {

		$custom_orders = '-';
		$custom_order_items = '-';

		$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter-deluxe/usage/';

		ob_start(); ?>
<form method="post" id="export-orders-custom-fields" class="export-options order-options">
	<div id="poststuff">

		<div class="postbox" id="export-options">
			<h3 class="hndle"><?php _e( 'Custom Order Fields', 'jigo_ce' ); ?></h3>
			<div class="inside">
				<p class="description"><?php _e( 'To include additional custom Order and Order Item meta in the Export Orders table above fill the Orders and Order Items text box then click Save Custom Fields.', 'jigo_ce' ); ?></p>
				<table class="form-table">

					<tr>
						<th>
							<label><?php _e( 'Order meta', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<textarea name="custom_orders" rows="5" cols="70" disabled="disabled"><?php echo esc_textarea( $custom_orders ); ?></textarea>
							<p class="description"><?php _e( 'Include additional custom Order meta in your export file by adding each custom Order meta name to a new line above.<br />For example: <code>Customer UA, Customer IP Address</code>', 'jigo_ce' ); ?></p>
						</td>
					</tr>

					<tr>
						<th>
							<label><?php _e( 'Order Item meta', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<textarea name="custom_order_items" rows="5" cols="70" disabled="disabled"><?php echo esc_textarea( $custom_order_items ); ?></textarea>
							<p class="description"><?php _e( 'Include additional custom Order Item meta in your exported CSV by adding each custom Order Item meta name to a new line above.<br />For example: <code>Personalized Message</code>.', 'jigo_ce' ); ?></p>
						</td>
					</tr>

				</table>
				<p class="submit">
					<input type="submit" value="<?php _e( 'Save Custom Fields', 'jigo_ce' ); ?>" class="button-primary" />
				</p>
				<p class="description"><?php printf( __( 'For more information on custom Order and Order Item meta consult our <a href="%s" target="_blank">online documentation</a>.', 'jigo_ce' ), $troubleshooting_url ); ?></p>
			</div>
			<!-- .inside -->
		</div>
		<!-- .postbox -->

	</div>
	<!-- #poststuff -->
	<input type="hidden" name="action" value="update" />
</form>
<!-- #export-orders-custom-fields -->
<?php
		ob_end_flush();

	}

	/* End of: WordPress Administration */

}

// Returns a list of Order export columns
function jigo_ce_get_order_fields( $format = 'full' ) {

	$export_type = 'order';

	$fields = array();
	$fields[] = array(
		'name' => 'purchase_id',
		'label' => __( 'Purchase ID', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'purchase_total',
		'label' => __( 'Purchase Total', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_discount',
		'label' => __( 'Order Discount', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_subtotal',
		'label' => __( 'Order Subtotal', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_shipping_cost',
		'label' => __( 'Order Shipping Cost', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_shipping_tax',
		'label' => __( 'Order Shipping Tax', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_tax_total',
		'label' => __( 'Order Tax Total', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'payment_gateway',
		'label' => __( 'Payment Gateway', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_method',
		'label' => __( 'Shipping Method', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'payment_status',
		'label' => __( 'Payment Status', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_key',
		'label' => __( 'Order Key', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'purchase_date',
		'label' => __( 'Purchase Date', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'notes',
		'label' => __( 'Notes', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'user_id',
		'label' => __( 'User ID', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'user_name',
		'label' => __( 'Username', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'user_role',
		'label' => __( 'User Role', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_full_name',
		'label' => __( 'Billing: Full Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_first_name',
		'label' => __( 'Billing: First Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_last_name',
		'label' => __( 'Billing: Last Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_company',
		'label' => __( 'Billing: Company', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_address',
		'label' => __( 'Billing: Street Address', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_city',
		'label' => __( 'Billing: City', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_postcode',
		'label' => __( 'Billing: ZIP Code', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_state',
		'label' => __( 'Billing: State (prefix)', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_state_full',
		'label' => __( 'Billing: State', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_country',
		'label' => __( 'Billing: Country (prefix)', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_country_full',
		'label' => __( 'Billing: Country', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_phone',
		'label' => __( 'Billing: Phone Number', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'billing_email',
		'label' => __( 'Billing: E-mail Address', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_full_name',
		'label' => __( 'Shipping: Full Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_first_name',
		'label' => __( 'Shipping: First Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_last_name',
		'label' => __( 'Shipping: Last Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_company',
		'label' => __( 'Shipping: Company', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_address',
		'label' => __( 'Shipping: Street Address', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_city',
		'label' => __( 'Shipping: City', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_postcode',
		'label' => __( 'Shipping: ZIP Code', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_state',
		'label' => __( 'Shipping: State (prefix)', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_state_full',
		'label' => __( 'Shipping: State', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_country',
		'label' => __( 'Shipping: Country (prefix)', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'shipping_country_full',
		'label' => __( 'Shipping: Country', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_items_product_id',
		'label' => __( 'Order Items: Product ID', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_items_variation_id',
		'label' => __( 'Order Items: Variation ID', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_items_sku',
		'label' => __( 'Order Items: SKU', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_items_name',
		'label' => __( 'Order Items: Product Name', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_items_variation',
		'label' => __( 'Order Items: Product Variation', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_items_quantity',
		'label' => __( 'Order Items: Quantity', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_items_cost',
		'label' => __( 'Order Items: Cost', 'jigo_ce' )
	);
	$fields[] = array(
		'name' => 'order_items_tax_rate',
		'label' => __( 'Order Items: Tax Rate', 'jigo_ce' )
	);

/*
	$fields[] = array(
		'name' => '',
		'label' => __( '', 'jigo_ce' )
	);
*/

	// Allow Plugin/Theme authors to add support for additional columns
	$fields = apply_filters( 'jigo_ce_' . $export_type . '_fields', $fields, $export_type );

	switch( $format ) {

		case 'summary':
			$output = array();
			$size = count( $fields );
			for( $i = 0; $i < $size; $i++ ) {
				if( isset( $fields[$i] ) )
					$output[$fields[$i]['name']] = 'on';
			}
			return $output;
			break;

		case 'full':
		default:
			$sorting = jigo_ce_get_option( $export_type . '_sorting', array() );
			$size = count( $fields );
			for( $i = 0; $i < $size; $i++ ) {
				$fields[$i]['reset'] = $i;
				$fields[$i]['order'] = ( isset( $sorting[$fields[$i]['name']] ) ? $sorting[$fields[$i]['name']] : $i );
			}
			// Check if we are using PHP 5.3 and above
			if( version_compare( phpversion(), '5.3' ) >= 0 )
				usort( $fields, jigo_ce_sort_fields( 'order' ) );
			return $fields;
			break;

	}

}

function jigo_ce_format_order_date( $date ) {

	$output = $date;
	if( $date )
		$output = str_replace( '/', '-', $date );
	return $output;

}

// Returns a list of Jigoshop Order statuses
function jigo_ce_get_order_statuses() {

	$args = array(
		'hide_empty' => false
	);
	$terms = get_terms( 'shop_order_status', $args );
	if( !empty( $terms ) && is_wp_error( $terms ) == false )
		return $terms;

}

?>