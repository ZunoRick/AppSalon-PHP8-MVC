<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo): bool{
    return ($actual !== $proximo) ? true : false;
}

//Función que revisa que el usuario esté autenticado
function isAuth() : void{
    if(!isset($_SESSION['login'])){
        header('Location: /');
    }
}

//Función que revisa que el usuario sea el administrador
function isAdmin() : void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}