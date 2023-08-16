<?php
    // conexion a la base de datos

    $servidor="localhost";
    $baseDeDatos="app";
    $usuario="root";
    $contrasenia="";

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
?>