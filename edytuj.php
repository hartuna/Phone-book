<?php
	include('connect.php');	
	$result = $connect->query('SELECT count(Id) FROM Data');
	$volume = mysqli_fetch_array($result);
	$id = $_POST['id'];
	include('header.php');
	if(isset($_POST['delete']) || isset($_POST['deletePosition'])){
		if(isset($_POST['deletePosition'])){
			$securityCode = $_POST['securityCode'];
			if($securityCode != ''){
				$result = $connect->query('SELECT SecurityCode FROM Data WHERE Id = "' . $id . '"');
				$value = mysqli_fetch_array($result);
				if($value['SecurityCode'] == $securityCode){
					if($id <= 10){
						$hackError = 'Proba edycji stałego rekordu - blokada';
					}
					else{
						$result = $connect->prepare('DELETE FROM Data WHERE Id = ' . $id);
						$result->execute();	
						$result->close();
						header('Location: /phone-book/edytuj.php');		
					}
				}
				else{
					$validateSecurityCodeError = 'Błędny kod zabezpieczający';
				}
			}
			else{
				$securityCodeError = true;	
			}
		}
	?> 
		<div class="errorWrapper">
		<?php
			if($securityCodeError){
			?><p class="error"><span><?php echo 'Brakujące dane'; ?></span></p><?php
			}
			else if($hackError){
			?><p class="error"><span><?php echo $hackError; ?></span></p><?php
			}
			else if($validateSecurityCodeError){
			?><p class="error"><span><?php echo $validateSecurityCodeError; ?></span></p><?php
			}
		?>	
		</div>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div id="defaultDelete">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<input class="<?php if($securityCodeError){ echo 'red'; } ?>" type="text" placeholder="Kod zabezpieczający" name="securityCode" value="<?php if(isset($securityCode)){ echo $securityCode; } ?>">
				<input class="send" type="submit" name="deletePosition" value="Usuń">
			</div>
		</form>
	<?php	
	}
	else if(isset($_POST['edit']) || isset($_POST['editPosition'])){
		if(isset($_POST['edit'])){
			$result = $connect->query('SELECT * FROM Data WHERE Id = "' . $id . '"');
			$value = mysqli_fetch_array($result);	
			$firstName = $value['FirstName'];
			$lastName = $value['LastName'];
			$street = $value['Street'];
			$houseNumber = $value['HouseNumber'];
			$apartmentNumber = $value['ApartmentNumber'];
			$city = $value['City'];	
			$phoneNumber = $value['PhoneNumber'];
		}
		else if(isset($_POST['editPosition'])){
			$securityCode = $_POST['securityCode'];
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$street = $_POST['street'];
			$houseNumber = $_POST['houseNumber'];
			$apartmentNumber = $_POST['apartmentNumber'];
			$city = $_POST['city'];	
			$phoneNumber = $_POST['phoneNumber'];
			if($firstName != '' && $lastName != '' && $street != '' && $houseNumber != '' && $city != '' && $phoneNumber != '' && $securityCode != ''){
				if(preg_match('#[a-zA-Z]#', $phoneNumber)){
					$validateNumberError = 'Błędny numer telefonu';
				}
				else{
					$result = $connect->query('SELECT SecurityCode FROM Data WHERE Id = "' . $id . '"');
					$value = mysqli_fetch_array($result);
					if(strlen($phoneNumber) > 12 || strlen($houseNumber) > 20 || strlen($apartmentNumber) > 20 || strlen($firstName) > 100 || strlen($lastName) > 100 || strlen($street) > 100 || strlen($city) > 100){
						$validateLength = 'Przekroczono maksymalną ilość znaków';
					}
					else if($value['SecurityCode'] == $securityCode){
						if($id <= 10){
							$hackError = 'Proba edycji stałego rekordu - blokada';
						}
						else{
							$result = $connect->prepare('UPDATE Data SET FirstName = "' . $firstName . '", LastName = "' . $lastName . '", Street = "' . $street . '", HouseNumber = "' . $houseNumber . '", ApartmentNumber = "' . $apartmentNumber . '", City = "' . $city . '", PhoneNumber = "' . $phoneNumber . '" WHERE Id = "' . $id . '"');	
							$result->execute();
							$result->close();
							header('Location: /phone-book/edytuj.php');		
						}
					}
					else{
						$validateSecurityCodeError = 'Błędny kod zabezpieczający';
					}
				}
			}
			else{
				if($securityCode == ''){
					$securityCodeError = true;
				}
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
		<div class="errorWrapper">
		<?php
			if($securityCodeError || $firstNameError || $lastNameError || $streetError || $houseNumberError || $cityError || $phoneNumberError){
			?><p class="error"><span><?php echo 'Brakujące dane'; ?></span></p><?php
			}
			else if($validateLength){
			?><p class="error"><span><?php echo $validateLength; ?></span></p><?php
			}
			else if($validateNumberError){
			?><p class="error"><span><?php echo $validateNumberError; ?></span></p><?php
			}
			else if($hackError){
			?><p class="error"><span><?php echo $hackError; ?></span></p><?php
			}
			else if($validateSecurityCodeError){
			?><p class="error"><span><?php echo $validateSecurityCodeError; ?></span></p><?php	
			}
		?>	
		</div>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
			<div id="defaultEdit">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
				<input class="<?php if($securityCodeError){ echo 'red'; } ?>" type="text" placeholder="Kod zabezpieczający" name="securityCode" value="<?php if(isset($securityCode)){ echo $securityCode; } ?>">
				<p>Imię</p>
				<input class="<?php if($firstNameError){ echo 'red'; } ?>" type="text" name="firstName" value="<?php if(isset($firstName)){ echo $firstName; } ?>">
				<p>Nazwisko</p>
				<input class="<?php if($lastNameError){ echo 'red'; } ?>" type="text" name="lastName" value="<?php if(isset($lastName)){ echo $lastName; } ?>">
				<p>Ulica</p>
				<input class="<?php if($streetError){ echo 'red'; } ?>" type="text" name="street" value="<?php if(isset($street)){ echo $street; } ?>">
				<p>Numer domu</p>
				<input class="<?php if($houseNumberError){ echo 'red'; } ?>" type="text" name="houseNumber" value="<?php if(isset($houseNumber)){ echo $houseNumber; } ?>">
				<p>Numer mieszkania</p>
				<input type="text" name="apartmentNumber" value="<?php if(isset($apartmentNumber)){ echo $apartmentNumber; } ?>">
				<p>Miejscowość</p>
				<input class="<?php if($cityError){ echo 'red'; } ?>" type="text" placeholder="Miejscowość" name="city" value="<?php if(isset($city)){ echo $city; } ?>">
				<p>Numer telefonu</p>
				<input class="<?php if($phoneNumberError || $validateNumberError){ echo 'red'; } ?>" type="text" name="phoneNumber" value="<?php if(isset($phoneNumber)){ echo $phoneNumber; } ?>">
				<input class="send" type="submit" name="editPosition" value="Edytuj">
			</div>
		</form>
	<?php
	}
	else{
	?> 	
		<div class="verification">
			<p>Zmiany w bazie zostały zapisane</p>
			<p>Powrót do strony głównej za <span id="time">6</span></p>
		</div>
	<?php
	}
	?>
	</div>
	<?php
		include('footer.php'); 
	?>
