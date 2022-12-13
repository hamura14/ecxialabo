<?php
/*
Template Name: プライバシーポリシー
*/
?>
<?php get_header() ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section>

  <div class="contct_title_sp sp">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/privacy_title_sp.jpg" alt="プライバシーポリシー">
  </div>
  <div class="contct_title_pc tb-pc">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/privacy_title.jpg" alt="プライバシーポリシー">
  </div>

  <?php custom_breadcrumb(); ?>
</section>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<?php get_footer() ?>