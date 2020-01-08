<?php
/**
 * Helper class.
 *
 *
 * @since	  1.0.0
 * @package	hayyabuild
 * @subpackage hayyabuild/includes
 * @author	 zintaThemes <>
 */

if (! defined( 'ABSPATH' ) || class_exists( 'HayyaBuildHelper' )) return;

class HayyaBuildHelper {

	/**
	 * redirect static varibale
	 *
	 * @since		1.0.0
	 * @access		protected
	 * @var			string	$plugin_name	The string used to uniquely identify this plugin.
	 */
	public static $redirect = array();

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since		1.0.0
	 * @access		protected
	 * @var			string	$plugin_name	The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since		1.0.0
	 * @access		protected
	 * @var			string	$version	The current version of the plugin.
	 */
	protected $version;

	/**
	 *
	 * @since		3.0.0
	 * @access		public
	 * @var 		array		$options
	 */
	public static $options = array();

	/**
	 * construct function
	 *
	 * @access		public
	 * @since		1.0.0
	 */
	public function __construct() {
		return true;
	}

	/**
	 * Admin notices function.
	 *
	 * @since 	1.0.0
	 * @param 	String 		$message 	notice message
	 * @param 	String 		$type 		notice type
	 */
	public static function _notices($message, $type) {
		add_action('admin_notices', function() use ($message, $type) {
			echo '<div class="notice notice-'.esc_attr( $type ).' is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
		});
	} // End __notice()

	/**
	 * check if any of posts pages
	 *
	 * @return     boolean  True if posts page, False otherwise.
	 */
    public static function is_posts_page() {
    	return is_home() || is_single() || is_archive() || is_tag() || is_author() || is_category() || is_date() || is_search();
    }

	/**
	 * add or remove slashes
	 *
	 * @param unknown $content
	 * @param unknown $slashes
	 * @return unknown|boolean
	 */
	public static function _slashes($content = null, $slashes = null ) {
		if ( null !== $content &&  null !== $slashes ) {
			if ( $slashes === 'add' ) return addslashes($content);
			else if ( $slashes === 'strip' ) return stripslashes($content);
		} return false;
	} // End _slashes()

	/**
	 * remove slashes if magic_quotes_gpc() is activated
	 *
	 * @param unknown $content
	 * @return unknown|boolean
	 */
	public static function _strip_magic_quotes($content = null) {
		return stripslashes_deep($content);
		// return get_magic_quotes_gpc() ? self::_slashes($content, 'strip') : $content;
	} // End _slashes()

	/**
	 *  Redirect to edit page after save an new element.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function _redirect($redirect = array()) {
		$redirect = self::$redirect;
		if ( is_array($redirect) && !empty($redirect) ) {
			if (isset($redirect['id']) && !empty($redirect['id'])) wp_redirect(admin_url('/admin.php?page=hayyabuild&id='.$redirect['id'].'&action=edit&update=ok'));
			if (isset($redirect['list']) && $redirect['list'] === 'notfound') wp_redirect(admin_url('/admin.php?page=hayyabuild&notfound=1'));
		}
	} // End _redirect()

	/**
	 *  check is it HayyaBuild pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function _is_hayy_pages() {
		return 'hayyabuild' === self::_get( 'page' ) || 'hayyabuild_addh' === self::_get( 'page' ) || 'hayyabuild_addc' === self::_get( 'page' ) || 'hayyabuild_addf' === self::_get( 'page' ) || 'hayyabuild_settings' === self::_get( 'page' ) || 'hayyabuild_help' === self::_get( 'page' );
	} // End _is_hayy_pages()

	/**
	 *  check admin main pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function _is_main_pages() {
		return 'hayyabuild' === self::_get( 'page' );
	} // End _is_main_pages()

	/**
	 *  check admin add new pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function _is_settings_page() {
		return 'hayyabuild_settings' === self::_get( 'page' );
	} // End _is_settings_pages()

	/**
	 *  check admin add new pages.
	 *
	 * @access 	public
	 * @since 	3.0.0
	 */
	public static function _is_help_page() {
		return  'hayyabuild_help' === self::_get( 'page' );
	} // End _is_help_pages()

	/**
	 *
	 * @access		public
	 * @since		1.0.0
	 * @param 		string		$param
	 */
	public static function _get($param) {
		return ( isset( $_GET[$param] ) ) ? wp_unslash( $_GET[$param] ) : false;
	} // End _get()

	/**
	 *
	 * @param 		string 		$param
	 */
	public static function _post($param) {
		return ( isset( $_POST[$param] ) ) ? wp_unslash( $_POST[$param] ) : false;
	} // End _post()

	/**
	 *
	 * @since 	1.0.0
	 */
	public static function _empty( $var = null ) {
		return ( null === $var ) ? '' : $var; // TODO: remove this functions
	} // End _empty()

	/**
	 * Get wpdb.
	 *
	 * @since   1.0.0
	 */
	public static function _debug( $message ) {
		return ( ! empty( $message ) ) ? '<div class="_debug">'.$message.'</div>' : '';
	} // End _debug()

	/**
	 * Get HayyaBuild options.
	 *
	 * @since   3.0.0
	 */
	public static function _options( $atts = null ) {
		if ( empty( self::$options ) ) self::$options = get_option('hayyabuild_settings');
		return self::$options;
	} // End _options()

	/**
	 * Get files content.
	 *
	 * @since   3.2.0
	 */
	public static function _get_content( $file = null ) {
		if ( $file && file_exists( $file ) ) {
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}
			if ( is_object( $wp_filesystem ) && $content = $wp_filesystem->get_contents( $file ) ) {
				return $content;
			}
		}
		return false;
	} // End _get_content()

	/**
	 * Check current user
	 *
	 * @since   3.2.0
	 */
	public static function _current_user( $capability = null ) {
		if ( ! function_exists('wp_get_current_user') ) {
			require_once( ABSPATH . 'wp-includes/pluggable.php' );
		}
		if ( function_exists('current_user_can') && function_exists('wp_get_current_user') ) {
			if ( ! $capability ) $capability = 'manage_options';
			if ( is_admin() && current_user_can($capability) ) {
				return true;
			}
		}
		return false;
	} // End _get_content()

	/**
	 *
	 * @since   3.2.0
	 */
	public static function _ajax_nonce($process = null) {
		if ( null === $process ) return check_ajax_referer( $process );
	}

	/**
	 *
	 * @since   3.1.0
	 * @return number
	 */
	public static function _mtime() {
		// $time_start = HayyaBuildHelper::_mtime();
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	/**
	 * @method    check
	 * @since     1.0.0
	 * @access    public
	 */
	public static function check() {
		return version_compare( HAYYABUILD_VERSION , '5', '<' );
	}

}
