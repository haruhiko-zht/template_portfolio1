<!-- ヘッド -->
<?php get_header(); ?>

<!-- メニュー -->
<?php get_template_part('content', 'menu'); ?>

<!-- メイン -->
<main class="main">
    <div class="wrap">
        <h1 class="not-found__title">URLに該当するページは見つかりませんでした。</h1>
        <p><a href="<?= home_url() ?>" class="not-found__link">ホームへ戻る</a></p>
    </div>
</main>

<!-- フッター -->
<?php get_footer(); ?>