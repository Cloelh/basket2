<?php
/**
 * The core plugin class.
*
* @since      1.0.0
* @package    hayyabuild
* @subpackage hayyabuild/includes
* @author     zintaThemes <>
*/

if (! defined( 'ABSPATH' ) || class_exists( 'HayyaBuildBlocks' )) return;

class HayyaBuildBlocks
{

    /**
     * The single instance of HayyaBuild.
     * @var     object
     * @access  private
     * @since     3.0.0
     */
    private static $_instance = false;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @access        public
     * @since        1.0.0
     * @var          unown
     */
    public function __construct() {
        if ( self::$_instance ) return self::$_instance;
        $this->register_hayyabuild_block();
        add_filter('block_categories', [ $this, 'register_block_category' ], 10, 2);
        add_action('enqueue_block_editor_assets', [ $this, 'blocks_assets' ] );
        return self::$_instance = true;
    } // End __construct()

    /**
     * register hayyabuild block category
     */
    public function register_block_category($categories, $post) {
        return array_merge(
            $categories,
            [
                [
                    'slug' => 'hayyabuild',
                    'title' => esc_html('HayyaBuild', 'hayyabuild')
                ]
            ]
        );
    } // End register_block_category()

    /**
     * register HayyaBuild blocks }
     */
    public function register_hayyabuild_block() {
        if ( ! function_exists( 'register_block_type' ) ) return;
        $blocks = [ 'Pagecontent', 'Magicbox', 'Menu', 'Smenu', 'Breadcrumb', 'Search', '' ];
        $dir = HAYYABUILD_PATH . 'includes' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR;
        $ext = '.php';
        foreach ($blocks as $block) {
            $file = $dir . strtolower( $block ) . $ext;
            if ( file_exists( $file ) ) {
                $class = 'HayyaBuild' . $block;
                require_once $file;
                class_exists( $class ) && new $class();
            }
        }
    } // End register_hayyabuild_block()

    /**
     * Enqueue blocks assets
     * 
     * @access        public
     * @since        1.0.0
     * @var          unown
     * 
     */
    public function blocks_assets() {

        $bundel = HAYYABUILD_PATH . '/admin/assets/js/hayyabuild.bundle.min.js';
        $bundel_url = file_exists( $bundel ) ? '' : '-lite';

        wp_register_script(
            'leaflet',
            HAYYABUILD_URL . 'public/assets/vendor/leaflet/leaflet.js',
            [],
            HAYYABUILD_VERSION
        );

        wp_enqueue_script(
            'hayyabuild-blocks',
            HAYYABUILD_URL . 'admin/assets/js/hayyabuild.bundle'.$bundel_url.'.min.js',
            [ 'leaflet', 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ],
            HAYYABUILD_VERSION
        );

        if ( function_exists( 'wp_set_script_translations' ) ) {
          wp_set_script_translations( 'hayyabuild-blocks', 'hayyabuild', HAYYABUILD_PATH . '/languages/' );
        }
    }

} // End HayyaBuild {} class
