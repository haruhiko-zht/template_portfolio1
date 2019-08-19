<footer class="footer">
    <div class="wrap footer__wrap">
        <?php wp_nav_menu(array(
            'container' => 'nav',
            'container_class' => 'menu',
            'menu_class' => '',
            'theme_location' => 'footermenu',
            'items_wrap' => '<ul>%3$s</ul>'
        )); ?>
        <div class="footer__copyright">&copy;
            <?php
            $footer_query = new WP_Query(array(
                'order' => 'ASC',
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 1,
            ));
            ?>
            <?php echo substr($footer_query->posts[0]->post_date, 0, 4).' '.get_bloginfo('name').'.'; ?>
        </div>
    </div>
</footer>

<!-- SP menu_bar -->
<ul class="sp-menu">
    <li class="sp-menu__item">
        <label class="sp-menu__item-wrap" id="js-sp-menu-btn">
            <div><i class="fas fa-bars"></i></div>
            <div class="sp-menu__item-title">メニュー</div>
        </label>
    </li>
    <li class="sp-menu__item">
        <label class="sp-menu__item-wrap" id="js-link-home">
            <div><i class="fas fa-home"></i></div>
            <div class="sp-menu__item-title">ホーム</div>
        </label>
    </li>
    <li class="sp-menu__item" id="js-sp-search-btn">
        <label class="sp-menu__item-wrap">
            <div><i class="fas fa-search"></i></div>
            <div class="sp-menu__item-title">検索</div>
        </label>
    </li>
    <li class="sp-menu__item" id="js-scroll-top">
        <label class="sp-menu__item-wrap">
            <div><i class="fas fa-arrow-up"></i></div>
            <div class="sp-menu__item-title">トップ</div>
        </label>
    </li>
    <li class="sp-menu__item" style="opacity: .5">
        <label class="sp-menu__item-wrap">
            <div><i class="fas fa-outdent"></i></div>
            <div class="sp-menu__item-title">サイドバー</div>
        </label>
    </li>
</ul>

<!-- SP modal -->
<div class="sp-modal__back"></div>

<!-- SP search -->
<div class="sp-modal__search"><?php get_search_form(); ?></div>

<!-- SP menu -->
<div class="sp-modal__menu">
    <div class="sp-modal__menu-times" id="js-sp-modal__menu-times"><i class="fas fa-times"></i></div>
    <?php wp_nav_menu(array(
        'container' => 'nav',
        'container_class' => 'sp-modal__menu-list',
        'menu_class' => '',
        'theme_location' => 'mainmenu',
        'items_wrap' => '<ul>%3$s</ul>'
    )); ?>
    <div class="sp-modal__menu-sns-btn">
        <?php dynamic_sidebar('SNSボタンエリア'); ?>
    </div>
</div>


<!-- スクリプト関係 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="<?php echo get_bloginfo('template_directory').'/js/main.js'; ?>"></script>

<?php wp_footer(); ?>
</body>
</html>