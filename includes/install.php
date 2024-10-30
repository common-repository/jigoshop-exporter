<?php
// De-activate Store Exporter to limit conflicts
function jigo_ce_deactivate_ce() {

	$plugins = array(
		'jigoshop-exporter/exporter.php',
		'jigoshop-store-exporter/exporter.php'
	);
	deactivate_plugins( $plugins, true );

}

function jigo_ce_install() {

	jigo_ce_create_options();

}

// Trigger the creation of Admin options for this Plugin
function jigo_ce_create_options() {

	$prefix = 'jigo_ce';

	if( !get_option( $prefix . '_export_filename' ) )
		add_option( $prefix . '_export_filename', 'export_%dataset%-%date%-%time%-%random%.csv' );
	if( !get_option( $prefix . '_delete_file' ) )
		add_option( $prefix . '_delete_file', 1 );
	if( !get_option( $prefix . '_delimiter' ) )
		add_option( $prefix . '_delimiter', ',' );
	if( !get_option( $prefix . '_category_separator' ) )
		add_option( $prefix . '_category_separator', '|' );
	if( !get_option( $prefix . '_bom' ) )
		add_option( $prefix . '_bom', 1 );
	if( !get_option( $prefix . '_encoding' ) )
		add_option( $prefix . '_encoding', get_option( 'blog_charset', 'UTF-8' ) );
	if( !get_option( $prefix . '_escape_formatting' ) )
		add_option( $prefix . '_escape_formatting', 'all' );
	if( !get_option( $prefix . '_date_format' ) )
		add_option( $prefix . '_date_format', 1 );

}
?>