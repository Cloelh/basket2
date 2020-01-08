<?php
/**
 *
 * The admin-specific functionality of the plugin.
 *
 * @since        1.0.0
 * @package      hayyabuild
 * @subpackage   hayyabuild/includes
 * @author       zintaThemes <>
 */

if (! defined( 'ABSPATH' ) || class_exists( 'HayyaBuildAdmin' )) return;

class HayyaBuildAdmin extends HayyaBuild
{
    /**
     * The single instance of HayyaBuild.
     * @var     object
     * @access  private
     * @since     3.0.0
     */
    private static $_instance = false;

    /**
     * The ID of this plugin.
     *
     * @since       1.0.0
     * @access   private
     * @var        string     $plugin_name   name of this plugin.
     */
    private $plugin_name   = null;

    /**
      * The version of this plugin.
      *
      * @since       1.0.0
      * @access   private
      * @var        string     $version     The current version of this plugin.
      */
    private $version     = null;

    /**
      * Element ID.
      *
      * @since       1.0.0
      * @access   private
      * @var        Intger     $id         Element ID.
      */
    private $id       = null;

    /**
      * The elements list.
      *
      * @since       1.0.0
      * @access   private
      * @var        string     $version     The current version of this plugin.
      */
    protected static $modules = array();

    /**
      *
      * @since     1.0.0
      * @access    protected
      * @var       string    $type    Elements type.
      */
    protected static $type = null;

    /**
     *
     */
    protected static $page = null;

    /**
      * Initialize the class and set its properties.
      *
      * @since       1.0.0
      * @param       string     $plugin_name   The name of this plugin.
      * @param       string     $version     The version of this plugin.
      */
    public function __construct() {
      'hayyabuild' === HayyaBuildHelper::_get( 'page' ) && $this->call_actions();
      'hayyabuild_templates' === HayyaBuildHelper::_get( 'page' ) && $this->call_templates();
      add_action( 'save_post', [ $this, 'save_hayyabuild_meta' ] );
      // HayyaBuildHelper::_is_main_pages() && $this->submit();
    } // End _construct()

    /**
     * Add header function
     *
     * @access      public
     * @since       1.0.0
     */
    public static function add_header() {
        self::hayyabuild_admin();
    } // End add_header()

    /**
     * Add footer function
     *
     * @access      public
     * @since       1.0.0
     */
    public static function add_footer() {
        self::hayyabuild_admin();
    } // End add_footer()

    /**
     * Add Content function
     *
     * @access      public
     * @since       1.0.0
     */
    public static function add_content() {
        self::hayyabuild_admin();
    } // End add_content()

    /**
     *
     * Load admin templates page
     *
     * @access       private
     * @since       1.0.0
     */
    public static function templates() {
      $include = false;
      $file = HAYYABUILD_PATH . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-templates.php';
      if ( file_exists($file) ) {
        require_once $file;
        $include = true;
      }
      HayyaBuildView::template_list(
        HayyaBuildView::templates_array(),
        $include
      );
    } // End templates()

    /**
     *
     * Load admin help page
     *
     * @access       private
     * @since       1.0.0
     */
    public static function options() {
        require_once HAYYABUILD_PATH . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-settings.php';
        new HayyaBuildSettings();
    } // End hayya_help()

    /**
     *
     * Load admin help page
     *
     * @access       private
     * @since       1.0.0
     */
    public static function help() {
        require_once HAYYABUILD_PATH . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-help.php';
        new HayyaBuildHelp();
    } // End hayya_help()

    /**
     * call hayyabuild actions
     */
    public function call_actions() {
      if ( HayyaBuildHelper::_get( 'export' ) === '1' )
        return $this->export();

      $action = HayyaBuildHelper::_get( 'action' );
      switch ($action) {
        case 'restore':
          return $this->restore();
          break;
        case 'delete':
          return $this->delete();
          break;
        case 'trash':
          return $this->trash();
          break;
        case 'publishe':
          return $this->publishe();
          break;
      }

      if ( 'import' === HayyaBuildHelper::_post( 'import' ) ) {
        require_once HAYYABUILD_PATH . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-import.php';
        return HayyaBuildEmport::import_save();
      }
    } // End call_actions()

