<?php
include "../Auth/authorization.php";
$mysqli = new mysqli("localhost", "root", "", "prueba", 3306);

if ($mysqli->connect_errno) {
    echo "Hubo un fallo de conexion: " . $mysqli->connect_error;
    exit();
} else {
    echo "<h4 style='color:green;'>Se conecto correctamente.</h4>";
}
$ctl = new QueryCall($mysqli);

function base_session($token)
{
    return session($token);
}
