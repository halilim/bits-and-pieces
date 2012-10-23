<?php

/**
 * @author Halil Özgür <halil.ozgur@gmail.com>
 * @copyright 2012
 *
 * Copy the changed/added files in the last git commit
 *
 * Usage:
 *     php "<path>/git_copy_last_diff.php" "<repo path>" "<export path>"
 *
 * In Registry:
 *     [HKEY_CLASSES_ROOT\Directory\shell\git_copy_last_diff]
 *     @="Git &Export Last Diff"
 *     command:
 *     cmd /C <usage> (change /'s with \'s)
 *     e.g.:
 *     cmd /C php "D:\Code\bits-and-pieces\shell-scripts\git_copy_last_diff.php" "%1" "C:\Users\Halil\Desktop\export_temp"
 */

define('DS', DIRECTORY_SEPARATOR);

function mycopy($src, $dst)
{
    $dir = dirname($dst);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    return copy($src, $dst);
}

//echo '<pre>'.var_export($argv, true).'</pre>';

$source = rtrim($argv[1], "/\\");
$target = rtrim($argv[2], "/\\");
chdir($source);
exec("git diff-tree -r --no-commit-id --name-only --diff-filter=ACMRT HEAD~1 HEAD", $files);
foreach ($files as $v) {
    mycopy($source.DS.$v, $target.DS.$v);
}
