<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "admin") {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Administrador</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<header>
  <h1>Panel de Administrador - <?= htmlspecialchars($_SESSION["nombre"]) ?></h1>
  <a href="../logout.php" class="btn btn-outline-light btn-sm">Cerrar sesion</a>
</header>

<div class="container mt-4">

  <div id="mensaje"></div>

  <h2>Solicitudes pendientes</h2>
  <table class="table table-bordered bg-white" id="tablaSolicitudes">
    <thead>
      <tr><th>Usuario</th><th>Taller</th><th>Estado</th><th>Accion</th></tr>
    </thead>
    <tbody></tbody>
  </table>

</div>
<script src="../js/administrador.js"></script>
</body>
</html>