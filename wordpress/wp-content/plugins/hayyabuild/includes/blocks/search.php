<?php
/**
 * simple menu block class.
*
* @since      5.0.0
* @package    hayyabuild
* @subpackage hayyabuild/includes/blocks
* @author     zintaThemes <>
*/

if (! defined( 'ABSPATH' ) || class_exists( 'HayyaBuildSearch' )) return;

class HayyaBuildSearch extends HayyaBuildBlocks
{

    /**
     * The single instance of HayyaBuild.
     * @var     object
     * @access  private
     * @since     3.0.0
     */
    private static $_instance = false;

    /**
     * Define the Search block class.
     *
     * @access        public
     * @since        1.0.0
     * @var          unown
     */
    public function __construct() {
        if ( self::$_instance ) return self::$_instance;
        $this->register_smenu();
        return self::$_instance = true;
    } // End __construct()

    /**
     * Search block
     */
    private function register_smenu() {
        register_block_type( 'hayyabuild/search',
            [
                'render_callback' => [
                    $this,
                    'render_callback'
                ],
                'attributes' => [
                    'theme' => [
                        'type' => 'string',
                        'default' => ''
                    ],
                    'expand' => [
                        'type' => 'boolean',
                        'default' => false
                    ],
                    'right' => [
                        'type' => 'boolean',
                        'default' => false
                    ],
                    'id' => [
                        'type' => 'string',
                        'default' => ''
                    ],
                    'editor' => [
                        'type' => 'boolean',
                        'default' => false
                    ],
                    'classesList' => [
                        'type' => 'string',
                        'default' => ''
                    ]
                ]
            ]
        );
    }

    /**
     * render_callback
     *
     * @param      array   $attributes  The attributes
     *
     * @return     string  ( description_of_the_return_value )
     */
    public function render_callback( $attributes = [] ) {
        if ( empty( $attributes ) || ! is_array($attributes) ) return '';
        extract($attributes);

        $s = HayyaBuildHelper::_get( 's' ) ? HayyaBuildHelper::_get( 's' ) : '';

        $classes = '';
        $classes = ! empty($theme) ? ' '.$theme : '';
        $classes .= $expand === true ? ' hb_expand' : '';
        $classes .= $right === true ? ' hb_right' : '';
        $classes .= ! empty($classesList) ? ' '.$classesList : '';

        $output = '<div class="wp-block-hayyabuild-search' . esc_attr( $classes . ' ' . $id ) . '">';

        $output .= '<form role="search" method="get" class="" action="' . esc_url( get_site_url() ) . '/">';

        if ( function_exists('is_plugin_active') && is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            $output .= '<input type="hidden" name="post_type" value="product" />';
        }

        $output .= '<button name="search_submit" class="wp-block-hayyabuild-search__icon" type="submit"><i class="fa fa-search"></i></button>';
        $output .= '<input type="search" value="' . esc_attr( $s ) . '" name="s" placeholder="'.esc_attr('Search...', 'hayyabuild') . '" /></form>';

        $output .= '</div>';

        return $output;
    } // End render_callback()

} // End HayyaBuild {} class
