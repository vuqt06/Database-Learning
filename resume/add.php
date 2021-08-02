<?php
session_start();
require_once "pdo.php";

function validatePos() {
  for($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['year'.$i]) ) continue;
    if ( ! isset($_POST['desc'.$i]) ) continue;

    $year = $_POST['year'.$i];
    $desc = $_POST['desc'.$i];

    if ( strlen($year) == 0 || strlen($desc) == 0 ) {
      return "All fields are required";
    }

    if ( ! is_numeric($year) ) {
      return "Position year must be numeric";
    }
  }
  return true;
}

if(isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
	if(isset($_POST['cancel'])) {
		header('Location: index.php');
		return;
	}
	

	if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) 
		&& isset($_POST['headline']) && isset($_POST['summary'])) {
		if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1
			|| strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1
			|| strlen($_POST['summary']) < 1) {
			$_SESSION['failure'] = "All fields are required";
			header("Location: add.php");
			return;
		}
		else {
			$check = strpos($_POST['email'], '@');
			if($check) {

				$msg = validatePos();
				if (is_string($msg)) {
					$_SESSION['failure'] = $msg;
					header("Location: add.php");
					return;
				}
				$stmt = $pdo->prepare('INSERT INTO Profile
  					(user_id, first_name, last_name, email, headline, summary)
  					VALUES ( :uid, :fn, :ln, :em, :he, :su)');

				$stmt->execute(array(
  					':uid' => $_SESSION['user_id'],
  					':fn' => $_POST['first_name'],
  					':ln' => $_POST['last_name'],
  					':em' => $_POST['email'],
  					':he' => $_POST['headline'],
  					':su' => $_POST['summary'])
				);

				$profile_id = $pdo->lastInsertId();
				$rank = 1;

				for($i=1; $i<=9; $i++) {
    				if ( ! isset($_POST['year'.$i]) ) continue;
    				if ( ! isset($_POST['desc'.$i]) ) continue;

    				$year = $_POST['year'.$i];
    				$desc = $_POST['desc'.$i];

    				$stmt2 = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :des)');
					$stmt2->execute(array(
  						':pid' => $profile_id,
  						':rank' => $rank,
  						':year' => $year,
  						':des' => $desc)
					);
					$rank++;
  				}

    			$_SESSION['success'] = "Profile added";
    			header("Location: index.php");
    			return;
    			
			}
			else {
				$_SESSION['failure'] = "Email address must contain @";
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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
<title>Vu Trinh's Profile Add</title>
</head>
<body>
<div class="container">
<?php
	if (isset($_SESSION['name']) && isset($_SESSION['user_id'])) {
		echo ("<h1> Adding Profile for ".htmlentities($_SESSION['name']).'</h1>');
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
<p>First Name: <input type="text" name="first_name" size="60"></p>
<p>Last Name: <input type="text" name="last_name" size="60"></p>
<p>Email: <input type="text" name="email"></p>
<p>Headline: <input type="text" name="headline"></p>
<p>Summary:<br><textarea name="summary" rows="8" cols="80"></textarea></p>
<p>Position: <input type="submit" id="addPos" value="+"></p>
<div id="position_fields"> </div>
<p></p>
<p>
	<input type="submit" value="Add">
	<input type="submit" name="cancel" value="Cancel">
</p>
</form>
<script type="text/javascript">
	
countPos = 0;

// http://stackoverflow.com/questions/17650776/add-remove-html-inside-div-using-javascript
$(document).ready(function(){
    window.console && console.log('Document ready called');
    $('#addPos').click(function(event){
        // http://api.jquery.com/event.preventdefault/
        event.preventDefault();
        if ( countPos >= 9 ) {
            alert("Maximum of nine position entries exceeded");
            return;
        }
        countPos++;
        window.console && console.log("Adding position "+countPos);
        $('#position_fields').append(
            '<div id="position'+countPos+'"> \
            <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
            <input type="button" value="-" \
                onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
            <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
            </div>');
    });
});

</script>
</div>
</body>