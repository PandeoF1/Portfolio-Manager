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
	<link href="/css/index.css" rel="stylesheet">
</head>
<?php if (isset($div["/"])) { ?>

	<body style="padding-top: 21px; background-image: url('/images/background.webp'); background-repeat: no-repeat; background-size: 100%; background-color: #353235;">
		<div style="width: 100%; position: fixed;">
			<nav style="text-align: center; position: relative;">
				<b><a href="/projects" style="color: #16A7F2; text-align: center;">Projects</a></b>
			</nav>
		</div>
		<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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

	<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Not found</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/untitled-1.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body id="page-top">
    <div id="wrapper">
        

            </div>
            </nav>
            <div class="container-fluid">
                <div class="text-center mt-5">
                    <div class="error mx-auto" data-text="404">
                        <p class="m-0">404</p>
                    </div>
                    <p class="text-dark mb-5 lead">Page Not Found</p>
                    <p class="text-black-50 mb-0">It looks like you found a glitch in the matrix...</p><a href="./login.php">← Back to Login</a></div>
            </div>
        </div>
        <footer class="bg-white sticky-footer">

        </footer>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
<?php } ?>

</html>