<?php
require_once('func.php');

//=====================================
// カスタムヘッダー
//=====================================
$custom_header_defaults = array(
    'default-image' => get_bloginfo('template_directory').'/img/hero--demo.jpg',
    'header-text' => false,
);
// カスタムヘッダー有効化
add_theme_support('custom-header', $custom_header_defaults);


//=====================================
// カスタムメニュー有効化
//=====================================
register_nav_menu('mainmenu', 'ヘッダーメニュー');
register_nav_menu('footermenu', 'フッターメニュー');


//=====================================
// ページネーション
//=====================================
function pagination($pages = '', $range = 2)
{
    $showitems = ($range * 2) + 1; // 表示するページ数（5ページを表示）

    global $paged; // 現在のページ値
    if (empty($paged)) {
        $paged = 1;
    } // デフォルトのページ

    if ($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages; // 全ページ数を取得
        if (!$pages) // 全ページ数が空の場合は１とする
        {
            $pages = 1;
        }
    }

    if (1 != $pages) // 全ページが１でない場合はページネーションを表示する
    {
        echo "<div class=\"pagination\">\n";

        if ($paged < $pages) {
            echo "<div class=\"pagination__next--large\"><a href=\"".get_pagenum_link($paged + 1)."\">次のページ</a></div>\n";
        }

        echo "<div class=\"pagination__detail\">\n";

        // prev 現在のページ値が１より大きい場合は表示
        if ($paged > 1) {
            echo "<span class=\"pagination__detail--btn\"><a href='".get_pagenum_link($paged - 1)."'>&lt;</a></span>\n";
        }

        for ($i = 1; $i <= $pages; $i++) {
            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
                echo ($paged == $i) ? "<span class=\"pagination__detail--btn pagination__detail--current\">".$i."</span>\n" : "<span class=\"pagination__detail--btn\"><a href='".get_pagenum_link($i)."'>".$i."</a></span>\n";
            }
        }

        // next 総ページ数より現在のページ値が小さい場合は表示
        if ($paged < $pages) {
            echo "<span class=\"pagination__detail--btn\"><a href=\"".get_pagenum_link($paged + 1)."\">&gt;</a></span>\n";
        }
        echo "</div>\n";
        echo "</div>\n";
    }
}


//=====================================
// ビジュアルエディタにstyle.cssを適用
//=====================================
add_editor_style('style.css');

//ビジュアルエディターのクラス名に任意のclassを追加する
add_filter('tiny_mce_before_init', 'tiny_mce_before_init_custom_demo');
function tiny_mce_before_init_custom_demo($mceInit)
{
    //追加するクラス名を付け加える
    $mceInit['body_class'] .= ' blog-detail__text';//使用テーマにより追加するクラス名は変わります
    return $mceInit;
}


//=====================================
// アイキャッチ画像
//=====================================
add_theme_support('post-thumbnails');


//=====================================
// SVG許可
//=====================================
function add_file_types_to_uploads($file_types)
{

    $new_filetypes = array();
    $new_filetypes['svg'] = 'image/svg+xml';
    $file_types = array_merge($file_types, $new_filetypes);

    return $file_types;
}

add_action('upload_mimes', 'add_file_types_to_uploads');


//=====================================
// 概要文の文字数
//=====================================
function my_length($length)
{
    if ((is_home() || is_front_page()) && !is_paged() || is_search()) {
        return 138;
    } elseif (is_page_template('portfolio.php')) {
        return 1000;
    } else {
        return 110;
    }
}

add_filter('excerpt_length', 'my_length', 999);


//=====================================
// 概要文の省略記号
//=====================================
function my_more($more)
{
    return '...';
}

add_filter('excerpt_more', 'my_more');


//=====================================
// 固定表示記事の選択非表示
//=====================================
function remove_sticky_posts()
{
    echo '<script>if(typeof jQuery != "undefined"){jQuery(function(){jQuery("#sticky-span").remove();})}'."\n".'</script>';
}

add_action('admin_head', 'remove_sticky_posts');


//=====================================
// カスタムフィールド
//=====================================
/**
 * template - about.php
 * プロフィール詳細
 */
function custom_area_about()
{
    global $post;
    echo '<table>'."\n";
    for ($i = 1; $i <= 8; $i++) {
        echo '<tr><td>情報:'.$i.'</td><td><input type="text" name="about_infoKey'.$i.'" value="'.get_post_meta($post->ID,
                'about_infoKey'.$i,
                true).'" placeholder="項目名"></td><td><input type="text" name="about_infoVal'.$i.'" value="'.get_post_meta($post->ID,
                'about_infoVal'.$i, true).'" placeholder="項目内容"></td></tr>'."\n";
    }
    echo '</table>'."\n";
}

