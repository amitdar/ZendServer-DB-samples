<?php

$link = mysql_connect($dbHost, $dbUsername, $dbPassword);
if (!$link) {
	echo 'Could not connect: ' . mysql_error();
	die(1);
}

$query = "DROP DATABASE IF EXISTS " . $dbName . ";";
$result = mysql_query($query, $link );
if (! $result) {
	echo "Invalid query [$query]: " . mysql_error();
	die(1);
}
echo "DROP DATABASE Successful".PHP_EOL;

$query = "CREATE DATABASE IF NOT EXISTS  " . $dbName . ";";
$result = mysql_query($query, $link);
if (! $result) {
	echo "Invalid query [$query]: " . mysql_error();
	die(1);
}
echo "CREATE DATABASE Successful".PHP_EOL;

mysql_select_db($dbName, $link);

$file_content = file(dirname ( __FILE__ ).'/db_dump.sql', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

// execute the sql
$query = "";
foreach($file_content as $sql_line){
	$trimmed = trim($sql_line);
	if(! empty($trimmed) && substr($trimmed, 0, 2) != '--'){
		$query .= $sql_line;
		if (substr(rtrim($query), -1) == ';'){
			$result = mysql_query($query, $link);
			if(! $result) {
				echo "Invalid query [$query]: " . mysql_error();
				die(1);
			}
			$query = "";
		}
	}
}

mysql_close($link);

echo "Create DB $dbName from dump successful on mysql at $dbHost" . PHP_EOL;