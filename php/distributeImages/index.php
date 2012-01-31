<?php
/**
 * @author Halil Özgür | halil.ozgur ATISHERE gmail.com
 */

function unixize($path)
{
    return str_replace("\\", "/", $path);
}

$width = 960;
$colWidth = 120;
$rowHeight = 120;
$path = realpath('./images/');
$webPath = "http://localhost/".str_replace(unixize($_SERVER["DOCUMENT_ROOT"]), "", unixize($path))."/";
$out = array();

//echo '<pre style="clear:both;">'.var_export(setlocale(LC_CTYPE, 0), true).'</pre>';

if (!empty($_POST)) {
    $width = $_POST['width'];
    $colWidth = $_POST['colWidth'];
    $rowHeight = $_POST['rowHeight'];
    $path = $_POST['path'];
    $webPath = $_POST['webPath'];
    $pathOpen = mb_convert_encoding($path, "iso-8859-9", "utf-8");
    $pathWeb = strtr($path, array(
        "\\" => "/",
        " " => "%20",
    ));

    $ct = 0;
    $it = new RecursiveDirectoryIterator($pathOpen, FilesystemIterator::SKIP_DOTS);
    foreach(new RecursiveIteratorIterator($it, RecursiveIteratorIterator::LEAVES_ONLY, RecursiveIteratorIterator::CATCH_GET_CHILD) as $file) {
        if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), array("jpeg", "jpg", "png", "gif", "bmp", "tiff"))) {
            $ct++;
            $out[] = str_replace($pathOpen.DIRECTORY_SEPARATOR, '', $file);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Distribute Images Evenly (Thumb Collage)</title>
</head>
<body>
    <h1>Distribute images evenly within a width (Thumb Collage)</h1>
    <p>
        Currently only for local files. Print-screen for image editing.
    </p>
   <form method="post" action="">
        <label>Width :<br /><input type="text" name="width" value="<?=$width?>" /> px</label><br /><br />
        <label>Col Width :<br /><input type="text" name="colWidth" value="<?=$colWidth?>" /> px</label><br /><br />
        <label>Row Height :<br /><input type="text" name="rowHeight" value="<?=$rowHeight?>" /> px</label><br /><br />
        <label>Path :<br /><input type="text" name="path" size="80" value="<?=$path?>" /> absolute path, or relative to this file</label><br /><br />
        <label>Web Path :<br /><input type="text" name="webPath" size="80" value="<?=$webPath?>" /></label><br /><br />
        <input type="submit" value="Do It!" />
    </form>
    <?php if (!empty($_POST)) { ?>
        <br /><br />
    	Total: <?php echo $ct; ?> files.<br />
        <br />
        <?php if ($out) { ?>
            <table style="width: <?php echo $width; ?>px;">
                <tr>
                    <?php
                    $colCount = (int)floor($width / $colWidth);
                    $ct = 0;
                    foreach ($out as $v) {
                        $ct++;
                        ?>
                    	<td style="text-align: center;vertical-align: middle;"><img src="<?php echo $webPath.$v; ?>" /></td>
                        <?php if ($ct % $colCount == 0) { ?>
                        	</tr>
                            <tr>
                        <?php } ?>
                    <?php } ?>
                </tr>
            </table>
        <?php } else { ?>
         	No image files found in the specified path.
        <?php } ?>
    <?php } ?>
</body>