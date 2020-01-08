<?php
/**
 *
 * The admin-view functionality of the plugin.
 *
 * @since      	1.0.0
 * @package    	hayyabuild
 * @subpackage 	hayyabuild/admin
 * @author     	zintaThemes <>
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

class HayyaBuildView {

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
    public function __construct() {}


    /**
     *
     * @param unknown $message
     */
    public static function help_tip($message = NULL) {
    	if ( !empty($message) ) {
    		echo '<span class="help-tip"><i class="hb_helper">'.esc_html( $message ).'</i></span>';
    	} else return false;
    }

    /**
     *
     * Show empty list message
     *
     * @param unknown $showButtns
     * @param unknown $mainList
     */
    public static function empty_list( $showButtns = NULL, $mainList = NULL ) { ?>
    	<div class="hayya_card-panel">
			<span>
				<?php
				esc_html_e( 'This list is empty!', 'hayyabuild' );
				if ( $mainList ) echo '<br/>';
				if ( $showButtns) :?>
					<br/>
					<a href="post-new.php?post_type=hayyabuild&type=header" class="waves-effect waves-light btn"><i class="fa fa-plus"></i> <?php esc_html_e('New Header','hayyabuild' );?></a>
					<a href="post-new.php?post_type=hayyabuild&type=content" class="waves-effect waves-light btn"><i class="fa fa-plus"></i> <?php esc_html_e('New Content','hayyabuild' );?></a>
					<a href="post-new.php?post_type=hayyabuild&type=footer" class="waves-effect waves-light btn"><i class="fa fa-plus"></i> <?php esc_html_e('New Footer','hayyabuild' );?></a>
				<?php endif;?>
			</span>
		</div> <?php
    }


    /**
     *
     * Show empty list message
     *
     * @param unknown $showButtns
     * @param unknown $mainList
     */
    public static function please_upgrade() { ?>
      <div class="hayya_card-panel">
        <h4><?php esc_html_e( 'HayyaBuild Version 5.0 and later require WordPress 5.0 or later!', 'hayyabuild' ); ?></h4>
        <h5><?php esc_html_e( 'To use HayyaBuild please upgrade WordPress!', 'hayyabuild' ); ?></h5>
      </div> <?php
    }


    /**
     *
     * Show NavBar
     *
     */
    public static function nav_bar ( $main = NULL ) {
      $direction = is_rtl() ? 'right' : 'left'; ?>
	    <div class="main_conf">
        <img class="hayyabuild-logo" src="<?php echo esc_url( HAYYABUILD_URL.'admin/assets/images/main_logo.png?v='.HAYYABUILD_VERSION );?>"/>
	   </div><?php
    }

    /**
     *
     * Show emprt form
     *
     */
    public static function import_form () { ?>
        <ul class="hayyabuild-collapsible import-form" data-collapsible="accordion">
		    <li>
				<div class="collapsible-header">
					<i class="fa fa-mail-forward"></i>
					<?php esc_html_e( 'Import', 'hayyabuild');?>
				</div>
				<div class="collapsible-body">
                <?php
                $file = HAYYABUILD_PATH . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-import.php';
                if ( file_exists( $file ) && ! HayyaBuildHelper::check() ) {
                    require_once $file;
                    HayyaBuildEmport::import_form();
                } else if ( method_exists( 'HayyaBuildView', 'hayya_lite' ) ) {
                    HayyaBuildView::get_pro('import_form');
                }
                ?>
                </div>
            </li>
        </ul>
        <?php
	}

  /**
   *    @method    hayya_lite
   *    @param     string    $show    [description]
   *    @param     string    $options    [description]
   *    @return    string    [description]
   *
   *    @since     1.0.0
   *    @access    public
   */
  public static function hayya_lite( $page = 'empty' ) {
    $plugin_link = esc_url( 'https://hayyabuild.zintathemes.com?'.$page.'=1' );
    ?>
    <div class="hayyabuild-get-pro">
        <div class="center-align">
        	<p class="center-align">
            	<?php esc_html_e('This feature is available only in HayyaBuild Pro. You can unlock all features by getting HayyaBuild Pro version.', 'hayyabuild'); ?>

        	</p>
            <a target="_blank" class="waves-effect waves-darck" href="<?php echo esc_url($plugin_link); ?>">
            	<?php esc_html_e('GET IT NOW', 'hayyabuild'); ?>
            </a>
        </div>
    </div>
    <?php
  }

  /**
   *
   *
   * @access		protected
   * @since		1.0.0
   * @var			unown
   */
  public static function template_list( $templates, $include = false ) {
  	?>
  	<div id="hayyabuild" class="wrap">
  		<div class="hb-main_settings hayya_template">
  	    <?php self::nav_bar(); ?>
        <div class="status-tab">
          <ul class="pagination">
            <li class="active">
                <?php esc_html_e( 'Templates List', 'hayyabuild' );?>
            </li>
          </ul>
        </div>
  	    <?php if ( ! HayyaBuildHelper::_get( 'tpl' ) ) { ?>
	    	  <div class="content-tab" id="hayy_templates" >
            <div class="content-tabs">
    					<div class="hayya-filter-tabs">
    						<ul class="tabs">
    							<li class="tab active"><a class="hayya_filter waves-effect" data-filter="all" href="#"><?php esc_html_e('All', 'hayyabuild'); ?></a></li>
    							<li class="tab"><a class="hayya_filter waves-effect" data-filter="header" href="#"><?php esc_html_e('Headers', 'hayyabuild'); ?></a></li>
    							<li class="tab"><a class="hayya_filter waves-effect" data-filter="footer" href="#"><?php esc_html_e('Footers', 'hayyabuild'); ?></a></li>
    						</ul>
    					</div>
            </div>
            <div class="elements-list">
              <div class="wp-block-hayyabuild-row has-1-3_1-3_1-3-columns">

                <?php
                if ( ! $include ) {
                  HayyaBuildView::get_pro('templates_page');
                }
                ?>

    		      <?php foreach( $templates as $key => $value ) : ?>
    		        <div class="wp-block-hayyabuild-column hayya_filter_items filter_<?php echo $value['type'];?>">
                  <?php
                  $image = '';
                  if( file_exists(HAYYABUILD_PATH.'includes/data/'.$key.'.jpg') ) {
                    $image = HAYYABUILD_URL.'includes/data/'.$key.'.jpg?v='.HAYYABUILD_VERSION;
                  } else if ( file_exists(HAYYABUILD_PATH.'includes/data/'.$key.'.png') ) {
                    $image = HAYYABUILD_URL.'includes/data/'.$key.'.png?v='.HAYYABUILD_VERSION;
                  }
                  ?>
                  <div class="hayyabuild-templates-card hayyabuild-box-hoverable box-shadow-3">
                    <div class="card-image">
                      <img class="activator" src="<?php echo esc_url($image); ?>">
                    </div>
                    <div class="card-content">
                      <span class="card-title activator grey-text text-darken-4"><?php echo sanitize_text_field($value['name']); ?></span>
                      <div class="card-footer">
                        <?php esc_html_e('Type: ', 'hayyabuild'); echo $value['type']; ?>
                      </div>
                    </div>
                    <div class="card-reveal">
                      <span class="card-title grey-text text-darken-4">
                          <?php echo sanitize_text_field($value['name']); ?><i class="fa fa-close right"></i><hr/>
                      </span>
                      <div>
                        <?php echo $value['description']; ?>
                        <div>
                          <?php
                          if ( $include ) { ?>
                            <a href="admin.php?page=hayyabuild_templates&amp;section=templates&amp;tpl=<?php echo $key; ?>" class="btn">
                              <?php esc_html_e( 'Create', 'hayyabuild' );?>
                            </a><?php
                          }?>
                        </div>
                      </div>
                    </div>
                  </div>
    	    			</div>
  	    	      <?php endforeach; ?>
              </div>
            </div>
    	    </div> <?php
    		} else {
	        $tpl        = HayyaBuildHelper::_get( 'tpl' );
	        $template   = $templates[$tpl];
	        $type       = $template['type'];
          $url        = HAYYABUILD_URL.'includes/data/';
          $path       = HAYYABUILD_PATH.'includes/data/';
          $image      = '';

          if ( file_exists($path.$tpl.'.jpg') ) {
            $image = '<img class="activator" src="'.esc_url($url.$tpl.'.jpg?v='.HAYYABUILD_VERSION).'">';
          } else if ( file_exists($path.$tpl.'.png') ) {
            $image = '<img class="activator" src="'.esc_url($url.$tpl.'.png?v='.HAYYABUILD_VERSION).'">';
          }
	        if ( is_array($template) ) {
            ?>
            <div class="templates-title">

            </div>
            <div class="content-tab">
              <div class="content-tabs">
                <div class="hayya-filter-tabs">
                  <ul class="tabs">
                    <li class="tab active"><a class="hayya_filter"><?php esc_html_e( 'New from template', 'hayyabuild' );?></a></li>
                  </ul>
                </div>
              </div>
              <div class="elements-list">
                <div class="wp-block-hayyabuild-row has-1-3_2-3-columns template-form">
                    <div class="wp-block-hayyabuild-column">
                      <div class="hayyabuild-templates-card">
                        <div class="card-image waves-effect waves-block waves-light">
                          <?php echo $image; ?>
                        </div>
                        <div class="card-content">
                          <span class="card-title activator grey-text text-darken-4">
                            <?php esc_html_e($template['name']); ?>
                          </span>
                          <div class="card-footer">
                            <?php esc_html_e('Type: ', 'hayyabuild'); esc_html_e( $template['type'] ); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="wp-block-hayyabuild-column input-field">
                      <form method="post" action="" class="form-inline" role="form" >
                        <?php wp_nonce_field( 'import_form_nonce', '_hbnonce' ); ?>
                        <input type="hidden" id="tpl" value="<?php esc_attr_e($tpl);?>" name="tpl">
                        <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                          <div class="wp-block-hayyabuild-column input-field align-right">
                            <?php esc_html_e( ucfirst($type).' Name', 'hayyabuild' );?>
                          </div>
                          <div class="wp-block-hayyabuild-column">
                            <input name="name" id="name" size="30" value="<?php esc_attr_e($template['name']); ?>" type="text" class="validate">
                          </div>
                        </div>
                        <div class="wp-block-hayyabuild-row has-1-4_3-4-columns">
                          <div class="wp-block-hayyabuild-column input-field align-right">
                            <?php esc_html_e( 'Pages', 'hayyabuild' ); ?>
                          </div>
                          <div class="wp-block-hayyabuild-column">
                            <select id="pages" name="pages[]" data-placeholder="Select Pages" class="chosen-select" multiple> <?php
                              $pages = get_pages();
                              $all_selected = ' selected';
                              $error_selected = '';
                              if ( HayyaBuildHelper::_get( 'tpl' ) === '404_error' ) {
                                $all_selected = '';
                                $error_selected = ' selected';
                              }
                              echo '<option value="all"' . esc_attr($all_selected) . '>'.esc_html( 'All pages', 'hayyabuild' ).'</option>';?>
                              <optgroup label="<?php esc_html_e( 'Pages List', 'hayyabuild' )?>">
                              <?php foreach ( $pages as $page ) {
                                echo '<option value="' .esc_attr($page->ID). '">' . esc_attr($page->post_title) . '</option>';
                              } ?>
                              <optgroup label="<?php esc_html_e( 'Other Pages', 'hayyabuild' )?>"> <?php
    				                    $selected = '';
    				                    if ( isset($pages_list) && is_array($pages_list) ) $selected = ( $pages_list && in_array( '404page', $pages_list ) ) ? ' selected' : '';
                                  echo '<option value="404page"' . esc_attr($error_selected) . '>'.esc_html( '404 Error Page', 'hayyabuild' ).'</option>';?>
    				                    ?>
                              </optgroup>
                              </optgroup>
                            </select>
                          </div>
                        </div>
                          <div class="align-right">
                            <button class="btn right" type="submit" name="publish" value="publish">
                              <?php  esc_html_e('Add', 'hayyabuild'  ); ?>
                            </button>
                          </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div> <?php
            }
  	    } ?>
      </div>
  	</div>
  	<?php
  }

    /**
     * Templates list.
     *
     * @since   1.3.0
     */
    public static function templates_array() {
      $json_file = HAYYABUILD_PATH . 'admin' . DIRECTORY_SEPARATOR . 'templates.json';
      $ext = pathinfo( $json_file, PATHINFO_EXTENSION );
      if ( file_exists($json_file) && is_file( $json_file ) && $ext === 'json' ) {

        ob_start();
        include $json_file;
        $content = ob_get_clean();

        if ( $content ) {
          $data = json_decode( $content, true );
          if ( is_array( $data ) && ! empty($data) ) return $data;
        }
      }
      return [];
    }

  /**
   * display lite message
   * 
   * @access    protected
   * @since   1.0.0
   * @var     unown
   */
  public static function get_pro( $page = 'empty' ) {
    $plugin_link = esc_url( 'https://hayyabuild.zintathemes.com?'.$page.'=1' );
    ?>
      <div class="hayyabuild-get-pro">
        <div>
          <?php esc_html_e( 'Sorry about that. But this feature is unavailable in lite version.', 'hayyabuild' ); ?>
        </div>
        <?php esc_html_e( 'Get more features', 'hayyabuild' ); ?>
        <a href="<?php echo esc_url($plugin_link) ?>" target="_blank">
          <?php esc_html_e('from here.', 'hayyabuild'); ?>
        </a>
      </div>
    <?php
  }
} // End Class
