$(document).ready(function () {
    $('.js-form-show').click(function (e) {
        e.preventDefault();
        $('.form-show').removeClass('form-show');
        $(this).parent().addClass('form-show');
    });

    $('.js-form-close').click(function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().removeClass('form-show');
    });
});
