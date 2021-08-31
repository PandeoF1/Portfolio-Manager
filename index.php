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
else if ($url_parse[0] == "admin" || $url_parse[0] == "error" || $url_parse[0] == "login" || $url_parse[0] == "projects" || $url_parse[0] == "view_articles" || $url_parse[0] == "register")
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

	<head>
		<link href="/css/index.css" rel="stylesheet">
		<script src="/js/index.js"></script>
	</head>

	<body>
		<div class="navdiv">
			<nav class="navbar">
				<a href="/projects">Projects</a>
				<a href="/files/CV.pdf">CV</a>
			</nav>
		</div>
		<div style="margin-top: 3.8em; margin-left:auto; margin-right:auto; width: 71%;">
			<p class="text">
				<span class="span-h2">About me :</span>
				Hello, my name is PLANQUE Clément. I'm a french student in IT sector...
				<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
			</p>
		</div>
		<div id="footer-div" class="footer-div">
			<button onclick="displaychange();" class="footer-btn" title="Contacts">
				<img id="up" src="/images/footer-arrow-up.webp" />
				<img id="down" src="/images/footer-arrow-down.webp" />
			</button>
			<footer id="footer">
				<div class="roww">
					<h4 style="color: aliceblue;">Contact :</h4>
					<a href="mailto:admin@clementplanque.fr" target="_blank">admin@clementplanque.fr</a>
					<a href="https://www.linkedin.com/in/cl%C3%A9ment-p-14a7a312a/" target="_blank">LinkedIn</a>
					<a href="https://www.tisi-fr.com/board/member.php?action=profile&uid=187" target="_blank" title="IT monitoring">TISI blog</a>
					<p>© PLANQUE Clément - 2021</p>
				</div>
			</footer>
		</div>
	</body>

