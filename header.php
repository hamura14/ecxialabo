<!DOCTYPE html>
<html lang="ja" prefix="og: http://ogp.me/ns#">
<head>
  <meta charset="UTF-8">
  <?php
  if( is_single() && !is_home() || is_page() && !is_front_page()) {
    $title = get_the_title();
    if(!empty($post->post_excerpt)) {
      $description = str_replace(array("\r\n", "\r", "\n", "&nbsp;"), '', strip_tags($post->post_excerpt));
    } elseif(!empty($post->post_content)) {
      $description = str_replace(array("\r\n", "\r", "\n", "&nbsp;"), '', strip_tags($post->post_content));
      $description_count = mb_strlen($description, 'utf8');
      if($description_count > 120) {
        $description = mb_substr($description, 0, 120, 'utf8').'…';
      }
    } else {
      $description = 'フェイシャルエステや痩身エステなら堺駅・堺東駅のエクシアラボにお任せ下さい！その他のメニューでも、水素吸入サロンはクチコミが多く人気があって、おすすめです！また、足や頭のエステも好評を頂いております。まずは無料相談からお問い合わせ下さい！';
    }
    $page_type = 'article';
    $page_url = get_the_permalink();
    if(!empty(get_post_thumbnail_id())) {
      $ogp_img_data = wp_get_attachment_image_src(get_post_thumbnail_id(),'full');
      $ogp_img = $ogp_img_data[0];
    }
  } else {
    if(is_category()) {
      $title = single_cat_title("", false).'の記事一覧';
      if(!empty(category_description())) {
        $description = strip_tags(category_description());
      } else {
        $description = single_cat_title("", false).'の記事一覧ページです。';
      }
    } elseif(is_tax()) {
      $title = $current_term = single_term_title("", false).'の記事一覧';
      if(!empty(term_description())) {
        $description = strip_tags(term_description());
      } else {
        $description = $current_term = single_term_title("", false).'の記事一覧ページです。';
      }
    } elseif(is_tag()) {
      $title = single_cat_title("", false).'の記事一覧';
      if(!empty(tag_description())) {
        $description = strip_tags(tag_description());
      } else {
        $description = single_cat_title("", false).'の記事一覧ページです。';
      }
    } elseif(is_year()) {
      $title = get_the_time("Y年").'の記事一覧';
      $description = get_the_time("Y年").'に投稿された記事の一覧ページです。';
    } elseif(is_month()) {
      $title = get_the_time("Y年m月").'の記事一覧';
      $description = get_the_time("Y年m月").'に投稿された記事の一覧ページです。';
    } elseif(is_day()) {
      $title = get_the_time("Y年m月d日").'の記事一覧';
      $description = get_the_time("Y年m月d日").'に投稿された記事の一覧ページです。';
    } elseif(is_404()) {
      $title = 'お探しのページが見つかりませんでした。';
      $description = 'お探しのページが見つかりませんでした。リンクが存在しないかURLが間違っている可能性が高いです。';
    } else {
      $title = '';
      $description = get_bloginfo( 'description' );
    }
    $page_type = 'website';
    $http = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $page_url = $http.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
  }
  if(empty($ogp_img)) {
    $ogp_img = get_template_directory_uri().'/img/top_catch.jpg';
  }
  if(!empty($title)) {
    $output_title = $title.' | '.get_bloginfo('name');
  } else {
    $title = get_bloginfo('name');
    $output_title = get_bloginfo('name');
  }
  ?>
  <?php if (is_front_page() ): ?>
  <title>フェイシャルエステや痩身、水素吸入は堺駅・堺東のエクシアラボ</title>
  <?php else: ?>
  <title><?php echo $output_title; ?></title>
  <?php endif; ?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="format-detection" content="telephone=no">
  <?php if( is_single() || is_page() ): ?>
  <?php if(get_post_meta(get_the_ID(),'noindex',true)){ echo'<meta name="robots" content="noindex,follow">';}; ?>
  <?php endif; ?>
  <?php if( is_post_type_archive() || is_tag() || is_author() || is_date() || is_search() ): ?>
  <meta name="robots" content="noindex,nofollow">
  <?php endif; ?>
  <?php if( is_404() || is_page('contact-confirm') || is_page('contact-error') || is_page('contact-thanks')): ?>
  <meta name="robots" content="noindex,follow">
  <?php endif; ?>
  <meta name="description" content="<?php echo $description; ?>">
  <?php if ( is_front_page() ) :?>
  <meta name="keywords" content="フェイシャルエステ,痩身エステ,水素吸入サロン,堺駅,堺東駅,ECXIA LABO,エクシアラボ,">
  <?php else: ?>
  <?php $customfield = get_post_meta($post->ID, 'meta_keywords', true); ?>
  <?php if( empty($customfield) ): ?>
  <?php if ( has_tag() ): ?>
  <?php $tags = get_the_tags();
    $kwds = array();
    foreach($tags as $tag){
      $kwds[] = $tag->name;
    }	?>
  <meta name="keywords" content="<?php echo implode( ',',$kwds ); ?>">
  <?php endif; ?>
  <?php else: ?>
  <meta name="keywords" content="<?php echo esc_attr( $post->meta_keywords ); ?>">
  <?php endif; ?>
  <?php endif; ?>
  <meta property="og:type" content="<?php echo $page_type; ?>">
  <meta property="og:locale" content="ja_JP">
  <meta property="og:title" content="<?php echo $title; ?>">
  <meta property="og:url" content="<?php echo $page_url; ?>">
  <meta property="og:description" content="<?php echo $description; ?>">
  <meta property="og:image" content="<?php echo $ogp_img; ?>">
  <meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:description" content="<?php echo $description; ?>">
  <meta name="twitter:image:src" content="<?php echo $ogp_img; ?>">
  <?php if(!is_404()) {
        echo '<link rel="canonical" href="https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'].'">';
      }
    ?>
  <?php if ( is_paged() && get_previous_posts_link() ) : ?>
  <link rel="prev" href="<?php echo get_pagenum_link( $paged - 1 ); ?>">
  <?php endif; ?>
  <?php if ( is_paged() && get_next_posts_link() ):?>
  <link rel="next" href="<?php echo get_pagenum_link( $paged +1 ); ?>">
  <?php endif; ?>
  <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.ico">
  <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/img/apple-touch-icon.png">
  <link rel="icon" type="image/png" size="256x256" href="<?php echo get_template_directory_uri(); ?>/img/android-chrome.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <?php $my_theme = wp_get_theme(); ?>
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.css?ver<?php echo $my_theme->get( 'Version' ) ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
  <?php wp_head(); ?>

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-250311841-1"></script>
  <script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'UA-250311841-1');
  </script>


  <!-- Google Tag Manager -->
  <!-- <script>
  (function(w, d, s, l, i) {
    w[l] = w[l] || [];
    w[l].push({
      'gtm.start': new Date().getTime(),
      event: 'gtm.js'
    });
    var f = d.getElementsByTagName(s)[0],
      j = d.createElement(s),
      dl = l != 'dataLayer' ? '&l=' + l : '';
    j.async = true;
    j.src =
      'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
    f.parentNode.insertBefore(j, f);
  })(window, document, 'script', 'dataLayer', 'GTM-PWPZKLC');
  </script> -->
  <!-- End Google Tag Manager -->

