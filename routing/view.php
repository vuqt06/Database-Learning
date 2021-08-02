<?php
session_start();
require_once "pdo.php";
if (!isset($_SESSION['who'])) {
	die("Not logged in");
}
?>

<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Vu Trinh's Automobile Tracker</title>
</head>
<body>
<div class="container">
<?php
	if (isset($_SESSION['who'])) {
		echo ("<h1> Tracking Autos for ".htmlentities($_SESSION['who']).'</h1>');
	}

	if (isset($_SESSION['success'])) {
		echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
	}
?>

<h2>Automobiles</h2>
<?php
	$stmt = $pdo->query("SELECT * from autos");
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo "<ul>";
	foreach($rows as $row) {
		echo("<li>");
		echo("<p>");
		echo($row['year']);
		echo(" ");
		echo($row['make']);
		echo(" ");
		echo($row['mileage']);
		echo("</p>");
		echo("</li>");
	}
	echo "</ul>";
?>

<p><a href="add.php">Add New</a> | <a href="logout.php">Logout</a></p>


</div>
</body>