/**
 * template - about.php
 * プロフィール画像
 */
function custom_area_about_profileImage()
{
    global $post;
    echo 'ABOUTプロフィール画像URL: <input type="text" name="about_profileImage" value="'.get_post_meta($post->ID,
            'about_profileImage', true).'">';
}

/**
 * template - portfolio.php
 * 1ページあたりの表示件数
 */
function custom_area_portfolio_perPage()
{
    global $post;
    echo '1ページあたりの表示件数: <input type="number" name="portfolio_perPage" value="'.get_post_meta($post->ID,
            'portfolio_perPage', true).'" placeholder="3">(デフォルト:3件)';
}

/**
 * template - blog.php
 * 1ページあたりの表示件数
 */
function custom_area_blog_perPage()
{
    global $post;
    echo '1ページあたりの表示件数: <input type="number" name="blog_perPage" value="'.get_post_meta($post->ID, 'blog_perPage',
            true).'" placeholder="9">(デフォルト:9件)';
}

/**
 * カスタムフィールドの入力エリアを登録するための関数
 */
function add_custom_inputbox()
{
    global $post;
    $template_file = get_post_meta($post->ID, '_wp_page_template', true);

    if ($template_file === 'about.php') {
        add_meta_box('about_profileImage_id', 'プロフィール画像', 'custom_area_about_profileImage', 'page', 'normal');
        add_meta_box('about_id', 'ABOUT入力欄', 'custom_area_about', 'page', 'normal');
    } elseif ($template_file === 'portfolio.php') {
        add_meta_box('portfolio_perPage_id', '表示設定', 'custom_area_portfolio_perPage', 'page', 'normal');
    } elseif ($template_file === 'blog.php') {
        add_meta_box('blog_perPage_id', '表示設定', 'custom_area_blog_perPage', 'page', 'normal');
    }
}

// メタボックス追加
add_action('add_meta_boxes', 'add_custom_inputbox');


/**
 * カスタムフィールドの値を保存するための関数
 *
 * @param $post_id
 */
function save_custom_postdata($post_id)
{
    // custom_area_about
    $about_infoKey = '';
    $about_infoVal = '';
    for ($i = 1; $i <= 8; $i++) {
        if (isset($_POST['about_infoKey'.$i]) || isset($_POST['about_infoVal'.$i])) {
            $about_infoKey = (string)filter_input(INPUT_POST, 'about_infoKey'.$i);
            $about_infoVal = (string)filter_input(INPUT_POST, 'about_infoVal'.$i);
        }
        if ($about_infoKey !== get_post_meta($post_id, 'about_infoKey'.$i,
                true) || $about_infoVal !== get_post_meta($post_id, 'about_infoVal'.$i, true)) {
            update_post_meta($post_id, 'about_infoKey'.$i, $about_infoKey);
            update_post_meta($post_id, 'about_infoVal'.$i, $about_infoVal);
        } elseif ($about_infoKey === '') {
            delete_post_meta($post_id, 'about_infoKey'.$i, get_post_meta($post_id, 'about_infoKey'.$i, true));
        } elseif ($about_infoVal === '') {
            delete_post_meta($post_id, 'about_infoVal'.$i, get_post_meta($post_id, 'about_infoVal'.$i, true));
        }
    }
    // custom_area_about_profileImage
    $about_profileImage = '';
    if (isset($_POST['about_profileImage'])) {
        $about_profileImage = (string)filter_input(INPUT_POST, 'about_profileImage');
    }
    if ($about_profileImage !== get_post_meta($post_id, 'about_profileImage', true)) {
        update_post_meta($post_id, 'about_profileImage', $about_profileImage);
    } elseif ($about_profileImage === '') {
        delete_post_meta($post_id, 'about_profileImage', get_post_meta($post_id, 'about_profileImage', true));
    }

    // custom_area_portfolio_perPage
    $portfolio_perPage = '';
    if (isset($_POST['portfolio_perPage'])) {
        $portfolio_perPage = filter_input(INPUT_POST, 'portfolio_perPage');
    }
    if ($portfolio_perPage !== get_post_meta($post_id, 'portfolio_perPage', true)) {
        update_post_meta($post_id, 'portfolio_perPage', $portfolio_perPage);
    } elseif ($portfolio_perPage === '') {
        delete_post_meta($post_id, 'portfolio_perPage', get_post_meta($post_id, 'portfolio_perPage', true));
    }

    // custom_area_blog_perPage
    $blog_perPage = '';
    if (isset($_POST['blog_perPage'])) {
        $blog_perPage = filter_input(INPUT_POST, 'blog_perPage');
    }
    if ($blog_perPage !== get_post_meta($post_id, 'blog_perPage', true)) {
        update_post_meta($post_id, 'blog_perPage', $blog_perPage);
    } elseif ($blog_perPage === '') {
        delete_post_meta($post_id, 'blog_perPage', get_post_meta($post_id, 'blog_perPage', true));
    }
}

