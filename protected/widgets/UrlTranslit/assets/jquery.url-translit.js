$(function () {
    $.fn.UrlTranslit = function (options) {
        var opts = $.extend({}, $.fn.UrlTranslit.defaults, options), $this;
        return this.each(function () {
            $this = $(this);
            var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
            var $destination = $('#' + opts.destination);
            o.destinationObject = $destination;

            // IE always sucks :)
            if (!Array.indexOf) {
                Array.prototype.indexOf = function (obj) {
                    for (var i = 0; i < this.length; i++) {
                        if (this[i] === obj) {
                            return i;
                        }
                    }
                    return -1;
                }
            }

            $this.keyup(function () {
                var str = $(this).val().trim();
                var result = '';
                for (var i = 0; i < str.length; i++) {
                    result += $.fn.UrlTranslit.transliterate(str.charAt(i), o)
                }
                var regExp = new RegExp('[' + o.urlSeparator + ']{2,}', 'g');
                result = result.replace(regExp, o.urlSeparator);
                $destination.val(result);
            })
        });
    };

    /**
     * Transliterate character
     * @param {String} char
     * @param {Object} opts
     */
    $.fn.UrlTranslit.transliterate = function (char, opts) {
        var trChar = char.toLowerCase();
        var charIsLowerCase = trChar === char;

        for (var index = 0; index < opts.dictTranslate.length; index++) {
            if (trChar === opts.dictTranslate[index][0]) {
                trChar = opts.dictTranslate[index][1];
                break;
            }
        }

        if (opts.type === 'url') {
            var code = trChar.charCodeAt(0);
            if (code >= 33 && code <= 47 && code !== 45
                || code >= 58 && code <= 64
                || code >= 91 && code <= 96
                || code >= 123 && code <= 126
                || code >= 1072
            ) {
                return '';
            }
            if (trChar === ' ' || trChar === '-') {
                return opts.urlSeparator;
            }
        }

        // noinspection JSValidateTypes
        if ((opts.caseStyle === 'upper') || (opts.caseStyle === 'normal' && !charIsLowerCase)) {
            return trChar.toUpperCase();
        }
        return trChar;
    };

    /**
     * Default options
     */
    $.fn.UrlTranslit.defaults = {
        /**
         * Dictionaries
         */
        dictTranslate: [],
        /*
         * Case transformation: normal, lower, upper
         */
        caseStyle: 'lower',

        /*
         * Words separator in url
         */
        urlSeparator: '-',

        /*
         * Transliteration type: raw or url
         *    url - used for transliterating text into url slug
         *    raw - raw transliteration (with special characters)
         */
        type: 'url'
    };
})(jQuery);
