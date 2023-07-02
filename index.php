<?php
include 'database_model.php';
$mysqli = new mysqli("localhost", "root", "", "prueba", 3306);

if ($mysqli->connect_errno) {
    echo "Hubo un fallo de conexion: " . $mysqli->connect_error;
    exit();
} else {
    echo "<h4 style='color:green;'>Se conecto correctamente.</h4>";
}
$ctl = new QueryCall($mysqli);

/*EJEMPLOS:

Usando el formato para select:
    print_r($ctl->select("tabla", [2], ["id"], ["id", "algo"])->call());
        Resumen: 

    print_r($ctl->insert("tabla", ["algo loqúisimo"], ["algo"])->call());

    print_r($ctl->update("tabla", [1, "algo cambiado"], ["id"], ["id", "algo"])->call());

    print_r($ctl->delete("tabla", [2], ["id"])->call());

    print_r($ctl->setQuery("SELECT * FROM tabla WHERE id>2")->call());

*/