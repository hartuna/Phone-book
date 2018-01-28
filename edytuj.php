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
				$result1 = $connect->query('SELECT SecurityCode FROM Data WHERE Id = "' . $id . '"');
				$value = mysqli_fetch_array($result1);
				if($value['SecurityCode'] == $securityCode){
					$result = $connect->prepare('DELETE FROM Data WHERE Id = ' . $id);
					$result->execute();	
					$result->close();
					header('Location: /phone-book/edytuj.php');	
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
	else{
	?> 	
		<div class="verification">
			<p>Dane zostały usunięte</p>
		</div>
	<?php
	}
	?>
	</div>
	<?php
		include('footer.php'); 
	?>
