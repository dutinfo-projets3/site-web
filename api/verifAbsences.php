<?php

function isValidDay($j,$m,$a){
	if($m==1||$m==3||$m==5||$m==8||$m==7||$m==10||$m==12){
		return $j>0 && $j<32;
	}
	if($m==4||$m==6||$m==9||$m==11){
		return $j>0 && $j<31;
	}
	if(($a%4==0 && $a%100!=0) || $a%400){
		return $j>0 && $j<29;
	} else {
		return $j>0 && $j<28;
	}
	return false;
}

function isValidHour($h,$m){
	return $h>=0 && $h<=23 && $m>=0 && $m<=59;
}

function baseVerif($var){
	return isset($var) && !empty($var) && ctype_digit($var);
}