<?php
#if ( isset($_GET["mota"]) && $_GET["mota"] = "mota_pendejax111" ) {
	require 'inc/config.php';

  $dbh=mysql_connect (MYSQL_HOST, MYSQL_USER, MYSQL_PASS) or die ('I cannot connect to the database because: ' . mysql_error());
  mysql_select_db (MYSQL_DB);
  
  # $query = "SELECT mota FROM candidatos WHERE 1";
	# $res = mysql_query($query);
	# $fila = mysql_fetch_array($res);
	# $score = $fila['mota'];
	# $score += 1;
	$query = "UPDATE candidatos SET mota = mota + 1 WHERE id = 1 LIMIT 1;";
	$res = mysql_query($query);
	mysql_close($dbh);
#}
?>

