$(document).on('click', '[id^=analyzeButton]', function (e) {
    var $btn = $(this);
    $btn.button('loading');
});