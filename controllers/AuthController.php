<?php
session_start();
require_once __DIR__ . "/../models/Usuario.php";
header("Content-Type: application/json");

$accion = $_GET["accion"] ?? "";
$datos = json_decode(file_get_contents("php://input"), true);
$usuarioModel = new Usuario();

if ($accion == "login") {
    $correo = $datos["correo"] ?? "";
    $password = $datos["password"] ?? "";

    $usuario = $usuarioModel->validarLogin($correo, $password);
    if ($usuario) {
        $_SESSION["id"] = $usuario["id"];
        $_SESSION["nombre"] = $usuario["nombre"];
        $_SESSION["rol"] = $usuario["rol"];
        echo json_encode(["ok" => true, "rol" => $usuario["rol"]]);
    } else {
        echo json_encode(["ok" => false, "mensaje" => "Correo o contrasena incorrectos"]);
    }
} elseif ($accion == "registro") {
    $nombre = trim($datos["nombre"] ?? "");
    $correo = trim($datos["correo"] ?? "");
    $password = $datos["password"] ?? "";

    if ($nombre === "" || $correo === "" || $password === "") {
        echo json_encode(["ok" => false, "mensaje" => "Todos los campos son obligatorios"]);
        exit();
    }
    if ($usuarioModel->buscarPorCorreo($correo)) {
        echo json_encode(["ok" => false, "mensaje" => "Ese correo ya esta registrado"]);
        exit();
    }
    $usuarioModel->crear($nombre, $correo, $password, "usuario");
    echo json_encode(["ok" => true, "mensaje" => "Registro exitoso, ya puede iniciar sesion"]);
} else {
    echo json_encode(["ok" => false, "mensaje" => "Accion no valida"]);
}