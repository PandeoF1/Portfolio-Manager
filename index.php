<?php
require "config/mysql.conf.php";

$mysqli = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

$mysqli->query(
	"INSERT INTO `log` (`id`, `ip`, `message`) VALUES (NULL, '" . $_SERVER['REMOTE_ADDR'] . "', '" . $_SERVER["REQUEST_URI"] . "')"
);

session_start();

$url_parse = explode("/", trim($_SERVER["REQUEST_URI"], "/"));

if ($url_parse[0] == "") //Nerf for title
	$url_parse[0] = "/";

// Fetch title
$result = $mysqli->query(
	"SELECT * FROM `title` WHERE url = '$url_parse[0]'"
);
while ($row = $result->fetch_row())
	$title = $row[2];

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
	<title><?php echo $title ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="/css/scrollbar.css" rel="stylesheet">
</head>
<?php if (isset($div["/"])) { ?>

	<body style="padding-top: 70px; background-image: url('/images/background.jpg'); background-repeat: no-repeat; background-size: 100%; background-color: #333333;">
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</body>

<?php } ?>
<?php if (isset($div["admin"])) {
	if ($_SESSION["authenticated"] == 1) {
		$version = file_get_contents('https://raw.githubusercontent.com/PandeoF1/Portfolio-Manager/main/version?token=AN5LJNZYP2I3TSMXCUNZMQTBGDFF2');
		$result = $mysqli->query(
			"SELECT * FROM `version`"
		);
		while ($row = $result->fetch_row())
			$db_version = $row[1];
		if ($version != $db_version)
			echo "Update available : https://github.com/PandeoF1/Portfolio-Manager"
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

<?php if (isset($div["login"])) {
	if ($_SESSION["authenticated"] == 1)
		header("location: /admin/");
	if (isset($_POST["identifiant"]) && isset($_POST["mdp"])) {
		$email = $_POST["identifiant"];
		$pass = $_POST["mdp"] . "SHFIUdhsggfiyhDSAHfgSHFIUdhsggfiyhDSAHfgSHFIUdhUdhsggfiyhDSAHfgSHFIUdhUdhsggfiyhDSAHfgFDsgfd";
		$result = $mysqli->query(
			"SELECT * FROM `account` WHERE email = '$email'"
		);
		while ($row = $result->fetch_row()) {
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

		<head>
			<meta charset="utf-8">
			<link rel="stylesheet" href="/css/login.css">
		</head>

		<div class="center">
			<h2><b>Identification</b></h2>
			<form action=" " method="post">
				<div class="txt_field">
					<input type="text" name="identifiant" required>
					<span></span>
					<label>Identifiant</label>
				</div>
				<div class="txt_field">
					<input type="password" name="mdp" required>
					<span></span>
					<label>Mot de passe</label>
				</div>
				<input type="submit" value="Login">
				<br><br>
				<?php if (isset($user)) { ?>
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

<?php if (isset($div["error"])) { ?>

	<body>
		<p>Page not found</p>
	</body>
<?php } ?>

</html>