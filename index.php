<?php
	require "config/mysql.conf.php";

	$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


	$result = $mysqli->query("SELECT * FROM test");
	$row	= $result->fetch_row();
	if ($_SERVER["REQUEST_URI"] != "/")
	{
		foreach ($row as $row_)
			echo $row_;

		echo "<br>url : ";
		$url_parse = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
		echo $_SERVER["REQUEST_URI"];
	}
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</head>
<?php if ($div["/"]){ ?>
<body>
	<div class="container">
		<h1>Bonjour</h1>
	</div>
</body>
<?php } ?>
<?php if ($div["admin"]){ ?>
<body>
	<p>admin</p>
</body>
<?php } ?>
</html>