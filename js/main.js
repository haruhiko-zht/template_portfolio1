$(function () {
    //=====================================
    // wp-caption用 clear:both
    // =====================================
    const $nodeWpCaption = document.querySelectorAll('.wp-caption');

    for (let i = 0; i < $nodeWpCaption.length; i++) {
        $nodeWpCaption[i].insertAdjacentHTML('beforebegin', '<div style="clear:both"></div>');
    }


    //=====================================
    // SP_スムーススクロール(TOP)
    // =====================================
    $('#js-scroll-top').on('click', function () {
        $('html').animate({
            scrollTop: 0
        }, 800);
    });


    //=====================================
    // SP_ホーム画面への遷移ボタン
    // =====================================
    $('#js-link-home').on('click', function () {
        window.location.href = '/';
    });


    //=====================================
    // SP_モーダル閉
    // =====================================
    $('.sp-modal__back').on('click', function () {
        $(this).attr('style', 'display: none');
        $('.sp-modal__search').attr('style', 'display:none');
        $('.sp-modal__menu').attr('style', 'display:none');
    });

    $('#js-sp-modal__menu-times').on('click', function () {
        $('.sp-modal__menu').attr('style', 'display:none');
        $('.sp-modal__back').attr('style', 'display:none');
    });


    //=====================================
    // SP_検索ボタン
    // =====================================
    $('#js-sp-search-btn').on('click', function () {
        $('.sp-modal__back').attr('style', 'display:block');
        $('.sp-modal__search').attr('style', 'display:block');
        $('#js-search__sp-field').focus();
    });


    //=====================================
    // SP_モーダルメニュー
    // =====================================
    $('#js-sp-menu-btn').on('click', function () {
        $('.sp-modal__back').attr('style', 'display:block');
        $('.sp-modal__menu').attr('style', 'display:block');
    });

});
