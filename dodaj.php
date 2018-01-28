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
		$securityCode = $_POST['securityCode'];
		if($firstName != '' && $lastName != '' && $street != '' && $houseNumber != '' && $city != '' && $phoneNumber != '' && $securityCode != ''){
			if(preg_match('#[a-zA-Z]#', $phoneNumber)){
				$validateNumberError = 'Błędny numer telefonu';
			}
			else if(!is_numeric($securityCode) || $securityCode < 0 || $securityCode > 999999){
				$validateSecurityCodeError = 'Błędny kod zabezpieczający';
			}
			else if(!preg_match('#(.*)\@(.*)\.(.*)#', $email)){
				$validateEmailError = 'Błędny e-mail';
			}
			
			else{
				if($volume['count(Id)'] >= 50){
					$result = $connect->prepare('DELETE FROM Data WHERE Id > 10');
					$result->execute();	
					$result->close();
				}
				$result = $connect->prepare('INSERT Data (FirstName, LastName, Street, HouseNumber, ApartmentNumber, City, PhoneNumber, SecurityCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');	
				$result->bind_param('sssssssi', $firstName, $lastName, $street, $houseNumber, $apartmentNumber, $city, $phoneNumber, $securityCode);
				$result->execute();
				$result->close();
				if($email != ''){
					mail($email, 'Dodanie wpisu', 'Dziękuję za skorzystanie z mojego formularza. Dane zostaną automatycznie usunięte gdy w bazie znajdzie się 50 pozycji.');
				}	
				header('Location: /phone-book/dodaj.php');	
			}			
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
			if($securityCode == ''){
				$securityCodeError = true;
			}
		}
	}
	include('header.php');
	?> 
		<div class="errorWrapper">
			<?php
				if($firstNameError || $lastNameError || $streetError || $houseNumberError || $cityError || $phoneNumberError || $securityCodeError){
				?><p class="error"><span><?php echo 'Brakujące dane'; ?></span></p><?php
				}
				else if($validateNumberError){
				?><p class="error"><span><?php echo $validateNumberError; ?></span></p><?php
				}
				else if($validateSecurityCodeError){
				?><p class="error"><span><?php echo $validateSecurityCodeError; ?></span></p><?php	
				}
				else if($validateEmailError){
				?><p class="error"><span><?php echo $validateEmailError; ?></span></p><?php	
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
				<input class="<?php if($phoneNumberError || $validateNumberError){ echo 'red'; } ?>" type="text" placeholder="Numer telefonu" name="phoneNumber" value="<?php if(isset($phoneNumber)){ echo $phoneNumber; } ?>">
				<p>Kod zabezpieczający może mieć maksymalnie 6 cyfr (zalecane)</p>
				<input class="<?php if($securityCodeError || $validateSecurityCodeError){ echo 'red'; } ?>" type="text" placeholder="Kod zabezpieczający" name="securityCode" value="<?php if(isset($securityCode)){ echo $securityCode; } ?>">
				<p>Jeżeli chcesz otrzymać powiadomienie, wpisz poniżej e-mail</p>
				<input class="<?php if($validateEmailError){ echo 'red'; } ?>" type="text" placeholder="E-mail" name="email" value="<?php if(isset($email)){ echo $email; } ?>">
				<input class="send" type="submit" name="Add" value="Dodaj">
			</div>
		</form>
	</div>
	<?php
		include('footer.php'); 
	?>