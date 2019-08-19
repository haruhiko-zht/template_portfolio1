<?php
/*
 * Template Name: Blog ~ブログ~
 */
?>
<?php
// ファイル読み込み
require_once('func.php');

// ページネーション用変数
$paged = (int)get_query_var('paged');
if ($paged === 0) {
    $paged = 1;
}

// 表示件数
$meta = (int)get_post_meta($post->ID, 'blog_perPage', true);
$list_cnt = (!empty($meta)) ? $meta : 9;

// WPクエリ
$args = array(
    'post__not_in' => get_option('sticky_posts'), //固定表示記事は非表示
    'posts_per_page' => $list_cnt,
    'paged' => $paged,
    'post_type' => 'post',
    'post_status' => 'publish',
    'category_name' => 'blog' //blogカテゴリのみ取得
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
            <section <?php post_class('blog-page'); ?>>
                <!-- ページタイトル -->
                <h1 class="blog-page__title"><?php the_title(); ?></h1>

                <!-- ページ本文 -->
                <div class="blog-page__text"><?php the_content(); ?></div>

                <!-- 記事一覧 -->
                <?php if ($the_query->have_posts()): ?>
                    <div class="blog-page__list">
                        <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                            <!-- 個別記事 -->
                            <article <?php post_class('blog-page__item'); ?>>
                                <a href="<?php the_permalink(); ?>" class="blog-page__item--link">
                                    <!-- アイキャッチ画像 -->
                                    <?php if (has_post_thumbnail()): ?>
                                        <?php the_post_thumbnail('large', array('class' => 'blog-page__item-img')); ?>
                                    <?php else: ?>
                                        <img src="<?php echo get_bloginfo('template_directory').'/img/blog--noimage.png'; ?>"
                                             class="blog-page__item-img">
                                    <?php endif; ?>

                                    <!-- 記事詳細 -->
                                    <!--                                    <div class="blog-page__item-desc">-->
                                    <!--                                        <div class="blog-page__item--title-text">-->
                                    <!-- 記事タイトル -->
                                    <h1 class="blog-page__item-title"><?php the_title(); ?></h1>

                                    <!-- 記事文章（一部or抜粋） -->
                                    <div class="blog-page__item-text">
                                        <?php if (is_single()): ?>
                                            <?php the_content(); ?>
                                        <?php else: ?>
                                            <?php the_excerpt(); ?>
                                        <?php endif; ?>
                                    </div>
                                    <!--                                        </div>-->

                                    <!-- 投稿日 -->
                                    <div class="blog-page__item-timestamp"><?php the_time("Y年n月d日"); ?></div>
                                    <!--                                    </div>-->
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>
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
