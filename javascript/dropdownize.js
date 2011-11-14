/**
 * Make drop downs with a few options.
 *  
 *  <div class="ddzContainer" style="position: relative;">
 *      <a href="#" class="ddzOpener">Aha</a>
 *      <div class="ddzMenu">Lorem ipsum dolor sit <br />amet consectetuer<br /></div>
 *  </div>
 * 
 * $(".ddzOpener")
 *     .dropdownize({menuEl: ".ddzMenu"})
 *     .click(function (){ return false; });
 * 
 * Useful CSS:
 *     .ddzContainer{position: relative;}
 *     .ddzMenu{position: absolute;width: 150px;top: 0;  display:none;background-color: #eee;}
 */
;(function($){
    $.fn.dropdownize = function(options) {
        var defaults = {
            hideAfter: 400,
            showOn: "mouseenter",
            showFn: function (){
                        $(this).slideDown("fast");
                    },
            hideFn: function (){
                        $(this).slideUp("fast");
                    }
        };
        var o = $.extend(true, {}, defaults, options);
        return this.each(function() {
            var $this = $(this);
            var menuElem;
            if ($.isFunction(o.menuEl)) {
                menuElem = o.menuEl.call($this);
            } else {
                menuElem = $(o.menuEl);
            }
            var ddzTOId = 0;
            function ddzHide(){
                o.hideFn.call(menuElem);
                $this.removeClass("hover");
                ddzTOId = 0;
            }
            function ddzSetHide(){
                ddzTOId = setTimeout(ddzHide, o.hideAfter);
            }
            function ddzClrTO()
            {
                if (ddzTOId != 0) {
                    clearTimeout(ddzTOId);
                    ddzTOId = 0;
                }
            }
            $this.bind(o.showOn + ".dropdownize", function (){
                o.showFn.call(menuElem);
                $(this).addClass("hover");
            });
            $this.add(menuElem)
                .bind("mouseleave.dropdownize", function (){
                    ddzSetHide();
                })
                .bind("mouseenter.dropdownize", function (){
                    ddzClrTO();
                });
        });
    };
})(jQuery);