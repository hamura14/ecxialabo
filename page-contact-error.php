<?php
/*
Template Name: お問い合わせ 入力エラー
*/
?>
<?php get_header() ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section>
  <div class="contct_title_sp sp">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/contact_title_sp.jpg" alt="お問い合わせ">
  </div>
  <div class="contct_title_pc tb-pc">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/contact_title.jpg" alt="お問い合わせ">
  </div>

  <?php custom_breadcrumb(); ?>
</section>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<?php get_footer() ?>