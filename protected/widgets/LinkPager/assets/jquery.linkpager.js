$(function () {
    $.fn.LinkPager = function () {
    };

    $.fn.LinkPager.onclick = function (element) {
        var pageNum = $(element).parent().parent().children("input.form-control").val();
        $.fn.LinkPager.location(pageNum);
    };

    $.fn.LinkPager.onkeydown = function (element, e) {
        if (e.keyCode === 13) {
            var pageNum = $(element).val();
            $.fn.LinkPager.location(pageNum);
        }
    };

    $.fn.LinkPager.location = function (pageNum) {
        var url = $.fn.LinkPager.url.replace($.fn.LinkPager.jumpPageReplace, pageNum);
        $(location).attr("href", url);
    };

    $.fn.LinkPager.url = '';

    $.fn.LinkPager.jumpPageReplace = '';
})(jQuery);
