=== Jigoshop - Store Exporter ===

Contributors: visser, visser.labs
Donate link: http://www.visser.com.au/#donations
Tags: e-commerce, jigoshop, shop, cart, ecommerce, export, csv, xml, xls, excel, customers, products, sales, orders, coupons, users
Requires at least: 2.9.2
Tested up to: 4.5.1
Stable tag: 1.5.8

== Description ==

Export store details out of Jigoshop into simple formatted files (e.g. CSV, XML, XLS, etc.).

Features include:

* Export Products (*)
* Export Products by Product Category
* Export Products by Product Status
* Export Products by Type including Variations
* Export Categories
* Export Tags
* Export Orders (**)
* Export Orders by Order Status (**)
* Export Orders by Order Date (**)
* Export Orders by Customers (**)
* Export Customers (**)
* Export Customers by Order Status (**)
* Export Users
* Export Coupons (**)
* Toggle and save export fields
* Field label editor (**)
* Works with WordPress Multisite
* Export to CSV file
* Export to XML file (**)
* Export to Excel 2007 file (**)
* Supports external CRON commands (**)
* Supports scheduled exports (**)

(*) Compatible with Product Importer Deluxe, All in One SEO Pack, Advanced Google Product Feed, WordPress SEO, Ultimate SEO, Per Product Pricing,   and more.

(**) Requries the Pro upgrade to enable additional store export functionality.

For more information visit: http://www.visser.com.au/jigoshop/

== Installation ==

1. Upload the folder 'jigoshop-exporter' to the '/wp-content/plugins/' directory
2. Activate 'Jigoshop - Store Exporter' through the 'Plugins' menu in WordPress

See Usage section before for instructions on how to generate export files.

== Usage ==

1. Open Jigoshop > Store Export from the WordPress Administration
2. Select the Export tab on the Store Exporter screen
3. Select which export type and Jigoshop details you would like to export
4. Click Export
5. Download archived copies of previous exports from the Archives tab

Done!

== Support ==

If you have any problems, questions or suggestions please join the members discussion on our Jigoshop dedicated forum.

http://www.visser.com.au/jigoshop/forums/

== Screenshots ==

1. The overview screen for Store Exporter.
2. Select the data fields to be included in the export, selections are remembered for next export.
3. Each dataset (e.g. Products, Orders, etc.) include filter options to filter by date, status, type, customer and more.
4. A range of export options can be adjusted to suit different languages and file formatting requirements.
5. Export a list of Jigoshop Product Categories into a CSV file.
6. Export a list of Jigoshop Product Tags into a CSV file.
7. Download achived copies of previous exports

== Changelog ==

= 1.5.8 =
* Changed: Enable Archives is disabled by default
* Added: %random% Tag to export filename for random number generation

= 1.5.7 =
* Fixed: Privilege escalation vulnerability (thanks panVagenas & jamesgol)

= 1.5.6 =
* Fixed: Saving Export filename option over-sanitized
* Fixed: Limit volume for Users export
* Fixed: Offset for Users export
* Fixed: Sanitize form fields
* Fixed: Data validation on outputs
* Fixed: Saving of Order in Users export
* Fixed: Saving of Order By in Users export
* Fixed: Count of Customers for large store catalogues

= 1.5.5 =
* Added: Export Users type in basic Store Exporter
* Fixed: Add missing WordPress options for Plugin if not present on activation
* Added: Export type is remembered between screen refreshes
* Changed: Moved Product Sorting widget to products.php
* Changed: Moved Filter Products by Product Category widget to products.php
* Changed: Moved Filter Products by Product Tag widget to products.php
* Changed: Moved Filter Products by Product Status widget to products.php
* Fixed: Conflicts with other WooCommerce Plugins due to shared 'save' form action
* Fixed: Remember column options after exporting Orders

= 1.5.4 =
* Added: Per Product Shipping support for Products export

= 1.5.3 =
* Fixed: PHP warning notice in Orders export
* Added: Rename of export files across Plugin
* Added: Export Users
* Added: Support for User ID in Users export
* Added: Support for Username in Users export
* Added: Support for User Role in Users export
* Added: Support for First Name in Users export
* Added: Support for Last Name in Users export
* Added: Support for Full Name in Users export
* Added: Support for Nickname in Users export
* Added: Support for E-mail in Users export
* Added: Support for Website in Users export
* Added: Sorting support for Users export
* Added: Sorting options for Coupons
* Changed: Preparations for sortable export column
* Fixed: URL to Add New export button after empty export
* Added: jQuery checks for functions before running
* Fixed: Empty exports
* Changed: Better detection of empty exports
* Changed: Better detection of empty data types
* Added: Customer Filter to Export screen
* Added: Filter Customers by Order Status option 
* Added: Using is_wp_error() throughout CPT and Term requests

