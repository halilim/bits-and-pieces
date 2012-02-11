/**
 * Inserts a script asynchronously (e.g. Google Analytics way)
 * 
 * Example usage:
 * insertAsyncScript("http://s7.addthis.com/js/250/addthis_widget.js");
 */

function insertAsyncScript(src, autoSsl){
    var scr = document.createElement('script');
    scr.type = 'text/javascript';
    scr.async = true;
    var src = src;
    var autoSsl = autoSsl;
    if (typeof autoSsl === "undefined") {
        autoSsl = true;
    }
    if (autoSsl) {
        var proto = document.location.protocol;
        if (proto == 'https:') {
            src = src.replace(/^http:/, "https:");
        } else {
            src = src.replace(/^https:/, "http:");
        }
    }
    scr.src = src;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(scr, s);
}