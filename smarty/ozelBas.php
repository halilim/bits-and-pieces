<?php

function ozelBas($girdi, $sClass)
{
	$kelimeler = explode(' ', $girdi);
	$adet = count($kelimeler);
	if ($adet > 1) {
    	$lim = floor($adet/2);
    	return '<span class="'.$sClass.'">'.implode(' ', array_slice($kelimeler, 0, $lim)).
        	'</span> '.implode(' ', array_slice($kelimeler, $lim));
	} else {
    	return $girdi;
	}
}
// $Tpl->register_modifier('ozelBas', 'ozelBas');