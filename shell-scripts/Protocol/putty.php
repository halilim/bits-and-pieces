<?php
$in = urldecode($argv[1]);
$params = substr($in, strpos($in, ':')+1);
$cmd = '"'.dirname(__FILE__).DIRECTORY_SEPARATOR.'putty.exe" '.$params;
system($cmd);
exit;