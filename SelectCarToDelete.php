<?php

include('Header.php');

if (isset($_POST['submitdetails'])) {

try {

$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT count(*) FROM cars where registration = :reg';

$result = $pdo->prepare($sql);

$result->bindValue(':reg', $_POST['reg']);

$result->execute();

if($result->fetchColumn() > 0)

{

$sql = 'SELECT * FROM cars where registration = :reg';

$result = $pdo->prepare($sql);

$result->bindValue(':reg', $_POST['reg']);

$result->execute();

while ($row = $result->fetch()) {

echo $row['registration'] . ' Are you sure you want to delete ??' .

'<form action="DeleteCar.php" method="post">

<input type="hidden" name="id" value="'.$row['registration'].'">

<input type="submit" value="Delete" name="delete">

</form>';

}
}

else {

print "No rows matched the query.";

}}

catch (PDOException $e) {

$output = 'Unable to connect to the database server: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

}

}

?>
