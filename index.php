<!-- ヘッド -->
<?php get_header(); ?>

<!-- メニュー -->
<?php get_template_part('content', 'menu'); ?>

<!-- メイン -->
<main class="main">
    <!-- HERO画像 -->
    <section class="hero">
        <img src="<?php header_image(); ?>" class="hero__img" alt="<?php bloginfo('name'); ?>">
    </section>

    <div class="wrap">
        <!-- 紹介エリア1 -->
        <?php dynamic_sidebar('【ホーム】上段エリア'); ?>

        <!-- 紹介エリア2 -->
        <?php dynamic_sidebar('【ホーム】中段エリア'); ?>

        <!-- ブログエリア -->
        <?php dynamic_sidebar('【ホーム】下段エリア'); ?>
    </div>
</main>

<!-- フッター -->
<?php get_footer(); ?>