<?php
/*
Template Name: 404
*/
?>
<?php get_header(); ?>
<section>
  <div class="not">
    <div class="not-inner">
      <h2>ページが見つかりませんでした。</h2>
      <p>当サイトをご覧頂き、ありがとうございます。</p>
      <p>大変申し訳ないのですが、あなたがアクセスしようとしたページは、削除されたか、URLが変更されています。</p>
      <div class="not-btn" ontouchstart="">
        <a href="<?php echo esc_url(home_url('/')); ?>">TOPに戻る</a>
      </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>