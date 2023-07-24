<?php
include_once "Auth\authorization.php";

function shop_show_shop($token = "")
{
    global $ctl;
    show_shop($ctl, $token);
}
