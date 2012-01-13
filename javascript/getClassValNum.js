/**
 * Mostly used as a data storage
 * <div class="test etc_vs">... getClassNum(".test", "etc") -> "vs"
 */
function getClassVal(el, str) {
    var re = new RegExp((str || "[^\\s]+") + "_([^\\s]+)");
    var ret = null;
    if ($(el).size() > 0 && $(el).attr("class")) {
        var ret = re.exec($(el).attr("class"));
        if (ret && ret.length == 2) {
            ret = ret[1];
        }
    }
    return ret;
}
/**
 * Numerical version
 */
function getClassNum(el, str) {
    return parseFloat(getClassVal(el, str));
}