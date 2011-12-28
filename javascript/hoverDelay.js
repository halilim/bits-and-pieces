/**
 * Wait for some time to activate after hover.
 */
;(function($){
    $.fn.hoverDelay = function(fn, delay) {
        return this.each(function() {
            var $this = $(this);
            $this.hover(
                function (){
                    $this.data("hoverDelay.tId", setTimeout(function (){
                        fn.call($this);
                    }, delay || 75));
                }
                ,function (){
                    if ($this.data("hoverDelay.tId")) {
                        clearTimeout($this.data("hoverDelay.tId"));
                    }
                }
            );
        });
    };
})(jQuery);