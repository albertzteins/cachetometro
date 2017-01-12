<?php
#if ( isset($_GET["amlo"]) && $_GET["amlo"] = "amlo_presidente2012" ) {
	require 'inc/config.php';

  $dbh=mysql_connect (MYSQL_HOST, MYSQL_USER, MYSQL_PASS) or die ('I cannot connect to the database because: ' . mysql_error());
  mysql_select_db (MYSQL_DB);
  
	# $query = "SELECT amlo FROM candidatos WHERE 1";
	# $res = mysql_query($query);
	# $fila = mysql_fetch_array($res);
	# $score = $fila['amlo'];
	# $score += 1;
	$query = "UPDATE candidatos SET amlo = amlo + 1 WHERE id = 1 LIMIT 1;";
	$res = mysql_query($query);
	mysql_close($dbh);
#}
?>

