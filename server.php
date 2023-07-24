<?php
include_once "Model/base.php";
include_once "Model/index.php";
include_once "Model/login.php";
include_once "Model/menu.php";
include_once "Model/register.php";
include_once "Model/shop.php";
header("Access-Control-Allow-Origin: http://localhost:8080");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['functionName'])) {
        $functionName = $_POST['functionName'];

        unset($_POST['functionName']);

        if (function_exists($functionName)) {
            $result = call_user_func_array($functionName, array_values($_POST));

            echo json_encode($result);
        } else {
            echo json_encode(['error' => 'La función no existe']);
        }
    } else {
        echo json_encode(['error' => 'Nombre de función no proporcionado']);
    }
}
