<?php 
// set default timezone
date_default_timezone_set('CDT'); // CDT

$info = getdate();
$date = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];

echo $current_date = "$date/$month/$year == $hour:$min:$sec"; ?><br/><br/><?php 

echo $current_date = date('d/m/Y == h:i:s A');

?>