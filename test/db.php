<?php


$mysql_link_old = mysql_connect("localhost", "ullalaul_totalap", "It#4Fg$5");
mysql_select_db("ullalaul_totalapps",$mysql_link_old);

$sql = "SELECT *
FROM `user_group_joins`
WHERE `user_group_id` = '20'";

	$result = mysql_query($sql, $mysql_link_old);
	
	
	while($res = mysql_fetch_assoc($result)){
	
		$sql2 = "INSERT INTO `user_group_joins` (user_group_id, user_id)VALUES (25,".$res['user_id'].")";
		$result2 = mysql_query($sql2, $mysql_link_old);
		
	}

?>