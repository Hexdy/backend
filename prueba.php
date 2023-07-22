<?php

$rest = substr("abcdefghijk", 0, -1);

function datatype($variable, $tipo)
{
    if (gettype($variable) === $tipo) {
        echo "Es verdadero que la variable es de tipo $tipo <br>";
    } else {
        echo "No es verdadero que la variable es de tipo $tipo <br>";
    }
}

$var1 = 1;
$var2 = "algo";
$var3 = [$var1, $var2];
datatype($var1, "string");
datatype($var1, "array");
datatype($var2, "string");
datatype($var3, "array");
echo date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +15 day'));




#las peticiones se harán de forma que llegaran a los archivos definidos para cada parte, despues se enviaran a authentication.php para verificar que esten bien formados, de ahi los 
# redireccionará a la data, creando las llamadas o enviará un error si la autenticacion no fue correcta, entonces tendrémos 3 tipos de errores: error de escritura, error de contingencia y error de no encontrado
