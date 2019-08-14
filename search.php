<?php
// ファイル読み込み
require_once('func.php');

//検索ワード
$searchQuery = get_search_query();

// ページネーション用変数
$paged = (int)get_query_var('paged');
if ($paged === 0) {
    $paged = 1;
}

// １ページあたりの表示数
//$list_cnt = 9;

// 記事取得(portfolio)
$args = array(
    's' => $searchQuery, //検索ワード
    'post__not_in' => get_option('sticky_posts'), //固定表示記事は非表示
    'paged' => $paged,
//    'posts_per_page' => $list_cnt,
    'post_type' => 'post',
    'post_status' => 'publish',
    'category_name' => 'portfolio' //portfolioカテゴリのみ取得
);
$pf_query = new WP_Query($args);

// 記事取得(blog)
$args = array(
    's' => $searchQuery, //検索ワード
    'post__not_in' => get_option('sticky_posts'), //固定表示記事は非表示
    'paged' => $paged,
//    'posts_per_page' => $list_cnt,
    'post_type' => 'post',
    'post_status' => 'publish',
    'category_name' => 'blog' //blogカテゴリのみ取得
);
$blog_query = new WP_Query($args);
?>

<!-- ヘッド -->
<?php get_header(); ?>

<!-- メニュー -->
<?php get_template_part('content', 'menu'); ?>

<!-- メイン -->
<main class="main">
    <div class="wrap">
        <h1><?= $searchQuery ?>の検索結果</h1>

        <!-- ポートフォリオエリア -->
        <section <?php post_class('works'); ?>>
            <h2 class="works__title tal">Portfolio</h2>
            <div class="works__list">
                <?php if ($pf_query->have_posts()): while ($pf_query->have_posts()): $pf_query->the_post(); ?>
                    <article <?php post_class('works__item'); ?>>
                        <a href="<?php the_permalink(); ?>">
                            <!-- アイキャッチ画像 -->
                            <figure>
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large', array('class' => 'works__item-img')); ?>
                                <?php else: ?>
                                    <img src="<?php echo get_bloginfo('template_directory').'/img/blog--noimage.png'; ?>"
                                         class="works__item-img">
                                <?php endif; ?>

                                <!-- タイトル -->
                                <figcaption>
                                    <h1 class="works__item-title"><?php the_title() ?></h1>
                                </figcaption>
                            </figure>
                        </a>
                    </article>
                <?php endwhile; ?>
                <?php else: ?>
                    <p>該当する情報は見つかりませんでした。</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- ブログエリア -->
        <section <?php post_class('blog-page'); ?>>
            <!-- ページタイトル -->
            <h2 class="blog-page__title">Blog</h2>

            <!-- ページ本文　-->
            <div class="blog-page__text"></div>

            <!-- 記事一覧 -->
            <div class="blog-page__list">
                <?php if ($blog_query->have_posts()): while ($blog_query->have_posts()): $blog_query->the_post(); ?>
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
                            <div class="blog-page__item-desc">
                                <div class="blog-page__item--title-text">
                                    <!-- 記事タイトル -->
                                    <h3 class="blog-page__item-title"><?php the_title(); ?></h3>

                                    <!-- 記事文章（一部or抜粋） -->
                                    <div class="blog-page__item-text">
                                        <?php if (is_single()): ?>
                                            <?php the_content(); ?>
                                        <?php else: ?>
                                            <?php the_excerpt(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- 投稿日 -->
                                <div class="blog-page__item-timestamp"><?php the_time("Y年n月d日"); ?></div>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
                <?php else: ?>
                    <p>該当する情報は見つかりませんでした。</p>
                <?php endif; ?>
            </div>
        </section>


    </div>
</main>

<!-- フッター -->
<?php get_footer(); ?>
