<?php

/**
 * Delete files based on predicates
 *
 * Example usage:
 * php deleteRotate.php "/usr/local/backup/sql/*.sql" 7 62 0 7,15,21,28
 *
 * arg. 1: pattern, passed to glob() (required)
 * arg. 2: last n consecutive days to keep (required)
 * arg. 3: max last n days to keep, older files will be deleted regardless (required)
 * arg. 4: confirm, if 0, only show, don't delete (required)
 * arg. 5: days of month to keep, e.g. 7, 15, 21, 28 (optional)
 */

if (count($argv) < 5) {
    trigger_error("Invalid number of arguments", E_USER_ERROR);
}

/*if (!is_dir($argv[1])) {
    trigger_error("Invalid path", E_USER_ERROR);
}*/
$pattern = $argv[1];

if (!is_int($argv[2]) && $argv[2] <= 0) {
    trigger_error("Invalid number of consecutive days", E_USER_ERROR);
}
$lastNdays = $argv[2];
$lastNdaysAgo = strtotime("-".$lastNdays." days");

if (!is_int($argv[3]) && $argv[3] <= 0) {
    trigger_error("Invalid number of max last days", E_USER_ERROR);
}
$maxDays = $argv[3];
$maxDaysAgo = strtotime("-".$maxDays." days");

if (!isset($argv[4])) {
    trigger_error("Confirmation not set, set to 0 or 1", E_USER_ERROR);
}

$daysOfMonth = array();
if (isset($argv[5])) {
    $daysOfMonth = explode(",", $argv[5]);
    foreach ($daysOfMonth as $k => $v) {
        $daysOfMonth[$k] = (int)$v;
    	if ($v <= 0 || $v > 31) {
            trigger_error("Invalid month day number", E_USER_ERROR);
        }
    }
}

foreach (glob($pattern) as $v) {
    $mTime = filemtime($v);
    $mDay = date("d", $mTime);
    if ($mTime < $maxDaysAgo || ($mTime < $lastNdaysAgo && !in_array($mDay, $daysOfMonth))) {
        if ($argv[4]) {
            unlink($v);
        } else {
            echo $v.PHP_EOL;
        }
    }
}
