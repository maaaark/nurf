<?php

$hours   = date("H");
$minutes = date("i");
$date    = date("d.m.Y");

$diff    = $minutes % 5;
if($diff > 0){
	$minutes = $minutes - 5 - $diff;
}

$date = $hours.":".$minutes." ".$date;
echo $date;
?>