<?php
/**
 * The core plugin class.
 *
 * This is used to define HayyaBuild metaboxes
 *
 *
 * @since      5.0.0
 * @package    hayyabuild
 * @subpackage hayyabuild/metabox
 * @author     zintaThemes <>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 *
 */
class HayyaBuildMetaBox extends HayyaBuildAdmin
{

    /**
     *
     */
    function __construct() {}

    /**
     *
     */
    public static function settings() {

        global $post;

        if ( $post->ID ) {
            $settings = get_post_meta($post->ID, '_hayyabuild_settings');
        } else {
            $settings = 'a:23:{s:5:"title";s:0:"";s:15:"background_type";s:22:"background_transparent";s:16:"background_image";s:0:"";s:17:"background_repeat";s:6:"repeat";s:15:"background_size";s:4:"auto";s:16:"background_video";s:0:"";s:16:"background_color";s:0:"";s:10:"text_color";s:0:"";s:6:"height";s:0:"";s:13:"height_m_unit";s:2:"px";s:12:"border_color";s:0:"";s:10:"margin_top";s:0:"";s:13:"margin_bottom";s:0:"";s:11:"margin_left";s:0:"";s:12:"margin_right";s:0:"";s:16:"border_top_width";s:0:"";s:19:"border_bottom_width";s:0:"";s:17:"border_left_width";s:0:"";s:18:"border_right_width";s:0:"";s:11:"padding_top";s:0:"";s:14:"padding_bottom";s:0:"";s:12:"padding_left";s:0:"";s:13:"padding_right";s:0:"";}';
            $settings = unserialize($settings);
        }

        $settings = isset($settings[0]) ? $settings[0] : $settings;

        $type = HayyaBuildHelper::_get('type');

        if ( empty( $type ) ) {
            $type = $settings['type'];
        }

        if ( 'header' != $type && 'footer' != $type && 'content' != $type ) {
            $type = 'content';
        }

        $pages = isset($settings['pages']) ? (array) $settings['pages'] : array();

        ?>
        <div id="hayyabuild" class="wrap">
            
            <input type="hidden" name="settings[type]" value="<?php esc_attr_e( $type ); ?>" />
            
            <?php wp_nonce_field( 'hayyabuild_nonce_action', 'hayyabuild_nonce' ); ?>

            <div class="wp-block-hayyabuild-row has-1-2_1-2-columns settings">
                <div class="wp-block-hayyabuild-column">
                    <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                        <div class="wp-block-hayyabuild-column input-field">
                            <?php esc_html_e( $type ) . ' '; ?>
                            <?php esc_html_e( 'Title', 'hayyabuild' );?>
                        </div>
                        <div class="wp-block-hayyabuild-column">
                            <input id="title" type="text" name="settings[title]" placeholder="<?php esc_attr_e( 'Title', 'hayyabuild' );?>" value="<?php echo ( isset( $settings['title']) ) ? esc_attr( $settings['title'] ) : '';?>"/>
                        </div>
                    </div>

                    <?php self::pages( $pages ); ?>

                    <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                        <div class="wp-block-hayyabuild-column input-field">
                            <?php esc_html_e( 'Background type', 'hayyabuild' );?>
                        </div>
                        <div class="wp-block-hayyabuild-column">
                            <select id="background_type_input" name="settings[background_type]" class="hayyabuild-select" id="background_type">
                                <?php
                                $background_types = array( 'background_transparent' => esc_attr( 'Transparent', 'hayyabuild' ), 'background_image' => esc_attr( 'Image', 'hayyabuild' ), 'background_video' => esc_attr( 'Video', 'hayyabuild' ), 'background_color' => esc_attr( 'Color', 'hayyabuild' ) );
                                foreach ($background_types as $key => $value) {
                                    $selected = ( $key == HayyaBuildHelper::_empty($settings['background_type']) ) ? 'selected' : '';
                                    echo '<option value="' . esc_attr($key) . '" '.esc_attr($selected).'>'.esc_html($value).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="background_div" id="background_image">
                        <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                            <div class="wp-block-hayyabuild-column input-field">
                                <?php esc_html_e( 'Background image', 'hayyabuild' );?>
                            </div>
                            <div class="wp-block-hayyabuild-column">
                                <nobr>
                                    <input id="background_image_input" type="text" name="settings[background_image]" placeholder="<?php esc_attr_e( 'Image URL', 'hayyabuild' );?>" value="<?php echo ( isset( $settings['background_image']) ) ? esc_url($settings['background_image']) : '';?>"/>
                                    <a id="background_image_button" class="waves-effect btn " href="#">
                                        <?php esc_html_e( 'Select', 'hayyabuild' );?>
                                        <i class="fa fa-camera"></i>
                                    </a>
                                </nobr>
                            </div>
                        </div>
                        <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                            <div class="wp-block-hayyabuild-column input-field">
                                <?php esc_html_e( 'Background repeat', 'hayyabuild' );?>
                            </div>
                            <div class="wp-block-hayyabuild-column">
                                <select id="background_repeat_input" name="settings[background_repeat]" class="hayyabuild-select">
                                    <?php
                                    $background_repeat = array('repeat' => esc_attr( 'Repeat', 'hayyabuild' ), 'repeat-x' => esc_attr( 'Repeat X', 'hayyabuild' ), 'repeat-y' => esc_attr( 'Repeat Y', 'hayyabuild' ), 'no-repeat' => esc_attr( 'No repeat', 'hayyabuild' ) );

                                    foreach ($background_repeat as $key => $value) {
                                        $selected = ( $key == HayyaBuildHelper::_empty($settings['background_repeat']) ) ? 'selected': '';
                                        echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>' . esc_html($value) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                            <div class="wp-block-hayyabuild-column input-field">
                                <?php esc_html_e( 'Background size', 'hayyabuild' );?>
                            </div>
                            <div class="wp-block-hayyabuild-column">
                                <select id="background_size_input" name="settings[background_size]" class="hayyabuild-select">
                                    <?php
                                    $background_size = array('auto' => esc_attr( 'Auto', 'hayyabuild' ), 'length' => esc_attr( 'Length', 'hayyabuild' ), 'cover' => esc_attr( 'Cover', 'hayyabuild' ), 'contain' => esc_attr( 'Contain', 'hayyabuild' ), 'initial' => esc_attr( 'Initial', 'hayyabuild' ), '100% 100%' => '100% 100%' );

                                    foreach ($background_size as $key => $value) {
                                        $selected = ( $key == $settings['background_size'] ) ? 'selected': '';
                                        echo '<option value="' . esc_attr($key) . '" ' . esc_attr($selected) . '>'.esc_html($value).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                            <div class="wp-block-hayyabuild-column input-field">
                                <?php esc_html_e( 'Background Effects', 'hayyabuild' ); ?>
                            </div>
                            <div class="wp-block-hayyabuild-column">
                                <select name="settings[background_effect][]" class="hayyabuild-select" multiple>
                                    <option value=""><?php esc_html_e( 'Disable', 'hayyabuild' );?></option>
                                    <?php
                                    $background_effect = array(
                                            'hayya-bgfixed' => esc_attr( 'Fixed', 'hayyabuild' ),
                                            'hayya-bgparallax' => esc_attr( 'Parallax', 'hayyabuild' ),
                                            // 'bgzoom' => esc_attr( 'Zoom Effect', 'hayyabuild' )
                                    );
                                    foreach ($background_effect as $key => $value) {
                                        $selected = '';
                                        if ( isset($settings['background_effect']) && is_array($settings['background_effect']) ) {
                                            $selected = ( in_array( $key, $settings['background_effect'] ) ) ? ' selected' : '';
                                        }
                                        echo '<option value="'.esc_attr($key).'" '.esc_attr($selected).'>'.esc_html($value).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="background_div" id="background_video">
                        <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                            <div class="wp-block-hayyabuild-column input-field">
                                <?php esc_html_e( 'Background Video', 'hayyabuild' );?>
                            </div>
                            <div class="wp-block-hayyabuild-column">
                                <nobr>
                                    <input id="background_video_input" type="text" name="settings[background_video]" placeholder="<?php esc_attr_e( 'Video URL', 'hayyabuild' );?>" value="<?php echo (isset($settings['background_video'])) ? esc_url($settings['background_video']) : '';?>"/>
                                    <a id="background_video_button" class="waves-effect btn" href="#">
                                        <?php esc_html_e( 'Select', 'hayyabuild' );?>
                                        <i class="fa fa-video-camera"></i>
                                    </a>
                                </nobr>
                            </div>
                        </div>
                    </div>

                    <div class="wp-block-hayyabuild-row has-1-4_3-4-columns background_div" id="background_color">
                        <div class="wp-block-hayyabuild-column input-field">
                            <?php esc_html_e( 'Background color', 'hayyabuild' );?>
                        </div>
                        <div class="wp-block-hayyabuild-column">
                            <input name="settings[background_color]" class="minicolors" id="color-piker" type="text" value="<?php echo (isset($settings['background_color'])) ?  sanitize_text_field($settings['background_color']) : '';?>"/>
                        </div>
                    </div>

                    <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                        <div class="wp-block-hayyabuild-column input-field">
                            <?php esc_html_e( 'Scroll Effects', 'hayyabuild' ); ?>
                        </div>
                        <div class="wp-block-hayyabuild-column">
                            <select name="settings[scroll_effect][]" class="hayyabuild-select" multiple>
                                <option value=""><?php esc_html_e( 'Disable', 'hayyabuild' );?></option>
                                <?php
                                $scroll_effect = array(
                                    'hb-sticky' => esc_attr( 'Sticky', 'hayyabuild' ),
                                    'hb-parallax' => esc_attr( 'Parallax Effect', 'hayyabuild' ),
                                    'hb-fade-in' => esc_attr( 'Fade In', 'hayyabuild' ),
                                    'hb-fade-out' => esc_attr( 'Fade Out', 'hayyabuild' ),
                                    'hb-scale-in' => esc_attr( 'Scale In', 'hayyabuild' ),
                                    'hb-scale-out' => esc_attr( 'Scale Out', 'hayyabuild' )
                                );
                                foreach ($scroll_effect as $key => $value) {
                                    $selected = '';
                                    if ( isset($settings['scroll_effect']) && is_array($settings['scroll_effect']) ) {
                                        $selected = ( in_array( $key, $settings['scroll_effect'] ) ) ? ' selected' : '';
                                    }
                                    echo '<option value="'.esc_attr($key).'" '.esc_attr($selected).'>'.esc_html($value).'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="wp-block-hayyabuild-column">
                    <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                        <div class="wp-block-hayyabuild-column input-field">
                            <?php esc_html_e( 'Text color', 'hayyabuild' );?>
                        </div>
                        <div class="wp-block-hayyabuild-column">
                            <input name="settings[text_color]" class=" minicolors" type="text" value="<?php echo (isset($settings['text_color'])) ? $settings['text_color'] : '';?>"/>
                        </div>
                    </div>
                    <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                        <div class="wp-block-hayyabuild-column input-field">
                            <?php
                            echo ucfirst( esc_html($type) ) . ' ';
                            esc_html_e( 'Height', 'hayyabuild' );
                            ?>
                        </div>
                        <div class="wp-block-hayyabuild-column">
                            <div class="wp-block-hayyabuild-row has-2-3_1-3-columns height-row">
                                <div class="wp-block-hayyabuild-column">
                                    <input id="height" name="settings[height]" type="number" value="<?php echo (isset($settings['height'])) ? filter_var($settings['height'], FILTER_SANITIZE_NUMBER_INT) : '';?>"/>
                                </div>
                                <div class="wp-block-hayyabuild-column">
                                    <select name="settings[height_m_unit]" class="hayyabuild-select">
                                        <?php
                                        $height_fit = array( 'px' => 'px', 'percent' => '%', 'VH' => 'vh' );
                                        foreach ($height_fit as $key => $value) {
                                            $selected = ( $key == $settings['height_m_unit'] ) ? 'selected': '';
                                            echo '<option value="' . esc_attr( $key ) . '" ' . esc_attr( $selected ) . '>' . esc_html( $value ) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                        <div class="wp-block-hayyabuild-column input-field">
                            <?php esc_html_e( 'Border Color', 'hayyabuild' );?>
                        </div>
                        <div class="wp-block-hayyabuild-column">
                            <input name="settings[border_color]" type="text" class="minicolors" value="<?php echo ( isset($settings['border_color']) ) ?  sanitize_text_field( $settings['border_color'] ) : '';?>"/>
                        </div>
                    </div>

                    <?php self::spaces( (array) $settings ); ?>

                </div>
            </div>
        </div>
        <?php
    }

    /**
     *
     */
    private static function spaces( array $settings = [] ) {
        ?>
        <div class="hayyabuild-layout">
            <div class="margin">
                    <label><?php esc_html_e('Margin', 'hayyabuild');?></label>
                    <input name="settings[margin_top]" placeholder="---" value="<?php echo (isset($settings['margin_top'])) ? filter_var($settings['margin_top'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="margin_top">
                    <input name="settings[margin_bottom]" placeholder="---" value="<?php echo (isset($settings['margin_bottom'])) ? filter_var($settings['margin_bottom'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="margin_bottom">
                    <input name="settings[margin_left]" placeholder="---" value="<?php echo (isset($settings['margin_left'])) ? filter_var($settings['margin_left'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="margin_left">
                    <input name="settings[margin_right]" placeholder="---" value="<?php echo (isset($settings['margin_right'])) ? filter_var($settings['margin_right'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="margin_right">
                    <div class="border">
                        <label><?php esc_html_e('Border', 'hayyabuild');?></label>
                        <input name="settings[border_top_width]" placeholder="---" value="<?php echo (isset($settings['border_top_width'])) ? filter_var($settings['border_top_width'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="border_top_width">
                        <input name="settings[border_bottom_width]" placeholder="---" value="<?php echo (isset($settings['border_bottom_width'])) ? filter_var($settings['border_bottom_width'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="border_bottom_width">
                        <input name="settings[border_left_width]" placeholder="---" value="<?php echo (isset($settings['border_left_width'])) ? filter_var($settings['border_left_width'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="border_left_width">
                        <input name="settings[border_right_width]" placeholder="---" value="<?php echo (isset($settings['border_right_width'])) ? filter_var($settings['border_right_width'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="border_right_width">
                        <div class="padding">
                            <label><?php esc_html_e('Padding', 'hayyabuild');?></label>
                            <input name="settings[padding_top]" placeholder="---" value="<?php echo (isset($settings['padding_top'])) ? filter_var($settings['padding_top'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="padding_top">
                            <input name="settings[padding_bottom]" placeholder="---" value="<?php echo (isset($settings['padding_bottom'])) ? filter_var($settings['padding_bottom'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="padding_bottom">
                            <input name="settings[padding_left]" placeholder="---" value="<?php echo (isset($settings['padding_left'])) ? filter_var($settings['padding_left'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="padding_left">
                            <input name="settings[padding_right]" placeholder="---" value="<?php echo (isset($settings['padding_right'])) ? filter_var($settings['padding_right'], FILTER_SANITIZE_NUMBER_INT) : '';?>" type="text" class="padding_right">
                            <div class="content">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    /**
     *
     */
    private static function pages( array $pages = [] ) {
        ?>
        <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
            <div class="wp-block-hayyabuild-column input-field">
                <?php esc_html_e( 'Pages List', 'hayyabuild' );?>
            </div>
            <div class="wp-block-hayyabuild-column">

                <select id="pages" name="settings[pages][]" data-placeholder="Select Pages" class="chosen-select" multiple>
                    <?php
                    $all_pages = get_pages();
                    $selected = '';
                    if ( isset($pages) && is_array($pages) ) {
                        $selected = ( $pages && in_array( 'all', $pages ) ) ? ' selected' : '';
                    }
                    echo '<option value="all"'.esc_attr($selected).'>'.esc_html( 'All pages', 'hayyabuild' ).'</option>';?>

                    <optgroup label="<?php esc_attr_e( 'Pages List', 'hayyabuild' )?>">
                    <?php
                    foreach ( $all_pages as $page ) {
                        $selected = '';
                        if ( isset($pages) && is_array($pages) ) {
                            $selected = ( $page->ID && in_array( $page->ID, $pages ) ) ? ' selected' : '';
                        }
                        echo '<option value="' .esc_attr($page->ID). '"'.esc_attr($selected).'>'.esc_html($page->post_title) .'</option>';
                    }
                    ?>
                    </optgroup>

                    <optgroup label="<?php esc_attr_e( 'Other Pages', 'hayyabuild' )?>">
                        <?php
                        $selected = '';
                        if ( isset($pages) && is_array($pages) ) $selected = ( $pages && in_array( '404page', $pages ) ) ? ' selected' : '';
                        echo '<option value="404page"'.esc_attr($selected).'>'.esc_attr( '404 Error Page', 'hayyabuild' ).'</option>';?>
                        ?>
                    </optgroup>

                </select>
            </div>
        </div>
        <?php
    }

    /**
     * inlinestyle metabox
     */
    public static function inline_style() {
        global $post;
        $inlinestyle = $post->ID ? get_post_meta($post->ID, '_hayyabuild_inlinestyle', true) : '';
        $inlinestyle = $inlinestyle ? json_encode( $inlinestyle ) : '';
        // var_dump(json_encode($inlinestyle));
        ?>
        <textarea id="hayyabuild_inline_style" rows="5" name="hayyabuild_inlinestyle" class="widefat textarea"><?php echo $inlinestyle; ?></textarea>
        <?php
    }

    /**
     *
     */
    public static function css() {
        global $post;
        $hayyabuild_css = $post->ID ? get_post_meta($post->ID, '_hayyabuild_css', true) : '';
        esc_html_e('Just write CSS code, "without syle tag".', 'hayyabuild'); ?>
        <textarea id="code_editor_page_css" rows="5" name="hayyabuild_css" class="widefat textarea"><?php echo wp_unslash( $hayyabuild_css ); ?></textarea><?php
    }
}
