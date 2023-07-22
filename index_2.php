<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<form action="">
    <select name="selection" id="selection">
        <option value="5">Ninguno  </option>
        <option value ="0">insert</option>
        <option value ="1">select</option>
        <option value ="2">update</option>
        <option value ="3">delete</option>
        <option value ="4">custom</option>
    </select>
    <button type="submit" name="submit" value="submit"> boton</button>
</form>
<p id="container"></p>
<body>

</body>

</html>

<?php
include('index.php');
if($_GET){
$selection = $_GET['selection'];
echo "El valor elegido es: ",$selection;
pabada($selection);
}
?>