    /**
     * call hayyabuild actions
     */
    public function call_templates() {
      if ( HayyaBuildHelper::_post('tpl') ) {
        require_once HAYYABUILD_PATH . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-templates.php';
        return HayyaBuildTemplates::template_save();
      }
    } // End call_actions()

    /**
      *
      * load admin views page
      *
      * @access   public
      * @since       1.0.0
      */
    public static function hayyabuild_admin() {
        if ('hayyabuild' === HayyaBuildHelper::_get('page')) {
            require_once HAYYABUILD_PATH . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'class-hayyabuild-list.php';
            new HayyaBuildList();
        }
    } // End hayyabuild_admin()

    /**
     * Bedore saves a hayyabuild post type.
     *
     * @param      string  $post_id  The post identifier
     *
     * @return     string  The post identifier
     */
    public function save_hayyabuild_meta( $post_id = null ) {
      if ( self::$_instance || ! $post_id ) return $post_id;
      self::$_instance = true;

      $post_types = [ 'post', 'page', 'event', 'hayyabuild' ];
      $post_type = get_post_type($post_id);

      if ( ! in_array( $post_type, $post_types ) ) return $post_id;

      $inlinestyle = json_decode(
        HayyaBuildHelper::_post('hayyabuild_inlinestyle')
      );

      update_post_meta($post_id, '_hayyabuild_inlinestyle', $inlinestyle);

      if (
        $post_type !== 'hayyabuild' ||
        ! isset( $_POST['hayyabuild_nonce'] ) ||
        ! wp_verify_nonce( wp_unslash( $_POST['hayyabuild_nonce'] ), 'hayyabuild_nonce_action' )
      ) return $post_id;

      $settings = HayyaBuildHelper::_post('settings');
      $css      = HayyaBuildHelper::_post('hayyabuild_css');
      $pages    = [];


      if ( ! empty($settings) && is_array($settings) ) {
          $pages = $settings['pages'];
          $type = 'header' === $settings['type'] || 'footer' === $settings['type'] ? $settings['type'] : 'content';

          // update HayyaBuild post title
          $title = $settings['title'] ? $settings['title'] : 'HayyaBuild ' . date("m.d.y - g:i a");
          // if ( ! $settings['title'] ) $settings['title'] = $title;
          wp_update_post( [ 'ID' => $post_id, 'post_title' => $title ] );
      } else {
        $type = 'content';
      }

      update_post_meta($post_id, '_hayyabuild_settings', $settings);
      update_post_meta($post_id, '_hayyabuild_css', $css);

      ! wp_is_post_autosave($post_id) && $this->add_to_map( $post_id );

      return $post_id;
    } // End save_hayyabuild_meta()

    /**
     * generate_map
     */
    public function add_to_map( $post_id ) {
      if ( ! $post_id ) return false;
      $settings = get_post_meta( $post_id, '_hayyabuild_settings', true );
      if ( empty($settings) || ! is_array($settings) || ! $settings['type'] ) return $post_id;

      $type = $settings['type'];
      $pages = ! empty( $settings['pages'] ) ? $settings['pages'] : [];

      $map = (array) get_option('hayyabuild_map');
      foreach ($map as $key => $value) {
          if ( ! $value['type'] || get_post_type($key) !== 'hayyabuild' || wp_is_post_autosave($key) || empty( $value['pages'] ) ) unset($map[$key]);
      }
      $map[$post_id] = array( 'type' => $type, 'pages' => $pages );
      update_option('hayyabuild_map', $map);
    } // End generate_map()

    /**
     * generate_map
     */
    public function remove_from_map($post_id) {
      if ( ! $post_id ) return false;
      $map = (array) get_option('hayyabuild_map');
      if ( isset($map[$post_id]) ) unset( $map[$post_id] );
      update_option('hayyabuild_map', $map);
    } // End remove_from_map()

    /**
      *
      * @param   unknown
      */
    private function publishe() {
      $nonce = HayyaBuildHelper::_get('_hbnonce');
      $post_id = HayyaBuildHelper::_get('id');
      if ( ! $post_id || empty( $nonce ) || ! wp_verify_nonce( $nonce, 'publish_url' ) ) return;

      $post_type = get_post_type($post_id);

      if ( $post_type !== 'hayyabuild' ) {
        return HayyaBuildHelper::_notices(esc_html('ERROR: You can only publish HayyaBuild posts.', 'hayyabuild'), 'error');
      }

      $this->add_to_map( $post_id );
      wp_publish_post( $post_id  );
      return HayyaBuildHelper::_notices(esc_html('SUCCESS: Item has been successfully published.', 'hayyabuild'), 'success');
    } // End publishe()

