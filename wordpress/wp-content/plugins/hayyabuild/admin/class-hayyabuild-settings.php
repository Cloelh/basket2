<?php
/**
 *
 * The admin-list functionality of the plugin.
 *
 * @since       1.0.0
 * @package     hayyabuild
 * @subpackage  hayyabuild/admin
 * @author      zintaThemes <>
 */

if ( ! defined( 'ABSPATH' ) || class_exists('HayyaBuildSettings') ) return;

class HayyaBuildSettings extends HayyaBuildAdmin {

    /**
     * Define the view for forntend.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @access      public
     * @since       1.0.0
     * @var         unown
     */
    public function __construct() {
        // if (  ) 
        // 'hayyabuild_templates' === HayyaBuildHelper::_get( 'page' )
        return $this->settings_view();
    }

    /**
     *
     * @access      public
     * @since       1.0.0
     * @var         unown
     */
    protected function settings_view() {
        $google_api_key = '';
        ?>
        <div id="hayyabuild" class="wrap">
            <div class="hb-main_settings">
                <?php HayyaBuildView::nav_bar(true);?>
                <div class="view_title">
                    <h2><?php esc_html_e( 'HayyaBuild Options', 'hayyabuild' );?></h2>
                </div>
                <hr>
                <form action="" method="post">

                    <?php settings_fields( 'hayyabuild-options' );?>
                    <?php do_settings_sections( 'hayyabuild-group' );?>

                    <ul class="hayyabuild-collapsible" data-collapsible="accordion">
                        <li class="active">
                            <div class="collapsible-header">
                                <i class="fa fa-sliders-h"></i><?php esc_html_e( 'Main', 'hayyabuild');?>
                            </div>
                            <div class="collapsible-body valign-wrapper ">
                                <div class="wp-block-hayyabuild-row has-1-4_3-4-columns settings valign">
                                    <div class="wp-block-hayyabuild-column input-field">
                                        <?php esc_html_e( 'Google API key', 'hayyabuild');?>
                                    </div>
                                    <div class="wp-block-hayyabuild-column hb-right">
                                        <input id="google_api_key" type="text" name="settings[google_api_key]" placeholder="<?php esc_html_e( 'API Key', 'hayyabuild');?>" value="<?php esc_attr_e($google_api_key);?>">
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="wp-block-hayyabuild-button hb-center">
                        <button class="button-size-2" type="submit" name="save-settings"><?php esc_html_e('Save Settings', 'hayyabuild');?></button>
                        <button class="button-size-2 red" type="cancel"><?php esc_html_e('Cancel Changes', 'hayyabuild');?></button>
                    </div>
                </form>
            </div>
        </div><?php
    }
} // End Class
