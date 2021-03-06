/**
 * Hide element when clicked anywhere on the page
 */
;(function($){
    $.fn.hideOnDocClick = function(hideFn) {
        return this.each(function() {
            var $this = $(this);
            $this.click(function(e) {
                e.stopPropagation();
            });
            $(document).click(function() {
                if (hideFn) {
                    hideFn.call($this);
                } else {
                    $this.hide();
                }
            });
        });
    };
})(jQuery);