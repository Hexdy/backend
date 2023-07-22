<?php
include "../data/database_model.php";
function datatype($var, $type)
{
    return gettype($var) === $type;
}
function session($ctl, $token)
{
    if (!datatype($token, "string")) {
        return "400, BAD REQUEST: Wrong data type";
    }
    $query = "SELECT sesion.final_de_sesion,
                sesion.estado,
                web.primer_nombre, 
                web.primer_apellido
                FROM inicia
                JOIN sesion ON inicia.sesion_token = sesion.token
                JOIN web ON inicia.cliente_id = web.cliente_id
                WHERE inicia.sesion_token = '$token';
            ";

    $response = $ctl->setQuery($query)->call();

    if (!datatype($response, "array")) {

        return "500, INTERNAL SERVER ERROR: $response";
    } else {

        $actualDate = date('Y-m-d H:i:s');

        $dbDate = $response[0];

        if ($actualDate <= $dbDate) {
            $newDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' +15 minutes'));

            $ctl->update("sesion", [$token, $actualDate, $newDate], ["token"], ["token", "ultima_sesion", "final_de_sesion"])->call();
            return [True, $response[2], $response[3]];
        } else {

            $ctl->update("sesion", [$token, "Finalizada"], ["token"], ["token", "estado"])->call();
            return [False];
        }
    }
}
