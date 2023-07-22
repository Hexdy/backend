<?php
include 'base.php';
$mysqli = new mysqli("localhost", "root", "", "prueba", 3306);

if ($mysqli->connect_errno) {
    echo "Hubo un fallo de conexion: " . $mysqli->connect_error;
    exit();
} else {
    echo "<h4 style='color:green;'>Se conecto correctamente.</h4>";
}
$ctl = new QueryCall($mysqli);


function session($token)
{
    global $ctl;

    $id = ($ctl->select("inicia", [$token], ["sesion_token"], ["id"])->call())[0];

    if ($id) {
        $nombre_completo = ($ctl->select("web", [$id], ["id"], ["primer_nombre", "primer_apellido"])->call());
    }

    return $nombre_completo;
}

/*EJEMPLOS:

Usando el formato para select:
    print_r($ctl->insert("tabla", ["algo loqúisimo"], ["algo"])->call());

    print_r($ctl->select("tabla", [2], ["id"], ["id", "algo"])->call());
        Resumen: (α∈D): ∀ δ, n = δ -> ∀ δ[n] ∃ γ[n]

    print_r($ctl->update("tabla", [1, "algo cambiado"], ["id"], ["id", "algo"])->call());

    print_r($ctl->delete("tabla", [2], ["id"])->call());

    print_r($ctl->setQuery("SELECT * FROM tabla WHERE id>2")->call());

*/