"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/* eslint no-var: 0 */
(function ($) {
  'use strict';

  var hayyaBuild =
  /*#__PURE__*/
  function () {
    function hayyaBuild() {
      _classCallCheck(this, hayyaBuild);

      // HayyaBuild version
      this.name = 'HayyaBuild'; // HayyaBuild description

      this.description = 'HayyaBuild allows you to build unlimited headers,', 'pages and footers for your WordPress website without the needs for writing any code.'; // HayyaBuild version

      this.version = '5.0';
      this.grid = false; // set list view value

      this._initializer();
    }
    /**
     * on dom content loaded
     */


    _createClass(hayyaBuild, [{
      key: "domContentLoaded",
      value: function domContentLoaded() {
        var _this = this;

        document.addEventListener('DOMContentLoaded', function () {
          _this.editorBackground();

          _this.material();

          _this.CSSEditor(document.getElementById('code_editor_page_css'));
        });
      }
      /**
       * initialize CSS Editor box
       */

    }, {
      key: "CSSEditor",
      value: function CSSEditor(_CSSEditor) {
        if (_CSSEditor) {
          var editorSettings = wp.codeEditor.defaultSettings ? _.clone(wp.codeEditor.defaultSettings) : {}; // eslint-disable-line no-undef

          editorSettings.codemirror = _.extend({}, // eslint-disable-line no-undef
          editorSettings.codemirror, {
            tabSize: 2,
            mode: 'css'
          });
          var cssEditorInit = wp.codeEditor.initialize(_CSSEditor, editorSettings);
          typeof cssEditorInit.codemirror.on === 'function' && cssEditorInit.codemirror.on('change', function (c) {
            _CSSEditor.value = c.getValue();
          });
        }
      }
      /**
       * material init
       */

    }, {
      key: "material",
      value: function material() {
        var fileFields = document.querySelectorAll('.file-field input[type="file"]');
        fileFields && fileFields.forEach(function (fileField) {
          fileField.addEventListener('change', function (e) {
            var filePath = fileField.parentNode.parentNode.querySelector('input.file-path');

            if (filePath && fileFields[0] && fileFields[0].files[0] && fileFields[0].files[0].name) {
              filePath.value = fileFields[0].files[0].name;
            }
          });
        });
        var collapsibles = document.querySelectorAll('.hayyabuild-collapsible');
        collapsibles && collapsibles.forEach(function (collapsible) {
          var lis = collapsible.querySelectorAll('li');
          lis && lis.forEach(function (li) {
            li.addEventListener('click', function (e) {
              if (e.target.classList && e.target.classList.contains('collapsible-header')) {
                lis.forEach(function (remove) {
                  if (li !== remove) remove.classList.remove('active');
                });

                if (li.classList.contains('active')) {
                  li.classList.remove('active');
                } else {
                  li.classList.add('active');
                }
              }
            });
          });
        });
      }
      /**
       * Grid & List Filtration
       */

    }, {
      key: "gridList",
      value: function gridList(hayyaListView) {
        var _this2 = this;

        hayyaListView && _typeof(hayyaListView) === 'object' && hayyaListView.forEach(function (el) {
          var grid = false;
          var width = '100%';
          el.addEventListener('click', function (event) {
            event.preventDefault();
            hayyaListView.forEach(function (i) {
              i.parentNode.classList.remove('active');
            });
            el.parentNode.classList.add('active');
            var list = el.getAttribute('data-view');
            var elementsList = document.querySelectorAll('.element-list');

            if (elementsList && _typeof(elementsList) === 'object') {
              width = list === 'list' ? '100%' : 'calc(50% - 0px)';
              _this2.grid = list === 'grid';
              elementsList.forEach(function (e, i) {
                setTimeout(function () {
                  e.style.width = width;
                  e.classList.remove('hayya_grid');
                }, 50 + i * 50);
              });
            }
          });
        });
      }
      /**
       * Items Filtraion
       */

    }, {
      key: "itemsFiltraion",
      value: function itemsFiltraion(tabs) {
        var _this3 = this;

        tabs && _typeof(tabs) === 'object' && tabs.forEach(function (tab) {
          var filter = '';
          tab.addEventListener('click', function (event) {
            event.preventDefault();
            tabs.forEach(function (el) {
              el.parentNode.classList.remove('active');
            });
            tab.parentNode.classList.add('active');
            var delay = 200;
            var time = 200;
            filter = tab.getAttribute('data-filter');
            if (_this3.grid || $('.hayya_template').length > 0) delay = time = 1;

            if (filter !== 'all') {
              var empty = document.querySelector('.filter_empty_' + filter);

              if (empty) {
                $('.empty-filter').slideUp(delay);
                $(empty).slideDown(delay);
              } else {
                $('.empty-filter').slideUp(delay);
              }
            } else {
              if ($('.empty-filter').length > 0) {
                $('.empty-filter').slideUp(delay);
              }
            }

            var j = 1;
            $($('.hayya_filter_items').get().reverse()).each(function (i, e) {
              if (filter === 'all' || $(e).hasClass('filter_' + filter)) {
                if ($(e).hasClass('hayya_is_hidden')) {
                  setTimeout(function () {
                    $(e).slideDown(delay).removeClass('hayya_is_hidden');
                  }, j * time);
                  j++;
                }
              } else {
                if (!$(e).hasClass('hayya_is_hidden')) {
                  setTimeout(function () {
                    $(e).slideUp(delay).addClass('hayya_is_hidden');
                  }, j * time);
                  j++;
                }
              }
            });
          });

          if (filter === '') {
            $('.empty-filter').slideUp(1);
          } // }

        });
      }
      /**
       * Copy Shortcode
       */

    }, {
      key: "copyShortcode",
      value: function copyShortcode(copy) {
        copy && _typeof(copy) === 'object' && copy.forEach(function (c) {
          c.addEventListener('click', function (event) {
            var content = c.textContent;
            window.prompt('Copy to clipboard: Ctrl+C, Enter', c.textContent);
          });
        });
      }
      /**
       *  editor background mange
       */

    }, {
      key: "editorBackground",
      value: function editorBackground() {
        var editor = document.querySelector('.edit-post-visual-editor.editor-styles-wrapper');
        var backgroundDiv = document.querySelectorAll('.background_div');
        var type = document.getElementById('background_type_input');
        if (!editor || !backgroundDiv.length || !type) return;
        var backgroundColorInput = document.getElementById('background_color_input');
        var backgroundImageInput = document.getElementById('background_image_input');
        var backgroundRepeatInput = document.getElementById('background_repeat_input');
        var backgroundSizeInput = document.getElementById('background_size_input');

        var changeBackground = function changeBackground() {
          var backgroundType = type.value;
          var show = document.getElementById(backgroundType); // background color

          var backgroundColor = backgroundColorInput ? backgroundColorInput.value : ''; // background image

          var backgroundImage = backgroundImageInput ? backgroundImageInput.value : ''; // background repeat

          var backgroundRepeat = backgroundRepeatInput ? backgroundRepeatInput.value : ''; // background repeat

          var backgroundSize = backgroundSizeInput ? backgroundSizeInput.value : '';
          var background = '';

          if (backgroundType === 'background_color') {
            background = backgroundColor;
          } else if (backgroundType === 'background_image' || backgroundType === 'background_video' && backgroundImage) {
            background = 'url("' + backgroundImage + '")';
          }

          backgroundDiv.forEach(function (el) {
            el.style.display = 'none';
          });
          if (show) show.style.display = 'block';
          editor.style.background = background;
          if (backgroundRepeat) editor.style.backgroundRepeat = backgroundRepeat;
          if (backgroundSize) editor.style.backgroundSize = backgroundSize;
        };

        changeBackground();
        type.addEventListener('change', changeBackground);
        backgroundColorInput && backgroundColorInput.addEventListener('change', changeBackground);
        backgroundImageInput && backgroundImageInput.addEventListener('change', changeBackground);
        backgroundRepeatInput && backgroundRepeatInput.addEventListener('change', changeBackground);
        backgroundSizeInput && backgroundSizeInput.addEventListener('change', changeBackground);
      }
      /**
       *  minicolors to select colors
       */

    }, {
      key: "miniColors",
      value: function miniColors(_miniColors) {
        if (_miniColors) {
          for (var i = 0; i < _miniColors.length; i++) {
            var e = _miniColors[i];
            $(e).minicolors($.minicolors = {
              defaults: {
                control: 'hue',
                dataUris: true,
                defaultValue: '',
                format: 'rgb',
                hide: null,
                hideSpeed: 100,
                opacity: true,
                position: 'bottom left',
                show: null,
                showSpeed: 100,
                theme: 'default'
              }
            });
          }
        }
      }
      /**
       * selector chosen
       */

    }, {
      key: "chosenSelect",
      value: function chosenSelect() {
        $('.chosen-select').chosen({
          width: '100%',
          no_results_text: 'Oops, nothing found!'
        });
        $('.chosen-select').bind('load, change', function (evt, params) {
          var $s = $(this); // alert(params.selected)

          if ($(this).val() === '' || $(this).val() === null) {
            $s.children().each(function () {
              $(this).prop('disabled', false);
            });
          } else if (params.selected && params.selected === 'all') {
            $(this).val('all');
            $s.children().not(':selected').each(function () {
              $(this).prop('disabled', true);
            });
          }

          $('.chosen-select').trigger('chosen:updated');
        });
      }
      /**
       *  Image upload dialog
       */

    }, {
      key: "imageUploader",
      value: function imageUploader() {
        var imageUploader;
        var imageUpload = document.getElementById('background_image_button');
        imageUpload && _typeof(imageUpload) === 'object' && imageUpload.addEventListener('click', function (event) {
          event.preventDefault();

          if (imageUploader) {
            imageUploader.open();
            return;
          }

          imageUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            'library': {
              type: 'image'
            } // multiple: true

          });
          imageUploader.on('select', function (html) {
            var attachment = imageUploader.state().get('selection').first().toJSON();
            var input = document.getElementById('background_image_input');
            input.value = attachment.url;
            var postEditor = document.querySelector('.edit-post-visual-editor.editor-styles-wrapper');
            if (postEditor) postEditor.style.background = 'url("' + attachment.url + '")';
          });
          imageUploader.open();
        });
      }
      /**
       *  Video upload dialog
       */

    }, {
      key: "videoUploader",
      value: function videoUploader() {
        var videoUploader;
        var video = document.getElementById('background_video_button');
        video && _typeof(video) === 'object' && video.addEventListener('click', function (event) {
          event.preventDefault();

          if (videoUploader) {
            videoUploader.open();
            return;
          }

          videoUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Video',
            'library': {
              type: 'video'
            }
          });
          videoUploader.on('select', function (html) {
            var attachment = videoUploader.state().get('selection').first().toJSON();
            var input = document.getElementById('background_video_input');
            input.value = attachment.url;
            var postEditor = document.querySelector('.edit-post-visual-editor.editor-styles-wrapper');
            if (postEditor) postEditor.style.background = '#FFF';
          });
          videoUploader.open();
        });
      }
      /**
       * { function_description }
       */

    }, {
      key: "_initializer",
      value: function _initializer() {
        this.videoUploader();
        this.imageUploader(); // this.editorBackground()

        this.domContentLoaded();
        this.gridList(document.querySelectorAll('.hayya_list_view'));
        this.itemsFiltraion(document.querySelectorAll('.hayya_filter'));
        this.copyShortcode(document.querySelectorAll('.copy-shortcode'));
        this.miniColors(document.querySelectorAll('INPUT.minicolors'));
        $('.chosen-select').length > 0 && this.chosenSelect();
      }
    }]);

    return hayyaBuild;
  }();

  window.HayyaBuild = {};
  new hayyaBuild();
})(jQuery);