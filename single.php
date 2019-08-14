<?php
// ファイル読み込み
require_once('func.php');
?>

    <!-- ヘッド -->
<?php get_header(); ?>

    <!-- メニュー -->
<?php get_template_part('content', 'menu'); ?>

    <!-- メイン -->
    <main class="main">
        <div class="wrap wrap--blog-detail">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <!-- 記事 -->
                <article <?php post_class('blog-detail'); ?>>
                    <!-- 記事タイトル -->
                    <h1 class="blog-detail__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

                    <?php if (in_category('blog')): ?>
                        <!-- 投稿日 -->
                        <p class="blog-detail__timestamp"><?php the_time("Y年n月d日"); ?></p>
                    <?php endif; ?>

                    <!-- アイキャッチ画像 -->
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('full', array('class' => 'blog-detail__img')); ?>
                    <?php else: ?>
                        <img src="<?php echo get_bloginfo('template_directory').'/img/blog--noimage.png'; ?>"
                             class="blog-detail__img">
                    <?php endif; ?>

                    <!-- 記事本文 -->
                    <div class="blog-detail__text">
                        <?php the_content(); ?>
                    </div>
                </article>
                <!-- ページ分け -->
                <?php wp_link_pages(); ?>

            <?php endwhile; ?>
                <!-- ページネーション -->
                <div class="detail__pagination">
                    <?php if (!empty(get_previous_post(true))): ?>
                        <?php $prev_post = get_previous_post(true); ?>
                        <a href="<?= get_permalink($prev_post->ID) ?>" class="detail__pagination-link">
                            <div class="detail__pagination--prev">
                                <i class="fas fa-angle-left"></i>
                                <?php if (has_post_thumbnail($prev_post->ID)): ?>
                                    <?= get_the_post_thumbnail($prev_post->ID, 'post-thumbnail',
                                        array('class' => 'detail__pagination-img')) ?>
                                <?php else: ?>
                                    <img src="<?php echo get_bloginfo('template_directory').'/img/blog--noimage.png'; ?>"
                                         class="detail__pagination-img">
                                <?php endif; ?>
                                <div class="detail__pagination-title"><?= titleOm(get_the_title($prev_post->ID),
                                        40) ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty(get_next_post(true))): ?>
                        <?php $next_post = get_next_post(true); ?>
                        <a href="<?= get_permalink($next_post->ID) ?>" class="detail__pagination-link">
                            <div class="detail__pagination--next">
                                <i class="fas fa-angle-right"></i>
                                <?php if (has_post_thumbnail($next_post->ID)): ?>
                                    <?= get_the_post_thumbnail($next_post->ID, 'post-thumbnail',
                                        array('class' => 'detail__pagination-img')) ?>
                                <?php else: ?>
                                    <img src="<?php echo get_bloginfo('template_directory').'/img/blog--noimage.png'; ?>"
                                         class="detail__pagination-img">
                                <?php endif; ?>
                                <div class="detail__pagination-title"><?= titleOm(get_the_title($next_post->ID),
                                        40) ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- フッター -->
<?php get_footer(); ?>