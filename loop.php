<?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article <?php post_class('blog-page__item'); ?>>
        <!-- アイキャッチ画像 -->
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('medium', array('class' => 'blog-page__item-img')); ?>
        <?php else: ?>
            <img src="<?php echo get_bloginfo('template_directory').'/img/blog--noimage.png'; ?>"
                 class="blog-page__item-img">
        <?php endif; ?>

        <!-- 記事タイトル -->
        <h1 class="blog-page__item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

        <!-- 記事文章（一部） -->
        <div class="blog-page__item-text">
            <?php if (is_single()): ?>
                <?php the_content(); ?>
            <?php else: ?>
                <?php the_excerpt(); ?>
            <?php endif; ?>
        </div>

        <!-- 投稿日 -->
        <p class="blog-page__item-timestamp"><?php the_time("Y年n月d日"); ?></p>
    </article>
<?php endwhile; endif; ?>