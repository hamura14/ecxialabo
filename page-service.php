<?php
/*
Template Name: メニュー一覧
*/
?>
<?php get_header() ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section>
  <div class="service_background">
    <div class="service_background_inner">
      <h2>メニュー一覧</h2>
    </div>
  </div>
  <?php custom_breadcrumb(); ?>
</section>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<?php get_footer() ?>