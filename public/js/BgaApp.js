/**
 * Board Game Affionadoes common functions.
 * @type {{url, ajaxUrl}}
 */
var BgaApp = (function() {

    function ajaxUrl(path)
    {
        return BgaData.ajaxUrl + path;
    }

    function url(path) {

        if (arguments.length === 1)
            return BgaData.url + path;

        return BgaData.url + path + '?' + $.param(arguments[1]);
    }



    return {
        url : url,
        ajaxUrl : ajaxUrl,
    };
})();
