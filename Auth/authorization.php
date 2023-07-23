<?php
include "../Data/database_model.php";

function datatype($var, $type)
{
    return gettype($var) === $type;
}

function session($ctl, $token)
{
    if (isset($ctl, $token)) {
        return "400, BAD REQUEST: Wrong data type";
    } elseif (!datatype($token, "string")) {
        return "400, BAD REQUEST: Wrong data type";
    } elseif (strlen($token) > 15 && strlen($token) < 8) {
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

    if (!datatype($response, "array") & count($response) > 0) {

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

function register_web_first(QueryCall $ctl, $first_name, $first_surname, $doc_type, $doc, $mail, $password)
{
    $values = func_get_args();

    unset($values[0]);

    $length_verificator = True;

    $maximum = [30, 30, 20, 11, 40, 40];

    foreach ($values as $index => $var) {
        $length_verificator = $length_verificator && (strlen(strval($var)) <= $maximum[$index]);
    }

    $length_verificator = $length_verificator && (strlen(strval($password)) >= 6) && (strlen(strval($mail) >= 6));

    unset($values[4]);

    $type_verificator = True;

    foreach ($values as $var) {
        $type_verificator = $type_verificator && datatype($var, "string");
    }
    $type_verificator = $type_verificator && is_int($doc);

    if (isset($ctl, $first_name, $first_surname, $doc_type, $doc, $mail, $password)) {
        return "400, BAD REQUEST: Wrong data type";
    } elseif ($type_verificator) {
        return "400, BAD REQUEST: Wrong data type";
    } elseif ($length_verificator) {
        return "400, BAD REQUEST: Wrong data type";
    }

    $existence_verificator_doc = empty($ctl->select("web", ["cliente_id"], [$doc_type, $doc], ["tipo", "numero"])->call());
    $existence_verificator_mail = empty($ctl->select("cliente", ["email"], [$mail], ["email"])->call());

    if ($existence_verificator_doc) {
        return "409, CONFLICT: This client already exists";
    } else if ($existence_verificator_mail) {
        return "409, CONFLICT: This Email is already in use";
    }

    if ($ctl->insert("cliente", [$mail, $password], ["email", "contrasenia"])->call() === ["OK", 200]) {
        $id = $ctl->select("cliente", ["id"], [$mail], ["email"])->call();
        return $ctl->insert("web", [$id[0], $first_name, $first_surname, $doc_type, $doc, "En espera"], ["cliente_id", "primer_nombre", "primer_apellido", "tipo", "numero", "autorizacion"])->call();
    }
}

function register_web_second(QueryCall $ctl, $token, $second_name, $second_surname, $street, $neighborhood, $city)
{
    $values = func_get_args();

    unset($values[0]);

    $length_verificator = True;

    foreach ($values as $var) {
        $length_verificator = $length_verificator && (strlen(strval($var)) <= 30) && (strlen(strval($var)) >= 2);
    }

    $type_verificator = True;

    foreach ($values as $var) {
        $type_verificator = $type_verificator && datatype($var, "string");
    }

    if (isset($ctl, $second_name, $second_surname, $street, $neighborhood, $city)) {
        return "400, BAD REQUEST: Wrong data type";
    } elseif ($type_verificator) {
        return "400, BAD REQUEST: Wrong data type";
    } elseif ($length_verificator) {
        return "400, BAD REQUEST: Wrong data type";
    }

    $user = session($ctl, $token);
    if ($user[0]) {
        return $ctl->update("web", [$user[2], $second_name, $second_surname], ["primer_nombre"], ["primer_nombre", "segundo_nombre", "segundo_apellido"])->call();
    } else {
        return "401, UNAUTHORIZED: The session expired";
    }
}
