<?php

/**
 * @author Halil Özgür <halil.ozgur@gmail.com>
 * @copyright 2012
 *
 * Copy the files changed/added in the last git commit along with their folder structure.
 * Example use cases:
 *     Uploading the changed files
 *     Temporarily copying those files for some processing and later copying them back
 *     ...etc
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
 *
 * A third argument to this script is available. Available values (currently only one):
 *     W -> the files that are changed since the last commit (in the working tree)
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

// By default, list the files that are changed between the last commit (HEAD) and the previous commit
$cmd = "git diff-tree -r --no-commit-id --name-only --diff-filter=ACMRT HEAD~1 HEAD";

if (isset($argv[3])) {
    switch ($argv[3]) {
        case 'W': // Changed files between the last commit and the working tree
            $cmd = "git diff --name-only";
            break;
    }
}

chdir($source);
exec($cmd, $files);
foreach ($files as $v) {
    mycopy($source.DS.$v, $target.DS.$v);
}
