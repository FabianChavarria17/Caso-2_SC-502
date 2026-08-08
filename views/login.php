
<?php
session_start();
if (isset($_SESSION["id"])) {
    header("Location: " . ($_SESSION["rol"] == "admin" ? "administrador.php" : "usuario.php"));
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Inscripcion a Talleres - Ingreso</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<div class="container">
  <div class="card-form">
    <h1>Sistema de Inscripcion a Talleres</h1>

    <div id="panelLogin">
      <h2>Iniciar sesion</h2>
      <form id="frmLogin">
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" class="form-control" id="correo" required>

        </div>
        <div class="mb-3">
          <label class="form-label">Contrasena</label>
          <input type="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
      </form>
      <p class="text-center mt-3">
        Sin cuenta? <a href="#" id="lnkMostrarRegistro">Registrese aqui</a>
      </p>
    </div>

    <div id="panelRegistro" style="display:none;">
      <h2>Crear cuenta</h2>
      <form id="frmRegistro">
        <div class="mb-3">
          <label class="form-label">Nombre</label>
          <input type="text" class="form-control" id="regNombre" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Correo</label>
          <input type="email" class="form-control" id="regCorreo" required>

        </div>
        <div class="mb-3">
          <label class="form-label">Contrasena</label>
          <input type="password" class="form-control" id="regPassword" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Registrarme</button>
      </form>
      <p class="text-center mt-3">
        <a href="#" id="lnkMostrarLogin">Volver a iniciar sesion</a>
      </p>
    </div>

    <div id="mensaje" class="mt-3"></div>
  </div>
</div>
<script src="../js/login.js"></script>
</body>

</html>