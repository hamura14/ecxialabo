</main>

<?php if (!is_page (array('service', 'facial', 'slimming', 'slimming'))): ?>
<div class="top_banner">
  <div class="top_banner_sp sp">
    <a href="javascript:void(0)" class="disabled" tabindex="-1"><img src="<?php echo get_template_directory_uri(); ?>/img/top_banner_sp.jpg" alt="初めての方でも受けやすいトライアルコースをご用意！"></a>
  </div>
  <div class="top_banner_pc tb-pc">
    <a href="javascript:void(0)" class="disabled" tabindex="-1"><img src="<?php echo get_template_directory_uri(); ?>/img/top_banner.jpg" alt="初めての方でも受けやすい「トライアルコース」をご用意しております！"></a>
  </div>
</div>
<?php endif; ?>


<!-- Blog -->
<?php if (is_front_page() ): ?>
<section class="blog_space">
  <div class="mt-5">
    <div class="top_news">
      <h2 class="text-center">新着情報</h2>
      <div class="top_underline"></div>
    </div>
    <ul class="top_news_list">
      <?php
      $args = array(
        'posts_per_page' => 3,
        'post_type' => 'blog',
      );
      $the_query = new WP_Query( $args );
      if ( $the_query->have_posts() ) :
    ?>
      <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
      <li>
        <a href="<?php the_permalink(); ?>">
          <time><?php the_time("Y年m月d日"); ?></time>
          <p>
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
        </p>
        </a>
      </li>
      <?php endwhile; ?>
      <?php
        wp_reset_postdata();
        endif;
      ?>
    </ul>
    <div class="top_shop_btn">
      <a href="<?php echo esc_url(home_url('/blog/')); ?>">一覧を見る ▶</a>
    </div>
  </div>
</section>
<?php endif; ?>





<footer>
  <div class="footer_btn">
    <div class="footer_btn_01">
      <a href="javascript:void(0)" class="disabled" tabindex="-1"><img src="<?php echo get_template_directory_uri(); ?>/img/top_img01.jpg" alt="初めての方へ"></a>
    </div>
    <div class="footer_btn_02">
      <a href="<?php echo esc_url(home_url('/salon/')); ?>"><img src="<?php echo get_template_directory_uri(); ?>/img/top_img02.jpg" alt="お店へのアクセス"></a>
    </div>
  </div>

  <div class="footer">
    <div class="footer-top">
      <nav class="footer-top-nav">
        <ul>
          <li><a href="<?php echo esc_url(home_url('/')); ?>">トップページ</a></li>
          <li><a href="javascript:void(0)" class="disabled" tabindex="-1">当サロンの強み</a></li>
          <li><a href="javascript:void(0)" class="disabled" tabindex="-1">メニュー一覧</a></li>
          <li><a href="<?php echo esc_url(home_url('/salon/')); ?>">サロン案内</a></li>
          <li><a href="javascript:void(0)" class="disabled" tabindex="-1">初めての方へ</a></li>
          <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">新着情報</a></li>
          <li><a href="<?php echo esc_url(home_url('/question/')); ?>">よくある質問</a></li>
          <li><a href="<?php echo esc_url(home_url('/privacy/')); ?>">プライバシーポリシー</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a></li>
        </ul>
      </nav>
    </div>

    <div class="footer-bottom">
      <div class="footer-bottom-logo">
        <div class="tb"><img src="<?php echo get_template_directory_uri(); ?>/img/logo_ecxialabo_sp.png" alt="ECXIA LABO（エクシアラボ）ロゴ"></div>
        <div class="sp-pc"><img src="<?php echo get_template_directory_uri(); ?>/img/logo_ecxialabo.png" alt="ECXIA LABO（エクシアラボ）ロゴ"></div>
      </div>
      <div class="footer-bottom-info">
        <div class="footer-bottom-info-left">
          <a href="tel:072-260-9712">
            <div class="footer-bottom-info-tel">
              <div class="footer-bottom-info-icon">
                <img src="<?php echo get_template_directory_uri(); ?>/img/tel_icon.png" alt="電話アイコン">
              </div>
              <p>072-260-9712</p>
            </div>
          </a>
          <div class="footer-bottom-info-time">【受付時間】10:00〜19:00　日曜･月曜定休日
          </div>
          <div class="footer-bottom-info-access">〒590-0958　大阪府堺市堺区宿院町西3-2-1
          </div>
        </div>
        <div class="footer-bottom-info-right">
          <div class="footer-bottom-info-btn">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>">お問い合わせ</a>
          </div>
          <div class="footer-bottom-info-insta">
            <a href="https://www.instagram.com/ecxialabo/" target="_blank">
              <img src="<?php echo get_template_directory_uri(); ?>/img/instagram.gif" alt="Instagram">
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <small>Copyright©2022 ECXIA LABO</small>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</body>
</html>