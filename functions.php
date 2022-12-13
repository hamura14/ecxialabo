<?php
// function maintenance_mode() {
// if ( !current_user_can( 'edit_themes' ) || !is_user_logged_in() ) {
// wp_die('ただいまメンテナンス中です。');
// }
// }
// add_action('get_header', 'maintenance_mode');

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles' );
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','wp_oembed_add_host_js');
remove_action('template_redirect', 'rest_output_link_header', 11);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_print_styles', 'print_emoji_styles');
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );
add_filter( 'pre_site_transient_update_core', '__return_zero' );
remove_action( 'wp_version_check', 'wp_version_check' );
remove_action( 'admin_init', '_maybe_update_core' );

add_editor_style("editor-style.css");

function my_tiny_mce_before_init( $init_array ) {
    $init_array['valid_elements']          = '*[*]';
    $init_array['extended_valid_elements'] = '*[*]';

    return $init_array;
}
add_filter( 'tiny_mce_before_init' , 'my_tiny_mce_before_init' );

function remove_dns_prefetch( $hints, $relation_type ) {
	if ( 'dns-prefetch' === $relation_type ) {
		return array_diff( wp_dependencies_unique_hosts(), $hints );
	}
	return $hints;
}

function dequeue_plugins_style() {
    wp_dequeue_style('wp-block-library');
}
add_action( 'wp_enqueue_scripts', 'dequeue_plugins_style', 9999);

function add_seo_custom_fields() {
  $screen = array('page' , 'post' );
  add_meta_box( 'seo_setting', 'SEO', 'seo_custom_fields', $screen );
}
function seo_custom_fields() {
  global $post;
  $meta_keywords = get_post_meta($post->ID,'meta_keywords',true);
  $noindex = get_post_meta($post->ID,'noindex',true);
  if($noindex==1){
    $noindex_check="checked";
  }
  else {
    $noindex_check= "/";
  }
  echo '<p>meta keywordを設定 半角カンマ区切りで入力<br />';
  echo '<input type="text" name="meta_keywords" value="'.esc_html($meta_keywords).'" size="80" /></p>';
  echo '<p>低品質コンテンツの場合はチェック<br>';
  echo '<input type="checkbox" name="noindex" value="1" ' . $noindex_check . '> noindex</p>';
}
function save_seo_custom_fields( $post_id ) {
  if(!empty($_POST['meta_keywords']))
    update_post_meta($post_id, 'meta_keywords', $_POST['meta_keywords'] );
  else delete_post_meta($post_id, 'meta_keywords');

  if(!empty($_POST['noindex']))
    update_post_meta($post_id, 'noindex', $_POST['noindex'] );
  else delete_post_meta($post_id, 'noindex');
}
add_action('admin_menu', 'add_seo_custom_fields');
add_action('save_post', 'save_seo_custom_fields');

add_post_type_support( 'page', 'excerpt' );

function example_add_dashboard_widgets() {
  wp_add_dashboard_widget(
    'example_dashboard_widget',
    '注意事項',
    'example_dashboard_widget_function'
  );
}
function example_dashboard_widget_function() {
  echo '
  <h1>WordPressの更新について</h1>
  <p style="color:red; line-height:1.8;">WordPress(プラグイン、テーマ、翻訳など)を更新した場合、サイトのデザインが崩れてしまったり、バグが発生する場合がございますので、更新については、なるべく避けるようにお願い致します。</p>
  ';
}
add_action('wp_dashboard_setup', 'example_add_dashboard_widgets');

remove_action( 'welcome_panel', 'wp_welcome_panel' );

function remove_dashboard_widget() {
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
}
add_action('wp_dashboard_setup', 'remove_dashboard_widget' );

function remove_menus() {
  remove_menu_page('edit.php');
    remove_menu_page('edit-comments.php');
      remove_submenu_page('options-general.php', 'options-discussion.php');
}
add_action('admin_menu', 'remove_menus');

// function replaceImagePath($arg) {
// 	$content = str_replace('"img/', '"' . get_bloginfo('template_directory') . '/img/', $arg);
// 	return $content;
// }
// add_action('the_content', 'replaceImagePath');

remove_filter('the_content', 'wpautop');

remove_filter('the_excerpt', 'wpautop');

