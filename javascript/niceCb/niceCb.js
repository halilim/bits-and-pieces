/**
 * (Visually) replace checkboxes with images. Implemented with as little as possible
 * modification of the default code and behavior.
 * Parameters to change: width, height and background of .niceCbNew in CSS.
 */
function niceCb(cbEls){
    $(cbEls)
        .addClass("niceCbCb")
        .after('<span class="niceCbNew"></span>')
        .change(function (){
            $(this).next().toggleClass("selected", $(this).is("input:checked"));
        })
        .change();
}