= 1.5.2 =
* Fixed: Coupon export as XML
* Fixed: Order export as XML
* Fixed: Customer export as XML
* Fixed: Compatibility with WordPress 3.9.1
* Added: Product export support for Advanced Google Product Feed
* Added: Product export support for All in One SEO Pack
* Added: Product export support for WordPress SEO
* Added: Product export support for Ultimate SEO
* Fixed: Fatal error affecting CRON export for XML export
* Fixed: Price formatting issue

= 1.5.1 =
* Fixed: Clearing the Limit Volume or Offset values would not be saved
* Fixed: Force file extension if removed from the Filename option on Settings screen
* Changed: Reduced memory load by storing $args in $export global

= 1.5 =
* Fixed: Fatal error if Store Exporter is not activated

= 1.4.9 =
* Changed: Replaced jigo_ce_save_csv_file_attachment() with generic jigo_ce_save_file_attachment()
* Changed: Replaced jigo_ce_save_csv_file_guid() with generic jigo_ce_save_file_guid()
* Changed: Replaced jigo_ce_save_csv_file_details() with generic jigo_ce_save_file_details()
* Changed: Replaced jigo_ce_update_csv_file_detail() with generic jigo_ce_update_file_detail()
* Changed: Moved jigo_ce_save_file_details() into common Plugin space
* Changed: Added third allow_empty property to custom get_option()
* Added: Disabled support for XML Export Format under Export Option
* Changed: Created new functions-csv.php file
* Changed: Moved jigo_ce_generate_csv_filename() to functions-csv.php
* Changed: Moved jigo_ce_generate_csv_header() to functions-csv.php

= 1.4.8 =
* Fixed: Export error prompt displaying due to WordPress transient

= 1.4.7 =
* Added: Disabled Custom Order Fields widget to Export screen
* Changed: Using WP_Query instead of get_posts for bulk export
* Changed: Cross-Sells and Up-Sells get their own formatting functions
* Added: Toggle visibility of each export types fields within Export Options
* Added: Option for Up-Sells to export Product SKU instead of Product ID
* Added: Option for Cross-Sells to export Product SKU instead of Product ID
* Changed: Toggle visibility of dataset relevant export options
* Changed: Moved Field delimiter option to Settings tab
* Changed: Moved Category separator option to Settings tab
* Changed: Moved Add BOM character option to Settings tab
* Changed: Moved Character encoding option to Settings tab
* Changed: Moved Field escape formatting option to Settings tab
* Changed: Moved Order Item Formatting option to Export Options widget
* Changed: Combined Volume offset and Limit volume
* Added: Skip Overview screen option to Overview screen

= 1.4.6 =
* Fixed: CSV File not being displayed on Media screen
* Changed: An empty weight/height/width/length will make the dimension unit empty
* Added: Setttings tab for managing global export settings
* Added: Custom export filename support with variables: %store_name%, %dataset%, %date%, %time%
* Changed: Moved Date Format option to Settings tab
* Changed: Moved Max unique Order items option to Settings tab
* Changed: Moved Enable Archives options to Settings tab
* Changed: Removed Manage Custom Product Fields link from Export Options
* Changed: Moved Script Timeout option to Settings tab

= 1.4.5 =
* Added: Disabled Custom Product Fields dialog
* Added: Product Up-sell support
* Added: Product Cross-sell support

= 1.4.4 =
* Fixed: Multi-site support resolved
* Changed: Permanently delete failed exports

= 1.4.3 =
* Added: Error notice to explain blank CSV
* Changed: Renamed "Delete temporary CSV after download" to "Enable Archives"
* Changed: Removed jigo_ce_unload_export_global()
* Fixed: Delete WordPress Media on failed export
* Added: Link to Usage document when an error is encountered "Need help?"
* Changed: Using 'export' capability check for Store Export menu
* Changed: Using 'update_plugins' capability check for Jigoshop Plugins Dashboard widget (thanks Marcus!)

= 1.4.2 =
* Added: Order Item Product Variations to Orders export
* Changed: Using new admin notice function
* Changed: Using jigo_ce global less
* Added: PHP defines for Plugin

= 1.4.1 =
* Fixed: Order Status not working on exports
* Fixed: User Role not working on Order exports

