/**
 * Mostly used as a data storage
 * <div class="test etc_5">... getClassNum(".test", "etc") -> 5
 */
function getClassNum(el, str) {
    var re = new RegExp((str || "[^\s]+") + "_(\\d+)");
    var ret = null;
    if ($(el).size() > 0 && $(el).attr("class")) {
        var ret = re.exec($(el).attr("class"));
        if (ret && ret.length == 2) {
            ret = ret[1];
        }
    }
    return ret;
}