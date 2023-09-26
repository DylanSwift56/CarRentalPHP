<?php try {

$pdo = new PDO('mysql:host=localhost;dbname=CarRental; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = 'SELECT * from cars;';

$result = $pdo->query($query);
?>

<form action="SelectCar.php" method="POST">

<?php

echo "select a Car: "; 
	echo("<select name='cars'>");

while($row = $result->fetch()){
		$rowName =  $row['registration']." - ".$row['status']." - ".$row['fueltype']." - ".$row['categoryid']." - ".$row['makemodelid']." - ".$row['passengers'];
	
?>

<option value="<?php  echo $rowName?>" >
<?php echo $rowName ?>
</option>
<?php

}

echo "</select>";

echo "</form>";

}
catch (PDOException $e) {

$output = 'Unable to connect to the database server: ' . $e->getMessage();

echo $output;

}

?>