

document.getElementById("lnkMostrarRegistro").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("panelLogin").style.display = "none";
    document.getElementById("panelRegistro").style.display = "block";
    document.getElementById("mensaje").innerHTML = "";
});

document.getElementById("lnkMostrarLogin").addEventListener("click", function (e) {
    e.preventDefault();
    document.getElementById("panelRegistro").style.display = "none";
    document.getElementById("panelLogin").style.display = "block";
    document.getElementById("mensaje").innerHTML = "";
});

document.getElementById("frmLogin").addEventListener("submit", function (e) {
    e.preventDefault();
    const correo = document.getElementById("correo").value;
    const password = document.getElementById("password").value;
    const mensaje = document.getElementById("mensaje");

    fetch("../controllers/AuthController.php?accion=login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ correo, password })
    })
        .then(res => res.json())
        .then(data => {
            if (data.ok) {
                window.location.href = data.rol == "admin" ? "administrador.php" : "usuario.php";
            } else {
                mensaje.innerHTML = `<div class="alert alert-danger">${data.mensaje}</div>`;
            }
        })
        .catch(() => {
            mensaje.innerHTML = `<div class="alert alert-danger">Error de conexion</div>`;
        });
});

document.getElementById("frmRegistro").addEventListener("submit", function (e) {
    e.preventDefault();
    const nombre = document.getElementById("regNombre").value;
    const correo = document.getElementById("regCorreo").value;
    const password = document.getElementById("regPassword").value;
    const mensaje = document.getElementById("mensaje");

    fetch("../controllers/AuthController.php?accion=registro", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ nombre, correo, password })
    })
        .then(res => res.json())
        .then(data => {
            if (data.ok) {
                mensaje.innerHTML = `<div class="alert alert-success">${data.mensaje}</div>`;
                document.getElementById("frmRegistro").reset();
                document.getElementById("lnkMostrarLogin").click();
            } else {
                mensaje.innerHTML = `<div class="alert alert-danger">${data.mensaje}</div>`;
            }
        })
        .catch(() => {
            mensaje.innerHTML = `<div class="alert alert-danger">Error de conexion</div>`;
        });
});