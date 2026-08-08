<?php
require_once __DIR__ . "/../config/db.php";

class Taller
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = conectarDB();
    }

    // Muestra talleres disponibls
    public function obtenerDisponibles()
    {
        $stmt = $this->pdo->query("SELECT * FROM talleres WHERE cupo > 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM talleres WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Evita talleres en 0
    public function descontarCupo($id)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE talleres SET cupo = cupo - 1 WHERE id = ? AND cupo > 0"
        );
        $stmt->execute([$id]);
        return $stmt->rowCount() > 0;
    }
}