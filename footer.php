<footer class="footer">
    <div class="wrap footer__wrap">
        <?php wp_nav_menu(array(
            'container' => 'nav',
            'container_class' => 'menu',
            'menu_class' => '',
            'theme_location' => 'footermenu',
            'items_wrap' => '<ul>%3$s</ul>'
        )); ?>
        <div class="footer_copyright">&copy;
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

<!-- スクリプト関係 -->
<script src="<?php echo get_bloginfo('template_directory').'/js/main.js'; ?>"></script>

</body>
</html>