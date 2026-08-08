<?php
session_start();
require_once __DIR__ . "/../models/Solicitud.php";
require_once __DIR__ . "/../models/Taller.php";
header("Content-Type: application/json");

if (!isset($_SESSION["id"])) {
    http_response_code(401);
    echo json_encode(["ok" => false, "mensaje" => "Debe iniciar sesion"]);
    exit();
}

$accion = $_GET["accion"] ?? "";
$datos = json_decode(file_get_contents("php://input"), true);
$solicitudModel = new Solicitud();
$tallerModel = new Taller();

switch ($accion) {

    // Usuario una solicita inscripcion
    case "solicitar":
        if ($_SESSION["rol"] != "usuario") {
            echo json_encode(["ok" => false, "mensaje" => "Accion no permitida"]);
            exit();
        }
        $tallerId = $datos["taller_id"] ?? null;
        $taller = $tallerId ? $tallerModel->obtenerPorId($tallerId) : null;

        if (!$taller || $taller["cupo"] <= 0) {
            echo json_encode(["ok" => false, "mensaje" => "El taller no tiene cupos disponibles"]);
            exit();
        }
        if ($solicitudModel->existeActiva($_SESSION["id"], $tallerId)) {
            echo json_encode(["ok" => false, "mensaje" => "Ya tiene una solicitud activa o aprobada para este taller"]);
            exit();
        }
        $solicitudModel->crear($_SESSION["id"], $tallerId);
        echo json_encode(["ok" => true, "mensaje" => "Solicitud enviada correctamente"]);
        break;

    // ver solictudes propias del usuario
    case "mis":
        echo json_encode(["ok" => true, "solicitudes" => $solicitudModel->listarPorUsuario($_SESSION["id"])]);
        break;

    // Admin ve solictudes pendientes
    case "pendientes":
        if ($_SESSION["rol"] != "admin") {
            echo json_encode(["ok" => false, "mensaje" => "Accion no permitida"]);
            exit();
        }
        echo json_encode(["ok" => true, "solicitudes" => $solicitudModel->listarPendientes()]);
        break;

    // Admin aprueba
    case "aprobar":
        if ($_SESSION["rol"] != "admin") {
            echo json_encode(["ok" => false, "mensaje" => "Accion no permitida"]);
            exit();
        }
        $id = $datos["id"] ?? null;
        $solicitud = $id ? $solicitudModel->obtenerPorId($id) : null;

        if (!$solicitud || $solicitud["estado"] != "pendiente") {
            echo json_encode(["ok" => false, "mensaje" => "La solicitud ya fue procesada"]);
            exit();
        }
        if (!$tallerModel->descontarCupo($solicitud["taller_id"])) {
            echo json_encode(["ok" => false, "mensaje" => "Ya no hay cupo disponible para este taller"]);
            exit();
        }
        $solicitudModel->actualizarEstado($id, "aprobada");
        echo json_encode(["ok" => true, "mensaje" => "Solicitud aprobada"]);
        break;

    // Admin rechaza
    case "rechazar":
        if ($_SESSION["rol"] != "admin") {
            echo json_encode(["ok" => false, "mensaje" => "Accion no permitida"]);
            exit();
        }
        $id = $datos["id"] ?? null;
        $solicitud = $id ? $solicitudModel->obtenerPorId($id) : null;

        if (!$solicitud || $solicitud["estado"] != "pendiente") {
            echo json_encode(["ok" => false, "mensaje" => "La solicitud ya fue procesada"]);
            exit();
        }
        $solicitudModel->actualizarEstado($id, "rechazada");
        echo json_encode(["ok" => true, "mensaje" => "Solicitud rechazada"]);
        break;

    default:
        echo json_encode(["ok" => false, "mensaje" => "Accion no valida"]);
}