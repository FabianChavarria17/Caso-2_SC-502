
function mostrarMensaje(texto, tipo) {
    document.getElementById("mensaje").innerHTML =
        `<div class="alert alert-${tipo}">${texto}</div>`;
}

function cargarTalleres() {
    fetch("../controllers/TallerController.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#tablaTalleres tbody");
            tbody.innerHTML = "";
            if (!data.ok || data.talleres.length === 0) {
                tbody.innerHTML = `<tr><td colspan="3" class="text-center">No hay talleres con cupo disponible</td></tr>`;
                return;
            }
            data.talleres.forEach(taller => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${taller.nombre}</td>
                    <td>${taller.cupo}</td>
                    <td><button class="btn btn-primary btn-sm" onclick="solicitar(${taller.id})">Solicitar</button></td>
                `;
                tbody.appendChild(fila);
            });
        });
}

function cargarMisSolicitudes() {
    fetch("../controllers/SolicitudController.php?accion=mis")
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#tablaMisSolicitudes tbody");
            tbody.innerHTML = "";
            if (!data.ok || data.solicitudes.length === 0) {
                tbody.innerHTML = `<tr><td colspan="2" class="text-center">Aun no tiene solicitudes</td></tr>`;
                return;
            }
            data.solicitudes.forEach(s => {
                const fila = document.createElement("tr");
                fila.innerHTML = `<td>${s.taller}</td><td>${s.estado}</td>`;
                tbody.appendChild(fila);
            });
        });
}

function solicitar(tallerId) {
    fetch("../controllers/SolicitudController.php?accion=solicitar", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ taller_id: tallerId })
    })
        .then(res => res.json())
        .then(data => {
            mostrarMensaje(data.mensaje, data.ok ? "success" : "danger");
            if (data.ok) {
                cargarTalleres();
                cargarMisSolicitudes();
            }
        });
}

cargarTalleres();
cargarMisSolicitudes();