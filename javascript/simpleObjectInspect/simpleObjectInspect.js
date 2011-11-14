// Halil Özgür halil.ozgur Alt+65 t gmail com
function simpleObjInspect(oObj, key, tabLvl)
{
    key = key || "";
    tabLvl = tabLvl || 1;
    var tabs = "";  
    for(var i = 1; i < tabLvl; i++){  
        tabs += "\t";  
    }
    var keyTypeStr = " (" + typeof key + ")";
    if (tabLvl == 1) {
        keyTypeStr = "(self)";
    }
    var s = tabs + key + keyTypeStr + " : ";
    if (typeof oObj == "object" && oObj !== null) {
        s += typeof oObj + "\n";
        for (var k in oObj) {
            if (oObj.hasOwnProperty(k)) {
                s += simpleObjInspect(oObj[k], k, tabLvl + 1);
            }
        }
    } else {
        s += "" + oObj + " (" + typeof oObj + ") \n";
    }
    return s;
}