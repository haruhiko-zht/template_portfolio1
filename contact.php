<?php
/*
 Template Name: Contact ~お問い合わせ~
*/
?>
    <!-- ヘッド -->
<?php get_header(); ?>
    <!-- メニュー -->
<?php get_template_part('content', 'menu'); ?>

    <!-- メイン -->
    <main class="main">
        <div class="wrap">
            <section class="contact">
                <h1 class="contact__title"><?php echo get_the_title(); ?></h1>
                <p class="contact__text"><?php the_content() ?></p>
                <?php if (have_posts()): while (have_posts()): the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
            </section>
        </div>
    </main>

    <!-- フッター -->
<?php get_footer(); ?>