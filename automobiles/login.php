<?php // Do not put any HTML above this line
session_start();

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123


// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    unset($_SESSION['email']);
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "User name and password are required";
        header("Location: login.php");
        return;
    } else {
        $check_email = strpos($_POST['email'], '@');
        $check = hash('md5', $salt.$_POST['pass']);
        if ( ($check == $stored_hash) && $check_email ) {
            // Redirect the browser to view.php
            $_SESSION['email'] = $_POST['email'];
            error_log("Login success ".$_POST['email']);
            header("Location: index.php");
            return;
        } 
        else if (!$check_email) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            error_log("Login fail ".$_POST['email']." $check_email");
            header("Location: login.php");
            return;
        }
        else if ($check != $stored_hash) {
            $_SESSION['error'] = "Incorrect password";
            error_log("Login fail ".$_POST['email']." $check");
            header("Location: login.php");
            return;
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
<head>
<?php require_once "bootstrap.php"; ?>
<title>Vu Trinh's Login Page</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php
// Note triple not equals and think how badly double
// not equals would work here...
if (isset($_SESSION['error'])) {
    // Look closely at the use of single and double quotes
    echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    unset($_SESSION['error']);
}
?>
<form method="POST">
<p>User Name <input type="text" name="email" id="nam"></p><br/>
<p>Passwword <input type="text" name="pass" id="id_1723"></p><br/>
<input type="submit" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find an account and password hint in the HTML comments.
<!-- Hint: The password is the four character sound a cat
makes (all lower case) followed by 123. -->
</p>
</div>
</body>
