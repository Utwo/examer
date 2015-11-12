$(document).ready(function () {
    $('.js-form-show').click(function (e) {
        e.preventDefault();
        var form = $(this).parent().find('.form-grade');
        $.magnificPopup.open({
            removalDelay: 300,
            mainClass: 'mfp-fade',
            items: {
                src: form,
                type: 'inline',
            }
        });
    })
});
