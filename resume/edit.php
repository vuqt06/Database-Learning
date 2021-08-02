<?php
require_once "pdo.php";
session_start();

if(isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

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

if ( isset($_POST['first_name']) && isset($_POST['last_name'])
     && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['profile_id']) ) {

    // Data validation
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1
        || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }
    $check = strpos($_POST['email'], '@');

    if (!$check) {
        $_SESSION['error'] = 'Bad data';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    $msg = validatePos();
    if(is_string($msg)) {
        $_SESSION['error'] = $msg;
        Header("Location: edit.php?profile_id=".$_GET['profile_id']);
        return;
    }

    $sql = "UPDATE Profile SET first_name = :first,
            last_name = :last, email = :email, headline = :headline, summary = :summary
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':first' => $_POST['first_name'],
        ':last' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':profile_id' => $_POST['profile_id']));

    $stmt2 = $pdo->prepare('DELETE FROM Position WHERE profile_id=:pid');
    $stmt2->execute(array( ':pid' => $_GET['profile_id']));

    $rank = 1;
    for($i=1; $i<=9; $i++) {
        if ( ! isset($_POST['year'.$i]) ) continue;
        if ( ! isset($_POST['desc'.$i]) ) continue;

        $year = $_POST['year'.$i];
        $desc = $_POST['desc'.$i];
        $stmt3 = $pdo->prepare('INSERT INTO Position
            (profile_id, rank, year, description)
            VALUES ( :pid, :rank, :year, :des)');

        $stmt3->execute(array(
        ':pid' => $_REQUEST['profile_id'],
        ':rank' => $rank,
        ':year' => $year,
        ':des' => $desc)
        );

        $rank++;

    }

    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that autos_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$first = htmlentities($row['first_name']);
$last = htmlentities($row['last_name']);
$email = htmlentities($row['email']);
$headline = htmlentities($row['headline']);
$summary = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>

<!DOCTYPE html>
<<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vu Trinh's Resume Registry</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        echo('<h1>Editing Profile for '.$_SESSION['name'].'</h1>')
    ?>

    <form method="post">
    <p>First Name:
    <input type="text" name="first_name" value="<?= $first ?>"></p>
    <p>Last Name:
    <input type="text" name="last_name" value="<?= $last ?>"></p>
    <p>Email:
    <input type="text" name="email" value="<?= $email ?>"></p>
    <p>Headline:
    <input type="text" name="headline" value="<?= $headline ?>"></p>
    <p>Summary:<br>
    <textarea name="summary" rows="8" cols="80"><?= $summary ?></textarea>
    </p>
    <?php
        $stmt4 = $pdo->prepare("SELECT * FROM Position WHERE profile_id = :pid");
        $stmt4->execute(array(
            'pid' => $_GET['profile_id']));
        $positions = $stmt4->fetchAll(PDO::FETCH_ASSOC);

        $pos = 0;
        echo('<p>Position: <input type="submit" id="addPos" value="+">'."\n");
        echo('<div id="position_fields"> </div>'."\n");
        foreach ($positions as $position) {
            $pos++;
            echo('<div id="position'.$pos.'">'."\n");
            echo('<p>Year: <input type="text" name="year'.$pos.'"');
            echo(' value="'.$position['year'].'"/>'."\n");
            echo('<input type="button" value="-" ');
            echo('onclick="$(\'#position'.$pos.'\').remove();return false;">'."\n");
            echo("</p>\n");
            echo('<textarea name="desc'.$pos.'" rows="8" cols="80">'."\n");
            echo(htmlentities($position['description'])."\n");
            echo("\n</textarea>\n</div>\n");
        }
        echo("</div></p>\n");
    ?>
    <input type="hidden" name="profile_id" value="<?= $profile_id ?>">
    <p><input type="submit" value="Save"/><input type="submit" name ="cancel" value="Cancel"/></p>
</form>
<script type="text/javascript">
    countPos = <?= $pos ?>;
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
</body>
</html>
