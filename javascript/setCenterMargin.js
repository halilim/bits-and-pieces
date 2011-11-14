/**
 * Sets left margin of a group of elemnts according to the position of the corresponding element in the parent/source group of elements.
 * Useful when you want a submenu centered under a top menu item.
 * 
 * NOTES:
 * 	  - In order to get the widths, elements should be visible at first. You can -nearly- hide them at the start with:
 *			.destParent{height: 1px;overflow: hidden;}
 *		and then completely hide again with just after calling the function like:
 *			setCenterMargin($(".srcEls"), $(".destEl"), true);
 *			$(".destParent").hide().css({"height": "auto", "overflow": "show"});
 *			$(".destEl").hide();
 * 
 * @param bool	applyTextAlign	If true, a text align of center or right is applied to each srcEl based on the position of the destEl in the destParent.
 * @param int	correction		If set, that amount of pixels is added (or substracted, if you give a negative value) from each destEl's left.
 */
function setCenterMargin(sourceElems, destElems, applyTextAlign, correction){
    var srcPar = $(sourceElems).parent();
    var srcParLeft = srcPar.offset().left;
    var srcParWidth = srcPar.width();
    var destPar = $(destElems).parent();
    var destParWidth = destPar.width();
    $(destElems).each(function(){
        var dest = $(this);
        var src = $(sourceElems).eq(dest.index());
        var destW = dest.width();
        var srcW = src.width();
        var srcL = src.offset().left;
        var left = (srcL - srcParLeft) + Math.round((srcW - destW) / 2) + (correction || 0);
		if (left < 0) {
            left = 0;
        }
        var maxL = destParWidth - destW;
        if (left > maxL) {
            left = maxL;
        }
        if (applyTextAlign) {
            var textAlign = "";
            if (srcL - srcParLeft >= srcParWidth * .75) {
                textAlign = "right";
            } else if (srcL - srcParLeft >= srcParWidth * .25) {
                textAlign = "center";
            }
            if (textAlign != "") {
                dest.css({"text-align": textAlign});
            }
        }
        dest.css("margin-left", left + "px");
    });
}