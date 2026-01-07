const idmascota = document.getElementById('idmascota').value
var mascotabackend = {};
const urlbackend = 'controllers/';
function getmascota(idmascota) {
    fetch(urlbackend + "mascotas.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "get",
            idmascota: idmascota
        }),
    })
        .then((response) => response.json())
        .then((result) => {
            mascotabackend = result.data
            console.log(mascotabackend);
            // Inicializar vista
            updateDisplay();

        })
        .catch((error) => {
            console.error("Error al listar registros:", error);
        });
}

getmascota(idmascota);

// ESTRUCTURA JSON (Estado inicial de la mascota)
let mascota = {
    nombre: "Max",
    especie: "Perro • Beagle",
    edad: "3 años",
    peso: "12 kg",
    salud: "Óptima",
    bio: "Me encanta perseguir pelotas de tenis y soy muy amigable con otros perros. Odio el sonido de la aspiradora.",
    foto: "https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&q=80&w=200"
};

// Función para actualizar la vista principal
function updateDisplay() {
    document.getElementById('display-name').innerText = mascotabackend.nombremascota;
    document.getElementById('display-species').innerText = mascotabackend.tipomascota+" • "+mascotabackend.raza;
    document.getElementById('display-age').innerText = mascotabackend.edad;
    document.getElementById('display-bio').innerText = `"${mascotabackend.comportamiento}"`;
    document.getElementById('display-photo').src = mascotabackend.linkimgurl||"https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&q=80&w=200";
    document.getElementById('display-health').innerText = mascotabackend.estadosalud;
    document.getElementById('display-indicaciones-extras').innerText = mascotabackend.indicacionesextra;
}

// Lógica del PopUp
function openEditModal() {
    // Cargar datos del JSON al Formulario
    document.getElementById('input-name').value = mascotabackend.nombremascota;
    document.getElementById('input-species').value = mascotabackend.tipomascota;
    document.getElementById('input-raza').value = mascotabackend.raza;
    document.getElementById('input-comportamiento').value = mascotabackend.comportamiento;
    document.getElementById('input-indicaciones-extras').value = mascotabackend.indicacionesextra;
    document.getElementById('input-age').value = mascotabackend.edad;
    const select = document.getElementById('input-estadosalud');
    const option = Array.from(select.options).find(o => o.value === mascotabackend.estadosalud);
    if (option) {
        select.value = option.value;
    } else {
        console.warn(`No se encontró el estado "${mascotabackend.estadosalud}" en la lista de opciones`);
    }
    const modal = document.getElementById('edit-modal');
    const content = document.getElementById('modal-content');

    modal.classList.remove('hidden');
    setTimeout(() => {
        content.classList.remove('scale-95', 'opacity-0');
    }, 10);
}

function closeEditModal() {
    const content = document.getElementById('modal-content');
    content.classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        document.getElementById('edit-modal').classList.add('hidden');
    }, 300);
}

// Manejar el envío del formulario
document.getElementById('edit-form').onsubmit = function (e) {
    e.preventDefault();
    mascota = {};
    mascota.idmascota = document.getElementById('input-idmascota-edit').value
    // Actualizar el objeto JSON (Aquí harías tu fetch POST/PATCH)
    mascota.nombre = document.getElementById('input-name').value;
    mascota.especie = document.getElementById('input-species').value;
    mascota.raza = document.getElementById('input-raza').value;
    mascota.estadosalud = document.getElementById('input-estadosalud').value;
    mascota.edad=document.getElementById('input-age').value;
    mascota.comportamiento = document.getElementById('input-comportamiento').value;
    mascota.indicacionesextra = document.getElementById('input-indicaciones-extras').value;

    console.log(mascota);

    
    actualizarMascota(mascota);
    closeEditModal();
    alert("Se actualizaron los datos de tu mascota");
    window.location.reload();

    console.log("Datos listos para enviar al backend:", mascota);
};


function actualizarMascota(updatemascotaobjeto) {
    document.getElementById('save-changes').disabled = true;
    document.getElementById('save-changes').innerText = 'Guardando...';
    const dataregister = {
        action: "update",
        ...updatemascotaobjeto,
    };
    console.log(dataregister);
    fetch(urlbackend + "mascotas.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(dataregister),
    })
        .then((response) => response.json())
        .then((data) => {
            //console.log(data);
            if (data.success) {
                console.log("respuesta :", data);
                
            }
        })
        .catch((error) => {
            console.log(error);
        });
}
