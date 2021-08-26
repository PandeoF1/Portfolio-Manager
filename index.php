<?php
require "config/mysql.conf.php";

$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


session_start();

$result = $mysqli->query("SELECT * FROM test");
$row	= $result->fetch_row();
if ($_SERVER["REQUEST_URI"] != "/") {
	foreach ($row as $row_)
		echo $row_;

	echo "<br>url : ";
	$url_parse = explode("/", trim($_SERVER["REQUEST_URI"], "/"));
	echo $_SERVER["REQUEST_URI"];
}
if ($_SERVER["REQUEST_URI"] == "/")
	$div["/"] = 1;
else if ($url_parse[0] == "admin" || $url_parse[0] == "error" || $url_parse[0] == "login")
	$div[$url_parse[0]] = 1;
else
	$div["error"] = 1;

?>

<!-- Portfolio - Manager | By : P.Clement & N.Théo (Pandeo_F1) - https://github.com/PandeoF1/Portfolio-Manager -->

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo "Portfolio PLANQUE Clement" ?></title>
</head>
<?php if ($div["/"]) { ?>

	<body>
		<p>Salut</p>
	</body>
<?php } ?>
<?php if ($div["admin"]) {
	if ($_SESSION["authenticated"] == 1) {
?>

		<body>
			<p>admin</p>
		</body>
<?php
	} else {
		header("location: /login/");
	}
}
?>

<?php if ($div["login"]) {
	if ($_SESSION["authenticated"] == 1)
		header("location: /admin/");
	if (isset($_POST["identifiant"]) && isset($_POST["mdp"])) {
		$email = $_POST["identifiant"];
		$pass = $_POST["mdp"];
		$result = $mysqli->query(
			"SELECT * FROM `account` WHERE email = '$email'"
		);
		while ($row = $result->fetch_row()) {
			echo "Database : " . $row[2] . "<br>";
			echo password_hash($pass, PASSWORD_DEFAULT) . "<br>";
			if (password_verify($pass, $row[2])) {
				$_SESSION["authenticated"] = 1;
				$_SESSION["username"] = $row[1];
				$_SESSION["admin"] = $row[3];
				header("location: /admin/");
			}
		}
	}
?>

	<body>
		<div class="center">
			<h1>Identification</h1>
			<form action=" " method="post">
				<div class="txt_field">
					<input type="text" name="identifiant" required>
					<span></span>
					<label>E-Mail</label>
				</div>
				<div class="txt_field">
					<input type="password" name="mdp" required>
					<span></span>
					<label>Mot de passe</label>
				</div>
				<input type="submit" value="Login">
				<br><br>
				<?php if ($_POST["identifiant"] && $_POST["mdp"]) { ?>
					<div class="alert">
						<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
						Le mot de passe ou l'identifiant n'est pas correct.
					</div>
					<br>
				<?php } ?>
			</form>
		</div>
	</body>
<?php } ?>

<?php if ($div["error"]) { ?>

	<body>
		<p>Page not found</p>
	</body>
<?php } ?>

</html>