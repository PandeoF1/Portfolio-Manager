<?php
require "config/ticket.conf.php";

$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
$result = $mysqli->query("SELECT * FROM test");
$row	= $result->fetch_row();
foreach($row as $row_)
	echo $row_;
echo "<br>url : ";
$url_parse = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
echo $_SERVER["REQUEST_URI"];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test</title>
</head>
<body>
<p>Testeuhhh</p>
</body>
</html>