<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include("calculaCentroPoligono.php"); // Inclui o arquivo com o sistema de segurança
	?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
</head>

<body>



<div class="form-group">

<form action="" method="post">

<label for="pos1">Posição 1:</label>
   <input name="pos1" type="text" class="form-control"/>
<label for="pos2">Posição 2:</label>
	<input name="pos2" type="text" class="form-control"/>
<label for="pos2">Posição 3:</label>
	<input name="pos3" type="text" class="form-control"/>
<label for="pos2">Posição 3:</label>
	<input name="pos4" type="text" class="form-control" />
	
	<input name="submit" type="submit" />
</form>

</div>

<?php
  if (isset($_POST['submit'])) {
    $pos1 = $_POST['pos1'];
    $pos2 = $_POST['pos2'];
	$pos3 = $_POST['pos3'];
    $pos4 = $_POST['pos4'];

	$arrayPosicoes = array($pos1, $pos2, $pos3, $pos4);
	
	echo "</br>";
	print_r($arrayPosicoes);
	
	$result = GetCenterFromDegrees($arrayPosicoes);
	
	echo "</br>";
	echo "</br>";
	echo "CENTRO: ";

	print_r( $result);
	
  }
?>

</body>

</html>