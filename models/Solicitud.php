<?php
require_once __DIR__ . "/../config/db.php";

class Solicitud
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = conectarDB();
    }

    // Evitar solicitudes dobrles
    public function existeActiva($usuarioId, $tallerId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT id FROM solicitudes
             WHERE usuario_id = ? AND taller_id = ? AND estado IN ('pendiente','aprobada')"
        );
        $stmt->execute([$usuarioId, $tallerId]);
        return $stmt->fetch() !== false;
    }

    public function crear($usuarioId, $tallerId)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO solicitudes (usuario_id, taller_id, estado) VALUES (?, ?, 'pendiente')"
        );
        return $stmt->execute([$usuarioId, $tallerId]);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM solicitudes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarPendientes()
    {
        $stmt = $this->pdo->query(
            "SELECT s.id, u.nombre AS usuario, t.nombre AS taller, s.estado
             FROM solicitudes s
             JOIN usuarios u ON u.id = s.usuario_id
             JOIN talleres t ON t.id = s.taller_id
             WHERE s.estado = 'pendiente'
             ORDER BY s.fecha ASC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorUsuario($usuarioId)
    {
        $stmt = $this->pdo->prepare(
            "SELECT s.id, t.nombre AS taller, s.estado
             FROM solicitudes s
             JOIN talleres t ON t.id = s.taller_id
             WHERE s.usuario_id = ?
             ORDER BY s.fecha DESC"
        );
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizarEstado($id, $estado)
    {
        $stmt = $this->pdo->prepare("UPDATE solicitudes SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }
}