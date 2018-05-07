$(function () {
    $.fn.LinkPager = function () {
    };

    $.fn.LinkPager.onclick = function (this_) {
        var pageNum = $(this_).parent().parent().children("input.form-control").val();
        $.fn.LinkPager.location(pageNum);
    };

    $.fn.LinkPager.onkeydown = function (this_, event_) {
        if (event_.keyCode == 13) {
            var pageNum = $(this_).val();
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
