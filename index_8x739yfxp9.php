<?php
if ($_SERVER["REQUEST_URI"] != "/") {
	require "config/mysql.conf.php";

	$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


	$result = $mysqli->query("SELECT * FROM test");
	$row	= $result->fetch_row();
	foreach ($row as $row_)
		echo $row_;

	echo "<br>url : ";
	$url_parse = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
	echo $_SERVER["REQUEST_URI"];
}
?>

<!-- Portfolio - Manager | By : P.Clement & N.Théo (Pandeo_F1) - https://github.com/PandeoF1/Portfolio-Manager -->

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Portfolio PLANQUE Clément</title>
</head>

<body>
	<p>Test</p>
	
</body>

</html>
<?php
echo "<mm:dwdrfml documentRoot=" . __FILE__ .">";$included_files = get_included_files();foreach ($included_files as $filename) { echo "<mm:IncludeFile path=" . $filename . " />"; } echo "</mm:dwdrfml>";
?>