<?php
session_start();
require_once './vue/header.php';

if ($_SERVER['REQUEST_URI'] == '/debug'){
    require_once './vue/debug.php'; 

}

if ($_SERVER['REQUEST_URI'] == '/disconnect'){
    session_destroy();
    header('location:/');
}


if ($_SERVER['REQUEST_URI'] == '/connect'){
    require_once 'vue/connect.php'; 

}

if ($_SERVER['REQUEST_URI'] == '/'){
    require_once 'vue/acceuil.php'; 

}

if ($_SERVER['REQUEST_URI'] == '/memory') {
    require_once 'vue/game.php';

}

if ($_SERVER['REQUEST_URI'] == '/register') {
    require_once 'vue/register.php';
}


// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
