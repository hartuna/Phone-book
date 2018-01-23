<?php
	include('connect.php');	
	$result = $connect->query('SELECT count(Id) FROM Data');
	$volume = mysqli_fetch_array($result);
	if(isset($_POST['sendDefault'])){
		$active = 'default';
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		if(isset($_POST['firstName'])){
			if($firstName == ''){
				$firstNameError = true;
			}
			if($lastName == ''){
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
			if($street == ''){
				$streetError = true;
			}
			if($houseNumber == ''){
				$houseNumberError = true;
			}
			if($city == ''){
				$cityError = true;
			}
		}
	}
	else{
		$active = 'none';
	}
	include('header.php'); 
	?>
		<div id="searchWrapper">
			<div class="errorWrapper">
			<?php 
				if($firstNameError || $lastNameError){
					$defaultError = true;
				?>
				<p class="error"><span>Brakujące dane!</span></p>
				<?php
				}
			?>
			</div>
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				<div id="defaultSearch">
					<input class="<?php if($firstNameError){ echo 'red'; } ?>" type="text" placeholder="Imię" name="firstName" value="<?php if(isset($firstName)){ echo $firstName; } ?>">
					<input class="<?php if($lastNameError){ echo 'red'; } ?>" type="text" placeholder="Nazwisko" name="lastName" value="<?php if(isset($lastName)){ echo $lastName; } ?>">
					<input class="send" <?php if($active == 'alternative'){ echo 'id="noActive"'; } ?> type="submit" name="sendDefault" value="Szukaj">
				</div>
			</form>
			<button id="change">Zmień sposób wyszukiwania</button>
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
				<div class="errorWrapper">
				<?php 
					if($streetError || $houseNumberError || $cityError){
						$alternativeError = true;
					?>
					<p class="error"><span>Brakujące dane!</span></p>
					<?php
					}
				?>
				</div>
				<div id="alternativeSearch">
					<input class="<?php if($streetError){ echo 'red'; } ?>" type="text" placeholder="Ulica" name="street" value="<?php if(isset($street)){ echo $street; } ?>">
					<input class="<?php if($houseNumberError){ echo 'red'; } ?>" type="text" placeholder="Numer domu" name="houseNumber" value="<?php if(isset($houseNumber)){ echo $houseNumber; } ?>">
					<input type="text" placeholder="Numer mieszkania" name="apartmentNumber" value="<?php if(isset($apartmentNumber)){ echo $apartmentNumber; } ?>">
					<input class="<?php if($cityError){ echo 'red'; } ?>" type="text" placeholder="Miejscowość" name="city" value="<?php if(isset($city)){ echo $city; } ?>">
					<input class="send" <?php if($active == 'default' || $active == 'none'){ echo 'id="noActive"'; } ?> type="submit" name="sendAlternative" value="Szukaj">
				</div>
				</form>
			</div>	
	<?php
		if($active != 'none'){
			if(isset($_POST['sendDefault'])){ 
				$result = $connect->query('SELECT * FROM Data WHERE FirstName = "' . $firstName . '" AND LastName = "' . $lastName . '"');	
			}
			else{
				$result = $connect->query('SELECT * FROM Data WHERE Street = "' . $street . '" AND HouseNumber = "' . $houseNumber . '" AND ApartmentNumber = "' . $apartmentNumber . '" AND City = "' . $city . '"');
			}
			?>
			<h2>Wyniki zapytania</h2>
			<div id="resultWrapper">
				<?php
				$i = 0;
				while($value = mysqli_fetch_array($result)){
					$i++;
					?>
					<div class="result">
						<p><span>Imię:</span><?php echo $value['FirstName']; ?></p>
						<p><span>Nazwisko:</span><?php echo $value['LastName']; ?></p>
						<p><span>Ulica:</span><?php echo $value['Street']; ?></p>
						<p><span>Nr domu:</span><?php echo $value['HouseNumber']; ?></p>
						<p><span>Nr mieszkania:</span><?php echo $value['ApartmentNumber']; ?></p>
						<p><span>Miejscowość:</span><?php echo $value['City']; ?></p>
						<p><span>Nr telefonu:</span><?php echo $value['PhoneNumber']; ?></p>
					</div>
					<?php	
				}
				?>
			</div>
			<?php
			if($i != 0){ 
			?>
			<h2>Pozycja <span id="number">1</span>/<span id="numberMax"><?php echo $i ?></span></h2>
			<?php
			}
			if($i > 1){
			?>	
				<button class="pager">Poprzedni</button>
				<button class="pager">Kolejny</button>
				<?php
				}	
			}	
		?>
	</div>
	<?php
		include('footer.php'); 
	?>