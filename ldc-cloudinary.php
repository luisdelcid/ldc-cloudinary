<?php
/**
 * Author: Luis del Cid
 * Author URI: https://luisdelcid.com/
 * Description: The LDC_Cloudinary::get_thumbnail_id method generates a thumbnail for an image attachment based on Cloudinary options defined on the fly and inserts an attachment into the media library. It returns the ID of the entry created in the wp_posts table.
 * Domain Path:
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network:
 * Plugin Name: LDC Cloudinary
 * Plugin URI: https://luisdelcid.com/ldc-cloudinary/
 * Text Domain: ldc-cloudinary
 * Version: 0.4.10.3
 */
 // ----------------------------------------------------------------------------------------------------

	defined('ABSPATH') or die('No script kiddies please!');

 // ----------------------------------------------------------------------------------------------------

	class LDC_Cloudinary {

	 // ------------------------------------------------------------------------------------------------

		static private $continue = false;

	 // ------------------------------------------------------------------------------------------------

		static private function generate_thumbnail_id($attachment_id = 0, $options = array(), $post_id = 0){
			$r = \Cloudinary\Uploader::upload(get_attached_file($attachment_id), $options);
			if(!$r instanceof \Cloudinary\Error and isset($r['secure_url'])){
				$id = self::sideload_file($r['secure_url'], $post_id);
				if($id){
					update_post_meta($attachment_id, '_ldc_cloudinary_' . md5($attachment_id . '-' . wp_json_encode($options)), $id);
					return $id;
				}
			}
			return 0;
		}

	 // ------------------------------------------------------------------------------------------------

		static public function get_thumbnail_id($attachment_id = 0, $options = array()){
			if(self::$continue and wp_attachment_is_image($attachment_id)){
				ksort($options);
				$cloudinary_image = get_post_meta($attachment_id, '_ldc_cloudinary_' . md5($attachment_id . '-' . wp_json_encode($options)), true);
				if(!$cloudinary_image){
					$cloudinary_image = self::generate_thumbnail_id($attachment_id, $options, wp_get_post_parent_id($attachment_id));
				}
				return $cloudinary_image;
			}
			return 0;
		}

	 // ------------------------------------------------------------------------------------------------

		static public function init(){
			if(defined('LDC_CLOUDINARY_CLOUD_NAME') and defined('LDC_CLOUDINARY_API_KEY') and defined('LDC_CLOUDINARY_API_SECRET')){
				require_once(plugin_dir_path(__FILE__) . 'vendor/autoload.php');
				\Cloudinary::config(array( 
					'cloud_name' => LDC_CLOUDINARY_CLOUD_NAME,
					'api_key' => LDC_CLOUDINARY_API_KEY,
					'api_secret' => LDC_CLOUDINARY_API_SECRET,
				));
				if(!is_admin()){
					require_once(ABSPATH . 'wp-admin/includes/file.php');
					require_once(ABSPATH . 'wp-admin/includes/image.php');
					require_once(ABSPATH . 'wp-admin/includes/media.php');
				}
				self::$continue = true;
			}
			Puc_v4_Factory::buildUpdateChecker('https://github.com/luisdelcid/ldc-cloudinary/', __FILE__, 'ldc-cloudinary');
		}

	 // ------------------------------------------------------------------------------------------------

		static private function sideload_file($url = '', $post_id = null){
			$file_array = array(
				'tmp_name' => download_url($url)
			);
			if(!is_wp_error($file_array['tmp_name'])){
				$file_array['name'] = basename($url);
				$attachment_id = media_handle_sideload($file_array, $post_id);
				if(is_wp_error($attachment_id)){
					@unlink($file_array['tmp_name']);
				} else {
					return $attachment_id;
				}
			}
			return 0;
		}

	 // ------------------------------------------------------------------------------------------------

	}

 // ----------------------------------------------------------------------------------------------------

	LDC_Cloudinary::init();

 // ----------------------------------------------------------------------------------------------------

