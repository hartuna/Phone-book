<?php
	include('connect.php');	
	$result = $connect->query('SELECT count(Id) FROM Data');
	$volume = mysqli_fetch_array($result);
	if(isset($_POST['Add'])){
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$street = $_POST['street'];
		$houseNumber = $_POST['houseNumber'];
		$apartmentNumber = $_POST['apartmentNumber'];
		$city = $_POST['city'];	
		$phoneNumber = $_POST['phoneNumber'];	
		$email = $_POST['email'];
		if($firstName != '' && $lastName != '' && $street != '' && $houseNumber != '' && $apartmentNumber != '' && $city != '' && $phoneNumber != ''){
			$result = $connect->prepare('INSERT Data (FirstName, LastName, Street, HouseNumber, ApartmentNumber, City, PhoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?)');	
			$result->bind_param('sssssss', $firstName, $lastName, $street, $houseNumber, $apartmentNumber, $city, $phoneNumber);
			$result->execute();
			$result->close();	
		}
		else{
			if($firstName == ''){
				$firstNameError = true;
			}
			if($lastName == ''){
				$lastNameError = true;
			}
			if($street == ''){
				$streetError = true;
			}
			if($houseNumber == ''){
				$houseNumberError = true;
			}
			if($city == ''){
				$cityError = true;
			}
			if($phoneNumber == ''){
				$phoneNumberError = true;
			}
		}
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
		<a href="/phone-book/dodaj.php"><button class="page">Dodaj</button></a>
		<div id="volume">
			<p>Pojemność: <span id="busy"><?php echo $volume['count(Id)']; ?></span> / 50</p>	
			<div id="progress"></div>
		</div>
	</nav>
	<div id="container">
		<div class="errorWrapper">
			<?php 
			if($firstNameError || $lastNameError || $streetError || $houseNumberError || $cityError || $phoneNumberError){
			?>
			<p class="error"><span>Brakujące dane!</span></p>
			<?php
			}
		?>
		</div>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div id="defaultAdd">
				<input class="<?php if($firstNameError){ echo 'red'; } ?>" type="text" placeholder="Imię" name="firstName" value="<?php if(isset($firstName)){ echo $firstName; } ?>">
				<input class="<?php if($lastNameError){ echo 'red'; } ?>" type="text" placeholder="Nazwisko" name="lastName" value="<?php if(isset($lastName)){ echo $lastName; } ?>">
				<input class="<?php if($streetError){ echo 'red'; } ?>" type="text" placeholder="Ulica" name="street" value="<?php if(isset($street)){ echo $street; } ?>">
				<input class="<?php if($houseNumberError){ echo 'red'; } ?>" type="text" placeholder="Numer domu" name="houseNumber" value="<?php if(isset($houseNumber)){ echo $houseNumber; } ?>">
				<input type="text" placeholder="Numer mieszkania" name="apartmentNumber" value="<?php if(isset($apartmentNumber)){ echo $apartmentNumber; } ?>">
				<input class="<?php if($cityError){ echo 'red'; } ?>" type="text" placeholder="Miejscowość" name="city" value="<?php if(isset($city)){ echo $city; } ?>">
				<input class="<?php if($phoneNumberError){ echo 'red'; } ?>" type="text" placeholder="Numer telefonu" name="phoneNumber" value="<?php if(isset($phoneNumber)){ echo $phoneNumber; } ?>">
				<p>Jeżeli chcesz otrzymać powiadomienie, wpisz poniżej e-mail</p>
				<input type="text" placeholder="E-mail" name="email" value="<?php if(isset($email)){ echo $email; } ?>">
				<input class="send" type="submit" name="Add" value="Dodaj">
			</div>
		</form>
	</div>
</body>
</html>