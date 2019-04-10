=== LDC Cloudinary ===
Contributors: @luisdelcid
Donate link: https://luisdelcid.com/ldc-cloudinary/
Tags: cloudinary
Requires at least: 5.0
Tested up to: 5.1.1
Stable tag: 0.4.10.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The LDC_Cloudinary::get_thumbnail_id method generates a thumbnail for an image attachment based on Cloudinary options defined on the fly and inserts an attachment into the media library. It returns the ID of the entry created in the wp_posts table.

== Description ==

The LDC_Cloudinary::get_thumbnail_id method generates a thumbnail for an image attachment based on Cloudinary options defined on the fly and inserts an attachment into the media library. It returns the ID of the entry created in the wp_posts table.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/ldc-cloudinary` directory.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Define the `LDC_CLOUDINARY_CLOUD_NAME`, `LDC_CLOUDINARY_API_KEY` and `LDC_CLOUDINARY_API_SECRET` constants in the `wp-config.php` file. Here's a link to [Cloudflare Docs](https://cloudinary.com/documentation/php_integration#configuration "Cloudflare Docs").
4. Use the `LDC_Cloudinary::get_thumbnail_id` method to get/generate a thumbnail for an image attachment.

== Screenshots ==

1. [https://luisdelcid.com/ldc-cloudinary-images/banner-772x250.png  Banner.]
2. [https://luisdelcid.com/ldc-cloudinary-images/banner-1544x500.png  Banner (Retina).]
3. [https://luisdelcid.com/ldc-cloudinary-images/icon-128x128.png  Icon.]
4. [https://luisdelcid.com/ldc-cloudinary-images/icon-256x256.png  Icon (Retina).]

== Changelog ==

= 0.4.10.1 =
* Second release

= 0.4.10 =
* First release