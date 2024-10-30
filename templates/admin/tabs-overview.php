<div class="overview-left">

	<h3><a href="<?php echo add_query_arg( 'tab', 'export' ); ?>"><?php _e( 'Export', 'jigo_ce' ); ?></a></h3>
	<p><?php _e( 'Export store details out of Jigoshop into a CSV-formatted file.', 'jigo_ce' ); ?></p>
	<ul class="ul-disc">
		<li>
			<a href="<?php echo add_query_arg( 'tab', 'export' ); ?>#export-product"><?php _e( 'Export Products', 'jigo_ce' ); ?></a>
		</li>
		<li>
			<a href="<?php echo add_query_arg( 'tab', 'export' ); ?>#export-category"><?php _e( 'Export Categories', 'jigo_ce' ); ?></a>
		</li>
		<li>
			<a href="<?php echo add_query_arg( 'tab', 'export' ); ?>#export-tag"><?php _e( 'Export Tags', 'jigo_ce' ); ?></a>
		</li>
		<li>
			<a href="<?php echo add_query_arg( 'tab', 'export' ); ?>#export-order"><?php _e( 'Export Orders', 'jigo_ce' ); ?></a>
			<span class="description">(<?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?>)</span>
		</li>
		<li>
			<a href="<?php echo add_query_arg( 'tab', 'export' ); ?>#export-customer"><?php _e( 'Export Customers', 'jigo_ce' ); ?></a>
			<span class="description">(<?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?>)</span>
		</li>
		<li>
			<a href="<?php echo add_query_arg( 'tab', 'export' ); ?>#export-user"><?php _e( 'Export Users', 'jigo_ce' ); ?></a>
			<span class="description">(<?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?>)</span>
		</li>
		<li>
			<a href="<?php echo add_query_arg( 'tab', 'export' ); ?>#export-coupon"><?php _e( 'Export Coupons', 'jigo_ce' ); ?></a>
			<span class="description">(<?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?>)</span>
		</li>
	</ul>

	<h3><a href="<?php echo add_query_arg( 'tab', 'archive' ); ?>"><?php _e( 'Archives', 'jigo_ce' ); ?></a></h3>
	<p><?php _e( 'Download copies of prior store exports.', 'jigo_ce' ); ?></p>

	<h3><a href="<?php echo add_query_arg( 'tab', 'settings' ); ?>"><?php _e( 'Settings', 'jigo_ce' ); ?></a></h3>
	<p><?php _e( 'Manage CSV export options from a single detailed screen.', 'jigo_ce' ); ?></p>

	<h3><a href="<?php echo add_query_arg( 'tab', 'tools' ); ?>"><?php _e( 'Tools', 'jigo_ce' ); ?></a></h3>
	<p><?php _e( 'Export tools for Jigoshop.', 'jigo_ce' ); ?></p>

	<hr />
	<label class="description">
		<input type="checkbox" disabled="disabled" /> <?php _e( 'Jump to Export screen in the future', 'jigo_ce' ); ?>
		<span class="description"> - <?php printf( __( 'available in %s', 'jigo_ce' ), $jigo_cd_link ); ?></span>
	</label>

</div>
<!-- .overview-left -->
<div class="welcome-panel overview-right">
	<h3>
		<!-- <span><a href="#"><attr title="<?php _e( 'Dismiss this message', 'jigo_ce' ); ?>"><?php _e( 'Dismiss', 'jigo_ce' ); ?></attr></a></span> -->
		<?php _e( 'Upgrade to Pro', 'jigo_ce' ); ?>
	</h3>
	<p class="clear"><?php _e( 'Upgrade to Store Exporter Deluxe to unlock business focused e-commerce features within Store Exporter, including:', 'jigo_ce' ); ?></p>
	<ul class="ul-disc">
		<li><?php _e( 'Select export date ranges', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Export Orders', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Select Order fields to export', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Export custom Order and Order Item meta', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Export Customers', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Select Customer fields to export', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Export Coupons', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Select Coupon fields to export', 'jigo_ce' ); ?></li>
		<li><?php _e( 'CRON / Scheduled Exports', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Export to XML', 'jigo_ce' ); ?></li>
		<li><?php _e( 'Premium Support', 'jigo_ce' ); ?></li>
	</ul>
	<p>
		<a href="<?php echo $jigo_cd_url; ?>" target="_blank" class="button"><?php _e( 'More Features', 'jigo_ce' ); ?></a>&nbsp;
		<a href="<?php echo $jigo_cd_url; ?>" target="_blank" class="button button-primary"><?php _e( 'Buy Now', 'jigo_ce' ); ?></a>
	</p>
</div>
<!-- .overview-right -->