add_action('admin_menu', 'add_custom_inputbox'); //投稿ページへ表示するカスタムボックスを定義
add_action('save_post', 'save_custom_postdata'); //追加した表示項目のデータ更新・保存のためのアクションフック


//=====================================
// カスタムウィジェット
//=====================================
// ウィジェットエリアを作成する関数がどれなのかを登録する
add_action('widgets_init', 'my_widgets_area');

// ウィジェット自体の作成するクラスがどれなのかを登録する
add_action('widgets_init', create_function('', 'return register_widget("My_Widget_cols1_rows3_Panels");'));
add_action('widgets_init', create_function('', 'return register_widget("My_Widget_Recent_Posts");'));
add_action('widgets_init', create_function('', 'return register_widget("My_Widget_Posts_Portfolio");'));

// ウィジェットエリアを作成する
function my_widgets_area()
{
    register_sidebar(array(
        'name' => 'SNSボタンエリア',
        'id' => 'widget_header_sns',
        'description' => 'SNSボタンを表示するエリア',
        'before_widget' => '<div>',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => '【ホーム】上段エリア',
        'id' => 'widget_home_top',
        'description' => '上段のウィジェットエリア',
        'before_widget' => '<div>',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => '【ホーム】中段エリア',
        'id' => 'widget_home_middle',
        'description' => '中段のウィジェットエリア',
        'before_widget' => '<div>',
        'after_widget' => '</div>'
    ));
    register_sidebar(array(
        'name' => '【ホーム】下段エリア',
        'id' => 'widget_home_bottom',
        'description' => '下段のウィジェットエリア',
        'before_widget' => '<div>',
        'after_widget' => '</div>'
    ));
}

// ウィジェット

/**
 * Class My_Widget_cols1_rows3_Panels
 * パネルウィジェット（１行３列）
 */
class My_Widget_cols1_rows3_Panels extends WP_widget
{
    // 初期化（管理画面で表示するウィジェットの名前を設定する）
    function My_Widget_cols1_rows3_Panels()
    {
        parent::WP_Widget(false, $name = 'パネルウィジェット(1行3列)',
            array('description' => 'タイトル・画像・文章を設置するパネルウィジェットです。1行に3列のパネルを配置する形式です。'));
    }

