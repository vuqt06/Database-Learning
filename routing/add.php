<?php
session_start();
require_once "pdo.php";

if(isset($_SESSION['who'])) {
	if(isset($_POST['cancel'])) {
		header('Location: view.php');
		return;
	}
	

	if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
		if(strlen($_POST['make']) < 1) {
			$_SESSION['failure'] = "Make is required";
			header("Location: add.php");
			return;
		}
		else {
			if(is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
				$stmt = $pdo->prepare('INSERT INTO autos
        				(make, year, mileage) VALUES ( :mk, :yr, :mi)');
    			$stmt->execute(array(
        			':mk' => htmlentities($_POST['make']),
        			':yr' => htmlentities($_POST['year']),
        			':mi' => htmlentities($_POST['mileage']))
    			);
    			$_SESSION['success'] = "Record inserted";
    			header("Location: view.php");
    			return;
    			
			}
			else {
				$_SESSION['failure'] = "Mileage and year must be numeric";
				header("Location: add.php");
				return;
			}
		}
	}

}
else {
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
?>
<?php
	if (isset($_SESSION['failure'])) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['failure'])."</p>\n");
    unset($_SESSION['failure']);
	}
?>
<form method="POST">
<p>Make: <input type="text" name="make" size="60"></p>
<p>Year: <input type="text" name="year"></p>
<p>Mileage: <input type="text" name="mileage"></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>