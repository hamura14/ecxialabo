<?php
/*
Template Name: ブログカテゴリー
*/
?>
<?php get_header() ?>
<section>

  <div class="contct_title_sp sp">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/blog_title_sp.jpg" alt="新着ブログ">
  </div>
  <div class="contct_title_pc tb-pc">
    <img src="https://ecxia-labo.com/wp-content/themes/ecxialabo/img/blog_title.jpg" alt="新着ブログ">
  </div>

  <?php custom_breadcrumb(); ?>
</section>
<div class="blog">
  <section class="blog_content">
    <h2>
      <?php
        if ($terms = get_the_terms($post->ID, 'blog_category')) {
          foreach ( $terms as $term ) {
              echo esc_html($term->name)  ;
          }
        }
      ?>
    </h2>
    <ul class="blog_content_list">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <li>
        <a href="<?php the_permalink(); ?>">
          <time><?php the_time("Y/m/d"); ?></time>
          <h3>
            <?php the_title(); ?>
            <?php
              $last_post_ids = array();
              $lastposts = get_posts('post_type=blog&posts_per_page=5');
              foreach ($lastposts as $lastpost) {
                $last_post_ids[] = $lastpost->ID;
              }
            ?>
            <?php
              $days = 5;
              $today = date_i18n('U');
              $entry = get_the_time('U');
              $kiji = date('U', ($today - $entry)) / 86400 ;
              if ($days > $kiji) {
            ?>
            <?php if (in_array($post->ID, $last_post_ids)) : ?>
            <span class="new">NEW</span>
            <?php endif; ?>
            <?php } ?>
          </h3>
        </a>
      </li>
      <?php endwhile; endif; ?>
    </ul>
    <?php
      if ( function_exists( 'pagination' ) ) :
        pagination( $wp_query->max_num_pages, get_query_var( 'paged' ) );
      endif;
    ?>
  </section>
  <?php get_template_part("sidebar"); ?>
</div>
<?php get_footer(); ?>