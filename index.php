<?php
	if(isset($_POST['send'])){
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		include('connect.php');	
		$connect = new mysqli($dbServer, $dbUser, $dbPassword, $dbName);
		if(mysqli_connect_errno()){
			$error = 'Nie udało się nawiązać połączenia z bazą!';
		}
		else{
			if(isset($_POST['firstName'])){
				if($firstName == '' && $lastName != ''){
					$firstNameError = true;
				}
				else if($firstName != '' && $lastName == ''){
					$lastNameError = true;
				}
				else if($firstName == '' && $lastName == ''){
					$firstNameError = true;
					$lastNameError = true;
				}
			}
			$connect->query('set names "utf8" collate "utf8_polish_ci"');
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Phone book</title>
	<meta charset="utf-8" />
	<link href="style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
	<nav>
		<a href="/phone-book/"><button>Dodaj wpis</button></a>
		<a href="#"><button>Szukaj</button></a>
	</nav>
	<div id="container">
		<p class="error"><?php if($firstNameError || $lastNameError){ echo '<span>Brakujące dane!</span> '; } ?></p>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div id="defaultSearch">
				<input class="<?php if($firstNameError){ echo 'red'; }else{ echo 'normal'; } ?>" type="text" placeholder="Imię" name="firstName" value="<?php if(isset($firstName)){ echo $firstName; } ?>">
				<input class="<?php if($lastNameError){ echo 'red'; }else{ echo 'normal'; } ?>" type="text" placeholder="Nazwisko" name="lastName" value="<?php if(isset($lastName)){ echo $lastName; } ?>">
			</div>
			<input type="text" placeholder="Ulica">
			<input type="text" placeholder="Numer domu">
			<input type="text" placeholder="Numer mieszkania">
			<input type="text" placeholder="Miejscowość">
			<input type="submit" name="send" value="Szukaj">
		</form>	
	</div>
	<?php
		if(isset($_POST['send'])){ 
			$result = $connect->query('SELECT * FROM Data WHERE FirstName = "' . $firstName . '" AND LastName = "' . $lastName . '"');
			while($value = mysqli_fetch_array($result)){
			?>
			<div class="result">
				<p><?php echo $value['FirstName']; ?></p>
				<p><?php echo $value['LastName']; ?></p>
				<p><?php echo $value['Street']; ?></p>
				<p><?php echo $value['HouseNumber']; ?></p>
				<p><?php echo $value['ApartmentNumber']; ?></p>
				<p><?php echo $value['City']; ?></p>
				<p><?php echo $value['Number']; ?></p>
			</div>
			<?php	
			}
		}	
	?>
</body>
</html>