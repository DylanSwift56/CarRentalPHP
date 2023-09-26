<?php

include('Header.php');

try { 
$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', ''); 
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'update cars set status=:cstatus,fueltype = :cfueltype,categoryid = :ccategoryid, makemodelid = :cmakemodelid, passengers = :cpassengers WHERE registration = :creg';
$result = $pdo->prepare($sql);
$result->bindValue(':creg', $_POST['ud_registration']); 
$result->bindValue(':cstatus', $_POST['ud_status']); 
$result->bindValue(':cfueltype', $_POST['ud_fueltype']);
$result->bindValue(':ccategoryid', $_POST['ud_categoryid']); 
$result->bindValue(':cmakemodelid', $_POST['ud_makemodelid']); 
$result->bindValue(':cpassengers', $_POST['ud_passengers']);  

$result->execute();
     
 
$count = $result->rowCount();
if ($count > 0)
{
echo "You just updated A car with registration: " . $_POST['ud_registration'] ."  click<a href='UpdateAndDelete.php'> here</a> to go back ";
}
else
{
echo "nothing updated";
}
}
 
catch (PDOException $e) { 

$output = 'Unable to process query sorry : ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(); 

}
?>