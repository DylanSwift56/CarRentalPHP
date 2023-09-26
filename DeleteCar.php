<?php

include('Header.php');

try {

$pdo = new PDO('mysql:host=localhost;dbname=carrental; charset=utf8', 'root', '');

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "UPDATE CARS SET STATUS = 'R' WHERE registration = :id";

$result = $pdo->prepare($sql);

$result->bindValue(':id', $_POST['id']);

$result->execute();

echo "You just set the car with registration: " . $_POST['id'] ." as removed \n click<a href='DeleteForm.html'> here</a> to go back ";

}

catch (PDOException $e) {

if ($e->getCode() == 23000) {

echo "ooops couldnt delete as that record is linked to other tables click<a href='DeletForm.html'> here</a> to go back ";

}

} ?>