    // ウィジェットの入力項目を作成する処理
    function form($instance)
    {
        $panel_title = esc_attr($instance['panel_title']);
        $title1 = esc_attr($instance['title1']);
        $image1 = esc_attr($instance['image1']);
        $body1 = esc_attr($instance['body1']);
        $title2 = esc_attr($instance['title2']);
        $image2 = esc_attr($instance['image2']);
        $body2 = esc_attr($instance['body2']);
        $title3 = esc_attr($instance['title3']);
        $image3 = esc_attr($instance['image3']);
        $body3 = esc_attr($instance['body3']);
        ?>

        <!-- ウィジェットタイトル＆ディスクリプション -->
        <div>
            <p>
                <label for="<?= $this->get_field_id('panel_title'); ?>">
                    <?= 'ウィジェットタイトル:' ?>
                </label>
                <input class="widefat" id="<?= $this->get_field_id('panel_title') ?>"
                       name="<?= $this->get_field_name('panel_title') ?>"
                       type="text" value="<?= $panel_title ?>">
            </p>
        </div>

        <!-- パネル１ -->
        <div>
            <p>
                <label for="<?= $this->get_field_id('title1'); ?>">
                    <?= 'タイトル1:' ?>
                </label>
                <input class="widefat" id="<?= $this->get_field_id('title1') ?>"
                       name="<?= $this->get_field_name('title1') ?>"
                       type="text" value="<?= $title1 ?>">
            </p>
            <p>
                <label for="<?= $this->get_field_id('image1'); ?>">
                    <?= '画像URL1:' ?>
                </label>
                <input class="widefat" id="<?= $this->get_field_id('image1') ?>"
                       name="<?= $this->get_field_name('image1') ?>"
                       type="text" value="<?= $image1 ?>">
            </p>
            <p>
                <label for="<?= $this->get_field_id('body1') ?>">
                    <?= '内容1:' ?>
                </label>
                <textarea class="widefat" rows="16" cols="20" id="<?= $this->get_field_id('body1') ?>"
                          name="<?= $this->get_field_name('body1') ?>"><?= $body1 ?></textarea>
            </p>
        </div>

        <!-- パネル２ -->
        <div>
            <p>
                <label for="<?= $this->get_field_id('title2'); ?>">
                    <?= 'タイトル2:' ?>
                </label>
                <input class="widefat" id="<?= $this->get_field_id('title2') ?>"
                       name="<?= $this->get_field_name('title2') ?>"
                       type="text" value="<?= $title2 ?>">
            </p>
            <p>
                <label for="<?= $this->get_field_id('image2'); ?>">
                    <?= '画像URL2:' ?>
                </label>
                <input class="widefat" id="<?= $this->get_field_id('image2') ?>"
                       name="<?= $this->get_field_name('image2') ?>"
                       type="text" value="<?= $image2 ?>">
            </p>
            <p>
                <label for="<?= $this->get_field_id('body2') ?>">
                    <?= '内容2:' ?>
                </label>
                <textarea class="widefat" rows="16" cols="20" id="<?= $this->get_field_id('body2') ?>"
                          name="<?= $this->get_field_name('body2') ?>"><?= $body2 ?></textarea>
            </p>
        </div>

        <!-- パネル３ -->
        <div>
            <p>
                <label for="<?= $this->get_field_id('title3'); ?>">
                    <?= 'タイトル3:' ?>
                </label>
                <input class="widefat" id="<?= $this->get_field_id('title3') ?>"
                       name="<?= $this->get_field_name('title3') ?>"
                       type="text" value="<?= $title3 ?>">
            </p>
            <p>
                <label for="<?= $this->get_field_id('image3'); ?>">
                    <?= '画像URL3:' ?>
                </label>
                <input class="widefat" id="<?= $this->get_field_id('image3') ?>"
                       name="<?= $this->get_field_name('image3') ?>"
                       type="text" value="<?= $image3 ?>">
            </p>
            <p>
                <label for="<?= $this->get_field_id('body3') ?>">
                    <?= '内容3:' ?>
                </label>
                <textarea class="widefat" rows="16" cols="20" id="<?= $this->get_field_id('body3') ?>"
                          name="<?= $this->get_field_name('body3') ?>"><?= $body3 ?></textarea>
            </p>
        </div>
        <?php
    }

    // ウィジェットに入力された情報を保存する処理
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['panel_title'] = strip_tags($new_instance['panel_title']);
        $instance['title1'] = strip_tags($new_instance['title1']);
        $instance['image1'] = trim($new_instance['image1']);
        $instance['body1'] = trim($new_instance['body1']);
        $instance['title2'] = strip_tags($new_instance['title2']);
        $instance['image2'] = trim($new_instance['image2']);
        $instance['body2'] = trim($new_instance['body2']);
        $instance['title3'] = strip_tags($new_instance['title3']);
        $instance['image3'] = trim($new_instance['image3']);
        $instance['body3'] = trim($new_instance['body3']);

