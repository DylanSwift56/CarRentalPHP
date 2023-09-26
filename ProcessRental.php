<?php include('Header.php');?>


<html>

<head>
<title>Process Rental</title>
</head>

<body>

<h1>Add A Rental!</h1>

<form action="ProcessRental.php" method="post">

<?php 

try {

		$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', '');

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$query = "SELECT registration, cost from cars where status='A'";

		$result = $pdo->query($query);
		
		if(!isset($_POST['submitdetails'])){
			//initialise dates to current date if submit button not clicked
			$returndate = date("Y-m-d");
			$pickupdate = date("Y-m-d");
		}else{
			//retain selected dates after submit
			$pickupdate = $_POST['pickupdate'];
			$returndate = $_POST['returndate'];
		}

		echo "<br>Registration: <select name='registration'>";
		while($row = $result->fetch()){
			$registration = $row["registration"];
			echo"<option value=$registration>".$registration."</option>";
			}
		echo "</select>";
		
		$query = "SELECT clientid, clientname from clients";

		$result = $pdo->query($query);

		
		echo "<br>Client: <select name='client'>";
		while($row = $result->fetch()){
			$clientid = $row["clientid"];
			$clientname = $row['clientname'];
			echo"<option value=$clientid>".$clientid." ---  ".$clientname."</option>";
			}
		echo "</select>";
		
		
		
		echo "<br>Pick Up Date: ";
		//set min to todays date
		echo "<input type='date' name='pickupdate' value='".$pickupdate."' min='".date("Y-m-d")."'>";
		
		echo "<br>Return Date: ";
		
		
		
		//set min to todays date
		echo "<input type='date' name='returndate'value='".$returndate."' min='".date("Y-m-d")."'>";
		
		echo "<br><br><input type='submit' name='submitdetails' value='SUBMIT' >

			</form>

			</body>

			</html>";
		
		if(isset($_POST['submitdetails'])){
			if(isset($_POST['pickupdate']) && $_POST['pickupdate'] > 0){
				
				if(isset($_POST['returndate']) && $_POST['returndate']){
						$selectedpickupdate = date('Y-m-d', strtotime($_POST['pickupdate']));
						echo "<br>The pick up date you have selected is ".$pickupdate;
						
						$selectedreturndate = date('Y-m-d', strtotime($_POST['returndate']));
						echo "<br>The return date you have selected is ".$returndate;
					
					if($selectedreturndate > $selectedpickupdate){
						// taken from https://www.geeksforgeeks.org/program-to-find-the-number-of-days-between-two-dates-in-php/
						$diff =  strtotime($_POST['returndate']) - strtotime($_POST['pickupdate']);
						// 1 day = 24 hours
						// 24 * 60 * 60 = 86400 seconds
						$amountOfDays =  abs(round($diff / 86400));
						
						if(isset($_POST['registration'])){
							$query = "SELECT pickupdate, returndate from rentals where registration='".$_POST['registration']."'";

							$result = $pdo->query($query);
							
							while($row = $result->fetch()){
								$otherpickupdate = $row['pickupdate'];
								$otherreturndate = $row['returndate'];
								
								//to ensure rental dates dont overlap on the same car 
								//pick up date and return date must be entirely before or after other rentals
								if(($selectedpickupdate < $otherpickupdate && $selectedreturndate < $otherpickupdate) || ($selectedpickupdate > $otherreturndate && $selectedreturndate > $otherreturndate)){	
									continue;
								}
								else{
									echo "This car is unavailable for these dates please select other dates";
									return;
								}
								
								
							}
						}
						
						$cost = 0;
						
						//Get cost for selected registration
						$query = "SELECT cost from cars where registration='".$_POST['registration']."'";

						$result = $pdo->query($query);
						
						while($row = $result->fetch()){
							$carcost = (int) $row['cost'];
						}

						//calculates the cost of rental relative to amount of days chosen
						for($i = 0; $i < (int)$amountOfDays; $i++){
							$cost += $carcost;
						}
						
						$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', '');
				
						$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
						$sql = "INSERT INTO RENTALS(Registration, clientid, pickupdate, returndate, cost) values (:cregistration, :cclientid, :cpickupdate, :creturndate, :ccost)";
			
						$stmt = $pdo->prepare($sql);
				
						$stmt->bindvalue(':cregistration', $_POST['registration']);
				
				
						//Extract the id section from the client selectBox
						//Exit when a number is not found
						$clientid = "";
						for($i = 0; $i < strlen($_POST['client']); $i++){
							if(!is_numeric($_POST['client'][$i])){
								break;
							}
							$clientid.=$_POST['client'][$i];
						}
						$stmt->bindvalue(':cclientid', $clientid);
						
						$stmt->bindvalue(':cpickupdate', $selectedpickupdate);
				
						$stmt->bindvalue(':creturndate', $selectedreturndate);
						
						$stmt->bindvalue(':ccost', $cost);
						
						$stmt->execute();
						echo "operation succesful";
						
						echo "<br>The cost of this rental will be ".$cost;
					
						/*TO DO next
						Add functionality to make a car unavailable for dates it has been booked
						Select pickupdate and return date based on registration and check if there is an overlap
						*/
					}
					else{
						echo "<br>The return date must be after the pick up date";
						return;
					}
				}else{
					echo "<br>Please enter a valid return date";
					return;
				}
			}
			else{
				echo "<br>Please enter a valid pickupdate";
				return;
			}
		}
	}
	catch (PDOException $e) {

		$output = 'Unable to connect to the database server: ' . $e->getMessage();

		echo $output;
		}

?>


