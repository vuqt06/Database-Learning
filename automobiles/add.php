<?php
session_start();
require_once "pdo.php";

if(isset($_SESSION['email'])) {
	if(isset($_POST['cancel'])) {
		header('Location: index.php');
		return;
	}
	

	if ( isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) 
		&& isset($_POST['model'])) {
		if(strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1
			|| strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
			$_SESSION['failure'] = "All fields are required";
			header("Location: add.php");
			return;
		}
		else {
			if(is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
				$stmt = $pdo->prepare('INSERT INTO autos
        				(make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
    			$stmt->execute(array(
        			':mk' => htmlentities($_POST['make']),
        			':md' => htmlentities($_POST['model']),
        			':yr' => htmlentities($_POST['year']),
        			':mi' => htmlentities($_POST['mileage']))
    			);
    			$_SESSION['success'] = "Record added";
    			header("Location: index.php");
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
	die("ACCESS DENIED");
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
	if (isset($_SESSION['email'])) {
		echo ("<h1> Tracking Autos for ".htmlentities($_SESSION['email']).'</h1>');
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
<p>Model: <input type="text" name="model" size="60"></p>
<p>Year: <input type="text" name="year"></p>
<p>Mileage: <input type="text" name="mileage"></p>
<input type="submit" value="Add">
<input type="submit" name="cancel" value="Cancel">
</form>
</div>
</body>