= 1.4 =
* Added: Missing common functions for non-Jigoshop installation

= 1.3.9 =
* Added: Notice when non-Jigoshop Plugin is active
* Added: Date formatting independant of WordPress > Settings > General
* Added: Parent Term ID to Categories export
* Added: Order Sorting option
* Added: Product Published and Product Modified to Products export

= 1.3.8 =
* Fixed: Default file encoding can trigger PHP warning
* Added: File encoding support for Categories and Tags
* Added: Product Tags sorting export support
* Added: Category sorting export support
* Added: File encoding for datasets
* Changed: Default file encoding to UTF-8
* Added: Product sorting and ordering
* Changed: Ordering of Export Options
* Added: Separate files for each dataset

= 1.3.7 =
* Changed: Removed broken screenshots
* Fixed: Jigoshop Plugin News widget
* Added: Additional Category column support
* Added: Additional Tag column support
* Fixed: HTML entities now print in plain-text

= 1.3.6 =
* Changed: Icon to Jigoshop standard
* Removed: jigo_is_admin_icon_valid() from common
* Fixed: Label for configurable Product Type
* Fixed: Fatal error on Archives screen
* Changed: Sale Price Dates From/To support

= 1.3.5 =
* Changed: Store Export menu to Export
* Added: Order Tax Total to Orders support
* Fixed: Fatal error refering to woo prefix
* Changed: Included additional Usage steps to readme.txt

= 1.3.4 =
* Added: jQuery Chosen support to Orders Customer dropdown
* Fixed: Incorrect counts on some Export types
* Added: Product ID support
* Added: Post Parent ID support
* Added: Filter Products export by Type
* Added: Sale Price Dates From/To support
* Added: Remove archived export
* Added: Count and filter of archived exports
* Fixed: Hide User ID 0 (guest) from Orders

= 1.3.3 =
* Fixed: Customers export count

= 1.3.2 =
* Added: Additional Customers export fields
* Added: Native jQuery UI support
* Fixed: Various small bugs

= 1.3.1 =
* Fixed: Tags export
* Added: Export Products by Product Tag filter
* Added: Notice for empty export files
* Changed: UI changes to Filter dialogs
* Added: Add New export button
* Fixed: Incorrect filename prefix
* Changed: Free version can see Order, Coupon and Customer export options
* Added: File Download Product support
* Fixed: Datepicker jQuery error
* Added: Escape field formatting option
* Added: New line support
* Added: Support for BOM
* Added: Order Billing Country prefix
* Added: Order Shipping Country prefix
* Fixed: Empty SKU becomes Product ID

= 1.3 =
* Added: Remember field selections

= 1.2.9 =
* Fixed: Surplus cell separator at end of lines

= 1.2.8 =
* Fixed: Export buttons not adjusting Export Dataset
* Added: Select All options to Export
* Added: Partial export support

= 1.2.7 =
* Fixed: Store Export screen title missing

= 1.2.6 =
* Added: Customers support
* Added: Integration with Exporter Deluxe
* Changed: Moved code out of templates

= 1.2.5 =
* Fixed: Export of Tags
* Fixed: Template header bug
* Added: Sales support for Checkout data
* Added: Tabbed viewing on the Exporter screen
* Fixed: Tag generation error

= 1.2.4 =
* Added: Export link to Plugins screen
* Fixed: Category column adding surplus Root and Parent category
* Added: Attribute support (compatible with Product Importer Deluxe
* Changed: Updated readme.txt

= 1.2.3 =
* Added: Added quotes to Product Categories, Tags, etc.
* Changed: Migrated to WordPress Extend
* Added: Support for Coupons

= 1.2.2 =
* Added: Category heirachy support (up to 3 levels deep)
* Fixed: Foreign character support
* Changed: Removed HTML converter in Description and Additional Description
* Changed: More efficient Tag generation
* Fixed: Multiple Tax Classes for Products

= 1.2.1 =
* Added: Visibility support
* Added: Featured support
* Added: Tax Status support
* Added: Customizable support

= 1.2 =
* Changed: Moved Store Export to Jigoshop menu
* Changed: Reduced menu priority to bottom of Jigoshop menu

= 1.1 =
* Fixed: Error in Dashboard Widget

= 1.0 =
* Added: First working release of the Plugin

== Disclaimer ==

It is not responsible for any harm or wrong doing this Plugin may cause. Users are fully responsible for their own use. This Plugin is to be used WITHOUT warranty.