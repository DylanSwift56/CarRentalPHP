<?php include('Header.php') ?>


<html>

<head>
<title>Update and Delete</title>

<style>

th, tr{
	padding: 5px;
}

table{
	margin:auto
}

</style>

</head>

<body>




<div class="container">
<?php

try { 
	$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', ''); 
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$sql = "SELECT * FROM cars";
	$result = $pdo->query($sql);
	
echo "<table border=3>";
echo "<tr><th>Registration</th>
<th>categoryID</th>
<th>status</th>
<th>fueltype</th>
<th>makemodelID</th>
<th>Passengers</th>
<th>Update</th>
<th>Delete</th>
</tr>";

while($row = $result->fetch()){
	echo "<tr><td>".$row['registration']."</td><td>".$row['categoryid']."</td><td>".$row['status']."</td><td>".$row['fueltype']."</td><td>".$row['makemodelid']."</td><td>".$row['passengers']."</td>";
	echo "<td><a href=\"carupdateform.php?registration=".$row['registration']."\">update</a>";
	echo "<td><a href=\"deleteform.php?registration=".$row['registration']."\">delete</a>";

}
}
catch (PDOException $e) { 
	$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(); 
}

?>
</div>

</body>
</html>
