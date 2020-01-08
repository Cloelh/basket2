<?php
/**
 * Public output class
 *
 *
 * @package    hayyabuild
 * @subpackage hayyabuild/public
 * @author     zintaThemes
 *
 *
 */

if (! defined('ABSPATH') || class_exists('HayyaBuildPublic')) return;

class HayyaBuildPublic extends HayyaBuild
{

    /**
     * The single instance of HayyaBuild.
     * @var     object
     * @access  private
     * @since     3.0.0
     */
    private static $_instance = false;

    /**
     * setting array for curent element.
     *
     * @since    1.0.0
     * @access    private
     * @var      string    $version    The current version of this plugin.
     */
    protected static $settings = [];

    /**
     * setting array for curent element.
     *
     * @since    1.0.0
     * @access    protected
     * @var      string    $version    The current version of this plugin.
     */
    protected static $map = [];

    /**
     * Initialize the class and set its properties.
     *
     * @since        1.0.0
     * @param          string    $plugin_name        The name of the plugin.
     * @param          string    $version    The version of this plugin.
     */
    public function __construct( $type ) {
        $this->start_hooks();
        ! has_filter('hayya_output') && HayyaBuild::get_loader()->add_filter('hayya_output', $this, 'hb_output');
        ! $type && $this->the_content();
    }

    /**
     * Starts hooks.
     *
     * @return     boolean  run this for one time
     */
    private function start_hooks() {
        if ( self::$_instance ) return;
        HayyaBuild::get_loader()->add_action( 'template_redirect', $this, 'hayyabuild_map', 9 );
        ! self::$_instance && new HayyaBuildHooks() && new HayyaBuildShortcode();
        return self::$_instance = true;
    }

    /**
     * HayyaBuild output
     *
     * @param      string   $type   The type
     *
     * @return     boolean  true
     *
     * @access     private
     * @since        1.0.0
     */
    public function hb_output( $type = null ) {

        if ( !$type || !isset(self::$settings[$type]) ) return false;
        $content = $id = $style = $class = $attributes = $settings = '';
        extract(self::$settings[$type]);

        if ( ! isset($post_content)) return false;

        $content = $post_content;
        $id = 'hb-'.$type;
        if ( isset($background_type) ) {
            $background_effect = isset($background_effect) ? $background_effect : [];
            $class .= self::background_effect($background_type, $background_effect);
            if ($background_type === 'background_video') {
                $fixed_video = isset($fixed_video) ? $fixed_video : '';
                $content = self::background_video($type, $content, $background_video, $fixed_video, $background_image);
            }
        }

        if (isset($scroll_effect) && ! empty($scroll_effect)) {
            $class .= ' hayya-scrolleffects';
            foreach ($scroll_effect as $value) {
                if ($value) $class .= " $value";
            }
        }

        if ( 'header' === $type || 'footer' === $type ) {
            $content = $this->generate_html($content, 'div', '', '', 'container', '');
        }
        $content = $this->generate_html($content, $type, $id, '', $class, $attributes);
        $content = $this->generate_html($content, 'div', 'hb-container-'.$type);
        $content = '<div id="hb-before-'.$type.'"></div>'.$content.'<div id="hb-after-'.$type.'"></div>';
        echo self::parse_output($content);
    } // End hb_output()

    /**
     * setup background
     *
     * @param      string  $background_type    The background type
     * @param      array   $background_effect  The background effect
     * 
     * @return     string  class name
     * 
     * @since      5.0
     * @access     private
     */
    public static function background_effect( $background_type = null,  $background_effect = [] ) {
        $class = '';
        if (( 'background_video' === $background_type || 'background_image' === $background_type ) && !empty($background_effect) ) {
            foreach ( $background_effect as $background_effect ) {
                if ( ! empty($background_effect) ) {
                    $class .= ' '.$background_effect;
                }
            }
            $class .= ' hayya-scrolleffects';
        }
        return $class;
    }

    /**
     * set background video
     * @param      string  $type              The type
     * @param      string  $content           The content
     * @param      string  $background_video  The background video
     * @param      string  $fixed_video       The fixed video
     * @param      string  $background_image  The background image
     * 
     * @return     string  video HTML code
     * 
     * @since      5.0
     * @access     private
     */
    public static function background_video( $type, $content, $background_video = null, $fixed_video = null, $background_image = null ) {
        $video_class = '';
        if ( ! $background_video ) {
            return '';
        }
        // $video_class = $fixed_video && $fixed_video === 'on' ? ' hayya-fixed-video hayya-scrolleffects hb-sticky' : '' ;
        return '<div class="hayya-video-background"><video class="'.$video_class.'" autoplay loop muted poster="'.$background_image.'">
                    <source src="'.$background_video.'" type="video/mp4">
                </video></div>' . $content;
    }

    /**
     * HTML output for a public
     *
     * @package        HayyaBuild
     * @param         string         $output
     * @access        private
     * @since        1.0.0
     */
    private function generate_html($output = null, $type = 'div', $id = '', $style = '', $class = '', $attributes = '') {
        if ($class) $class = ' class="'.$class.'"';
        if ($id) $id = ' id="'.$id.'"';
        if ($attributes) $attributes = ' '.$attributes;
        return '<'.$type.$id.$style.$class.$attributes.'>'.$output.'</'.$type.'>';
    } // End generate_html()

