<?php
/**
 *
 * HayyaBuild Admin Scripts functionality of the plugin.
 *
 * @since        1.0.0
 * @package      hayyabuild
 * @subpackage   hayyabuild/admin
 * @author       zintaThemes <>
 */

if (! defined( 'ABSPATH' ) || class_exists( 'HayyaBuildAdminHooks' )) return;

class HayyaBuildAdminHooks extends HayyaBuildAdmin
{

    /**
    * Initialize the class and set its properties.
    *
    * @since    3.0.0
    * @param        string    $plugin_name       The name of the plugin.
    * @param        string    $version    The version of this plugin.
    */
    public function __construct() {
        require_once HAYYABUILD_PATH . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-view.php';
        HayyaBuild::get_loader()->add_action('admin_menu', $this, 'admin_menus');
        HayyaBuild::get_loader()->add_action('admin_menu', $this, 'admin_body_class');
        HayyaBuild::get_loader()->add_action('add_meta_boxes', $this, 'register_meta_boxes');
        HayyaBuild::get_loader()->add_action( 'admin_init', $this, 'register_settings' );
        HayyaBuild::get_loader()->add_action('plugins_loaded', $this, 'scripts_start');
        return true;
    } // End __construct()

    /**
     *
     * @access      public
     * @since       1.0.0
     * @var         unown
     */
    public function register_settings() {
        register_setting( 'hayyabuild-settings-group', 'hayyabuild-options' );
    }

