
<?php
include 'Header.php';
include 'AddCarForm.php';

if (isset($_POST['submitdetails'])){
	
	try{
		$registration = $_POST['registration'];
		$status = "A";
		$fueltype = $_POST['fueltype'];
		$passengers = $_POST['passengers'];
		
		
			if(empty($_POST['categories'])){
				echo "<br>Category Is Empty";
			}
			if(empty($_POST['MakeModel'])){
				echo "<br>MakeModel is empty";
			}
			//if(empty($_POST['status'])){
				//echo "<br>status is empty<br>";
			//}
			if($_POST['registration'] == '')
				echo "<br>Please enter a registration";
			if($_POST['fueltype'] == '')
				echo "<br>Please enter a fueltype";
			if($_POST['passengers'] == '')
				echo "<br>Please enter a registration";

			else{
				$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', '');
				
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
				$sql = "INSERT INTO cars(registration, status, fueltype, categoryid, makemodelid, passengers, cost) values (:cregistration, :cstatus, :cfueltype, :ccategoryid, :cmakemodelid, :cpassengers, :ccost)";
			
				
				echo "The registration you selected is ".$_POST['registration']."<br>";
				echo "The status you selected is ".$status."<br>";
				echo "The categoryid you selected is ".$_POST['categories']."<br>";
				echo "The makemodelid you selected is ".$_POST['MakeModel']."<br>";
				echo "The fueltype you selected is ".$_POST['fueltype']."<br>";
				echo "The passengers you selected is ".$_POST['passengers']."<br>";
			
				$stmt = $pdo->prepare($sql);
				
				$stmt->bindvalue(':cregistration', $_POST['registration']);
				
				$stmt->bindvalue(':cstatus', $status);
				
				$stmt->bindvalue(':cfueltype', $_POST['fueltype']);
				
				$stmt->bindvalue(':ccategoryid', $_POST['categories']);
				$stmt->bindvalue(':cmakemodelid', $_POST['MakeModel']);
				
				$stmt->bindvalue(':cpassengers', $_POST['passengers']);

				//Set cost proportionate to category
				if($_POST['categories'] == '1'){
					$stmt->bindvalue(':ccost', '50');
				}
				else if($_POST['categories'] == '2'){
					$stmt->bindvalue(':ccost', '100');
				}
				else{
					$stmt->bindvalue(':ccost', '150');
				}
				
				$stmt->execute();
				echo "operation succesful";
		}
	}
	catch(PDOException $e){
		$title = 'Error connecting to database';
		$output = $e->getMessage();
		
	}
	
}

?>

<input type="submit" name="submitdetails" value="SUBMIT" >

</form>

</body>

</html>