<ul class="subsubsub">
	<li><a href="<?php echo esc_url( add_query_arg( 'filter', null ) ); ?>"<?php jigo_ce_archives_quicklink_current( 'all' ); ?>><?php _e( 'All', 'jigo_ce' ); ?> <span class="count">(<?php echo jigo_ce_archives_quicklink_count(); ?>)</span></a> |</li>
	<li><a href="<?php echo esc_url( add_query_arg( 'filter', 'product' ) ); ?>"<?php jigo_ce_archives_quicklink_current( 'product' ); ?>><?php _e( 'Products', 'jigo_ce' ); ?> <span class="count">(<?php echo jigo_ce_archives_quicklink_count( 'product' ); ?>)</span></a> |</li>
	<li><a href="<?php echo esc_url( add_query_arg( 'filter', 'category' ) ); ?>"<?php jigo_ce_archives_quicklink_current( 'category' ); ?>><?php _e( 'Categories', 'jigo_ce' ); ?> <span class="count">(<?php echo jigo_ce_archives_quicklink_count( 'category' ); ?>)</span></a> |</li>
	<li><a href="<?php echo esc_url( add_query_arg( 'filter', 'tag' ) ); ?>"<?php jigo_ce_archives_quicklink_current( 'tag' ); ?>><?php _e( 'Tags', 'jigo_ce' ); ?> <span class="count">(<?php echo jigo_ce_archives_quicklink_count( 'tag' ); ?>)</span></a> |</li>
	<li><a href="<?php echo esc_url( add_query_arg( 'filter', 'order' ) ); ?>"<?php jigo_ce_archives_quicklink_current( 'order' ); ?>><?php _e( 'Orders', 'jigo_ce' ); ?> <span class="count">(<?php echo jigo_ce_archives_quicklink_count( 'order' ); ?>)</span></a> |</li>
	<li><a href="<?php echo esc_url( add_query_arg( 'filter', 'customer' ) ); ?>"<?php jigo_ce_archives_quicklink_current( 'customer' ); ?>><?php _e( 'Customers', 'jigo_ce' ); ?> <span class="count">(<?php echo jigo_ce_archives_quicklink_count( 'customer' ); ?>)</span></a> |</li>
	<li><a href="<?php echo esc_url( add_query_arg( 'filter', 'coupon' ) ); ?>"<?php jigo_ce_archives_quicklink_current( 'coupon' ); ?>><?php _e( 'Coupons', 'jigo_ce' ); ?> <span class="count">(<?php echo jigo_ce_archives_quicklink_count( 'coupon' ); ?>)</span></a></li>
</ul>
<!-- .subsubsub -->
<br class="clear" />
<form action="" method="GET">
	<table class="widefat fixed media" cellspacing="0">
		<thead>

			<tr>
				<th scope="col" id="icon" class="manage-column column-icon"></th>
				<th scope="col" id="title" class="manage-column column-title"><?php _e( 'Filename', 'jigo_ce' ); ?></th>
				<th scope="col" class="manage-column column-type"><?php _e( 'Type', 'jigo_ce' ); ?></th>
				<th scope="col" class="manage-column column-author"><?php _e( 'Author', 'jigo_ce' ); ?></th>
				<th scope="col" id="title" class="manage-column column-title"><?php _e( 'Date', 'jigo_ce' ); ?></th>
			</tr>

		</thead>
		<tfoot>

			<tr>
				<th scope="col" class="manage-column column-icon"></th>
				<th scope="col" class="manage-column column-title"><?php _e( 'Filename', 'jigo_ce' ); ?></th>
				<th scope="col" class="manage-column column-type"><?php _e( 'Type', 'jigo_ce' ); ?></th>
				<th scope="col" class="manage-column column-author"><?php _e( 'Author', 'jigo_ce' ); ?></th>
				<th scope="col" class="manage-column column-title"><?php _e( 'Date', 'jigo_ce' ); ?></th>
			</tr>

		</tfoot>
		<tbody id="the-list">

<?php if( $files ) { ?>
	<?php foreach( $files as $file ) { ?>
			<tr id="post-<?php echo $file->ID; ?>" class="author-self status-<?php echo $file->post_status; ?>" valign="top">
				<td class="column-icon media-icon">
					<?php echo $file->media_icon; ?>
				</td>
				<td class="post-title page-title column-title">
					<strong><a href="<?php echo $file->guid; ?>" class="row-title"><?php echo $file->post_title; ?></a></strong>
					<div class="row-actions">
						<span class="view"><a href="<?php echo get_edit_post_link( $file->ID ); ?>" title="<?php _e( 'Edit', 'jigo_ce' ); ?>"><?php _e( 'Edit', 'jigo_ce' ); ?></a></span> | 
						<span class="trash"><a href="<?php echo get_delete_post_link( $file->ID, '', true ); ?>" title="<?php _e( 'Delete Permanently', 'jigo_ce' ); ?>"><?php _e( 'Delete', 'jigo_ce' ); ?></a></span>
					</div>
				</td>
				<td class="title">
					<a href="<?php echo esc_url( add_query_arg( 'filter', $file->export_type ) ); ?>"><?php echo $file->export_type_label; ?></a>
				</td>
				<td class="author column-author"><?php echo $file->post_author_name; ?></td>
				<td class="date column-date"><?php echo $file->post_date; ?></td>
			</tr>
	<?php } ?>
<?php } else { ?>
			<tr id="post-<?php echo $file->ID; ?>" class="author-self" valign="top">
				<td colspan="3" class="colspanchange"><?php _e( 'No past exports were found.', 'jigo_ce' ); ?></td>
			</tr>
<?php } ?>

		</tbody>
	</table>
	<div class="tablenav bottom">
		<div class="tablenav-pages one-page">
			<span class="displaying-num"><?php printf( __( '%d items', 'jigo_ce' ), jigo_ce_archives_quicklink_count() ); ?></span>
		</div>
		<!-- .tablenav-pages -->
		<br class="clear">
	</div>
	<!-- .tablenav -->
</form>