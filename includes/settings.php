<?php
function jigo_ce_export_settings_quicklinks() {

	ob_start(); ?>
<li>| <a href="#xml-settings"><?php _e( 'XML Settings', 'jigo_ce' ); ?></a> |</li>
<li><a href="#scheduled-exports"><?php _e( 'Scheduled Exports', 'jigo_ce' ); ?></a> |</li>
<li><a href="#cron-exports"><?php _e( 'CRON Exports', 'jigo_ce' ); ?></a></li>
<?php
	ob_end_flush();

}

function jigo_ce_export_settings_additional() {

	$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
	$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

	$email_to = '-';
	$post_to = '-';
	ob_start(); ?>
<tr>
	<th>
		<label for="email_to"><?php _e( 'Default e-mail recipient', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<input name="email_to" type="text" id="email_to" value="<?php echo esc_attr( $email_to ); ?>" class="regular-text code" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
		<p class="description"><?php _e( 'Set the default recipient of scheduled export e-mails, can be overriden via CRON using the <code>to</code> argument. Default is the WordPress Blog administrator e-mail address.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="post_to"><?php _e( 'Default remote POST URL', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<input name="post_to" type="text" id="post_to" value="<?php echo esc_url( $post_to ); ?>" class="regular-text code" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
		<p class="description"><?php _e( 'Set the default remote POST address for scheduled exports, can be overriden via CRON using the <code>to</code> argument. Default is empty.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<?php
	ob_end_flush();

}

// Returns the disabled HTML template for the Enable CRON and Secret Export Key options for the Settings screen
function jigo_ce_export_settings_cron() {

	$jigo_cd_url = 'http://www.visser.com.au/jigoshop/plugins/exporter-deluxe/';
	$jigo_cd_link = sprintf( '<a href="%s" target="_blank">' . __( 'Store Exporter Deluxe', 'jigo_ce' ) . '</a>', $jigo_cd_url );

	// Scheduled exports
	$order_statuses = jigo_ce_get_order_statuses();
	$auto_interval = 1440;

	// CRON exports
	$secret_key = '-';

	$troubleshooting_url = 'http://www.visser.com.au/documentation/store-exporter-deluxe/usage/';

	ob_start(); ?>
<tr id="xml-settings">
	<td colspan="2" style="padding:0;">
		<hr />
		<h3><?php _e( 'XML Settings', 'jigo_ce' ); ?></h3>
	</td>
</tr>
<tr>
	<th>
		<label><?php _e( 'Attribute display', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<ul>
			<li><label><input type="checkbox" name="xml_attribute_url" value="1" disabled="disabled" /> <?php _e( 'Site Address', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_title" value="1" disabled="disabled" /> <?php _e( 'Site Title', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_date" value="1" disabled="disabled" /> <?php _e( 'Export Date', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_time" value="1" disabled="disabled" /> <?php _e( 'Export Time', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></li>
			<li><label><input type="checkbox" name="xml_attribute_export" value="1" disabled="disabled" /> <?php _e( 'Export Type', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label></li>
		</ul>
		<p class="description"><?php _e( 'Control the visibility of different attributes in the XML export.', 'jigo_ce' ); ?></p>
	</td>
</tr>

<tr id="scheduled-exports">
	<td colspan="2" style="padding:0;">
		<hr />
		<h3><?php _e( 'Scheduled Exports', 'jigo_ce' ); ?></h3>
		<p class="description"><?php _e( 'Configure Store Exporter Deluxe to automatically generate exports.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="enable_auto"><?php _e( 'Enable scheduled exports', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<select id="enable_auto" name="enable_auto">
			<option value="1" disabled="disabled"><?php _e( 'Yes', 'jigo_ce' ); ?></option>
			<option value="0" selected="selected"><?php _e( 'No', 'jigo_ce' ); ?></option>
		</select>
		<p class="description"><?php _e( 'Enabling Scheduled Exports will trigger automated exports at the interval specified under Once every (minutes).', 'jigo_ce' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="auto_type"><?php _e( 'Export type', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<select id="auto_type" name="auto_type">
			<option value="product"><?php _e( 'Products', 'jigo_ce' ); ?></option>
			<option value="category"><?php _e( 'Categories', 'jigo_ce' ); ?></option>
			<option value="tag"><?php _e( 'Tags', 'jigo_ce' ); ?></option>
			<option value="order"><?php _e( 'Orders', 'jigo_ce' ); ?></option>
			<option value="customer"><?php _e( 'Customers', 'jigo_ce' ); ?></option>
			<option value="coupon"><?php _e( 'Coupons', 'jigo_ce' ); ?></option>
		</select>
		<span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
		<p class="description"><?php _e( 'Select the data type you want to export.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="auto_type"><?php _e( 'Export filters', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<ul>
			<li class="export-options order-options">
				<label><?php _e( 'Order Status', 'jigo_ce' ); ?></label>
				<select name="order_filter_status">
					<option value="" selected="selected"><?php _e( 'All', 'jigo_ce' ); ?></option>
<?php foreach( $order_statuses as $order_status ) { ?>
					<option value="<?php echo $order_status->name; ?>" disabled="disabled"><?php echo ucfirst( $order_status->name ); ?></option>
<?php } ?>
				</select>
				<span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
				<p class="description"><?php _e( 'Select the Order Status you want to filter exported Orders by. Default is to include all Order Status options.', 'jigo_ce' ); ?></p>
			</li>
			<li class="export-options order-options">
				<label><?php _e( 'Order Date', 'jigo_ce' ); ?></label>
				<input type="text" size="10" maxlength="10" class="text" disabled="disabled"> to <input type="text" size="10" maxlength="10" class="text" disabled="disabled"><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
				<p class="description"><?php _e( 'Filter the dates of Orders to be included in the export. Default is the date of the first order to today.', 'jigo_ce' ); ?></p>
			</li>
		</ul>
	</td>
</tr>
<tr>
	<th>
		<label for="auto_interval"><?php _e( 'Once every (minutes)', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<input name="auto_interval" type="text" id="auto_interval" value="<?php echo esc_attr( $auto_interval ); ?>" size="4" maxlength="4" class="text" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
		<p class="description"><?php _e( 'Choose how often Store Exporter Deluxe generates new exports. Default is every 1440 minutes (once every 24 hours).', 'jigo_ce' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label><?php _e( 'Export format', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<label><input type="radio" name="auto_format" value="csv" checked="checked" /><?php _e( 'CSV', 'jigo_ce' ); ?> <span class="description"><?php _e( '(Comma separated values)', 'jigo_ce' ); ?></span><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label><br />
		<label><input type="radio" name="auto_format" value="xml" disabled="disabled" /> <?php _e( 'XML', 'jigo_ce' ); ?> <span class="description"><?php _e( '(EXtensible Markup Language)', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label><br />
		<label><input type="radio" name="auto_format" value="xls" disabled="disabled" /> <?php _e( 'Excel (XLS)', 'jigo_ce' ); ?> <span class="description"><?php _e( '(Microsoft Excel 2007)', 'jigo_ce' ); ?><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span></label>
		<p class="description"><?php _e( 'Adjust the export format to generate different export file formats. Default is CSV.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="auto_method"><?php _e( 'Export method', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<select id="auto_method" name="auto_method">
			<option value="archive" selected="selected"><?php _e( 'Archive to WordPress Media', 'jigo_ce' ); ?></option>
			<option value="email" disabled="disabled"><?php _e( 'Send as e-mail', 'jigo_ce' ); ?></option>
			<option value="post" disabled="disabled"><?php _e( 'POST to Remote URL', 'jigo_ce' ); ?></option>
		</select>
		<span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
		<p class="description"><?php _e( 'Choose what Store Exporter Deluxe does with the generated export. Default is to archive the export to the WordPress Media for archival purposes.', 'jigo_ce' ); ?></p>
	</td>
</tr>

<tr id="cron-exports">
	<td colspan="2" style="padding:0;">
		<hr />
		<h3><?php _e( 'CRON Exports', 'jigo_ce' ); ?></h3>
		<p class="description"><?php printf( __( 'Store Exporter Deluxe supports exporting via a command line request, to do this you need to prepare a specific URL and pass it the following required inline parameters. For sample CRON requests and supported arguments consult our <a href="%s" target="_blank">online documentation</a>.', 'jigo_ce' ), $troubleshooting_url ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="enable_cron"><?php _e( 'Enable CRON', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<select id="enable_cron" name="enable_cron">
			<option value="1" disabled="disabled"><?php _e( 'Yes', 'jigo_ce' ); ?></option>
			<option value="0" selected="selected"><?php _e( 'No', 'jigo_ce' ); ?></option>
		</select>
		<p class="description"><?php _e( 'Enabling CRON allows developers to schedule automated exports and connect with Store Exporter Deluxe remotely.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<tr>
	<th>
		<label for="secret_key"><?php _e( 'Export secret key', 'jigo_ce' ); ?></label>
	</th>
	<td>
		<input name="secret_key" type="text" id="secret_key" value="<?php echo esc_attr( $secret_key ); ?>" class="regular-text code" disabled="disabled" /><span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
		<p class="description"><?php _e( 'This secret key (can be left empty to allow unrestricted access) limits access to authorised developers who provide a matching key when working with Store Exporter Deluxe.', 'jigo_ce' ); ?></p>
	</td>
</tr>
<?php
	ob_end_flush();

}
?>