    /**
      *
      * @param   unknown
      */
    private function restore() {
      $nonce = HayyaBuildHelper::_get('_hbnonce');
      $post_id = HayyaBuildHelper::_get('id');
      if ( ! $post_id || empty( $nonce ) || ! wp_verify_nonce( $nonce, 'restore_trash_url' ) ) return;

      $post_type = get_post_type($post_id);

      if ( $post_type !== 'hayyabuild' ) {
        return HayyaBuildHelper::_notices(esc_html('ERROR: You can only restore HayyaBuild posts from trash.', 'hayyabuild'), 'error');
      }

      if ( wp_untrash_post( $post_id  ) ) {
        $this->add_to_map( $post_id );
        return HayyaBuildHelper::_notices(esc_html('SUCCESS: Item has been successfully restored from trash.', 'hayyabuild'), 'success');
      } else {
       return HayyaBuildHelper::_notices(esc_html('ERROR:  Someting happen, Can\'t restore this item from trash.', 'hayyabuild'), 'error');
      }
    } // End restore()

    /**
      *
      * @param   unknown
      */
    private function trash() {
      $nonce = HayyaBuildHelper::_get('_hbnonce');
      $post_id = HayyaBuildHelper::_get('id');
      if ( ! $post_id || empty( $nonce ) || ! wp_verify_nonce( $nonce, 'trash_url' ) ) return;

      $post_type = get_post_type($post_id);

      if ( $post_type !== 'hayyabuild' ) {
        return HayyaBuildHelper::_notices(esc_html('ERROR: You can only move HayyaBuild posts to trash.', 'hayyabuild'), 'error');
      }

      if ( wp_trash_post( $post_id  ) ) {
        $this->remove_from_map( $post_id );
        return HayyaBuildHelper::_notices(esc_html('SUCCESS: Item has been successfully moved to trash.', 'hayyabuild'), 'success');
      } else {
       return HayyaBuildHelper::_notices(esc_html('ERROR:  Someting happen, Can\'t move this item to trash.', 'hayyabuild'), 'error');
      }
    } // End trash()

    /**
     *
     * @param   unknown
     */
    private function delete() {
      $nonce = HayyaBuildHelper::_get('_hbnonce');
      $post_id = HayyaBuildHelper::_get('id');
      if ( ! $post_id || empty( $nonce ) || ! wp_verify_nonce( $nonce, 'delete_url' ) ) return;

      $post_type = get_post_type($post_id);

      if ( $post_type !== 'hayyabuild' ) {
        return HayyaBuildHelper::_notices(esc_html('ERROR: You can only delete HayyaBuild posts.', 'hayyabuild'), 'error');
      }

      if ( wp_delete_post( $post_id  ) ) {
        $this->remove_from_map( $post_id );
        return HayyaBuildHelper::_notices(esc_html('SUCCESS: Item has been successfully deleted.', 'hayyabuild'), 'success');
      } else {
       return HayyaBuildHelper::_notices(esc_html('ERROR:  Someting happen, Can not delete this item.', 'hayyabuild'), 'error');
      }
    } // End delete()

