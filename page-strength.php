<?php
/*
Template Name: 当サロンの強み
*/
?>
<?php get_header() ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section>

  <div class="contct_title_sp sp">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/strength_title_sp.jpg" alt="当サロンの強み">
  </div>
  <div class="contct_title_pc tb-pc">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/strength_title.jpg" alt="当サロンの強み">
  </div>

  <?php custom_breadcrumb(); ?>
</section>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<?php get_footer() ?>