    /**
     *
     * @since    3.0.0
     */
    public function scripts_start() {
        add_action('admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        add_action('admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    } // End scripts_start()

    /**
     * Register the stylesheets for the admin area.
     *
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Plugin_Name_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Plugin_Name_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     *
     * @since   1.0.0
     */
    public static function enqueue_styles() {
        self::register_style();
        wp_enqueue_style('hayyabuild');
        if (is_rtl()) wp_enqueue_style('hayyabuild-rtl');
    } // End enqueue_styles()

    /**
     * Register the JavaScript for the admin area.
     *
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Plugin_Name_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Plugin_Name_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     *
     * @access   public
     * @since   1.0.0
     */
    public static function enqueue_scripts() {
        self::register_script();
        self::post_type();
        if ( ! function_exists( 'register_block_type' ) ) return;
        wp_enqueue_code_editor( [ 'type' => 'text/html' ] );
        wp_enqueue_script( 'hayyabuild' );
    } // End enqueue_scripts()

    /**
     * Posts a type.
     *  @method post_type
     *
     *  @since   5.4.0
     *  @access public
     */
    public static function post_type() {
        global $pagenow;
        if ('post-new.php' === $pagenow && isset($_GET['type']) && ( 'header' === $_GET['type'] || 'content' === $_GET['type'] || 'footer' === $_GET['type'] ) ) {
            $type = wp_unslash( $_GET['type'] );
        } elseif ('post.php' === $pagenow && isset($_GET['post'])) {
            $post_id = wp_unslash( $_GET['post'] );
            $settings = get_post_meta( $post_id, '_hayyabuild_settings', true );
            if ( isset( $settings['type'] ) ) {
                $type = $settings['type'];
            }
        }
        if ( isset( $type ) && !empty( $type ) ) {
            wp_localize_script( 'hayyabuild-blocks', 'hayyabuild_type', $type );
        }
    }

    /**
     *	Add hayyabuild class to body tag
     *	@method	body_classes
     *	@param	 array	$classes	classes array
     *	@return	array	classes array
     *
     *	@since	 1.0.0
     *	@access	public
     */
    public function admin_body_class() {
        add_filter('admin_body_class', function () {
            global $pagenow;
            if ('post-new.php' === $pagenow && isset($_GET['type']) && ('header' === $_GET['type'] || 'content' === $_GET['type'] || 'footer' === $_GET['type']) ) {
                $type = wp_unslash( $_GET['type'] );
            } elseif ('post.php' === $pagenow && isset($_GET['post'])) {
                $post_id = wp_unslash( $_GET['post'] );
                $settings = get_post_meta( $post_id, '_hayyabuild_settings', true );
                if ( isset( $settings['type'] ) ) {
                    $type = $settings['type'];
                }
            }
            if ( isset( $type ) && !empty( $type ) ) {
                return 'hayyabuild-'.$type;
            }
        });
    }

    /**
     * register hayyabuild metaboxes
     */
    public function register_meta_boxes() {

        // apply_filters( 'default_hidden_meta_boxes', array($this, 'register_heddin_meta_boxes') );

        require_once HAYYABUILD_PATH . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-metabox.php';

        $post_types = [ 'post', 'page', 'event', 'hayyabuild' ];

        foreach( $post_types as $post_type ) {
            add_meta_box(
                '_hayyabuild_inlinestyle',
                esc_html('HayyaBuild inlineStyle', 'hayyabuild'),
                function () {
                    HayyaBuildMetaBox::inline_style();
                },
                $post_type
            );
        }

        add_meta_box(
            '_hayyabuild_settings',
            esc_html('HayyaBuild Settings', 'hayyabuild'),
            function () {
                HayyaBuildMetaBox::settings();
            },
            'hayyabuild'
        );

        add_meta_box(
            '_hayyabuild_css',
            esc_html('HayyaBuild CSS', 'hayyabuild'),
            function () {
                HayyaBuildMetaBox::css();
            },
            'hayyabuild',
            'advanced'
        );
    }

    /**
     *
     *
     * @access   public
     * @since   3.0.0
     */
    public static function register_style() {

        global $wp_styles;
        $type = get_post_type();
        $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src'));

        if ( ! in_array('fontawesome.min.css', $srcs) && ! in_array('font-awesome.css', $srcs) && ! in_array('font-awesome.min.css', $srcs) ) {
            wp_enqueue_style(
                'fontawesome',
                HAYYABUILD_URL . 'public/assets/vendor/fontawesome/css/all.min.css',
                [],
                HAYYABUILD_VERSION
            );
        }

        if ( 'hayyabuild_templates' === HayyaBuildHelper::_get('page') || 'hayyabuild' === $type ) {
            wp_enqueue_style(
                'chosen',
                HAYYABUILD_URL.'admin/assets/libs/chosen/chosen.css',
                [],
                HAYYABUILD_VERSION
            );

            if ( 'hayyabuild' === $type ) {
                wp_enqueue_style(
                    'minicolors',
                    HAYYABUILD_URL.'admin/assets/libs/minicolors/jquery.minicolors.css',
                    [],
                    HAYYABUILD_VERSION
                );
            }
        }

        wp_register_style(
            'hayyabuild',
            HAYYABUILD_URL . 'admin/assets/css/editor.min.css',
            [],
            HAYYABUILD_VERSION,
            'all'
        );

        if (is_rtl()) {
            wp_register_style(
                'hayyabuild-rtl',
                HAYYABUILD_URL . 'admin/assets/css/rtl.min.css',
                [ 'hayyabuild' ],
                HAYYABUILD_VERSION,
                'all'
            );
        }
    } // End register_style()

    /**
     *
     *
     * @access   public
     * @since   3.0.0
     */
    public static function register_script() {
        
        $type = get_post_type();

        if ( 'hayyabuild_templates' === HayyaBuildHelper::_get('page') || 'hayyabuild' === $type ) {
            wp_enqueue_script(
                'chosen',
                HAYYABUILD_URL . 'admin/assets/libs/chosen/chosen.jquery.min.js',
                [],
                HAYYABUILD_VERSION
            );
        }

        if ( 'hayyabuild' === $type ) {
            wp_enqueue_script(
                'minicolors',
                HAYYABUILD_URL . 'admin/assets/libs/minicolors/jquery.minicolors.min.js',
                [ 'jquery' ],
                HAYYABUILD_VERSION
            );
        }

        wp_register_script(
            'hayyabuild',
            HAYYABUILD_URL.'admin/assets/js/admin-script.min.js',
            [],
            HAYYABUILD_VERSION,
            true
        );
    }

    /**
     *
     * Create admin menus and pages.
     *
     * @access   public
     * @since   1.0.0
     */
    public static function admin_menus() {
        $parent = new HayyaBuildAdmin();
        add_menu_page( esc_attr('HayyaBuild', 'hayyabuild'), esc_attr('HayyaBuild', 'hayyabuild'), 'manage_options', 'hayyabuild', [ 'HayyaBuildAdmin', 'hayyabuild_admin' ], HAYYABUILD_URL.'admin/assets/images/menu_icon.png' );
        add_submenu_page( 'hayyabuild', esc_attr('HayyaBuild List', 'hayyabuild'), esc_attr('List', 'hayyabuild'), 'manage_options', 'hayyabuild', [ 'HayyaBuildAdmin', 'hayyabuild_admin' ] );
        if ( function_exists( 'register_block_type' ) ) {
            add_submenu_page( 'hayyabuild', esc_attr('New Header', 'hayyabuild'), esc_attr('New Header', 'hayyabuild'), 'manage_options', 'post-new.php?post_type=hayyabuild&type=header' );
            add_submenu_page( 'hayyabuild', esc_attr('New Content', 'hayyabuild'), esc_attr('New Content', 'hayyabuild'), 'manage_options', 'post-new.php?post_type=hayyabuild&type=content' );
            add_submenu_page( 'hayyabuild', esc_attr('New Footer', 'hayyabuild'), esc_attr('New Footer', 'hayyabuild'), 'manage_options', 'post-new.php?post_type=hayyabuild&type=footer' );
            add_submenu_page( 'hayyabuild', esc_attr('hayyabuild Templates', 'hayyabuild'), esc_attr('Templates', 'hayyabuild'), 'manage_options', 'hayyabuild_templates', [ 'HayyaBuildAdmin', 'templates' ] );
            // add_submenu_page( 'hayyabuild', esc_attr('hayyabuild Options', 'hayyabuild'), esc_attr('Options', 'hayyabuild'), 'manage_options', 'hayyabuild_options', array( 'HayyaBuildAdmin', 'options' ) );
        }
        add_submenu_page( 'hayyabuild', esc_attr('hayyabuild Help', 'hayyabuild'), esc_attr('Help', 'hayyabuild'), 'manage_options', 'hayyabuild_help', [ 'HayyaBuildAdmin', 'help' ] );
    } // End admin_menus()
} // End Class
