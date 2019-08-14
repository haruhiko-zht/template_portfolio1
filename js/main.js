//=====================================
// wp-caption用　clear:both
//=====================================
const $nodeWpCaption = document.querySelectorAll('.wp-caption');

for (let i = 0; i < $nodeWpCaption.length; i++) {
    $nodeWpCaption[i].insertAdjacentHTML('beforebegin', '<div style="clear:both"></div>');
}