if ( ! function_exists( 'custom_breadcrumb' ) ) {
  function custom_breadcrumb() {
    if ( is_front_page() ) return false;
    $wp_obj = get_queried_object();
    echo '<div class="breadcrumb-list" id="breadcrumb" ontouchstart="">'.
      '<ul>'.
        '<li>'.
          '<a href="'. esc_url( home_url() ) .'"><span>ホーム</span></a>'.
        '</li>';
    if ( is_attachment() ) {
      $post_title = apply_filters( 'the_title', $wp_obj->post_title );
      echo '<li><span>'. esc_html( $post_title ) .'</span></li>';
    } elseif ( is_single() ) {
      $post_id    = $wp_obj->ID;
      $post_type  = $wp_obj->post_type;
      $post_title = apply_filters( 'the_title', $wp_obj->post_title );
      if ( $post_type !== 'post' ) {
        $the_tax = "";
        $tax_array = get_object_taxonomies( $post_type, 'names');
        foreach ($tax_array as $tax_name) {
            if ( $tax_name !== 'post_format' ) {
                $the_tax = $tax_name;
                break;
            }
        }
        $post_type_link = esc_url( get_post_type_archive_link( $post_type ) );
        $post_type_label = esc_html( get_post_type_object( $post_type )->label );
        echo '<li>'.
              '<a href="'. $post_type_link .'">'.
                '<span>'. $post_type_label .'</span>'.
              '</a>'.
            '</li>';
        } else {
          $the_tax = 'category';
        }
        $terms = get_the_terms( $post_id, $the_tax );
        if ( $terms !== false ) {
          $child_terms  = array();
          $parents_list = array();
          foreach ( $terms as $term ) {
            if ( $term->parent !== 0 ) {
              $parents_list[] = $term->parent;
            }
          }
          foreach ( $terms as $term ) {
            if ( ! in_array( $term->term_id, $parents_list ) ) {
              $child_terms[] = $term;
            }
          }
          $term = $child_terms[0];
          if ( $term->parent !== 0 ) {
            $parent_array = array_reverse( get_ancestors( $term->term_id, $the_tax ) );
            foreach ( $parent_array as $parent_id ) {
              $parent_term = get_term( $parent_id, $the_tax );
              $parent_link = esc_url( get_term_link( $parent_id, $the_tax ) );
              $parent_name = esc_html( $parent_term->name );
              echo '<li>'.
                    '<a href="'. $parent_link .'">'.
                      '<span>'. $parent_name .'</span>'.
                    '</a>'.
                  '</li>';
            }
          }
          $term_link = esc_url( get_term_link( $term->term_id, $the_tax ) );
          $term_name = esc_html( $term->name );
          echo '<li>'.
                '<a href="'. $term_link .'">'.
                  '<span>'. $term_name .'</span>'.
                '</a>'.
              '</li>';
        }
        echo '<li><span>'. esc_html( strip_tags( $post_title ) ) .'</span></li>';
    } elseif ( is_page() || is_home() ) {
      $page_id    = $wp_obj->ID;
      $page_title = apply_filters( 'the_title', $wp_obj->post_title );
      if ( $wp_obj->post_parent !== 0 ) {
        $parent_array = array_reverse( get_post_ancestors( $page_id ) );
        foreach( $parent_array as $parent_id ) {
          $parent_link = esc_url( get_permalink( $parent_id ) );
          $parent_name = esc_html( get_the_title( $parent_id ) );
          echo '<li>'.
                '<a href="'. $parent_link .'">'.
                  '<span>'. $parent_name .'</span>'.
                '</a>'.
              '</li>';
        }
      }
      echo '<li><span>'. esc_html( strip_tags( $page_title ) ) .'</span></li>';
    } elseif ( is_post_type_archive() ) {
      echo '<li><span>'. esc_html( $wp_obj->label ) .'</span></li>';
    } elseif ( is_date() ) {
      $year  = get_query_var('year');
      $month = get_query_var('monthnum');
      $day   = get_query_var('day');
      if ( $day !== 0 ) {
        echo '<li>'.
              '<a href="'. esc_url( get_year_link( $year ) ) .'"><span>'. esc_html( $year ) .'年</span></a>'.
            '</li>'.
            '<li>'.
              '<a href="'. esc_url( get_month_link( $year, $month ) ) . '"><span>'. esc_html( $month ) .'月</span></a>'.
            '</li>'.
            '<li>'.
              '<span>'. esc_html( $day ) .'日</span>'.
            '</li>';
      } elseif ( $month !== 0 ) {
        echo '<li>'.
              '<a href="'. esc_url( get_year_link( $year ) ) .'"><span>'. esc_html( $year ) .'年</span></a>'.
            '</li>'.
            '<li>'.
              '<span>'. esc_html( $month ) .'月</span>'.
            '</li>';
      } else {
        echo '<li><span>'. esc_html( $year ) .'年</span></li>';
      }
    } elseif ( is_author() ) {
      echo '<li><span>'. esc_html( $wp_obj->display_name ) .' の執筆記事</span></li>';
    } elseif ( is_archive() ) {
      $term_id   = $wp_obj->term_id;
      $term_name = $wp_obj->name;
      $tax_name  = $wp_obj->taxonomy;
      if ( $wp_obj->parent !== 0 ) {
        $parent_array = array_reverse( get_ancestors( $term_id, $tax_name ) );
        foreach( $parent_array as $parent_id ) {
          $parent_term = get_term( $parent_id, $tax_name );
          $parent_link = esc_url( get_term_link( $parent_id, $tax_name ) );
          $parent_name = esc_html( $parent_term->name );
          echo '<li>'.
                '<a href="'. $parent_link .'">'.
                  '<span>'. $parent_name .'</span>'.
                '</a>'.
              '</li>';
        }
      }
      echo '<li>'.
            '<span>'. esc_html( $term_name ) .'</span>'.
          '</li>';
    } elseif ( is_search() ) {
      echo '<li><span>「'. esc_html( get_search_query() ) .'」で検索した結果</span></li>';
    } elseif ( is_404() ) {
      echo '<li><span>お探しのページは見つかりませんでした。</span></li>';
    } else {
      echo '<li><span>'. esc_html( get_the_title() ) .'</span></li>';
    }
    echo '</ul></div>';
  }
}

