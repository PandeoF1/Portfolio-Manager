<?php
$mysqli = new mysqli("pandeo.fr", "xxloubexx", "xxloubexx", "xxloubexx");
$result = $mysqli->query("SELECT * FROM test");
$row	= $result->fetch_row();
foreach($row as $row_)
	echo $row_;
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