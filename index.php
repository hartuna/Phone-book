<?php
	include('connect.php');	
	$connect = new mysqli($dbServer, $dbUser, $dbPassword, $dbName);
	if(mysqli_connect_errno()){
		$error = 'Nie udało się nawiązać połączenia z bazą!';
	}
	$connect->query('set names "utf8" collate "utf8_polish_ci"');
	if(isset($_POST['sendDefault'])){
		$active = 'default';
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		if(isset($_POST['firstName'])){
			if($firstName == '' && $lastName == ''){
				$firstNameError = true;
				$lastNameError = true;
			}
			else if($firstName == ''){
				$firstNameError = true;
			}
			else if($lastName == ''){
				$lastNameError = true;
			}
		}
	}
	else if(isset($_POST['sendAlternative'])){
		$active = 'alternative';
		$street = $_POST['street'];
		$houseNumber = $_POST['houseNumber'];
		$apartmentNumber = $_POST['apartmentNumber'];
		$city = $_POST['city'];	
		if(isset($_POST['street'])){
			if($street == '' && $houseNumber == '' && $city == ''){
				$streetError = true;
				$houseNumberError = true;
				$cityError = true;
			}
			else if($street != '' && $houseNumber == '' && $city == ''){
				$houseNumberError = true;
				$cityError = true;
			}
			else if($street == '' && $houseNumber != '' && $city == ''){
				$streetError = true;
				$cityError = true;
			}
			else if($street == '' && $houseNumber == '' && $city != ''){
				$streetError = true;
				$houseNumberError = true;
			}
			else if($street != '' && $houseNumber != '' && $city == ''){
				$cityError = true;
			}
			else if($street != '' && $houseNumber == '' && $city != ''){
				$houseNumberError = true;
			}
			else if($street == '' && $houseNumber != '' && $city != ''){
				$streetError = true;
			}
		}
	}
	else{
		$active = 'none';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Phone book</title>
	<meta charset="utf-8" />
	<link href="style.css" rel="stylesheet" type="text/css" media="all" />
	<script src="script.js"></script>
</head>
<body>
	<nav>
		<a href="/phone-book/"><button class="page">Szukaj</button></a>
		<a href="#"><button class="page">Dodaj</button></a>
	</nav>
	<div id="container">
		<div class="errorWrapper">
		<?php 
			if($firstNameError || $lastNameError){
			?>
			<p class="error"><span>Brakujące dane!</span></p>
			<?php
			}
		?>
		</div>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div id="defaultSearch">
				<input class="<?php if($firstNameError){ echo 'red'; }else{ echo 'normal'; } ?>" type="text" placeholder="Imię" name="firstName" value="<?php if(isset($firstName)){ echo $firstName; } ?>">
				<input class="<?php if($lastNameError){ echo 'red'; }else{ echo 'normal'; } ?>" type="text" placeholder="Nazwisko" name="lastName" value="<?php if(isset($lastName)){ echo $lastName; } ?>">
				<input class="send" <?php if($active == 'alternative'){ echo 'id="noActive"'; } ?> type="submit" name="sendDefault" value="Szukaj">
			</div>
		</form>
		<button id="change">Zmień sposób wyszukiwania</button>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div class="errorWrapper">
			<?php 
				if($streetError || $houseNumberError || $cityError){
				?>
				<p class="error"><span>Brakujące dane!</span></p>
				<?php
				}
			?>
			</div>
			<div id="alternativeSearch">
				<input class="<?php if($streetError){ echo 'red'; }else{ echo 'normal'; } ?>" type="text" placeholder="Ulica" name="street" value="<?php if(isset($street)){ echo $street; } ?>">
				<input class="<?php if($houseNumberError){ echo 'red'; }else{ echo 'normal'; } ?>" type="text" placeholder="Numer domu" name="houseNumber" value="<?php if(isset($houseNumber)){ echo $houseNumber; } ?>">
				<input type="text" placeholder="Numer mieszkania" name="apartmentNumber" value="<?php if(isset($apartmentNumber)){ echo $apartmentNumber; } ?>">
				<input class="<?php if($cityError){ echo 'red'; }else{ echo 'normal'; } ?>" type="text" placeholder="Miejscowość" name="city" value="<?php if(isset($city)){ echo $city; } ?>">
				<input class="send" <?php if($active == 'default' || $active == 'none'){ echo 'id="noActive"'; } ?> type="submit" name="sendAlternative" value="Szukaj">
			</div>
			</form>	
	<?php
		if($active != 'none'){
			if(isset($_POST['sendDefault'])){ 
				$result = $connect->query('SELECT * FROM Data WHERE FirstName = "' . $firstName . '" AND LastName = "' . $lastName . '"');	
			}
			else{
				$result = $connect->query('SELECT * FROM Data WHERE Street = "' . $street . '" AND HouseNumber = "' . $houseNumber . '" AND ApartmentNumber = "' . $apartmentNumber . '" AND City = "' . $city . '"');
			}
			while($value = mysqli_fetch_array($result)){
			?>
			<h2>Wyniki zapytania</h2>
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
	</div>
</body>
</html>