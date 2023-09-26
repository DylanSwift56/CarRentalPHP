<?php
	session_start();
?>
<form action="AddCar.php" method="post">

Registration: <input type="text" name="registration">



	<?php
	
	try {

		$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', '');

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$query = 'SELECT makemodelid, make, model from makemodels';

		$result = $pdo->query($query);

		
		echo "<br>MakeModel: <select name='MakeModel'>";
		while($row = $result->fetch()){
				$makemodelid = $row["makemodelid"];
				$make = $row["make"];
				$model = $row["model"];
				
				echo"<option value=$makemodelid>". $makemodelid . "</option>";
			}
		echo "</select>";

		$query = 'SELECT categoryid, category from categories';

		$result = $pdo->query($query);
		
		?>
		<br>
		Category:
		<select name="categories">
		<?php
		while($row = $result->fetch()){
				$categoryid = $row["categoryid"];
				$category = $row["category"];
				
				echo"<option value=$categoryid>". $categoryid . "</option>";
			}
		echo "</select>";
		}
		catch (PDOException $e) {

		$output = 'Unable to connect to the database server: ' . $e->getMessage();

		echo $output;
		}
	?>
</select>

<br>

<!--Fuel Type: <input type="text" name="fueltype" ><br>-->


FuelType: 
<select name="fueltype">
	<option value="Petrol">Petrol</option>
	<option value="Diesel">Diesel</option>
	<option value="Electric">Electric</option>
	<option value="Hybrid">Hybrid</option>

</select><br>

Passengers: <input type="text" name="passengers" ><br>

