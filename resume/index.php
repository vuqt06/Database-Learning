<?php
	require_once "pdo.php";
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Vu Trinh's Resume Registry</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Vu Trinh's Resume Registry</h1>

<?php
	$login = 'login.php';
	$add = 'add.php';
	$logout = 'logout.php';
	if(isset($_SESSION['name']) && isset($_SESSION['user_id'])) {

		if(isset($_SESSION['error'])) {
			echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    		unset($_SESSION['error']);
		}

		if(isset($_SESSION['success'])) {
			echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    		unset($_SESSION['success']);
		}

		echo('<p><a href='.$logout.'>Logout</a></p>');

		$sql = "SELECT first_name, last_name, headline, profile_id FROM Profile";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row !== false) {
			echo('<table border="1">'."\n");
			echo('<thead><tr><th>Name</th><th>Headline</th>><th>Action</th></tr></thead>');
			echo('<tbody>');
			while($row) {
				$name = htmlentities($row['first_name'])." ".htmlentities($row['last_name']);
				echo "<tr><td>";
				echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$name.'</a>');
    			echo("</td><td>");
    			echo(htmlentities($row['headline']));
    			echo("</td><td>");
    			echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> ');
    			echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
    			echo("</td></tr>\n");
    			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			echo('</tbody></table>');
		}
		echo('<p><a href='.$add.'>Add New Entry</a></p>');
		echo("\n");
	}
	else {
		echo('<p><a href='.$login.'>Please log in</a></p>');

		$sql = "SELECT first_name, last_name, headline, profile_id FROM Profile";
		$stmt = $pdo->query($sql);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row !== false) {
			echo('<table border="1">'."\n");
			echo('<thead><tr><th>Name</th><th>Healine</th>></tr></thead>');
			echo('<tbody>');
			while($row) {
				$name = htmlentities($row['first_name'])." ".htmlentities($row['last_name']);
				echo "<tr><td>";
    			echo('<a href="view.php?profile_id='.$row['profile_id'].'">'.$name.'</a>');
    			echo("</td><td>");
    			echo(htmlentities($row['headline']));
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
			}
			echo("</td></tbody></table>");
			echo("\n");
		}
	}
	echo('<p><strong>Note: </strong>Your implementation should retain data across multiple logout/login sessions. This sample implementation clears all its data on logout - which you should not do in your implementation.</p>')
?>
</div>
</body>
</html>