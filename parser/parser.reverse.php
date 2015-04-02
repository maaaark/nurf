<?php

$hours   = date("H");
$minutes = date("i");

echo $minutes ." => ";
$diff    = $minutes / 5;
if($diff > 0){
	echo $diff;
}
?>