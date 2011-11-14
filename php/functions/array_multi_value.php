<?php
/**
 * Retrieve a value for a key from an array.
 * Works for multi-dimensional arrays.
 * Key checks are strict (false can be returned as a found value).
 * Null values are equal to not found.
 * 
 * @param mixed $key
 * @param array $array
 * @param bool $self Don't set this (used internally).
 * @return mixed
 */
function array_multi_value($key, $array, $self = false) {
    $ret = null;
    $found = false;
    foreach ($array as $k => $v) {
        if ($k === $key) {
            $found = true;
            $ret = $v;
        } else if (is_array($v)) {
        	$retS = array_multi_value($key, $v, true);
            if ($retS['found']) {
                $found = true;
                $ret = $retS['val'];
            }
        }
        if ($found) {
            break;
        }
   	}
    if ($self) {
        return array('found' => $found, 'val' => $ret);
    } else {
        return $ret;
    }
}