<?php } ?>
<?php if (isset($div["admin"])) {
	if ($_SESSION["authenticated"] == 1) {
		if ($_POST["title"]) {
			$result = $mysqli->query(
				"INSERT INTO `projects` (`id`, `title`, `text`) VALUES (NULL, '" . $_POST["title"] . "', '" . $_POST["content"] . "') "
			);
		}
		$version = file_get_contents('https://raw.githubusercontent.com/PandeoF1/Portfolio-Manager/main/version?token=AN5LJNZYP2I3TSMXCUNZMQTBGDFF2');
		$result = $mysqli->query(
			"SELECT * FROM `version`"
		);
		while ($row = $result->fetch_row())
			$db_version = $row[1];
		if ($version != $db_version)
			echo "Update available : https://github.com/PandeoF1/Portfolio-Manager"
?>

		<head>
			<meta charset="utf-8">
			<title><?php echo $title ?></title>
			<script src="/css/ckeditor/ckeditor.js"></script>
			<link rel="stylesheet" href="/css/add_article.css">
		</head>

		<body>
			<div class="container">
				<form action="" method="post">
					<div class="input-field">
						<label for="title">Title</label>
						<input type="text" name="title" id="title">
					</div>
					<textarea name="content" id="content"></textarea>
					<button type="submit" class="publish">Publish article</button>
				</form>
				<div class="redirect">
					<a href="/" class="redirect">Back to site</a>
					<a href="/view_articles" class="redirect">View articles</a>
					<a href="/register" class="redirect">Register</a>
				</div>

			</div>
			<script>
				CKEDITOR.replace('content');
			</script>
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
	if (isset($_POST["login"]) && isset($_POST["password"])) {
		$email = $_POST["login"];
		$pass = $_POST["password"] . "SHFIUdhsggfiyhDSAHfgSHFIUdhsggfiyhDSAHfgSHFIUdhUdhsggfiyhDSAHfgSHFIUdhUdhsggfiyhDSAHfgFDsgfd";
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
			<h2><b>Authentication</b></h2>
			<form action=" " method="post">
				<div class="txt_field">
					<input type="text" name="login" required>
					<span></span>
					<label>Login</label>
				</div>
				<div class="txt_field">
					<input type="password" name="password" required>
					<span></span>
					<label>Password</label>
				</div>
				<input type="submit" value="Login">
				<br><br>
				<?php if (isset($_POST['login'])) { ?>
					<div class="alert">
						<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
						Login or password incorrect.
					</div>
					<br>
				<?php } ?>
			</form>
		</div>
	</body>
<?php } ?>
<?php if (isset($div["projects"])) {
	$result = $mysqli->query(
		"SELECT * FROM `projects`"
	);
?>

	<head>
		<link rel="stylesheet" href="/css/projects.css">
	</head>

	<body>
		<div class="navdiv">
			<nav class="navbar">
				<a href="/">Home</a>
				<a href="/files/CV.pdf">CV</a>
			</nav>
		</div>
		<div style="margin-top: 3.8em; margin-left:auto; margin-right:auto; width: 71%;">
			<?php

			while ($row = $result->fetch_row()) {
				echo "<div class='text'>";
				echo "<h2>$row[1]</h2>";
				echo $row[2];
				echo "</div>";
			}
			?>
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
				<p class="text-black-50 mb-0">It looks like you found a glitch in the matrix...</p><a href="/">← Back to index</a>
			</div>
		</div>
		</div>
		<footer class="bg-white sticky-footer">

		</footer>
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/js/chart.min.js"></script>
		<script src="assets/js/bs-init.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
		<script src="assets/js/theme.js"></script>
	</body>
<?php } ?>

<?php if (isset($div["view_articles"])) {
	if ($_SESSION["authenticated"] == 1) {
		$version = file_get_contents('https://raw.githubusercontent.com/PandeoF1/Portfolio-Manager/main/version?token=AN5LJNZYP2I3TSMXCUNZMQTBGDFF2');
		$result = $mysqli->query(
			"SELECT * FROM `version`"
		);
		while ($row = $result->fetch_row())
			$db_version = $row[1];
?>

		<head>
			<title><?php echo $title ?></title>
			<link rel="stylesheet" href="/css/bootstrap.min.css">
			<script src="/js/fulkter.js"></script>
		</head>

		<body style="padding-top: 7px">
			<div class="container">
				<div class="row mb-4">
					<div class="col-xl-12">
						<a type="submit" href="/admin" class="btn btn-outline-primary" style="float: right;">Return</a>
					</div>
					<div class="col-xl-12" style="margin-top: 10px;">
						<div class="text-md-left dataTables_filter" id="dataTable_filter" style="float: right;"><label><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search" name="search_input" id="search_input" onkeyup="fulkter()"></label></div>
					</div>
				</div>
				<table class="table table-dark">
					<thead>
						<tr>
							<th>Id</th>
							<th>Title</th>
							<th>Message</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="table_body">
						<?php
						if (isset($_POST["id"])) {
							$result = $mysqli->query(
								"DELETE FROM `projects` WHERE `projects`.`id` = " . $_POST["id"]
							);
						}
						$result = $mysqli->query(
							"SELECT * FROM `projects`"
						);
						while ($row = $result->fetch_row()) {
							echo "<form action='' method='POST'>
						<input type='text' name='id' hidden value='" . $row[0] . "'>";
							echo "<tr>
							<td>" . $row[0] . "</td>";
							echo "<td>" . $row[1] . "</td>";
							echo "<td>" . $row[2] . "</td>";
							echo "<td>
							<button type='submit' style='background-color: transparent; border: 0;'>🗑️</button>
							</form>
							</td>
							</tr>";
						}
						?>
					</tbody>
				</table>
			</div>
		</body>

<?php
	} else {
		header("location: /login/");
	}
}
?>

<?php if (isset($div["register"])) {
	if ($_SESSION["authenticated"] == 1) {
		$version = file_get_contents('https://raw.githubusercontent.com/PandeoF1/Portfolio-Manager/main/version?token=AN5LJNZYP2I3TSMXCUNZMQTBGDFF2');
		$result = $mysqli->query(
			"SELECT * FROM `version`"
		);
		while ($row = $result->fetch_row())
			$db_version = $row[1];

	if (isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["rpassword"])) {
		if ($_POST["password"] == $_POST["rpassword"]) {
			$email = $_POST["login"];
			$pass = $_POST["password"] . "SHFIUdhsggfiyhDSAHfgSHFIUdhsggfiyhDSAHfgSHFIUdhUdhsggfiyhDSAHfgSHFIUdhUdhsggfiyhDSAHfgFDsgfd";
			$result = $mysqli->query(
				"SELECT COUNT(*) FROM `account` WHERE email = '$email'"
			);
			if ($result == 0) {
				$passhash = password_hash($pass, PASSWORD_DEFAULT);
				$mysqli->query(
					"INSERT INTO `account` (`id`, `email`, `password`) VALUES (NULL, '" . $email . "', '" . $passhash . "')"
				);
				echo "<script type='text/javascript'> alert('Success !'); </script>";
			} else {
				$error = 2;
			}
		} else {
			$error = 1;
		}
		
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

		<head>
			<meta charset="utf-8">
			<link rel="stylesheet" href="/css/login.css">
		</head>

		<div class="center">
			<h2><b>Register</b></h2>
			<form action="" method="post">
				<div class="txt_field">
					<input type="text" name="login" required>
					<span></span>
					<label>Login</label>
				</div>
				<div class="txt_field">
					<input type="password" name="password" required>
					<span></span>
					<label>Password</label>
				</div>
				<div class="txt_field">
					<input type="rpassword" name="rpassword" required>
					<span></span>
					<label>Repeat password</label>
				</div>
				<input type="submit" value="Login">
				<br><br>
				<?php if ($error == 1) { ?>
					<div class="alert">
						<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
						Passwords are not same.
					</div>
					<br>
				<?php } ?>
				<?php if ($error == 2) { ?>
					<div class="alert">
						<span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
						Account already created.
					</div>
					<br>
				<?php } ?>
			</form>
		</div>
		</body>

<?php
	} else {
		header("location: /login/");
	}
}
?>

</html>