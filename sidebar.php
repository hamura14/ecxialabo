<section class="sidebar">
  <div class="sidebar_item">
    <h3>カテゴリー</h3>
    <ul class="sidebar_item_list">
      <?php
        $args = array(
          'taxonomy' => 'blog_category',
          'title_li' => ''
        );
        wp_list_categories($args);
      ?>
    </ul>
  </div>
  <div class="sidebar_item">
    <h3>アーカイブ</h3>
    <ul class="sidebar_item_list">
      <?php
        $string = wp_get_archives(array(
          'type'            => 'monthly',
          'limit'           => '6',
          'show_post_count' => 1,
          'order'           => 'DESC',
          'post_type'     => 'blog',
          'echo' => 0
        ));
        echo preg_replace('/<\/a>&nbsp;(\([0-9]*\))/', ' <span class="count">$1</span></a>', $string);
      ?>
    </ul>
  </div>
</section>