        return $instance;
    }

    // 管理画面から入力されたウィジェットを画面に表示する処理
    function widget($args, $instance)
    {
        // 配列に変数を展開
        extract($args);

        // ウィジェットから入力された情報を取得
        $panel_title = apply_filters('widget_panel_title', $instance['panel_title']);
        $title1 = apply_filters('widget_title1', $instance['title1']);
        $image1 = apply_filters('widget_image1', $instance['image1']);
        $body1 = apply_filters('widget_body1', $instance['body1']);
        $title2 = apply_filters('widget_title2', $instance['title2']);
        $image2 = apply_filters('widget_image2', $instance['image2']);
        $body2 = apply_filters('widget_body2', $instance['body2']);
        $title3 = apply_filters('widget_title3', $instance['title3']);
        $image3 = apply_filters('widget_image3', $instance['image3']);
        $body3 = apply_filters('widget_body3', $instance['body3']);

        // ウィジェットから入力された情報がある場合、htmlを表示する
        if (!empty($instance)) {
            ?>
            <section class="intro">
                <h1 class="intro__title"><?= $panel_title ?></h1>
                <div class="intro__list">
                    <div class="intro__item">
                        <h3 class="intro__item-title"><?= $title1 ?></h3>
                        <?php if (!empty($image1) || !empty($image2) || !empty($image3)): ?>
                            <img src="<?= $image1 ?>" class="intro__item-img">
                        <?php endif; ?>
                        <p class="intro__item-text">
                            <?= $body1 ?>
                        </p>
                    </div>
                    <div class="intro__item">
                        <h3 class="intro__item-title"><?= $title2 ?></h3>
                        <?php if (!empty($image1) || !empty($image2) || !empty($image3)): ?>
                            <img src="<?= $image2 ?>" class="intro__item-img">
                        <?php endif; ?>
                        <p class="intro__item-text">
                            <?= $body2 ?>
                        </p>
                    </div>
                    <div class="intro__item">
                        <h3 class="intro__item-title"><?= $title3 ?></h3>
                        <?php if (!empty($image1) || !empty($image2) || !empty($image3)): ?>
                            <img src="<?= $image3 ?>" class="intro__item-img">
                        <?php endif; ?>
                        <p class="intro__item-text">
                            <?= $body3 ?>
                        </p>
                    </div>
                </div>
            </section>

            <?php
        }
    }
}

/**
 * Class My_Widget_Recent_Posts
 * 特定カテゴリの一覧表示（タイトル＋画像＋文章）
 */
class My_Widget_Recent_Posts extends WP_Widget
{

    /* ウィジェット管理画面上に表示させるウィジェット名 */
    function My_Widget_Recent_Posts()
    {
        parent::WP_Widget(false, $name = 'カテゴリ一覧表示 (アイキャッチ画像＋タイトル＋文章)',
            array('description' => '特定カテゴリ(スラッグ)のアイキャッチ画像＋タイトル＋本文一部を表示します。スラッグ名を入力しない場合はすべての投稿になります。'));
    }

    function widget($args, $instance)
    {
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if (!is_array($cache)) {
            $cache = array();
        }
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }
        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $slug = esc_attr($instance['slug']);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'],
            $instance, $this->id_base);

        if (empty($instance['number']) || !$number = absint($instance['number'])) {
            $number = 10;
        }

        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;

        $r = new WP_Query(apply_filters('widget_posts_args', array(
                'posts_per_page' => $number,
                'no_found_rows' => true,
                'post_status' => 'publish',
                'category_name' => $slug,
                'ignore_sticky_posts' => true
            )
        ));

        if ($r->have_posts()) {

            ?>
            <?php //echo $before_widget; ?>

            <!-- ウィジェットの表示部分の処理 -->
            <?php //if ($title) echo $before_title . $title . $after_title; ?>

            <section <?php post_class('blog'); ?>>
                <h1 class="blog__title tac"><?= $title ?></h1>
                <div class="blog__list">
                    <?php while ($r->have_posts()): $r->the_post(); ?>
                        <article <?php post_class('blog__item'); ?>>
                            <a href="<?php the_permalink(); ?>" class="blog__item-link">
                                <!-- アイキャッチ画像 -->
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large', array('class' => 'blog__item-img')); ?>
                                <?php else: ?>
                                    <img src="<?php echo get_bloginfo('template_directory').'/img/blog--noimage.png'; ?>"
                                         class="blog__item-img">
                                <?php endif; ?>
                                <div class="blog__item-title"><?php the_title(); ?></div>
                                <!-- 記事文章（一部） -->
                                <div class="blog__item-text">
                                    <?php if (is_single()): ?>
                                        <?php the_content(); ?>
                                    <?php else: ?>
                                        <?php the_excerpt(); ?>
                                    <?php endif; ?>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>
            </section>

            <?php //echo $after_widget; ?>
            <?php
            wp_reset_postdata();

        }

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['slug'] = strip_tags($new_instance['slug']);
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int)$new_instance['number'];
        $instance['show_date'] = (bool)$new_instance['show_date'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');

        if (isset($alloptions['widget_recent_entries'])) {
            delete_option('widget_recent_entries');
        }

        return $instance;

    }

    function flush_widget_cache()
    {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    /* ウィジェットの設定フォーム */
    function form($instance)
    {
        $slug = isset($instance['slug']) ? esc_attr($instance['slug']) : '';
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool)$instance['show_date'] : false;

        ?>
        <p><label for="<?php echo $this->get_field_id('slug'); ?>"><?php _e('スラッグ名:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('slug'); ?>"
                   name="<?php echo $this->get_field_name('slug'); ?>" type="text" value="<?php echo $slug; ?>"/></p>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>"
                   name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>"
                   size="3"/></p>

        <!--        <p><input class="checkbox" type="checkbox" --><?php //checked($show_date);
        ?>
        <!--                  id="--><?php //echo $this->get_field_id('show_date');
        ?><!--"-->
        <!--                  name="--><?php //echo $this->get_field_name('show_date');
        ?><!--"/>-->
        <!--            <label for="--><?php //echo $this->get_field_id('show_date');
        ?><!--">--><?php //_e('Display post date?');
        ?><!--</label></p>-->

        <?php
    }

}

