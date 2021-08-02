<?php
	session_start();

	if(!isset($_SESSION['username'])) {
		die("ACCESS DENIED. YOU ARE NOT MY BAE.");
	}
?>

<!DOCTYPE html>
<html lang = "en">
<head>
	<style> 
		@font-face {
			font-family: "Vtks Beautiful Dreams";
			src: url("./fonts/Vtks_Beautiful_Dreams.ttf");
		}

		@font-face {
			font-family: "Permanent Marker";
			src: url("./fonts/PermanentMarker.ttf");
		}

		@font-face {
			font-family: "Learning Curve";
			src: url("./fonts/LearningCurve.ttf");
		}

		@font-face {
			font-family: "Post-it Penscript";
			src: url("./fonts/Postit-Penscript.otf");
		}

		@font-face {
			font-family: "Asphyxiate";
			src: url("./fonts/asphyxiate.ttf");
		}

		body {
			background-color: #CDEEFD;
}

.main-content {
	margin-top: 2%;
	font-family: sans-serif;
	height: 30%;
	background-color: #B3E5FC;
	-webkit-border-radius: 5px;
	display: flex;
	-webkit-justify-content: center;
	padding: 2%;
}

.item {
	display: flex;
	justify-content: center;
}

img {
	display: flex;
	justify-content: center;
	width: 35%;
	margin: 2%;
	-webkit-border-radius: 5px;
	-webkit-transition: all 0.6s;
	margin: 0 auto;
}

img:hover {
	-webkit-transform: scale(1.1, 1.1);
}
	</style>
	<script src="https://kit.fontawesome.com/1cfdea155f.js" crossorigin="anonymous"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title style="font-family: Vtks Beautiful Dreams">Happy Birthday To My Emma</title>
	<link rel="shortcut icon" href="./images/birthday.ico" />
	<link rel="stylesheet" type="text/css" href="./css/header.css">
	<link rel="stylesheet" type="text/css" href="./css/main-content.css">
	<link rel="stylesheet" type="text/css" href="./css/after-content.css">
	<link rel="stylesheet" type="text/css" href="./css/footer.css">
	<script src="https://kit.fontawesome.com/c41c933aab.js" crossorigin="anonymous"></script>
  <script src = "./js/birthday.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
                                                           
</head>
<body style="background-color: #CDEEFD;">
	<div class="header">
		  <div class="title"><a href="index.html" style='color: #35BAF6;' style="font-family: Vtks Beautiful Dreams">Happy Birthday</a></div>
	</div>

	<div class="main-content">
		<div class="container">  
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="./images/nhung2.jpg" style="width:35%">
      </div>

      <div class="item">
        <img src="./images/nhung1.jpg" style="width:35%">
      </div>
    
      <div class="item">
        <img src="./images/nhung3.jpg" style="width:35%">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
		
	</div>

	<div class="after-content">
		<div class="message"><q>I didn’t ever think I would meet someone like you.<br>May all your days be as special as your birthday.<br>Happy 20th Birthday, Sweetheart.</q></div>
	</div>

	<div class="secret">
		<button class="button" onclick="secretMessage()">Secret Message</button>
	</div>

	<div id="secretmessage">
		<p id="love">Happy birthday, my love. I wish you to become more and more beautiful and successful. I am so happy you are my lover, my shoulder to lean on, and I want to use this opportunity to assure you that my love for you will last a lifetime. I wish you all the love and sweet things in the world. Thank you for coming into my life, and please love me more. I LOVE YOU.</p>
	</div>

	<div class="footer">
    <div class="copyright">
      <i class="far fa-copyright"></i>
      <div class="last-word">A present to Nhung Kim Le,</div>
    </div>
    <div class="true-end">From MI, USA to BC, Canada,</div>
    <div class="date">2022/01/21.</div>
  </div>

  <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="/__/firebase/8.6.5/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="/__/firebase/8.6.5/firebase-analytics.js"></script>

<!-- Initialize Firebase -->
<script src="/__/firebase/init.js"></script>
</body>

</html>