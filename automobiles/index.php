<?php
	require_once "pdo.php";
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Vu Trinh's Index Page</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Welcome to Automobiles Database</h1>

<?php
	$login = 'login.php';
	$add = 'add.php';
	$logout = 'logout.php';
	if(isset($_SESSION['email'])) {

		if(isset($_SESSION['error'])) {
			echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    		unset($_SESSION['error']);
		}

		if(isset($_SESSION['success'])) {
			echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    		unset($_SESSION['success']);
		}

		$sql = "SELECT make, model, year, mileage, autos_id FROM autos";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row === false) {
			echo 'No rows found';
		}
		else {
			echo('<table border="1">'."\n");
			echo('<thead><tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr></thead>');
			echo('<tbody>');
			while($row) {
				echo "<tr><td>";
    			echo(htmlentities($row['make']));
    			echo("</td><td>");
    			echo(htmlentities($row['model']));
    			echo("</td><td>");
    			echo(htmlentities($row['year']));
    			echo("</td><td>");
    			echo(htmlentities($row['mileage']));
    			echo("</td><td>");
    			echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
    			echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    			echo("</td></tr>\n");
    			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			echo('</tbody>');
			echo("</table>");
		}
		echo('<p><a href='.$add.'>Add New Entry</a></p>');
		echo("\n");
		echo('<p><a href='.$logout.'>Logout</a></p>');
		echo("\n");
		echo("<p><strong>Note: </strong>Your implementation should retain data across multiple logout/login sessions. This sample implementation clears all its data on logout - which you should not do in your implementation.</p>");

	}
	else {
		echo('<p><a href='.$login.'>Please log in</a></p>');
		echo('<p>Attempt to go to <a href='.$add.'>add data</a> without logging in</p>');
	}
?>
</div>
</body>

