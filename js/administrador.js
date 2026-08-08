
function mostrarMensaje(texto, tipo) {
    document.getElementById("mensaje").innerHTML =
        `<div class="alert alert-${tipo}">${texto}</div>`;
}

function cargarSolicitudes() {
    fetch("../controllers/SolicitudController.php?accion=pendientes")
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#tablaSolicitudes tbody");
            tbody.innerHTML = "";
            if (!data.ok || data.solicitudes.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center">No hay solicitudes pendientes</td></tr>`;
                return;
            }
            data.solicitudes.forEach(s => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${s.usuario}</td>
                    <td>${s.taller}</td>
                    <td>${s.estado}</td>
                    <td>
                        <button class="btn btn-success btn-sm" onclick="procesar(${s.id}, 'aprobar')">Aprobar</button>
                        <button class="btn btn-danger btn-sm" onclick="procesar(${s.id}, 'rechazar')">Rechazar</button>
                    </td>
                `;
                tbody.appendChild(fila);
            });
        });
}

function procesar(id, accion) {
    fetch(`../controllers/SolicitudController.php?accion=${accion}`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id })
    })
        .then(res => res.json())
        .then(data => {
            mostrarMensaje(data.mensaje, data.ok ? "success" : "danger");
            cargarSolicitudes();
        });
}

cargarSolicitudes();