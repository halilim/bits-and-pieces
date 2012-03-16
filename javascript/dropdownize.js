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
            preDelay: 0,
            hideAfter: 400,
            animSpeed: "fast",
            showOn: "mouseenter",
            showFn: function (){
                        $(this).slideDown(o.animSpeed);
                    },
            hideFn: function (){
                        $(this).slideUp(o.animSpeed);
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
            function ddzShow(){
                menuElem.stop(true, true);
                o.showFn.call(menuElem);
                $this.addClass("hover");
            }
            function ddzHide(){
                menuElem.stop(true, true);
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
                if (o.preDelay) {
                    $this.data("ddz.htId", setTimeout(function (){
                       ddzShow();
                    }, o.preDelay));
                } else {
                    ddzShow();
                }
            });
            $this.add(menuElem)
                .bind("mouseleave.dropdownize", function (){
                    ddzSetHide();
                    if ($this.data("ddz.htId")) {
                        clearTimeout($this.data("ddz.htId"));
                    }
                })
                .bind("mouseenter.dropdownize", function (){
                    ddzClrTO();
                });
        });
    };
})(jQuery);