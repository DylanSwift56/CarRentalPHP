<?php include('Header.php');?>

<!DOCTYPE html>

<html lang='cs'>

<head>

<title></title>

<meta charset='utf-8'>

</head>

<body>

<h1> Delete Car </h1>

<form action="SelectCarToDelete.php" method="post">

Registration: <input type="text" name="reg" value="<?php if (isset($_GET['registration'])) echo $_GET['registration']; ?>"><br>

<input type="submit" name="submitdetails" value="SUBMIT" >

</form>

</body>

</html>