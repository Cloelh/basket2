<?php
/**
 *
 * The admin-list functionality of the plugin.
 *
 * @since      	1.0.0
 * @package    	hayyabuild
 * @subpackage 	hayyabuild/admin
 * @author     	zintaThemes <>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class HayyaBuildHelp extends HayyaBuildAdmin {

    /**
     * Define the view for forntend.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @access		public
     * @since		1.0.0
     * @var			unown
     */
    public function __construct() {
    	return $this->help_view();
    }

	/**
	 *
     * @access		public
     * @since		1.0.0
     * @var			unown
	 */
    protected function help_view() {
        ?>
    	<div id="hayyabuild" class="wrap">
            <div class="hb-main_settings">
                <?php HayyaBuildView::nav_bar(true);?>
        	    <div class="view_title">
        	        <h3><?php esc_html_e( 'HayyaBuild', 'hayyabuild' );?> - <?php esc_html_e( 'Version', 'hayyabuild' );?> - <?php esc_html_e( HAYYABUILD_VERSION );?></h3>
        	    </div>
        	    <hr>
        	    <ul class="hayyabuild-collapsible" data-collapsible="accordion">
        	        <li class="active">
        	            <div class="collapsible-header"><i class="fa fa-mail-bulk"></i><?php esc_html_e( 'Contact Us', 'hayyabuild');?></div>
        	            <div class="collapsible-body valign-wrapper ">
        	                <div class="wp-block-hayyabuild-row has-2-3_1-3-columns settings valign">
        	                    <div class="wp-block-hayyabuild-column">
        	                        <section id="top">
        	                            <div>
        	                                <strong>
                                                <?php esc_html_e('First of all, thank you for using HayyaBuild.', 'hayyabuild');?>
                                            </strong>
                                            <br/>
                                            <?php esc_html_e('If we can be of assistance, please do not hesitate to contact us at','hayyabuild');?>
                                            <a target="_blank" href="https://zintathemes.com/support/?hayyabuild-help-page=1"><?php esc_html_e('Support.', 'hayyabuild');?></a><br />
                                            <strong>
                                                <?php esc_html_e('If you like it, Please don`t forget to write a good review.', 'hayyabuild');?>
                                            </strong>
                                            <a target="_blank" class="" href="https://wordpress.org/plugins/hayyabuild/#reviews">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i>
                                                    <?php esc_html_e('Click here to write your reivew.', 'hayyabuild');?>
                                                </i>
                                            </a>.
        	                            </div>
        	                            <div>
        	                                <div>
        	                                    <?php esc_html_e('Need help? You want to report a bug?', 'hayyabuild');?>
                                                <br />
        	                                    <?php esc_html_e('You can find us on:', 'hayyabuild');?>
        	                                </div>
        	                            </div>
        	                        </section>
        	                    </div>
        	                    <div class="wp-block-hayyabuild-column hb-right">
        	                        <img src="<?php echo esc_url( site_url().'/wp-content/plugins/hayyabuild/admin/assets/images/logo.png?v='.HAYYABUILD_VERSION ); ?>" />
        	                    </div>
        	                </div>
        	                <div class="wp-block-hayyabuild-button hb-center">
                                <a target="_blank" class="button-size-2" href="https://hayyabuild.zintathemes.com/?help_page=1"><?php esc_html_e('Plugin Website', 'hayyabuild');?></a>
                                <a target="_blank" class="button-size-2" href="https://zintathemes.com/?help_page=1"><?php esc_html_e('Our Website', 'hayyabuild');?></a>
        	                </div>
        	            </div>
        	        </li>
        	        <li>
        	            <div class="collapsible-header"><i class="fa fa-exclamation-circle"></i><?php esc_html_e('Help', 'hayyabuild');?></div>
        	            <div class="collapsible-body valign-wrapper">
        	                <div class="valign hayyabuild_help">
    	                        <section>
    	                            <h3><?php esc_html_e('Setup Your Template', 'hayyabuild');?></h3>
    	                            <div>
    	                                <div class="hayya_note">
                                            <?php esc_html_e('To use HayyaBuild to only building pages layouts and shortcodes, you don`t have to follow these steps. But it prefers to do so to take advantage of all HayyaBuild features.', 'hayyabuild');?>
                                        </div>
                                        <?php esc_html_e('To use HayyaBuild to build headers and footers and your theme doesn`t support HayyaBuild by default just follow these steps.', 'hayyabuild');?>
                                        <ul class="features">
                                            <li><?php esc_html_e('Make a backup from header.php and footer.php files.', 'hayyabuild');?></li>
                                            <li>
                                                <?php esc_html_e('Now open "Edit Themes" page which is located in the WordPress Dashboard > Appearance > Editor', 'hayyabuild');?>
                                            </li>
                                            <li>
                                                <?php esc_html_e('From template files list "on the right" choose "Theme Header" (header.php)', 'hayyabuild');?><br/>
                                            </li>
                                            <li>
                                                <?php esc_html_e('Now search for the header tag and replace it with hayybuild function.', 'hayyabuild');?>
                                                <div class="code">
                                                    <?php esc_html_e('<header> .... </header> OR <div id="header"> .... </div> or anything else', 'hayyabuild');?>
                                                </div>
                                                <?php esc_html_e('with this code', 'hayyabuild');?>
                                                <div class="code">
                                                    <?php esc_html_e('<?php hayyabuild();?>', 'hayyabuild');?>
                                                </div>
                                                <?php esc_html_e('and click on Update', 'hayyabuild');?>
                                            </li>
                                            <li>
                                                <?php esc_html_e('From Editor and template files list "on the right" choose Theme Footer (footer.php)', 'hayyabuild');?>
                                            </li>
                                            <li>
                                                <?php esc_html_e('Now search for the footer tag and replace it with hayybuild function', 'hayyabuild');?>
                                                <div class="code">
                                                    <?php esc_html_e('<footer> .... </footer> OR <div id="footer"> .... </div> or anything else', 'hayyabuild');?>
                                                </div>
                                                <?php esc_html_e('With this code', 'hayyabuild');?>
                                                <div class="code">
                                                    <?php esc_html_e('<?php hayyabuild();?>', 'hayyabuild');?>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="hayya_note">
                                            <?php esc_html_e('You can edit header.php and footer.php with any text editor from your desktop and then upload it to your WordPress theme directory.', 'hayyabuild');?>
                                        </div>
                                        <div class="hayya_note">
                                            <?php esc_html_e('You can try Hayya Theme from WordPress', 'hayyabuild');?>
                                            <a target="_blank" href="https://wordpress.org/themes/hayya/">
                                                <?php echo esc_url('https://wordpress.org/themes/hayya/');?>
                                            </a>
                                        </div>
    	                            </div>
    	                        </section>
        	                </div>
        	            </div>
        	        </li>
        	    </ul>
            </div>
    	</div><?php
    }
} // End Class