/**
 * Class My_Widget_Posts_Portfolio
 * 特定カテゴリの一覧表示
 * スライドキャプション付き
 */
class My_Widget_Posts_Portfolio extends WP_Widget
{

    /* ウィジェット管理画面上に表示させるウィジェット名 */
    function My_Widget_Posts_Portfolio()
    {
        parent::WP_Widget(false, $name = 'カテゴリ一覧表示(アイキャッチ画像)',
            array('description' => 'ギャラリーのように特定カテゴリ(スラッグ)のアイキャッチ画像一覧を表示します。スラッグ名を入力しない場合はすべての投稿になります。'));
    }

    function widget($args, $instance)
    {
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if (!is_array($cache)) {
            $cache = array();
        }
        if (!isset($args['widget_id'])) {
            $args['widget_id'] = $this->id;
        }
        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return;
        }

        ob_start();
        extract($args);

        $slug = esc_attr($instance['slug']);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : $instance['title'],
            $instance, $this->id_base);

        if (empty($instance['number']) || !$number = absint($instance['number'])) {
            $number = 10;
        }

        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;

        $r = new WP_Query(apply_filters('widget_posts_args', array(
                'posts_per_page' => $number,
                'no_found_rows' => true,
                'post_status' => 'publish',
                'category_name' => $slug,
                'ignore_sticky_posts' => true
            )
        ));

        if ($r->have_posts()) {

            ?>
            <?php //echo $before_widget; ?>

            <!-- ウィジェットの表示部分の処理 -->
            <?php //if ($title) echo $before_title . $title . $after_title; ?>

            <section <?php post_class('works'); ?>>
                <h1 class="works__title tac"><?= $title ?></h1>
                <div class="works__list">
                    <?php while ($r->have_posts()): $r->the_post(); ?>
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
                </div>
            </section>

            <?php //echo $after_widget; ?>
            <?php
            wp_reset_postdata();

        }

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['slug'] = strip_tags($new_instance['slug']);
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['number'] = (int)$new_instance['number'];
        $instance['show_date'] = (bool)$new_instance['show_date'];
        $this->flush_widget_cache();

        $alloptions = wp_cache_get('alloptions', 'options');

        if (isset($alloptions['widget_recent_entries'])) {
            delete_option('widget_recent_entries');
        }

        return $instance;

    }

    function flush_widget_cache()
    {
        wp_cache_delete('widget_recent_posts', 'widget');
    }

    /* ウィジェットの設定フォーム */
    function form($instance)
    {
        $slug = isset($instance['slug']) ? esc_attr($instance['slug']) : '';
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $number = isset($instance['number']) ? absint($instance['number']) : 5;
        $show_date = isset($instance['show_date']) ? (bool)$instance['show_date'] : false;

        ?>
        <p><label for="<?php echo $this->get_field_id('slug'); ?>"><?php _e('スラッグ名:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('slug'); ?>"
                   name="<?php echo $this->get_field_name('slug'); ?>" type="text" value="<?php echo $slug; ?>"/></p>

        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/></p>

        <p><label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show:'); ?></label>
            <input id="<?php echo $this->get_field_id('number'); ?>"
                   name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>"
                   size="3"/></p>

        <!--        <p><input class="checkbox" type="checkbox" --><?php //checked($show_date);
        ?>
        <!--                  id="--><?php //echo $this->get_field_id('show_date');
        ?><!--"-->
        <!--                  name="--><?php //echo $this->get_field_name('show_date');
        ?><!--"/>-->
        <!--            <label for="--><?php //echo $this->get_field_id('show_date');
        ?><!--">--><?php //_e('Display post date?');
        ?><!--</label></p>-->

        <?php
    }

}
