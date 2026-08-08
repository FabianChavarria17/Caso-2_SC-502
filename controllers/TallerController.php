<?php
session_start();
require_once __DIR__ . "/../models/Taller.php";
header("Content-Type: application/json");

if (!isset($_SESSION["id"])) {
    http_response_code(401);
    echo json_encode(["ok" => false, "mensaje" => "Debe iniciar sesion"]);
    exit();
}

$tallerModel = new Taller();
echo json_encode(["ok" => true, "talleres" => $tallerModel->obtenerDisponibles()]);