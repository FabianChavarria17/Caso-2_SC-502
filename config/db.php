<?php
//Conexion a la base de datos, recordar cambiar credenciales
function conectarDB()
{
    $host = "localhost";
    $dbname = "caso2";
    $user = "root";
    $pass = "admin";

    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $user,
            $pass
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die(json_encode(["ok" => false, "mensaje" => "Error de conexion a la base de datos"]));
    }
}