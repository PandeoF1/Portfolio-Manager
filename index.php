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
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo "Portfolio PLANQUE Clement" ?></title>
	<link src="/style/bootstrap.min.css" rel="stylesheet" />
	<script src="/style/bootstrap.bundle.min.js"></script>
</head>
<?php if (isset($div["/"])){ ?>

<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light"> <a class="navbar-brand" href="#">Navbar</a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
	  <div class="collapse navbar-collapse" id="navbarSupportedContent1">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item active"> <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> </li>
	      <li class="nav-item"> <a class="nav-link" href="#">Link</a> </li>
	      <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Dropdown </a>
	        <div class="dropdown-menu" aria-labelledby="navbarDropdown1"> <a class="dropdown-item" href="#">Action</a> <a class="dropdown-item" href="#">Another action</a>
	          <div class="dropdown-divider"></div>
	          <a class="dropdown-item" href="#">Something else here</a> </div>
          </li>
	      <li class="nav-item"> <a class="nav-link disabled" href="#">Disabled</a> </li>
        </ul>
	    <form class="form-inline my-2 my-lg-0">
	      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
	      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
  </div>
</nav>

<?php } ?>
<?php if (isset($div["admin"])) {
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

<?php if (isset($div["login"])) {
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
				<?php if (isset($_POST["identifiant"]) && isset($_POST["mdp"])) { ?>
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