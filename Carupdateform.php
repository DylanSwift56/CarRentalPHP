<?php
include 'Header.php';
try { 
$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', ''); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql="SELECT count(*) FROM cars WHERE registration=:reg";

$result = $pdo->prepare($sql);
$result->bindValue(':reg', $_GET['registration']); 
$result->execute();
if($result->fetchColumn() > 0) 
{
    $sql = 'SELECT * FROM cars where registration = :reg';
    $result = $pdo->prepare($sql);
    $result->bindValue(':reg', $_GET['registration']); 
    $result->execute();

    $row = $result->fetch() ;
    $reg = $row['registration'];
	$status = $row['status'];
	$fueltype = $row['fueltype'];
	$categoryid = $row['categoryid'];
	$makemodelid = $row['makemodelid'];
	$passengers = $row['passengers'];
   
}

else {
      print "No rows matched the query. try again click<a href='selectupdate.php'> here</a> to go back";
    }} 
catch (PDOException $e) { 
$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(); 
}

?>



<form action="carupdated.php" method="post">

<p>Registration is <?php if (isset($reg)) echo $reg; ?></p>

<input type="hidden" type="text" name="ud_registration" value="<?php if (isset($reg)) echo $reg; ?>"><br>
Status: <input type="text" name="ud_status" value="<?php if (isset($status)) echo $status; ?>"><br>
Fuel Type: <input type="text" name="ud_fueltype" value="<?php if (isset($fueltype)) echo $fueltype; ?>"><br>
Category ID: <input type="text" name="ud_categoryid" value="<?php if (isset($categoryid)) echo $categoryid; ?>"><br>
MakeModelID: <input type="text" name="ud_makemodelid" value="<?php if (isset($makemodelid)) echo $makemodelid; ?>"><br>
Passengers: <input type="text" name="ud_passengers" value="<?php if (isset($passengers)) echo $passengers; ?>"><br>


<input type="Submit" value="Update">
</form>
</body>

</html>