add_action( 'init', 'custom_post_type' );
function custom_post_type() {
  register_post_type( 'blog',
    array(
      'labels' => array(
        'name' => __( '新着情報' ),
        'singular_name' => __( '新着情報' ),
        'add_new' => _x('新規追加', 'blog'),
        'add_new_item' => __('新規追加')
      ),
      'public' => true,
      'has_archive' => true,
      'hierarchical' => false,
      'menu_position' =>2,
      'menu_icon' => 'dashicons-edit',
      'supports' => array('title','editor','thumbnail','revisions','excerpt')
    )
  );
  register_taxonomy(
    'blog_category',
    'blog',
    array(
      'hierarchical' => true,
      'update_count_callback' => '_update_post_term_count',
      'label' => 'カテゴリー',
      'singular_label' => 'カテゴリー',
      'public' => true,
      'show_ui' => true
    )
  );
}

function my_theme_archive_title( $title ) {
  if ( is_post_type_archive() && !is_date() ) {

    $title = post_type_archive_title( '', false );

  } elseif ( is_date() ) {

    $date  = single_month_title('',false);
    $point = strpos($date,'月');
    $title = mb_substr($date,$point+1).'年'.mb_substr($date,0,$point+1);

  }

  return $title;
}
add_filter( 'get_the_archive_title', 'my_theme_archive_title' );

add_theme_support( 'post-thumbnails' );

function pagination( $pages, $paged, $range = 2, $show_only = false ) {
    $pages = ( int ) $pages;
    $paged = $paged ?: 1;
    $text_first   = "<<";
    $text_before  = "&lt;";
    $text_next    = "&gt;";
    $text_last    = ">>";
    if ( $show_only && $pages === 1 ) {
        echo '<div class="pagination"></ul><li class="current pager">1</li></ul></div>';
        return;
    }
    if ( $pages === 1 ) return;
    if ( 1 !== $pages ) {
        echo '<div class="pagenation"><ul>';
        if ( $paged > $range + 1 ) {
            echo '<li><a href="', get_pagenum_link(1) ,'" class="first">', $text_first ,'</a></li>';
        }
        if ( $paged > 1 ) {
            echo '<li><a href="', get_pagenum_link( $paged - 1 ) ,'" class="prev">', $text_before ,'</a></li>';
        }
        for ( $i = 1; $i <= $pages; $i++ ) {
            if ( $i <= $paged + $range && $i >= $paged - $range ) {
                if ( $paged === $i ) {
                    echo '<li class="active">', $i ,'</li>';
                } else {
                    echo '<li><a href="', get_pagenum_link( $i ) ,'" class="pager">', $i ,'</a></li>';
                }
            }
        }
        if ( $paged < $pages ) {
            echo '<li><a href="', get_pagenum_link( $paged + 1 ) ,'" class="next">', $text_next ,'</a></li>';
        }
        if ( $paged + $range < $pages ) {
            echo '<li><a href="', get_pagenum_link( $pages ) ,'" class="last">', $text_last ,'</a></li>';
        }
        echo '</ul></div>';
    }
}

function blog_title() {
global $page, $paged;
if (!is_front_page()) {
echo trim(wp_title('', false)) . " | ";
} elseif(is_front_page()) {
bloginfo('description');
}
bloginfo('name');
if ($paged >= 2 || $page >= 2) {
echo ' | ' . sprintf('%sページ目', max($paged, $page));
}
}

function blog_desp_title() {
global $page, $paged;
if ($paged >= 2 || $page >= 2) {
echo ' | ' . sprintf('%sページ目', max($paged, $page));
}
}

function is_mobile(){
    $useragents = array(
        'iPhone', // iPhone
        'iPod', // iPod touch
        'Android', // 1.5+ Android
        'dream', // Pre 1.5 Android
        'CUPCAKE', // 1.5+ Android
        'blackberry9500', // Storm
        'blackberry9530', // Storm
        'blackberry9520', // Storm v2
        'blackberry9550', // Storm v2
        'blackberry9800', // Torch
        'webOS', // Palm Pre Experimental
        'incognito', // Other iPhone browser
        'webmate' // Other iPhone browser
    );
    $pattern = '/'.implode('|', $useragents).'/i';
    return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}
function my_admin_mail( $Mail ) {
$Browser = $_SERVER["HTTP_USER_AGENT"];
$Ip = $_SERVER["REMOTE_ADDR"];
$Host = gethostbyaddr($Ip);
$Mail->body .= "\n\n--------------------\n【送信者情報】\n・ブラウザー：" .$Browser. "\n・送信元IPアドレス：" .$Ip. "\n・送信元ホスト名：" .$Host;
return $Mail;
}
add_filter( 'mwform_admin_mail_mw-wp-form-48', 'my_admin_mail', 10, 2  );