<?php
	require "config/mysql.conf.php";

	$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


	$result = $mysqli->query("SELECT * FROM test");
	$row	= $result->fetch_row();
	foreach ($row as $row_)
		echo $row_;

	echo "<br>url : ";
	$url_parse = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
	echo $_SERVER["REQUEST_URI"];
	if ($_SERVER["REQUEST_URI"] == "/")
		$div["/"] = 1;
	else
		$div[$url_parse[0]] = 1;

?>

<!-- Portfolio - Manager | By : P.Clement & N.Théo (Pandeo_F1) - https://github.com/PandeoF1/Portfolio-Manager -->

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo "Portfolio PLANQUE Clement" ?></title>
</head>
<?php if ($div["/"]){ ?>
<body>
	<p>Salut</p>
</body>
<?php } ?>
<?php if ($div["admin"]){ ?>
<body>
	<p>admin</p>
</body>
<?php } ?>
</html>