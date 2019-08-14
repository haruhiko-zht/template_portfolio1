<?php
/**
 * タイトルの文字制限
 *
 * @param $str
 * @param  int  $length
 */
function titleOm($str, $length = 20)
{
    if (mb_strlen($str, 'UTF-8') > $length) {
        $title = mb_substr($str, 0, $length, 'UTF-8');
        echo $title.'…';
    } else {
        echo $str;
    }
}

/**
 * HTMLエスケープ
 *
 * @param $str
 * @return string
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}