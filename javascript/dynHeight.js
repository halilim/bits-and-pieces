/**
 * Dynamically resize the height of fixedEl based on dynEl.
 * Useful for pages which contain a header and an iFrame.
 * e.g. dynHeight(".header", ".iframe");
 */
function dynHeight(fixedEl, dynEl){
    function dhResize(fixedEl, dynEl){
        $(dynEl).height($(window).height() - $(fixedEl).height());
    }
    jQuery(function($) {
        dhResize(fixedEl, dynEl);
        $(window).resize(function() {
            dhResize(fixedEl, dynEl);
        });
    });
}