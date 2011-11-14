<?php
/**
 * ['lorem'] -> lorem
 * ['lorem', 'ipsum'] -> lorem and ipsum
 * ['lorem', 'ipsum', 'dolor'] -> lorem, ipsum and dolor
 * 
 * @param array $arr 
 * @param string $andStr
 * @param string $commaStr
 * @return string
 */
function implode_comma_and($arr, $andStr = ' ve ', $commaStr = ', ')
{
    $sz = count($arr);
    if ($sz < 1) {
        return '';
    }
    if ($sz == 1) {
        return $arr[0];
    }
    if ($sz == 2) {
        return $arr[0].$andStr.$arr[1];
    }
    if ($sz > 2) {
        return implode($commaStr, array_slice($arr, 0, $sz - 1)).$andStr.$arr[$sz - 1];
    }
}