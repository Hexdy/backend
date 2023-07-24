<?php
include_once "Auth\authorization.php";
function login_login($mail, $passwd, $token = "")
{
    global $ctl;
    return login($ctl, $mail, $passwd, $token);
}
