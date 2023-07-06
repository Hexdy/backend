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
function pabada($selection){
    GLOBAL $ctl;
if($_GET){
    $selection=$_GET['selection'];
}


switch ($selection){
    case 0:
        print_r($ctl->insert("tabla", ["algo loqúisimo"], ["algo"])->call());
        print_r($ctl->insert("tabla", ["algo loqúisimo posta"], ["algo"])->call());
        print_r($ctl->insert("tabla", ["algo loqúisimo posta que si"], ["algo"])->call());
        print_r($ctl->insert("tabla", ["algo normal"], ["algo"])->call());

        break;

        case 1:
            print_r($ctl->select("tabla", [2], ["id"], ["id", "algo"])->call());
            echo "<br>";
            print_r($ctl->select("tabla", [2], [], ["id", "algo"])->call());
        break;

        case 2:
            $respuesta=($ctl->delete("tabla", [2], ["id"])->call());
        break;
        
        case 3  :
            print_r($ctl->delete("tabla", [2], ["id"])->call());
        break;

        case 4:
            print_r($ctl->setQuery("SELECT * FROM tabla WHERE id>2")->call());
        break;
        }

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
?>
 