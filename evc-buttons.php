<?php

// 2014_10_27

add_action('admin_init', 'evc_buttons_load_scripts'); 
add_action('init', 'evc_buttons_load_scripts'); 
function evc_buttons_load_scripts () {
  $options = get_option('evc_widget_buttons');
  
  wp_enqueue_script('social-likes', plugins_url('js/social-likes.min.js' , __FILE__), array('jquery'), '3.0.4', true); 
 
  wp_register_style( 'social-likes-classic', plugins_url('css/social-likes_classic.css', __FILE__) );
  wp_register_style( 'social-likes-flat', plugins_url('css/social-likes_flat.css', __FILE__) );
  wp_register_style( 'social-likes-birman', plugins_url('css/social-likes_birman.css', __FILE__) );
  
  if (isset($options['evc_buttons_skin']) && in_array($options['evc_buttons_skin'], array('classic','flat','birman')))
    wp_enqueue_style( 'social-likes-' . $options['evc_buttons_skin'] );
  else
    wp_enqueue_style( 'social-likes-classic' );
}

add_action('admin_init', 'evc_buttons_admin_load_scripts'); 
function evc_buttons_admin_load_scripts () {
  wp_enqueue_script('jquery-ui-sortable');
}


add_filter ('evc_widget_tabs', 'evc_buttons_tabs');
function evc_buttons_tabs ($tabs) {
  
  $t = array(
    'evc_widget_buttons' => array(
      'id' => 'evc_widget_buttons',
      'name' => 'evc_widget_buttons',
      'title' => __( 'Кнопки', 'evc' ),
      'desc' => __( '', 'evc' ),
      'sections' => array(
        'evc_widget_buttons_section' => array(
          'id' => 'evc_widget_buttons_section',
          'name' => 'evc_widget_buttons_section',
          'title' => __( 'Кнопки "Поделиться"', 'evc' ),
          'desc' => __( 'Управление параметрами кнопок "Поделиться" через разные социальные сети. 
          <br/><br/><div class="evc-social-likes" style = "text-align:center;"></div>', 'evc' ),         
        )
      )
    ),
  );   

  return $t + $tabs;
}

add_filter ('evc_widget_fields', 'evc_buttons_fields');
function evc_buttons_fields ($fields) {
  
  $f = array(
    'evc_widget_buttons_section' => array(   
      
      array(
        'name' => 'evc_buttons_skin',
        'label' => __( 'Вид кнопок', 'evc' ),
        'desc' => __( 'Вы можете выбрать внешний вид кнопок.', 'evc' ),
        'type' => 'radio',
        'default' => 'classic',
        'options' => array(
          'classic' => 'Классические',
          'flat' => 'Плоские',
          'birman' => 'Бирман'
        )
      ),
      array(
        'name' => 'evc_buttons_skin_light',
        'desc' => __( 'Имеет эффект, только если выбран внешний вид: "Плоские".', 'evc' ),
        'type' => 'multicheck',      
        'options' => array(
          'light' => '"Легкий" стиль'
        )
      ),
      array(
        'name' => 'evc_buttons_only_icons',
        'desc' => __( 'Отображать на кнопках только логотип социальной сети или логотип и название.', 'evc' ),
        'type' => 'radio',
        'default' => '0',
        'options' => array(
          '0' => 'Лого и название сети',
          '1' => 'Только лого сети'
        )
      ),  
      array(
        'name' => 'evc_buttons_counters',
        'desc' => __( 'В каких случаях отображать счетчик.', 'evc' ),
        'type' => 'radio',
        'default' => '0',
        'options' => array(
          '1' => 'Всегда, даже если лайков ноль',
          '0' => 'Только если лайков больше ноля'
        )
      ), 
                
      array(
        'name' => 'evc_buttons_position',
        'label' => __( 'Расположение', 'evc' ),
        'desc' => __( 'Вы можете выбрать расположение кнопок.', 'evc' ),
        'type' => 'radio',
        'default' => 'horizontal',
        'options' => array(
          'horizontal' => 'Горизонтальное',
          'vertical' => 'Вертикальное',
          'single' => 'Одной кнопкой'
        )
      ), 
      array(
        'name' => 'evc_buttons',
        'label' => __( 'Кнопки', 'evc' ),
        'desc' => __( 'Отметьте кнопки, которые вам нужны.
        <br/>Чтобы <strong>изменить очередность</strong>, наведите курсор мыши на название соц. сети и, удерживая левую кнопку мыши, перетащите в нужное место.
        <br/><br/>Кнопка Пинтерест <strong>не будет размещаться</strong> для записей у которых нет изображений (прикрепленных как featured image или attachment).', 'evc' ),
        'type' => 'multicheck',
        'sortable' => '1',
        'default' => array(
          'facebook' => 'facebook',
          'plusone' => 'plusone',
          'vkontakte' => 'vkontakte',
          'twitter' => 'twitter'
        ),        
        'options' => array(
          'facebook' => 'Facebook',
          'twitter' => 'Twitter',
          'mailru' => 'Мой мир',
          'vkontakte' => 'ВКонтакте',
          'odnoklassniki' => 'Одноклассники',
          'plusone' => 'Google+',
          'pinterest' => 'Pinterest'
        )
      ),
      
      array(
        'name' => 'evc_buttons_twitter_via',
        'label' => __( 'Twitter "via"', 'evc' ),
        'desc' => __( 'Необязательно.
        <br/>Сайт или ваш собтвенный Твиттер аккаунт.', 'evc' ),
        'type' => 'text'
      ),      
      array(
        'name' => 'evc_buttons_twitter_related',
        'label' => __( 'Twitter "related"', 'evc' ),
        'desc' => __( 'Необязательно.
        <br/>Любой другой Твиттер аккаунт, который вы хотели бы прорекламировать.', 'evc' ),
        'type' => 'text'
      ),
      array(
        'name' => 'evc_buttons_insert',
        'label' => __( 'Поместить кнопки', 'evc' ),
        'desc' => __( 'Куда поместить кнопки.
          <br/>Разместить кнопки <strong>вручную</strong> можно используя шортокод:
          <br/><code>[evc_social_likes]</code> 
          <br/>или функцию: 
          <br/><code>evc_buttons_code();</code>.', 'evc' ),
        'type' => 'radio',
        'default' => 'after',
        'options' => array(
          'before' => 'До контента',
          'after' => 'После контента',
          'before_aftert' => 'И до, и после контента',
          'manual' => 'Вручную'
        )
      ),       
      array(
        'name' => 'evc_buttons_order',
        'type' => 'hidden'
      ),
      array(
        'name' => 'evc_buttons_code',
        'type' => 'hidden',
        'default' => '<div class="social-likes "><div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div><div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div><div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div><div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div></div>'
      )                              
    )  
  );  
  
  
  return $f + $fields;
}

function evc_widget_settings_page_js() {
  $options = get_option('evc_widget_buttons');
  
  $evc_buttons_order = isset($options['evc_buttons_order']) && !empty($options['evc_buttons_order']) ? $options['evc_buttons_order'] : '[]';
?>
<script type="text/javascript" >
  jQuery(document).ready(function($) {     
      
    var order = <?php echo $evc_buttons_order; ?>;        
    $.each(order, function(key, val){     
      $('.sortable').append($("#"+val.replace(/(:|\.|\[|\])/g,'\\$1')));
    });
    
    slBuild();
              
    $('.sortable').sortable({
      items: '.item',
      axis: 'y',
      update: function (event, ui) {
        slBuild();
        
        var data = $(this).sortable('toArray');
        $('#evc_widget_buttons\\[evc_buttons_order\\]').val(JSON.stringify(data));
        //console.log(data);
      }
    });
    
    var pluginUrl = "<?php echo plugins_url('css/' , __FILE__); ?>";      
    
    $('input[type=radio][name=evc_widget_buttons\\[evc_buttons_skin\\]]').change(function() {
      
      var socialLikesCss = $('head').find('link[id*="social-likes"]')[0];
            
      if (this.value == 'classic') {
        $(socialLikesCss).attr({
          id: 'social-likes-classic-css',
          href: pluginUrl + 'social-likes_classic.css'
        });
      }
      else if (this.value == 'flat') {
        $(socialLikesCss).attr({
          id: 'social-likes-flat-css',
          href: pluginUrl + 'social-likes_flat.css'
        });
      }
      else if (this.value == 'birman') {
        $(socialLikesCss).attr({
          id: 'social-likes-birman-css',
          href: pluginUrl + 'social-likes_birman.css'
        });
      }        
    
      slBuild();
    });    
    
    function slBuild () {
      var p = $('input[name=evc_widget_buttons\\[evc_buttons_position\\]]:checked').val(),
        i = $('input[name=evc_widget_buttons\\[evc_buttons_only_icons\\]]:checked').val(),
        c = $('input[name=evc_widget_buttons\\[evc_buttons_counters\\]]:checked').val(),
        o = {},
        pAttr = {
          'horizontal': {
            'class': 'social-likes'
          },
          'vertical': {
            'class': 'social-likes social-likes_vertical'
          },
          'single': {
            'class': 'social-likes social-likes_single',
            'data-single-title': "Поделиться"          
          }
        },
        iHtml = {
          '0': '<div class = "social-likes"><div class="facebook" title="Поделиться ссылкой на Фейсбуке">Facebook</div><div class="twitter" title="Поделиться ссылкой в Твиттере">Twitter</div><div class="mailru" title="Поделиться ссылкой в Моём мире">Мой мир</div><div class="vkontakte" title="Поделиться ссылкой во Вконтакте">Вконтакте</div><div class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках">Одноклассники</div><div class="plusone" title="Поделиться ссылкой в Гугл-плюсе">Google+</div><div class="pinterest" title="Поделиться ссылкой в Пинтерест">Pinterest</div></div>',    
          '1':'<div class = "social-likes"><div class="facebook" title="Поделиться ссылкой на Фейсбуке"></div><div class="twitter" title="Поделиться ссылкой в Твиттере"></div><div class="mailru" title="Поделиться ссылкой в Моём мире"></div><div class="vkontakte" title="Поделиться ссылкой во Вконтакте"></div><div class="odnoklassniki" title="Поделиться ссылкой в Одноклассниках"></div><div class="plusone" title="Поделиться ссылкой в Гугл-плюсе"></div><div class="pinterest" title="Поделиться ссылкой в Пинтерест"></div></div>'
        },
        iClass = {
          '0': '',
          '1': 'social-likes_notext'
        },
        tVia = $('input[name=evc_widget_buttons\\[evc_buttons_twitter_via\\]]').val(),
        tRelated = $('input[name=evc_widget_buttons\\[evc_buttons_twitter_related\\]]').val(),
        b,
        skin = $('input[name=evc_widget_buttons\\[evc_buttons_skin\\]]:checked').val();
        
      if (skin == 'flat') {
        $('#evc_widget_buttons\\[evc_buttons_skin_light\\]\\[light\\]').attr('disabled', false);  
        if ($('#evc_widget_buttons\\[evc_buttons_skin_light\\]\\[light\\]').attr('checked'))
          pAttr[p].class += ' social-likes_light';
      }
      else {
        $('#evc_widget_buttons\\[evc_buttons_skin_light\\]\\[light\\]').attr({
          'disabled': true,
          'checked': false
        }); 
      } 
      
      b = $('<div class = "social-likes"></div>');
      $('.sortable input:checked').each(function(){     
        $(b).append($(iHtml[i]).find('.' + $(this).attr('value'))[0]);
        //console.log($(this).attr('value'));  
      });
      
      if (tVia && $('.twitter', b))
        $('.twitter', b).attr('data-via', tVia);

      if (tRelated && $('.twitter', b))
        $('.twitter', b).attr('data-related', tRelated);
      
      pAttr[p].class += ' ' + iClass[i];
      
      $('.evc-social-likes').html(b);
      $('.social-likes').attr(pAttr[p]); 

      $('#evc_widget_buttons\\[evc_buttons_code\\]').val($('.evc-social-likes').html());      
        
      $('.social-likes').socialLikes({
        zeroes: parseInt(c)
      });
      
    }
 
    $('input[type=radio][name=evc_widget_buttons\\[evc_buttons_position\\]], input[type=radio][name=evc_widget_buttons\\[evc_buttons_only_icons\\]], input[type=radio][name=evc_widget_buttons\\[evc_buttons_counters\\]], .sortable input[type=checkbox], input[type=checkbox][name=evc_widget_buttons\\[evc_buttons_skin_light\\]\\[light\\]]').change(function() {
      slBuild();
    });
    
    <?php do_action('evc_widget_settings_page_js'); ?>
    
  }); // jQuery End
</script>
<?php
}

add_action('wp_footer', 'evc_buttons_js');
function evc_buttons_js() {
  $options = get_option('evc_widget_buttons');
?>
<script type="text/javascript" >
  jQuery(document).ready(function($) { 
    
    if ($('.social-likes')) {
      
      $('.social-likes').each(function(){     
        var p = $(this).parent();
        if (p.data('url')) {
          $(this).data({
            'url': p.data('url'),
            'title': p.data('title')
          }); 
        }
        
        if ($(this).find('.pinterest').length) {
          if (p.data('media')) {
            $($(this).find('.pinterest')[0]).data({
              'media': p.data('media')
            }); 
          }
          else       
            $($(this).find('.pinterest')[0]).remove();
        }
        
      });      
      
      $('.social-likes').socialLikes({
        zeroes: <?php echo $options['evc_buttons_counters']; ?>
      });
    }
  
  });
</script>
<?php
}

add_filter('the_content', 'evc_buttons_insert');
function evc_buttons_insert ($content) {
  global $post;
  $options = get_option('evc_widget_buttons');
  
  if($options['evc_buttons_insert'] == 'manual' || !isset($options['evc_buttons_code']) || empty($options['evc_buttons_code']) )
    return $content;

  $code = evc_buttons_code();  
  
  if($options['evc_buttons_insert'] == 'before')      
    $content = $code . $content;
  elseif($options['evc_buttons_insert'] == 'after')      
    $content = $content . $code;
  else
    $content = $code . $content . $code;
      
  return $content;
}

function evc_buttons_code () {
  global $post;
  $options = get_option('evc_widget_buttons');

  if( !isset($options['evc_buttons_code']) || empty($options['evc_buttons_code']) )
    return '';
  
  $data_media = '';
  $att_id = get_post_thumbnail_id( $post->ID );
  if(!$att_id || empty($att_id)) {
    $att = get_children( array( 
      'post_parent' => $post->ID, 
      'post_status' => 'inherit',     
      'post_type' => 'attachment', 
      'post_mime_type' => 'image', 
      'orderby' => 'menu_order id', 
      'order' => 'ASC', 
      'numberposts' => 1
    ));  
    if($att && !empty($att) && is_array($att)) {
      $att = array_shift($att);
      $att_id = $att->ID;
    }
    else
      $att_id = '';
  }
  if(!empty($att_id)) {
    $url = wp_get_attachment_url( $att_id );
    if (!empty($url))
      $data_media = 'data-media = "' . $url . '"';
  }
    
  $code = '<div class = "evc-social-likes" data-url="'.get_permalink($post->ID).'" data-title="'.$post->post_title.'" '.$data_media.'>'.$options['evc_buttons_code'].'</div>';  

  return $code;
}

add_shortcode('evc_social_likes', 'evc_buttons_shortcode');
function evc_buttons_shortcode ($atts = array(), $content = '') {
  if (!empty($atts))
    extract ($atts);
    
  $out = evc_buttons_code();
     
  return $out;
}