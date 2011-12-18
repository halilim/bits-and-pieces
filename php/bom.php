<?php
/**
 * @author Halil Özgür | halil.ozgur ATISHERE gmail.com
 */

$remove = false;
$bom = 'EFBBBF';
$exts = 'php,html,htm,tpl';
$path = realpath('./');

$out = array();

if (!empty($_POST)) {
    $remove = isset($_POST['remove']);
    $bom = $_POST['bom'];
    $exts = $_POST['exts'];
    $path = $_POST['path'];

    $bomStr = pack('H*', $bom);
    $bomLen = strlen($bomStr);

    $extsArr = explode(',', $exts);

    $ct = 0;
    $it = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
    foreach(new RecursiveIteratorIterator($it, RecursiveIteratorIterator::LEAVES_ONLY, RecursiveIteratorIterator::CATCH_GET_CHILD) as $file) {
        if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), $extsArr)) {
            $ct++;
            $firstChars = file_get_contents($file, false, null, 0, $bomLen);
            if ($firstChars == $bomStr) {
                if ($remove) {
                    file_put_contents($file, file_get_contents($file, false, null, $bomLen));
                }
                $out[] = str_replace($path.DIRECTORY_SEPARATOR, '', $file);
            }
        }
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>BOM Find And Remove</title>
</head>
<body>
    <h1>Find and remove BOM marker from source files</h1>
    <p>
        Looks only for the first n characters. <strong>Don't leave this in public web.</strong>
    </p>
    <form method="post" action="">
        <label>Remove? <input type="checkbox" name="remove" <?=$remove ? 'checked="checked"' : ''?> /></label><br /><br />
        <label>BOM Marker :<br /><input type="text" name="bom" value="<?=$bom?>" /> hex</label><br /><br />
        <label>File Extensions To Search:<br /><input type="text" name="exts" size="40" value="<?=$exts?>" /> separate only with commas</label><br /><br />
        <label>Folder :<br /><input type="text" name="path" size="80" value="<?=$path?>" /> absolute path, or relative to this file</label><br /><br />
        <input type="submit" value="Do It!" />
    </form>
    <?php if (!empty($_POST)) { ?>
        <br /><br />
    	Total: <?php echo $ct; ?> files.
        <?php if ($out) { ?>
            BOM found in<?php echo ($remove ? ' (and removed)' : ''); ?>:
            <ul>
                <?php foreach ($out as $v) { ?>
                	<li><?php echo $v; ?></li>
                <?php } ?>
            </ul>
        <?php } else { ?>
         	BOM not found.
        <?php } ?>
    <?php } ?>
</body>
</html>