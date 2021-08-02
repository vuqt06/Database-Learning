<!DOCTYPE html>
<html lang = "en">
<head>
	<meta charset="UTF-8">
	<title>Vu Trinh - Request/Response Cycle</title>
</head>
<body>
	<h1>Vu Trinh Request / Response</h1>
	<p>
		<?php 
			echo 'The SHA256 hash of "Vu Trinh" is ';
			print hash('sha256', 'Vu Trinh');
		?>
	</p>
	<pre>ASCII ART:
	*         *
	 *       *
	  *     *
	   *   *
	    * *
	     *
	</pre>
	<a href="fail.php">Click here to check the error setting</a><br>
	<a href="check.php">Click here to cause a traceback</a>
</body>
</html>