<?php
/*
Template Name: 新着情報　詳細
*/
?>
<?php get_header() ?>
<section>

  <div class="contct_title_sp sp">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/blog_title_sp.jpg" alt="新着情報">
  </div>
  <div class="contct_title_pc tb-pc">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/blog_title.jpg" alt="新着情報">
  </div>

  <!-- <div class="blog_background">
    <div class="blog_background_inner">
      <h2>新着情報</h2>
    </div>
  </div> -->
  <?php //custom_breadcrumb(); ?>
</section>
<div class="blog">
  <section class="detail_content">
    <div class="detail_content_ttl">
      <time><?php the_time("Y年m月d日"); ?></time><br>
      <h1><?php the_title(); ?></h1>
    </div>
    <div class="detail_content_img">
      <?php if (has_post_thumbnail()) : ?>
      <?php the_post_thumbnail(array(960, 460)); ?>
      <?php else : ?>
      <?php endif; ?>
    </div>
    <div class="detail_content_c"><?php the_content(); ?></div>
    <div class="top_shop_btn">
      <a href="<?php echo esc_url(home_url('/blog/')); ?>">一覧へ戻る ➡</a>
    </div>
  </section>
  <?php get_template_part("sidebar"); ?>
</div>
<?php get_footer(); ?>