<?php
	require_once "pdo.php";
	session_start();

	if(!isset($_GET['profile_id'])) {
		$_SESSION['error'] = "Missing profile_id";
		header("Location: index.php");
		return;
	}

	$stmt = $pdo->prepare("SELECT * FROM Profile WHERE profile_id = :xyz");
	$stmt->execute(array(':xyz' => $_GET['profile_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($row === false) {
		$_SESSION['error'] = "Bad value for profile_id";
		header("Location: index.php");
		return;
	}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Vu Trinh's Profile View</title>
</head>
<body>
	<h1>Profile information</h1>
	<?php
		echo('<p>First Name: '.$row['first_name'].'</p>');
		echo('<p>Last Name: '.$row['last_name'].'</p>');
		echo('<p>Email: '.$row['email'].'</p>');
		echo('<p>Headline:<br>'.$row['headline'].'</p>');
		echo('<p>Summary:<br>'.$row['summary'].'</p>');

		$stmt2 = $pdo->prepare("SELECT * FROM Position WHERE profile_id = :pid");
		$stmt2->execute(array(
			'pid' => $_GET['profile_id']));
		$rows = $stmt2->fetchAll(PDO::FETCH_ASSOC);

		echo('Position');
		echo('<ul>');
		foreach ($rows as $row) {
			echo('<li>'.$row['year'].': '.$row['description'].'</li>');
		}
		echo('</ul>');
	?>
	<a href="index.php" style="text-decoration: none;">Done</a>
</body>
</html>