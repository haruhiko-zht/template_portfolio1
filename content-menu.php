<header class="header">
    <div class="wrap">
        <h1 class="header__title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
        <div class="header__desc">WEB制作系のポートフォリオサイトです</div>
        <div class="header__sns-btn">
            <?php dynamic_sidebar('SNSボタンエリア'); ?>
        </div>
        <?php wp_nav_menu(array(
            'container' => 'nav',
            'container_class' => 'menu',
            'menu_class' => '',
            'theme_location' => 'mainmenu',
            'items_wrap' => '<ul>%3$s</ul>'
        )); ?>
    </div>
</header>