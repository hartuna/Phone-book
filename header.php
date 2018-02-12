<?php
	if(strstr($_SERVER['HTTP_HOST'], 'www.')){
		header('Location: http://bartlomiejhartuna.pl' . $_SERVER['REQUEST_URI']);
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Phone book</title>
	<meta charset="utf-8" />
	<link href="style.css" rel="stylesheet" type="text/css" media="all" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script src="script.js"></script>
</head>
<body>
	<nav>
		<img src="image/book.png" alt="książka telefoniczna" />
		<a href="/phone-book/"><button class="page">Szukaj</button></a>
		<a href="/phone-book/dodaj.php"><button class="page">Dodaj</button></a>
		<div id="volume">
			<p>Pojemność: <span id="busy"><?php echo $volume['count(Id)']; ?></span> / 50</p>	
			<div id="progress"></div>
		</div>
	</nav>
	<div id="container">