    /**
     * import json data
     *
     * @param      string   $f      
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    public static function import( $f ) {
      $site_url = get_site_url();
      $name     = HayyaBuildHelper::_post( 'name' );
      $pages    = maybe_serialize( HayyaBuildHelper::_post( 'pages' ) );

      ob_start();
      include wp_unslash($f);
      $encode_options = ob_get_clean();
      $data           = json_decode( $encode_options, true );

      if (
          ! isset($data['version']) ||
          ! isset($data['content']) ||
          'hayyabuild' !== $data['post_type']
      ) return false;

      $inlinestyle = [];

      foreach ($data as $key => $value) {
          if ( $key === 'settings') {
              $settings = $value;
              foreach ( $settings as $k => $v ) {
                  if ( is_string($v) ) {
                      if ( $k === 'height' ) $settings['height'] = sanitize_text_field($v);
                      elseif ( $k === 'background_image' ) $settings['background_image'] = esc_url($v);
                      elseif ( $k === 'background_video' ) $settings['background_video'] = esc_url($v);
                      $settings[$k] = str_replace('<--site_url-->', $site_url, $v);
                  }
              }
              $data['settings'] = $settings;
          } else if ( $key === 'content' ) {
              $data['content'] = str_replace('<--site_url-->', $site_url, $data['content']);
          } else if ( $key === 'inlinestyle' ) {
              foreach ($value as $k => $v) {
                $inlinestyle[$k] = str_replace('<--site_url-->', $site_url, $v);
              }
              $data['inlinestyle'] = $inlinestyle;
          }
      }

      if ( 'include_pages' !== HayyaBuildHelper::_post('include_pages') ) {
          unset($data['settings']['pages']);
      } else if ( HayyaBuildHelper::_post( 'pages' ) ) {
          $data['settings']['pages'] = maybe_serialize( HayyaBuildHelper::_post( 'pages' ) );
      }

      $data['settings']['title'] = HayyaBuildHelper::_post( 'name' ) ? HayyaBuildHelper::_post( 'name' ) : $data['title'];
      $post = [
          'post_content' => $data['content'],
          'post_title' => $data['settings']['title'],
          'post_type' => 'hayyabuild',
      ];

      if ( $post_id = wp_insert_post($post) ) {
          update_post_meta($post_id, '_hayyabuild_settings', $data['settings']);
          update_post_meta($post_id, '_hayyabuild_css', $data['css']);
          update_post_meta($post_id, '_hayyabuild_inlinestyle', $data['inlinestyle']);
          wp_redirect(
            site_url() . '/wp-admin/post.php?post=' . $post_id . '&action=edit'
          );
          exit();
      } else {
          HayyaBuildHelper::_notices( esc_html('ERROR06: Someting happen, Can\'t update database.', 'hayyabuild'), 'error' );
          return false;
      }
    }

    /**
     *
     * @param unknown $param
     */
    public function export() {

        $nonce = HayyaBuildHelper::_get('_hbnonce');
        $post_id = HayyaBuildHelper::_get('id');

        if ( ! $post_id || empty($nonce) || ! wp_verify_nonce( $nonce, 'export_url' ) ) return;

        $post = get_post($post_id);

        if ( ! $post ) {
          return HayyaBuildHelper::_notices(esc_html('ERROR: The post you requested was not found.', 'hayyabuild'), 'error');
        }

        if ( $post->post_type !== 'hayyabuild' ) {
          return HayyaBuildHelper::_notices(esc_html('ERROR: You can only export HayyaBuild posts.', 'hayyabuild'), 'error');
        }

        $hayyabuild_css = get_post_meta($post_id, '_hayyabuild_css', true);
        $inlinestyle = get_post_meta($post_id, '_hayyabuild_inlinestyle', true);
        $settings = get_post_meta($post_id, '_hayyabuild_settings', true);

        $name = str_replace(" ", "_", $post->post_title);
        $site_url = get_site_url();
        $json_name = 'HayyaBuild-' . $name . '-' . date("m-d-Y"); // Namming the filename will be generated.

        $post_content = str_replace($site_url, '<--site_url-->', $post->post_content);

        $style = [];
        foreach ($inlinestyle as $key => $value) {
          $style[$key]['element'] = $value->element;
          $style[$key]['style'] = str_replace($site_url, '<--site_url-->', $value->style);
        }

        $inlinestyle = $style;// str_replace($site_url, '<--site_url-->', $inlinestyle);

        foreach ( $settings as $k => $v ) {
          if ( ! is_array($v) ) {
            $settings[$k] = str_replace($site_url, '<--site_url-->', $v);
          }
        }


        $data = [
          'content' => $post_content,
          'settings' => $settings,
          'inlinestyle' => $inlinestyle,
          'css' => $hayyabuild_css,
          'title' => $post->post_title,
          'post_type' => 'hayyabuild',
          'version' => HAYYABUILD_VERSION,
          'exported_in' => date("m.d.y - g:i a")
        ];

        $json_file = json_encode($data); // Encode data into json data
        header("Content-Type: text/json; charset=utf8" . get_option('blog_charset'));
        header("Content-Disposition: attachment; filename=$json_name.json");
        echo $json_file;
        exit();
    } // End export()
} // end of class HayyaBuildAdmin
