<?php
session_start();
if (!isset($_SESSION["id"]) || $_SESSION["rol"] != "usuario") {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Usuario</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<header>
  <h1>Bienvenido, <?= htmlspecialchars($_SESSION["nombre"]) ?></h1>
  <a href="../logout.php" class="btn btn-outline-light btn-sm">Cerrar sesion</a>
</header>

<div class="container mt-4">

  <div id="mensaje"></div>

  <h2>Talleres disponibles</h2>
  <table class="table table-bordered bg-white" id="tablaTalleres">
    <thead>
      <tr><th>Taller</th><th>Cupos disponibles</th><th>Accion</th></tr>
    </thead>
    <tbody></tbody>
  </table>

  <h2 class="mt-5">Mis solicitudes</h2>
  <table class="table table-bordered bg-white" id="tablaMisSolicitudes">
    <thead>
      <tr><th>Taller</th><th>Estado</th></tr>
    </thead>
    <tbody></tbody>
  </table>

</div>
<script src="../js/usuario.js"></script>
</body>
</html>