</head>
<body class="body" ontouchstart="">
  <!-- Google Tag Manager (noscript) -->
  <!-- <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PWPZKLC" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript> -->
  <!-- End Google Tag Manager (noscript) -->


  <div class="wrap">
    <!------------------------------------------ header --->
    <header>
      <div class="header_h1 tb-pc">
        <h1>フェイシャルエステや痩身エステ、水素吸入サロンなら堺駅・堺東のECXIA LABO</h1>
      </div>
      <!---------------------SP--->
      <div class="header_sp sp-tb">
        <div class="header_sp_logo sp-tb">
          <a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo_ecxialabo.png" alt="ECXIA LABO（エクシアラボ）"></a>
        </div>
        <div class="header_sp_yoko sp-tb">
          <div class="header_sp_yoko_tel sp-tb">
            <a href="tel:072-260-9712"><img src="<?php echo get_template_directory_uri(); ?>/img/sp_icon_tel.svg" alt="電話番号"></a>
          </div>
          <div class="header_sp_yoko_reserve sp-tb">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/sp_icon_mail.svg" alt="ご予約"></a>
          </div>
          <div class="sp-header-trigger" id="nav-drawer">
            <input class="nav-unshown" id="nav-input" type="checkbox" />
            <div class="header-menu sp-tb">
              <label id="nav-open" for="nav-input"><img src="<?php echo get_template_directory_uri(); ?>/img/sp_icon_menu.svg" alt="メニューボタン" /></label>
            </div>
            <label class="nav-unshown sp-tb" id="nav-close" for="nav-input"></label>
            <div id="nav-content">
              <nav class="header-nav" id="header-sp-link" ontouchstart="">
                <ul class="header-nav-list" id="header-nav-list">
                  <li><a href="<?php echo esc_url(home_url('/')); ?>">トップ</a></li>
                  <!-- <li><a href="#">当サロンの強み</a></li> -->
                  <!-- <li><a href="#">メニュー一覧</a></li> -->
                  <li><a href="<?php echo esc_url(home_url('/salon/')); ?>">サロン案内</a></li>
                  <!-- <li><a href="#">初めての方へ</a></li> -->
                  <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">新着情報</a></li>
                  <li><a href="<?php echo esc_url(home_url('/question/')); ?>">よくある質問</a></li>
                  <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー</a></li>
                  <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <!---------------------PC--->
      <div class="header_pc pc">
        <div class="header_pc_logo pc">
          <a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/logo_ecxialabo.png" alt="ECXIA LABO（エクシアラボ）"></a>
        </div>
        <div class="header_pc_tel font_mincho pc">
          <img src="<?php echo get_template_directory_uri(); ?>/img/tel_icon.png" alt="電話アイコン">072-260-9712 <br><span class="font_14">【受付時間】10:00〜19:00　日曜･月曜定休日</span>
        </div>
        <div class="header_pc_contact pc">
          <a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a>
        </div>
      </div>


      <!------------------------------------------ Groval Navi --->
      <div class="header_gnavi pc">
        <nav class="gnavi">
          <div class="gnavi__inner">
            <ul>
              <li><a href="<?php echo esc_url(home_url('/')); ?>">ホーム</a></li>
              <li><a href="<?php echo esc_url(home_url('/')); ?>">当サロンの強み</a></li>
              <li><a href="<?php echo esc_url(home_url('/')); ?>">メニュー一覧</a></li>
              <li><a href="<?php echo esc_url(home_url('/salon/')); ?>">サロン案内</a></li>
              <li><a href="<?php echo esc_url(home_url('/question/')); ?>">よくある質問</a></li>
            </ul>
          </div>
        </nav>
      </div>
    </header>


    <main>