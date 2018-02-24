$(document).ready(function () {
    $(window).scroll(function () {
        // noinspection JSValidateTypes
        if ($(this).scrollTop() > 150) // В каком положении полосы прокрутки начинать показ кнопки "Наверх"
            $('#toplink').fadeIn();
        else
            $('#toplink').fadeOut();
    });
    // noinspection JSCheckFunctionSignatures
    $('#toplink').click(function () {
        $('body, html').animate({
            scrollTop: 0
        }, 1000); // Задержка прокрутки
    });
});
