<?php
session_start()
require_once "pdo.php";

if(isset($_SESSION['who'])) {
	if(isset($_POST['logout'])) {
		header('Location: index.php');
		return;
	}

	$failure = false;
	$success = false;

	if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
		if(strlen($_POST['make']) < 1) {
			$failure = "Make is required";
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
    			$success = "Record inserted";
    			
			}
			else {
				$failure = "Mileage and year must be numeric";
			}
		}
	}

}
else {
	die("Name parameter missing");
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
<h1>Tracking Autos for ee@</h1>
<?php
	if ( $failure !== false ) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
	}
	if ($success !== false) {
		echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
	}
?>
<form method="POST">
<p>Make: <input type="text" name="make" size="60"></p>
<p>Year: <input type="text" name="year"></p>
<p>Mileage: <input type="text" name="mileage"></p>
<input type="submit" value="Add">
<input type="submit" name="logout" value="Logout">
</form>
</div>
</body>