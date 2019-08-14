<?php
/*
 Template Name: About ~紹介~
*/
?>
    <!-- ヘッド -->
<?php get_header(); ?>

    <!-- メニュー -->
<?php get_template_part('content', 'menu'); ?>

    <!-- メイン -->
    <main class="main">
        <div class="wrap">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
                <article <?php post_class('about'); ?>>
                    <!-- ページタイトル -->
                    <h1 class="about__title"><?php the_title(); ?></h1>

                    <!-- ページ本文 -->
                    <div class="about__text blog-detail__text"><?php the_content(); ?></div>

                    <!-- カスタムフィールド -->
                    <div class="about__profile">
                        <!-- プロフィール画像 -->
                        <?php $meta = get_post_meta($post->ID, 'about_profileImage', true); ?>
                        <?php if (!empty($meta)): ?>
                            <img src="<?= get_post_meta($post->ID, 'about_profileImage', true) ?>"
                                 class="about__profile--image">
                        <?php endif; ?>
                        <!-- プロフィール詳細 -->
                        <div class="about__profile--detail">
                            <table>
                                <tbody>
                                <?php
                                for ($i = 1; $i <= 8; $i++): ?>
                                    <tr>
                                        <th><?= get_post_meta($post->ID, 'about_infoKey'.$i, true) ?></th>
                                        <td><?= get_post_meta($post->ID, 'about_infoVal'.$i, true) ?></td>
                                    </tr>
                                <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </div>
    </main>

    <!-- フッター -->
<?php get_footer(); ?>