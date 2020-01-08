<?php
/**
 * Plugin Name:     HayyaBuild
 * Plugin URI:      https://hayyabuild.zintathemes.com
 * Author:          ZintaThemes
 * Author URI:      www.zintathemes.com
 * Version:         1.5.4
 * Description:     HayyaBuild allows you to build unlimited headers, pages and footers for your WordPress website without the needs for writing any code.
 *
 * Text Domain:     hayyabuild
 * Domain Path:     /languages/
 *
 *
 * @link
 * @since            1.0.0
 * @package          HayyaBuild
 * @category         *
 * @author           ZintaThemes
 */

if (! defined('ABSPATH')) {
    return;
}

// Define HayyaBuild constants
defined('HAYYABUILD_VERSION') || define('HAYYABUILD_VERSION', '1.5.4');
defined('HAYYABUILD_PATH')    || define('HAYYABUILD_PATH', plugin_dir_path(__FILE__));
defined('HAYYABUILD_URL')     || define('HAYYABUILD_URL', plugin_dir_url(__FILE__));

final class HayyaBuildStart
{

  /**
   * The single instance of HayyaBuild.
   * @var         object
   * @access      private
   * @since         3.0.0
   */
  private static $_instance = false;

  /**
   * Constructor function.
   * @access      public
   * @since       3.0.0
   */
  public function __construct() {
    require_once HAYYABUILD_PATH . 'includes' . DIRECTORY_SEPARATOR . 'class-hayyabuild.php';
    register_activation_hook(__FILE__, array('HayyaBuild', 'hayyabuild_activate'));
    register_deactivation_hook(__FILE__, array('HayyaBuild', 'hayyabuild_deactivate'));
    return true;
  } // End __construct()

  /**
   * Begins execution of the plugin.
   *
   * @access      public
   * @since       3.0.0
   * @param       $type       string
   */
  public static function hayya_starter($type = null, $name = null) {
    $content = null === $type && ('header' === $name || 'footer' === $name) ? $name : $type;
    ! self::$_instance && self::$_instance = new self();
    return HayyaBuild::run( $content );
  } // End hayya_starter()
} // End HayyaBuildStart {} Class

/**
 * deprecated function, now we use hayyabuild() function instead
 *
 * @since       1.0.0
 * @param       $type       string
 */
function hayya_run($type) {
  HayyaBuildStart::hayya_starter(
    $type
  );
} // End hayya_run()

/**
 * Begins execution of the plugin.
 *
 * @since       5.0.0
 * @param       $type       string
 */
function hayyabuild($type = null) {
    $name = basename( debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS, 1 )[0]['file'], '.php' );
    HayyaBuildStart::hayya_starter( $type, $name );
} // End hayyabuild()

hayyabuild(); // Run HayyaBuild plugin
