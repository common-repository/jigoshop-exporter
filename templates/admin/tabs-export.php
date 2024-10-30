<ul class="subsubsub">
	<li><a href="#export-type"><?php _e( 'Export Type', 'jigo_ce' ); ?></a> |</li>
	<li><a href="#export-options"><?php _e( 'Export Options', 'jigo_ce' ); ?></a></li>
	<?php do_action( 'jigo_ce_export_quicklinks' ); ?>
</ul>
<!-- .subsubsub -->
<br class="clear" />

<p><?php _e( 'Select an export type from the list below to export entries. Once you have selected an export type you may select the fields you would like to export and optional filters available for each export type. When you click the export button below, Store Exporter will create an export file for you to save to your computer.', 'jigo_ce' ); ?></p>
<div id="poststuff">
	<form method="post" action="<?php echo esc_url( add_query_arg( array( 'failed' => null, 'empty' => null, 'message' => null ) ) ); ?>" id="postform">

		<div id="export-type" class="postbox">
			<h3 class="hndle"><?php _e( 'Export Type', 'jigo_ce' ); ?></h3>
			<div class="inside">
				<p class="description"><?php _e( 'Select the data type you want to export.', 'jigo_ce' ); ?></p>
				<table class="form-table">

					<tr>
						<th>
							<input type="radio" id="product" name="dataset" value="product"<?php disabled( $products, 0 ); ?><?php checked( $export_type, 'product' ); ?> />
							<label for="product"><?php _e( 'Products', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<span class="description">(<?php echo $products; ?>)</span>
						</td>
					</tr>

					<tr>
						<th>
							<input type="radio" id="category" name="dataset" value="category"<?php disabled( $categories, 0 ); ?><?php checked( $export_type, 'category' ); ?> />
							<label for="category"><?php _e( 'Categories', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<span class="description">(<?php echo $categories; ?>)</span>
						</td>
					</tr>

					<tr>
						<th>
							<input type="radio" id="tag" name="dataset" value="tag"<?php disabled( $tags, 0 ); ?><?php checked( $export_type, 'tag' ); ?> />
							<label for="tag"><?php _e( 'Tags', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<span class="description">(<?php echo $tags; ?>)</span>
						</td>
					</tr>

					<tr>
						<th>
							<input type="radio" id="order" name="dataset" value="order"<?php disabled( $orders, 0 ); ?><?php checked( $export_type, 'order' ); ?>/>
							<label for="order"><?php _e( 'Orders', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<span class="description">(<?php echo $orders; ?>)</span>
							<span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
						</td>
					</tr>

					<tr>
						<th>
							<input type="radio" id="customer" name="dataset" value="customer"<?php disabled( $customers, 0 ); ?><?php checked( $export_type, 'customer' ); ?>/>
							<label for="customer"><?php _e( 'Customers', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<span class="description">(<?php echo $customers; ?>)</span>
							<span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
						</td>
					</tr>

					<tr>
						<th>
							<input type="radio" id="user" name="dataset" value="user"<?php disabled( $users, 0 ); ?><?php checked( $export_type, 'user' ); ?>/>
							<label for="user"><?php _e( 'Users', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<span class="description">(<?php echo $users; ?>)</span>
						</td>
					</tr>

					<tr>
						<th>
							<input type="radio" id="coupon" name="dataset" value="coupon"<?php disabled( $coupons, 0 ); ?><?php checked( $export_type, 'coupon' ); ?> />
							<label for="coupon"><?php _e( 'Coupons', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<span class="description">(<?php echo $coupons; ?>)</span>
							<span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
						</td>
					</tr>

				</table>
				<!-- .form-table -->
			</div>
			<!-- .inside -->
		</div>
		<!-- .postbox -->

<?php if( $product_fields ) { ?>
		<div id="export-product" class="export-types">

			<div class="postbox">
				<h3 class="hndle">
					<?php _e( 'Product Fields', 'jigo_ce' ); ?>
				</h3>
				<div class="inside">
	<?php if( $products ) { ?>
					<p class="description"><?php _e( 'Select the Product fields you would like to export, your field selection is saved for future exports.', 'jigo_ce' ); ?></p>
					<p><a href="javascript:void(0)" id="product-checkall" class="checkall"><?php _e( 'Check All', 'jigo_ce' ); ?></a> | <a href="javascript:void(0)" id="product-uncheckall" class="uncheckall"><?php _e( 'Uncheck All', 'jigo_ce' ); ?></a></p>
					<table id="product-fields" class="ui-sortable">

		<?php foreach( $product_fields as $product_field ) { ?>
						<tr>
							<td>
								<label<?php if( isset( $product_field['hover'] ) ) { ?> title="<?php echo $product_field['hover']; ?>"<?php } ?>>
									<input type="checkbox" name="product_fields[<?php echo $product_field['name']; ?>]" class="product_field"<?php ( isset( $product_field['default'] ) ? checked( $product_field['default'], 1 ) : '' ); ?><?php disabled( $product_field['disabled'], 1 ); ?> />
									<?php echo $product_field['label']; ?>
									<?php if( $product_field['disabled'] ) { ?><span class="description"> - <?php printf( __( 'available in %s', 'jigoshop-exporter' ), $jigo_cd_link ); ?></span><?php } ?>
									<input type="hidden" name="product_fields_order[<?php echo $product_field['name']; ?>]" class="field_order" value="<?php echo $product_field['order']; ?>" />
								</label>
							</td>
						</tr>

		<?php } ?>
					</table>
					<p class="submit">
						<input type="submit" id="export_product" value="<?php _e( 'Export Products', 'jigo_ce' ); ?>" class="button-primary" />
					</p>
					<p class="description"><?php _e( 'Can\'t find a particular Product field in the above export list?', 'jigo_ce' ); ?> <a href="<?php echo $troubleshooting_url; ?>" target="_blank"><?php _e( 'Get in touch', 'jigo_ce' ); ?></a>.</p>
	<?php } else { ?>
					<p><?php _e( 'No Products were found.', 'jigo_ce' ); ?></p>
	<?php } ?>
				</div>
			</div>
			<!-- .postbox -->

			<div id="export-products-filters" class="postbox">
				<h3 class="hndle"><?php _e( 'Product Filters', 'jigo_ce' ); ?></h3>
				<div class="inside">

					<?php do_action( 'jigo_ce_export_product_options_before_table' ); ?>

					<table class="form-table">
						<?php do_action( 'jigo_ce_export_product_options_table' ); ?>
					</table>

					<?php do_action( 'jigo_ce_export_product_options_after_table' ); ?>

				</div>
				<!-- .inside -->

			</div>
			<!-- .postbox -->

		</div>
		<!-- #export-product -->

<?php } ?>
<?php if( $category_fields ) { ?>
		<div id="export-category" class="export-types">

			<div class="postbox">
				<h3 class="hndle">
					<?php _e( 'Category Fields', 'jigo_ce' ); ?>
				</h3>
				<div class="inside">
					<p class="description"><?php _e( 'Select the Category fields you would like to export.', 'jigo_ce' ); ?></p>
					<p><a href="javascript:void(0)" id="category-checkall" class="checkall"><?php _e( 'Check All', 'jigo_ce' ); ?></a> | <a href="javascript:void(0)" id="category-uncheckall" class="uncheckall"><?php _e( 'Uncheck All', 'jigo_ce' ); ?></a></p>
					<table id="category-fields" class="ui-sortable">

	<?php foreach( $category_fields as $category_field ) { ?>
						<tr>
							<td>
								<label<?php if( isset( $category_field['hover'] ) ) { ?> title="<?php echo $category_field['hover']; ?>"<?php } ?>>
									<input type="checkbox" name="category_fields[<?php echo $category_field['name']; ?>]" class="category_field"<?php ( isset( $category_field['default'] ) ? checked( $category_field['default'], 1 ) : '' ); ?><?php disabled( $category_field['disabled'], 1 ); ?> />
									<?php echo $category_field['label']; ?>
									<input type="hidden" name="category_fields_order[<?php echo $category_field['name']; ?>]" class="field_order" value="<?php echo $category_field['order']; ?>" />
								</label>
							</td>
						</tr>

	<?php } ?>
					</table>
					<p class="submit">
						<input type="submit" id="export_category" value="<?php _e( 'Export Categories', 'jigo_ce' ); ?> " class="button-primary" />
					</p>
					<p class="description"><?php _e( 'Can\'t find a particular Category field in the above export list?', 'jigo_ce' ); ?> <a href="<?php echo $troubleshooting_url; ?>" target="_blank"><?php _e( 'Get in touch', 'jigo_ce' ); ?></a>.</p>
				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

			<div id="export-categories-filters" class="postbox">
				<h3 class="hndle"><?php _e( 'Category Filters', 'jigo_ce' ); ?></h3>
				<div class="inside">

					<?php do_action( 'jigo_ce_export_category_options_before_table' ); ?>

					<table class="form-table">
						<?php do_action( 'jigo_ce_export_category_options_table' ); ?>
					</table>

					<?php do_action( 'jigo_ce_export_category_options_after_table' ); ?>					<p><label><?php _e( 'Category Sorting', 'jigo_ce' ); ?></label></p>

				</div>
				<!-- .inside -->
			</div>
			<!-- #export-categories-filters -->

		</div>
		<!-- #export-category -->
<?php } ?>
<?php if( $tag_fields ) { ?>
		<div id="export-tag" class="export-types">

			<div class="postbox">
				<h3 class="hndle">
					<?php _e( 'Tag Fields', 'jigo_ce' ); ?>
				</h3>
				<div class="inside">
					<p class="description"><?php _e( 'Select the Tag fields you would like to export.', 'jigo_ce' ); ?></p>
					<p><a href="javascript:void(0)" id="tag-checkall" class="checkall"><?php _e( 'Check All', 'jigo_ce' ); ?></a> | <a href="javascript:void(0)" id="tag-uncheckall" class="uncheckall"><?php _e( 'Uncheck All', 'jigo_ce' ); ?></a></p>
					<table id="tag-fields" class="ui-sortable">

	<?php foreach( $tag_fields as $tag_field ) { ?>
						<tr>
							<td>
								<label<?php if( isset( $tag_field['hover'] ) ) { ?> title="<?php echo $tag_field['hover']; ?>"<?php } ?>>
									<input type="checkbox" name="tag_fields[<?php echo $tag_field['name']; ?>]" class="tag_field"<?php ( isset( $tag_field['default'] ) ? checked( $tag_field['default'], 1 ) : '' ); ?><?php disabled( $tag_field['disabled'], 1 ); ?> />
									<?php echo $tag_field['label']; ?>
									<input type="hidden" name="tag_fields_order[<?php echo $tag_field['name']; ?>]" class="field_order" value="<?php echo $tag_field['order']; ?>" />
								</label>
							</td>
						</tr>

	<?php } ?>
					</table>
					<p class="submit">
						<input type="submit" id="export_tag" value="<?php _e( 'Export Tags', 'jigo_ce' ); ?> " class="button-primary" />
					</p>
					<p class="description"><?php _e( 'Can\'t find a particular Tag field in the above export list?', 'jigo_ce' ); ?> <a href="<?php echo $troubleshooting_url; ?>" target="_blank"><?php _e( 'Get in touch', 'jigo_ce' ); ?></a>.</p>
				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

			<div id="export-tags-filters" class="postbox">
				<h3 class="hndle"><?php _e( 'Product Tag Filters', 'jigo_ce' ); ?></h3>
				<div class="inside">

					<?php do_action( 'jigo_ce_export_tag_options_before_table' ); ?>

					<table class="form-table">
						<?php do_action( 'jigo_ce_export_tag_options_table' ); ?>
					</table>

					<?php do_action( 'jigo_ce_export_tag_options_after_table' ); ?>

				</div>
				<!-- .inside -->
			</div>
			<!-- #export-tags-filters -->

		</div>
		<!-- #export-tag -->

<?php } ?>
<?php if( $order_fields ) { ?>
		<div id="export-order" class="export-types">

			<div class="postbox">
				<h3 class="hndle">
					<?php _e( 'Order Fields', 'jigo_ce' ); ?>
				</h3>
				<div class="inside">

	<?php if( $orders ) { ?>
					<p class="description"><?php _e( 'Select the Order fields you would like to export.', 'jigo_ce' ); ?></p>
					<p><a href="javascript:void(0)" id="order-checkall" class="checkall"><?php _e( 'Check All', 'jigo_ce' ); ?></a> | <a href="javascript:void(0)" id="order-uncheckall" class="uncheckall"><?php _e( 'Uncheck All', 'jigo_ce' ); ?></a></p>
					<table id="order-fields" class="ui-sortable">

		<?php foreach( $order_fields as $order_field ) { ?>
						<tr>
							<td>
								<label<?php if( isset( $order_field['hover'] ) ) { ?> title="<?php echo $order_field['hover']; ?>"<?php } ?>>
									<input type="checkbox" name="order_fields[<?php echo $order_field['name']; ?>]" class="order_field"<?php ( isset( $order_field['default'] ) ? checked( $order_field['default'], 1 ) : '' ); ?> disabled="disabled" />
									<?php echo $order_field['label']; ?>
									<input type="hidden" name="order_fields_order[<?php echo $order_field['name']; ?>]" class="field_order" value="<?php echo $order_field['order']; ?>" />
								</label>
							</td>
						</tr>

		<?php } ?>
					</table>
					<p class="submit">
						<input type="button" class="button button-disabled" value="<?php _e( 'Export Orders', 'jigo_ce' ); ?>" />
					</p>
					<p class="description"><?php _e( 'Can\'t find a particular Order field in the above export list?', 'jigo_ce' ); ?> <a href="<?php echo $troubleshooting_url; ?>" target="_blank"><?php _e( 'Get in touch', 'jigo_ce' ); ?></a>.</p>
	<?php } else { ?>
					<p><?php _e( 'No Orders have been found.', 'jigo_ce' ); ?></p>
	<?php } ?>

				</div>
			</div>
			<!-- .postbox -->

			<div id="export-orders-filters" class="postbox">
				<h3 class="hndle"><?php _e( 'Order Filters', 'jigo_ce' ); ?></h3>
				<div class="inside">

					<?php do_action( 'jigo_ce_export_order_options_before_table' ); ?>

					<table class="form-table">
						<?php do_action( 'jigo_ce_export_order_options_table' ); ?>
					</table>

					<?php do_action( 'jigo_ce_export_order_options_after_table' ); ?>

				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

		</div>
		<!-- #export-order -->

<?php } ?>
<?php if( $customer_fields ) { ?>
		<div id="export-customer" class="export-types">

			<div class="postbox">
				<h3 class="hndle">
					<?php _e( 'Customer Fields', 'jigo_ce' ); ?>
				</h3>
				<div class="inside">
	<?php if( $customers ) { ?>
					<p class="description"><?php _e( 'Select the Customer fields you would like to export.', 'jigo_ce' ); ?></p>
					<p><a href="javascript:void(0)" id="customer-checkall" class="checkall"><?php _e( 'Check All', 'jigo_ce' ); ?></a> | <a href="javascript:void(0)" id="customer-uncheckall" class="uncheckall"><?php _e( 'Uncheck All', 'jigo_ce' ); ?></a></p>
					<table>

		<?php foreach( $customer_fields as $customer_field ) { ?>
						<tr>
							<td>
								<label<?php if( isset( $customer_field['hover'] ) ) { ?> title="<?php echo $customer_field['hover']; ?>"<?php } ?>>
									<input type="checkbox" name="customer_fields[<?php echo $customer_field['name']; ?>]" class="customer_field"<?php ( isset( $customer_field['default'] ) ? checked( $customer_field['default'], 1 ) : '' ); ?> disabled="disabled" />
									<?php echo $customer_field['label']; ?>
									<input type="hidden" name="customer_fields_order[<?php echo $customer_field['name']; ?>]" class="field_order" value="<?php echo $customer_field['order']; ?>" />
								</label>
							</td>
						</tr>

		<?php } ?>
					</table>
					<p class="submit">
						<input type="button" class="button button-disabled" value="<?php _e( 'Export Customers', 'jigo_ce' ); ?>" />
					</p>
					<p class="description"><?php _e( 'Can\'t find a particular Customer field in the above export list?', 'jigo_ce' ); ?> <a href="<?php echo $troubleshooting_url; ?>" target="_blank"><?php _e( 'Get in touch', 'jigo_ce' ); ?></a>.</p>
	<?php } else { ?>
					<p><?php _e( 'No Customers have been found.', 'jigo_ce' ); ?></p>
	<?php } ?>
				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

			<div id="export-customers-filters" class="postbox">
				<h3 class="hndle"><?php _e( 'Customer Filters', 'jigo_ce' ); ?></h3>
				<div class="inside">

					<?php do_action( 'jigo_ce_export_customer_options_before_table' ); ?>

					<table class="form-table">
						<?php do_action( 'jigo_ce_export_customer_options_table' ); ?>
					</table>

					<?php do_action( 'jigo_ce_export_customer_options_after_table' ); ?>

				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

		</div>
		<!-- #export-customer -->

<?php } ?>
<?php if( $user_fields ) { ?>
		<div id="export-user" class="export-types">

			<div class="postbox">
				<h3 class="hndle">
					<?php _e( 'User Fields', 'jigo_ce' ); ?>
				</h3>
				<div class="inside">
	<?php if( $users ) { ?>
					<p class="description"><?php _e( 'Select the User fields you would like to export.', 'jigo_ce' ); ?></p>
					<p><a href="javascript:void(0)" id="user-checkall" class="checkall"><?php _e( 'Check All', 'jigo_ce' ); ?></a> | <a href="javascript:void(0)" id="user-uncheckall" class="uncheckall"><?php _e( 'Uncheck All', 'jigo_ce' ); ?></a></p>
					<table>

		<?php foreach( $user_fields as $user_field ) { ?>
						<tr>
							<td>
								<label<?php if( isset( $user_field['hover'] ) ) { ?> title="<?php echo $user_field['hover']; ?>"<?php } ?>>
									<input type="checkbox" name="user_fields[<?php echo $user_field['name']; ?>]" class="user_field"<?php ( isset( $user_field['default'] ) ? checked( $user_field['default'], 1 ) : '' ); ?><?php disabled( $user_field['disabled'], 1 ); ?> />
									<?php echo $user_field['label']; ?>
									<?php if( $user_field['disabled'] ) { ?><span class="description"> - <?php printf( __( 'available in %s', 'jigoshop-exporter' ), $jigo_cd_link ); ?></span><?php } ?>
									<input type="hidden" name="user_fields_order[<?php echo $user_field['name']; ?>]" class="field_order" value="<?php echo $user_field['order']; ?>" />
								</label>
							</td>
						</tr>

		<?php } ?>
					</table>
					<p class="submit">
						<input type="submit" id="export_users" class="button-primary" value="<?php _e( 'Export Users', 'jigo_ce' ); ?>" />
					</p>
					<p class="description"><?php _e( 'Can\'t find a particular User field in the above export list?', 'jigo_ce' ); ?> <a href="<?php echo $troubleshooting_url; ?>" target="_blank"><?php _e( 'Get in touch', 'jigo_ce' ); ?></a>.</p>
	<?php } else { ?>
					<p><?php _e( 'No Users have been found.', 'jigo_ce' ); ?></p>
	<?php } ?>
				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

			<div id="export-users-filters" class="postbox">
				<h3 class="hndle"><?php _e( 'User Filters', 'jigo_ce' ); ?></h3>
				<div class="inside">

					<?php do_action( 'jigo_ce_export_user_options_before_table' ); ?>

					<table class="form-table">
						<?php do_action( 'jigo_ce_export_user_options_table' ); ?>
					</table>

					<?php do_action( 'jigo_ce_export_user_options_after_table' ); ?>

				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

		</div>
		<!-- #export-user -->

<?php } ?>
<?php if( $coupon_fields ) { ?>
		<div id="export-coupon" class="export-types">

			<div class="postbox">
				<h3 class="hndle">
					<?php _e( 'Coupon Fields', 'jigo_ce' ); ?>
				</h3>
				<div class="inside">
	<?php if( $coupons ) { ?>
					<p class="description"><?php _e( 'Select the Coupon fields you would like to export.', 'jigo_ce' ); ?></p>
					<p><a href="javascript:void(0)" id="coupon-checkall" class="checkall"><?php _e( 'Check All', 'jigo_ce' ); ?></a> | <a href="javascript:void(0)" id="coupon-uncheckall" class="uncheckall"><?php _e( 'Uncheck All', 'jigo_ce' ); ?></a></p>
					<table id="coupon-fields" class="ui-sortable">

		<?php foreach( $coupon_fields as $coupon_field ) { ?>
						<tr>
							<td>
								<label<?php if( isset( $coupon_field['hover'] ) ) { ?> title="<?php echo $coupon_field['hover']; ?>"<?php } ?>>
									<input type="checkbox" name="coupon_fields[<?php echo $coupon_field['name']; ?>]" class="coupon_field"<?php ( isset( $coupon_field['default'] ) ? checked( $coupon_field['default'], 1 ) : '' ); ?> disabled="disabled" />
									<?php echo $coupon_field['label']; ?>
									<input type="hidden" name="coupon_fields_order[<?php echo $coupon_field['name']; ?>]" class="field_order" value="<?php echo $coupon_field['order']; ?>" />
								</label>
							</td>
						</tr>

		<?php } ?>
					</table>
					<p class="submit">
						<input type="button" class="button button-disabled" value="<?php _e( 'Export Coupons', 'jigo_ce' ); ?>" />
					</p>
					<p class="description"><?php _e( 'Can\'t find a particular Coupon field in the above export list?', 'jigo_ce' ); ?> <a href="<?php echo $troubleshooting_url; ?>" target="_blank"><?php _e( 'Get in touch', 'jigo_ce' ); ?></a>.</p>
	<?php } else { ?>
					<p><?php _e( 'No Coupons have been found.', 'jigo_ce' ); ?></p>
	<?php } ?>
				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

			<div id="export-coupons-filters" class="postbox">
				<h3 class="hndle"><?php _e( 'Coupon Filters', 'jigo_ce' ); ?></h3>
				<div class="inside">

					<?php do_action( 'jigo_ce_export_coupon_options_before_table' ); ?>

					<table class="form-table">
						<?php do_action( 'jigo_ce_export_coupon_options_table' ); ?>
					</table>

					<?php do_action( 'jigo_ce_export_coupon_options_after_table' ); ?>

				</div>
				<!-- .inside -->
			</div>
			<!-- .postbox -->

		</div>
		<!-- #export-coupon -->

<?php } ?>
		<div class="postbox" id="export-options">
			<h3 class="hndle"><?php _e( 'Export Options', 'jigo_ce' ); ?></h3>
			<div class="inside">
				<p class="description"><?php _e( 'You can find additional export options under the Settings tab at the top of this screen.', 'jigo_ce' ); ?></p>

				<?php do_action( 'jigo_ce_export_options_before' ); ?>

				<table class="form-table">

					<?php do_action( 'jigo_ce_export_options' ); ?>

					<tr class="export-options product-options">
						<th><label for=""><?php _e( 'Up-sells formatting', 'jigo_ce' ); ?></label></th>
						<td>
							<label><input type="radio" name="product_upsell_formatting" value="0"<?php checked( $upsell_formatting, 0 ); ?> />&nbsp;<?php _e( 'Export Up-Sells as Product ID', 'jigo_ce' ); ?></label><br />
							<label><input type="radio" name="product_upsell_formatting" value="1"<?php checked( $upsell_formatting, 1 ); ?> />&nbsp;<?php _e( 'Export Up-Sells as Product SKU', 'jigo_ce' ); ?></label>
							<p class="description"><?php _e( 'Choose the up-sell formatting that is accepted by your Jigoshop import Plugin (e.g. Product Importer Deluxe, Jigoshop CSV Product Importer, etc.).', 'jigo_ce' ); ?></p>
						</td>
					</tr>

					<tr class="export-options product-options">
						<th><label for=""><?php _e( 'Cross-sells formatting', 'jigo_ce' ); ?></label></th>
						<td>
							<label><input type="radio" name="product_crosssell_formatting" value="0"<?php checked( $crosssell_formatting, 0 ); ?> />&nbsp;<?php _e( 'Export Cross-Sells as Product ID', 'jigo_ce' ); ?></label><br />
							<label><input type="radio" name="product_crosssell_formatting" value="1"<?php checked( $crosssell_formatting, 1 ); ?> />&nbsp;<?php _e( 'Export Cross-Sells as Product SKU', 'jigo_ce' ); ?></label>
							<p class="description"><?php _e( 'Choose the cross-sell formatting that is accepted by your Jigoshop import Plugin (e.g. Product Importer Deluxe, Jigoshop CSV Product Importer, etc.).', 'jigo_ce' ); ?></p>
						</td>
					</tr>

					<tr>
						<th>
							<label for="offset"><?php _e( 'Volume offset', 'jigo_ce' ); ?></label> / <label for="limit_volume"><?php _e( 'Limit volume', 'jigo_ce' ); ?></label>
						</th>
						<td>
							<input type="text" size="3" id="offset" name="offset" value="<?php echo esc_attr( $offset ); ?>" size="5" class="text" title="<?php _e( 'Volume Offset', 'jigo_ce' ); ?>" /> <?php _e( 'to', 'jigo_ce' ); ?> <input type="text" size="3" id="limit_volume" name="limit_volume" value="<?php echo esc_attr( $limit_volume ); ?>" size="5" class="text" title="<?php _e( 'Limit Volume', 'jigo_ce' ); ?>" />
							<p class="description"><?php _e( 'Volume offset and limit allows for partial exporting of a export type (e.g. records 0 to 500, etc.). This is useful when encountering timeout and/or memory errors during the a large or memory intensive export. To be used effectively both fields must be filled. By default this is not used and is left empty.', 'jigo_ce' ); ?></p>
						</td>
					</tr>

					<?php do_action( 'jigo_ce_export_options_table_after' ); ?>

				</table>

				<?php do_action( 'jigo_ce_export_options_after' ); ?>

			</div>
		</div>
		<!-- .postbox -->

		<?php do_action( 'jigo_ce_after_options' ); ?>

		<input type="hidden" name="action" value="export" />
		<?php wp_nonce_field( 'manual_export', 'jigo_ce_export' ); ?>
	</form>

	<?php do_action( 'jigo_ce_export_after_form' ); ?>

	<?php do_action( 'jigo_ce_before_modules' ); ?>

	<div id="export-modules" class="postbox">
		<h3 class="hndle"><?php _e( 'Export Modules', 'jigo_ce' ); ?></h3>
		<div class="inside">
			<p><?php _e( 'Export store details from other Jigoshop and WordPress Plugins, simply install and activate one of the below Plugins to enable those additional export options.', 'jigo_ce' ); ?></p>
<?php if( $modules ) { ?>
			<div class="table table_content">
				<table class="jigo_vm_version_table">
	<?php foreach( $modules as $module ) { ?>
					<tr>
						<td class="export_module">
		<?php if( $module['description'] ) { ?>
							<strong><?php echo $module['title']; ?></strong>: <span class="description"><?php echo $module['description']; ?></span>
		<?php } else { ?>
							<strong><?php echo $module['title']; ?></strong>
		<?php } ?>
						</td>
						<td class="status">
							<div class="<?php jigo_ce_modules_status_class( $module['status'] ); ?>">
		<?php if( $module['status'] == 'active' ) { ?>
								<div class="dashicons dashicons-yes" style="color:#008000;"></div><?php jigo_ce_modules_status_label( $module['status'] ); ?>
		<?php } else { ?>
			<?php if( $module['url'] ) { ?>
								<?php if( isset( $module['slug'] ) ) { echo '<div class="dashicons dashicons-download" style="color:#0074a2;"></div>'; } else { echo '<div class="dashicons dashicons-admin-links"></div>'; } ?>&nbsp;<a href="<?php echo $module['url']; ?>" target="_blank"<?php if( isset( $module['slug'] ) ) { echo ' title="' . __( 'Install via WordPress Plugin Directory', 'jigo_ce' ) . '"'; } else { echo ' title="' . __( 'Visit the Plugin website', 'jigo_ce' ) . '"'; } ?>><?php jigo_ce_modules_status_label( $module['status'] ); ?></a>
			<?php } ?>
		<?php } ?>
							</div>
						</td>
					</tr>
	<?php } ?>
				</table>
			</div>
			<!-- .table -->
<?php } else { ?>
			<p><?php _e( 'No export modules are available at this time.', 'jigo_ce' ); ?></p>
<?php } ?>
		</div>
		<!-- .inside -->
	</div>
	<!-- .postbox -->

	<?php do_action( 'jigo_ce_after_modules' ); ?>

</div>
<!-- #poststuff -->