    /**
     *
     * @package        HayyaBuild
     * @access        public
     * @since        1.0.0
     */
    public function hayyabuild_map() {
        if ( ! empty( self::$map ) ) return self::$map;

        $page = 'all';
        $posts_page = false;
        $hayyabuild_map = $type = [];
        $option_map = get_option('hayyabuild_map');

        if ( HayyaBuildHelper::is_posts_page() ) $page = get_option('page_for_posts');
        else if (function_exists('is_shop') && is_shop()) $page = get_option('woocommerce_shop_page_id');
        else if (is_404()) $page = '404page';
        else if (get_the_ID()) $page = get_the_ID();

        if ( is_array($option_map) && ! empty($option_map) ) {
            foreach ( $option_map as $id => $value ) {
                if (
                    isset($value['type']) &&
                    $value['pages'] &&
                    (
                        ! in_array($value['type'], $type) ||
                        ! in_array('all', $value['pages'])
                    ) &&
                    (
                        is_array($value['pages']) &&
                        (
                            in_array($page, $value['pages']) ||
                            in_array('all', $value['pages'])
                        )
                    )
                ) {
                    $hayyabuild_map[$value['type']] = $id;
                    $type[] = $value['type'];
                }
            }
            return self::$map = $hayyabuild_map;
        }
    } // End  hb_getMap()

    /**
     * @return 404 path
     */
    public function hayya_archive_template($param) {
        return HAYYABUILD_PATH . 'public/archive.php';
    }

    /**
     * @return 404 path
     */
    public function hayya_404_template($param) {
        return HAYYABUILD_PATH . 'public/404.php';
    }

    /**
     * Get settings.
     *
     * @package        HayyaBuild
     * @access         public
     * @since          1.0.0
     */
    public function hb_getsettings() {
        if (! empty(self::$settings)) return self::$settings;
        if ($map = $this->hayyabuild_map()) {
            $itemSettings = [];
            foreach($map as $type => $value) {
                $setting = [];
                $post = get_post($value);
                if ( is_object( $post ) && 'publish' === $post->post_status && 'hayyabuild' === $post->post_type) {
                    $setting = get_post_meta($post->ID, '_hayyabuild_settings', true);
                    $setting['csscode'] = get_post_meta($post->ID, '_hayyabuild_css', true);
                    $setting['post_content'] = $post->post_content;
                    $setting['post_inlineStyle'] = get_post_meta($post->ID, '_hayyabuild_inlinestyle', true);
                }
                $itemSettings[$type] = $setting;
            }
            return self::$settings = $itemSettings;
        } return false;
    } // End  hb_getsettings()

    /**
     * Pages Content.
     *
     * @package        HayyaBuild
     * @access        public
     * @since        3.0.0
     */
    public static function pages_content($page_content = null) {
        if ( class_exists('Vc_Manager') && HayyaBuildHelper::_get('vc_editable') ) return $page_content;
        if ( is_home() || is_archive() || is_search() || is_single() || is_tag() || is_date() ) return $page_content;
        if ( ! empty(self::$map) && ! empty(self::$settings) && isset(self::$settings['content']) ) {
            $settings = self::$settings['content'];
            $page_content = $settings['post_content'];
        }
        return self::parse_output($page_content);
    } // End pages_content()

    /**
     *    reterned page contetn
     *    @method    page_output
     *    @param     string         $content    [description]
     *    @return    string                     [description]
     *
     *    @package        HayyaBuild
     *    @access        public
     *    @since        3.0.0
     */
    public static function page_output($content, $do_shortcode = false, $id = null) {
        $prefix = (null === $id) ? '' : '_' . $id;
        if ($do_shortcode) $content = do_shortcode($content);
        return '<div id="hb-container-content-' . $id . '" class="hb-container-content"><div id="hb-content-' . $id . '" class="hb-content">' . $content . '</div></div>';
    }

    /**
     *
     * @package        HayyaBuild
     * @access        public
     * @since        3.0.0
     */
    public static function the_content() {
        HayyaBuild::get_loader()->add_filter('the_content', 'HayyaBuildPublic', 'pages_content');
    } // End the_content()

    /**
     * parse hayyabuild output
     *
     * @param      string  $content  The content
     *
     * @return     string  ( description_of_the_return_value )
     */
    public static function parse_output( $content = null ) {
        if ( ! $content ) return;
        return do_shortcode( do_blocks( $content ) );
    }

    /**
     * HTML output for a public
     *
     * @param         string         $output
     */
    private function hb_class($class) {
        if ($class) return $class;
        else return false;
    } // End hb_class()

    /**
     * Get styles.
     *
     * @since 1.0.0
     */
    private function load_styles($template) {
        return isset($template);
    } // End load_styles()

    /**
     * Get scripts.
     *
     * @since 1.0.0
     */
    private function load_scripts($template) {
        return isset($template);
    } // End load_scripts()


} // End HayyaBuildPublic {} class
