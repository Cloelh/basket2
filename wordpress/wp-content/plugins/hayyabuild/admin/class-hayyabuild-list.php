<?php
/**
 *
 * The admin-list functionality of the plugin.
 *
 * @since        1.0.0
 * @package      hayyabuild
 * @subpackage   hayyabuild/admin
 * @author       zintaThemes <>
 */

if (! defined( 'ABSPATH' ) || class_exists( 'HayyaBuildList' )) return;

class HayyaBuildList extends HayyaBuildAdmin {

    /**
     * Define the view for forntend.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @access    public
     * @since    1.0.0
     * @var      unown
     */
    public function __construct($list = null) {
      return $this->MainList($list);
    }

    /**
     *
     *
     * @access    protected
     * @since    1.0.0
     * @var      unown
     */
    protected function MainList($list = null) {
        ?>
        <div id="hayyabuild" class="wrap">
          <div class="hb-main_settings">
            <?php HayyaBuildView::nav_bar(true);?>
            <div class="status-tab">
                <?php

                $draft_current = $trash_current = $published_current = '';
                if ( HayyaBuildHelper::_get ( 'list' ) === 'draft' ) {
                  $post_status = 'draft';
                  $draft_current = 'active';
                } elseif ( HayyaBuildHelper::_get ( 'list' ) === 'trash' ) {
                  $post_status = 'trash';
                  $trash_current = 'active';
                } else {
                  $post_status = 'publish';
                  $published_current = 'active';
                }

                $counts = wp_count_posts('hayyabuild');

                $published_count = $counts->publish;
                $draft_count = $counts->draft;
                $trash_count = $counts->trash;

                $header = $content = $footer = false;

                ?>
                <ul class="pagination">
                  <li class="<?php echo esc_attr( $published_current );?>">
                      <?php if ( ! HayyaBuildHelper::_get ( 'list' ) ) {?>
                          <?php esc_html_e('Published', 'hayyabuild'); ?> <span class="count">(<?php echo esc_html( $published_count );?>)</span>
                      <?php } else { ?>
                              <a href="admin.php?page=hayyabuild"><?php esc_html_e('Published', 'hayyabuild'); ?> <span class="count">(<?php echo esc_html( $published_count );?>)</span></a>
                      <?php } ?>
                  </li>
                  <li class="<?php echo esc_attr( $draft_current );?>">
                      <?php if ( HayyaBuildHelper::_get ( 'list' ) == 'draft' ) {?>
                          <?php esc_html_e('Draft', 'hayyabuild'); ?> <span class="count">(<?php echo esc_html( $draft_count );?>)</span>
                      <?php } else { ?>
                      <a href="admin.php?page=hayyabuild&amp;list=draft"><?php esc_html_e('Draft', 'hayyabuild'); ?> <span class="count">(<?php echo esc_html( $draft_count );?>)</span></a>
                      <?php } ?>
                  </li>
                  <li class="<?php echo esc_attr( $trash_current );?>">
                      <?php if ( HayyaBuildHelper::_get ( 'list' ) == 'trash' ) {?>
                          <?php esc_html_e('Trash', 'hayyabuild'); ?> <span class="count">(<?php echo esc_html( $trash_count );?>)</span>
                      <?php } else { ?>
                          <a href="admin.php?page=hayyabuild&amp;list=trash" ><?php esc_html_e('Trash', 'hayyabuild'); ?> <span class="count">(<?php echo esc_html( $trash_count );?>)</span></a>
                      <?php } ?>
                  </li>
                </ul>
            </div>

            <div class="content-tab">

              <div class="content-tabs">
                <div class="hayya-filter-tabs">
                  <ul class="tabs">
                    <li class="tab active"><a class="hayya_filter waves-effect" data-filter="all" href="#"><?php esc_html_e('All', 'hayyabuild'); ?></a></li>
                    <li class="tab"><a class="hayya_filter waves-effect" data-filter="header" href="#"><?php esc_html_e('Headers', 'hayyabuild'); ?></a></li>
                    <li class="tab"><a class="hayya_filter waves-effect" data-filter="content" href="#"><?php esc_html_e('Pages Content', 'hayyabuild'); ?></a></li>
                    <li class="tab"><a class="hayya_filter waves-effect" data-filter="footer" href="#"><?php esc_html_e('Footers', 'hayyabuild'); ?></a></li>
                  </ul>
                </div>
                <div class="hayya-list-tabs">
                  <ul class="tabs">
                    <li class="tab active"><a class="hayya_list_view" data-view="list" href="#"><i class="dashicons dashicons-menu"></i></a></li>
                    <li class="tab"><a class="hayya_list_view" data-view="grid" href="#"><i class="dashicons dashicons-screenoptions"></i></i></a></li>
                  </ul>
                </div>
              </div>

              <div class="elements-list">

                <?php

                if ( function_exists( 'register_block_type' ) ) :

                  $loop = new WP_Query(
                    array(
                      'post_type' => 'hayyabuild',
                      'ignore_sticky_posts' => 1,
                      'post_status' => $post_status
                    )
                  );

                  if ( $loop->have_posts() ) :

                    while ( $loop->have_posts() ) : $loop->the_post(); ?>
                      <?php
                      global $post;
                      $settings = get_post_meta($post->ID, '_hayyabuild_settings', true);
                      $title = isset($settings['title']) ? $settings['title'] : 'Empty Title';

                      // backgrount
                      $background = '';
                      if ( isset($settings['background_type']) ) {
                        if ($settings['background_type'] === 'background_image' ) $background = 'background: url('.esc_url($settings['background_image']).');';
                        elseif ( $settings['background_type'] === 'background_video' ) $background = 'background: url('.HAYYABUILD_URL.'admin/assets/images/video_bg.jpg);';
                        elseif ($settings['background_type'] === 'background_color') $background = 'background: '.$settings['background_color'].';';
                      } else {
                        $background = 'background: url('.HAYYABUILD_URL.'admin/assets/images/empty_bg.png) repeat;';
                      }


                      $type = isset($settings['type']) ? $settings['type'] : 'content';

                      $$type = true;

                      // pages list
                      $pages = isset($settings['pages']) ? $settings['pages'] : [];
                      $pages_list = '';
                      if ( is_array($pages) && ! empty($pages) ) {
                        foreach ($pages as $page) {
                          if ( $page == 'all') $pages_list .= ' | '. $page;
                          else $pages_list .= ' | '. get_the_title( $page );
                        }
                      }

                      $list = HayyaBuildHelper::_get ( 'list' ) ? '&amp;list=' . HayyaBuildHelper::_get ( 'list' ) : '';

                      $edit_url = 'admin.php?page=hayyabuild&amp;id='.$post->ID.'&amp;action=edit';
                      $edit_nonce_url = wp_nonce_url( $edit_url, 'edit_url' ,'_hbnonce' );

                      $trash_url = 'admin.php?page=hayyabuild'.$list.'&amp;id='.$post->ID.'&amp;action=trash';
                      $trash_nonce_url = wp_nonce_url( $trash_url, 'trash_url' ,'_hbnonce' );

                      $publish_url = 'admin.php?page=hayyabuild&amp;list=draft&amp;id='.$post->ID.'&amp;action=publishe';
                      $publish_nonce_url = wp_nonce_url( $publish_url, 'publish_url' ,'_hbnonce' );

                      // $deactivate_draft_url = 'admin.php?page=hayyabuild&amp;list=draft&amp;id='.$post->ID.'&amp;action=deactivate';
                      // $deactivate_draft_nonce_url = wp_nonce_url( $deactivate_draft_url, 'deactivate_draft_url' ,'_hbnonce' );

                      $restore_trash_url = 'admin.php?page=hayyabuild&amp;list=trash&amp;id='.$post->ID.'&amp;action=restore';
                      $restore_trash_nonce_url = wp_nonce_url( $restore_trash_url, 'restore_trash_url' ,'_hbnonce' );

                      $delete_url = 'admin.php?page=hayyabuild&amp;list=trash&amp;id='.$post->ID.'&amp;action=delete';
                      $delete_nonce_url = wp_nonce_url( $delete_url, 'delete_url' ,'_hbnonce' );

                      $delete_template_url = 'admin.php?page=hayyabuild&amp;id='.$post->ID.'&amp;action=delete';
                      $delete_template_nonce_url = wp_nonce_url( $delete_template_url, 'delete_template_url' ,'_hbnonce' );

                      $export_url = 'admin.php?page=hayyabuild&amp;id='.$post->ID.'&amp;export=1';
                      $export_nonce_url = wp_nonce_url( $export_url, 'export_url' ,'_hbnonce' );

                      ?>


                      <div style="<?php echo esc_html( $background );?>" class="element-list hayya_filter_items filter_<?php echo esc_attr( $type );?>">
                        <div class="list-title">
                          <div class="container">
                            <span class="element-link">
                              <?php
                              printf(
                                '<a class="row-title" href="%s" aria-label="%s">%s</a>',
                                get_edit_post_link( $post->ID ),
                                /* translators: %s: post title */
                                esc_attr( sprintf( esc_html( '&#8220;%s&#8221; (Edit)', 'hayyabuild' ), $title ) ),
                                esc_html( $title )
                              );
                              ?>
                              <span class="pages-list"><?php esc_html_e('Pages List: ', 'hayyabuild'); esc_html_e($pages_list);?></span> 
                              <span class="type"><?php esc_html_e('Type: ', 'hayyabuild'); echo esc_html( $type );?></span>
                              <?php if ( 'publish' === $post_status && empty( $pages ) && $type === 'content' ) : ?>
                                <span>
                                  <?php esc_html_e('Shortcode', 'hayyabuild')?>:
                                  <code class="copy-shortcode">[hayyabuild id="<?php echo esc_attr( $post->ID ); ?>"]</code>
                                </span>
                              <?php endif; ?>
                            </span>
                            <div class="row-action">
                              <a title="<?php esc_html_e('Edit', 'hayyabuild'); ?>" href="<?php echo get_edit_post_link( $post->ID );?>">
                                <?php esc_html_e('Edit', 'hayyabuild'); ?> <i class="fa fa-edit"></i>
                              </a>

                              <?php if ( ! HayyaBuildHelper::_get ( 'list' ) || 'draft' === HayyaBuildHelper::_get ( 'list' ) ) { ?>
                                <a href="<?php echo esc_url($trash_nonce_url);?>" class="submitdelete">
                                  <?php esc_html_e('Trash', 'hayyabuild'); ?> <i class="fa fa-trash-alt"></i>
                                </a>
                              <?php } ?>
                              <?php if ( 'draft' === HayyaBuildHelper::_get ( 'list' ) ) { ?>
                                <a href="<?php echo esc_url($publish_nonce_url);?>">
                                  <?php esc_html_e('Publish', 'hayyabuild'); ?> <i class="fa fa-plane-departure"></i>
                                </a>
                              <?php } elseif ( 'trash' === HayyaBuildHelper::_get ( 'list' ) ) { ?>
                                <a href="<?php echo esc_url($restore_trash_nonce_url);?>">
                                  <?php esc_html_e('Restore', 'hayyabuild'); ?> <i class="fa fa-save"></i>
                                </a>
                                <a href="<?php echo esc_url($delete_nonce_url);?>" class="submitdelete">
                                  <?php esc_html_e('Delete', 'hayyabuild'); ?> <i class="fa fa-window-close"></i>
                                </a>
                              <?php } ?>

                              <a href="<?php echo admin_url( $export_nonce_url );?>">
                                <?php esc_html_e('Export', 'hayyabuild'); ?> <i class="fa fa-file-export"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div> <?php
                    endwhile;

                    // wp_reset_postdata();
                    wp_reset_query();

                    if ( ! $header ) { ?>
                      <div class="filter_empty_header empty-filter">
                        <?php HayyaBuildView::empty_list(true, false) ?>
                      </div>
                    <?php } ?>
                    <?php if ( ! $content ) { ?>
                      <div class="filter_empty_content empty-filter">
                        <?php HayyaBuildView::empty_list(true, false) ?>
                      </div>
                    <?php } ?>
                    <?php if ( ! $footer ) { ?>
                      <div class="filter_empty_footer empty-filter">
                        <?php HayyaBuildView::empty_list(true, false) ?>
                      </div>
                    <?php } ?>
                  <?php else: ?>
                      <?php HayyaBuildView::empty_list(true, true) ?>
                  <?php endif;

                else: ?>
                    <div class="filter_empty_header empty-filter">
                      <?php HayyaBuildView::please_upgrade(true, false) ?>
                    </div>
                  <?php
                endif; ?>

              </div>

            </div>
          </div>

          <?php HayyaBuildView::import_form();?>

        </div> <?php
    }

} // End Class
