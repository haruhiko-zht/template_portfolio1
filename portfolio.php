<?php
/*
 Template Name: Portfolio ~作品~
*/
?>
<?php
// 現在ページ数
$paged = (int)get_query_var('paged');
if ($paged === 0) {
    $paged = 1;
}

// 表示件数
$meta = (int)get_post_meta($post->ID, 'portfolio_perPage', true);
$list_cnt = (!empty($meta)) ? $meta : 3;

// WPクエリ
$args = array(
    'post__not_in' => get_option('sticky_posts'), // 固定表示記事は非表示
    'posts_per_page' => $list_cnt,
    'paged' => $paged,
    'post_type' => 'post',
    'post_status' => 'publish',
    'category_name' => 'portfolio'
);
$the_query = new WP_Query($args);
?>
    <!-- ヘッド -->
<?php get_header(); ?>

    <!-- メニュー -->
<?php get_template_part('content', 'menu'); ?>

    <!-- メイン -->
    <main class="main">
        <div class="wrap">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <section <?php post_class('portfolio'); ?>>
                    <!-- ページタイトル -->
                    <h1 class="portfolio__title"><?php the_title(); ?></h1>

                    <!-- ページ本文 -->
                    <div class="portfolio__text"><?php the_content(); ?></div>

                    <!-- 投稿記事ループ -->
                    <?php if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
                        <article <?php post_class('portfolio__item'); ?>>
                            <a href="<?php the_permalink(); ?>">
                                <!-- アイキャッチ画像 -->
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large', array('class' => 'portfolio__item-img')); ?>
                                <?php else: ?>
                                    <img src="<?php echo get_bloginfo('template_directory').'/img/blog--noimage.png'; ?>"
                                         class="portfolio__item-img">
                                <?php endif; ?>


                                <!-- 記事タイトル -->
                                <h3 class="portfolio__item-title"><?php the_title(); ?></h3>

                                <!-- 記事文章（一部） -->
                                <div class="portfolio__item-text">
                                    <?php if (is_single()): ?>
                                        <?php the_content(); ?>
                                    <?php else: ?>
                                        <?php the_excerpt(); ?>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <p>まだ投稿がありません.</p>
                    <?php endif; ?>
                </section>
            <?php endwhile; endif; ?>

            <!-- ページネーション -->
            <?php if (function_exists("pagination")) {
                pagination($the_query->max_num_pages);
            } ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </main>

    <!-- フッター -->
<?php get_footer(); ?>