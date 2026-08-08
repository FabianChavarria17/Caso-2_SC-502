<?php
require_once __DIR__ . "/../config/db.php";

class Usuario
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = conectarDB();
    }

    public function buscarPorCorreo($correo)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->execute([$correo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $correo, $password, $rol = "usuario")
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare(
            "INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nombre, $correo, $hash, $rol]);
    }

    public function validarLogin($correo, $password)
    {
        $usuario = $this->buscarPorCorreo($correo);
        if ($usuario && password_verify($password, $usuario["contrasena"])) {
            return $usuario;
        }
        return null;
    }
}