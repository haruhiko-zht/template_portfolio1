<?php
/*
 Template Name: Home ~トップページ~
*/
?>
    <!-- ヘッド -->
<?php get_header(); ?>

    <!-- メニュー -->
<?php get_template_part('content', 'menu'); ?>

    <!-- メイン -->
    <main class="main">
        <!-- ヒーローバナー（ヘッダー画像） -->
        <section class="hero">
            <img src="<?php header_image(); ?>" class="hero__img" alt="<?php bloginfo('name'); ?>">
        </section>

        <!-- ウィジェットエリア -->
        <section class="home">
            <?php if (is_active_sidebar('widget_home_top')): ?>
                <!-- 上段エリア -->
                <section>
                    <div class="wrap">
                        <?php dynamic_sidebar('【ホーム】上段エリア'); ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (is_active_sidebar('widget_home_middle')): ?>
                <!-- 中段エリア -->
                <section>
                    <div class="wrap">
                        <?php dynamic_sidebar('【ホーム】中段エリア'); ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (is_active_sidebar('widget_home_bottom')): ?>
                <!-- 下段エリア -->
                <section>
                    <div class="wrap">
                        <?php dynamic_sidebar('【ホーム】下段エリア'); ?>
                    </div>
                </section>
            <?php endif; ?>
        </section>
    </main>

    <!-- フッター -->
<?php get_footer(); ?>