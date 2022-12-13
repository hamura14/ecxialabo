<?php
/*
Template Name: サロン案内
*/
?>
<?php get_header() ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section>

  <div class="contct_title_sp sp">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/salon_title_sp.jpg" alt="サロン案内">
  </div>
  <div class="contct_title_pc tb-pc">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/salon_title.jpg" alt="サロン案内">
  </div>

  <?php custom_breadcrumb(); ?>
</section>
<?php the_content(); ?>
<?php endwhile; endif; ?>
<?php get_footer() ?>