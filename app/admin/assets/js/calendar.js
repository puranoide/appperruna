// --- ESTRUCTURA JSON (Simulación de backend) ---
const urlbackend = 'controllers/';

let citas = [
    { id: 1, fecha: "2026-01-05", hora: "09:00", mascota: "Luna", servicio: "Baño y Corte", dueño: "Ana Sosa", notas: "Traer champú especial" },
    { id: 2, fecha: "2026-01-05", hora: "14:30", mascota: "Thor", servicio: "Control Vacunas", dueño: "Carlos G.", notas: "Vacuna de la rabia" },
    { id: 3, fecha: "2026-01-05", hora: "14:30", mascota: "Thor", servicio: "Control Vacunas", dueño: "Carlos G.", notas: "Vacuna de la rabia" },
    { id: 4, fecha: "2026-01-05", hora: "14:30", mascota: "Thor", servicio: "Control Vacunas", dueño: "Carlos G.", notas: "Vacuna de la rabia" },
    { id: 5, fecha: "2026-01-12", hora: "11:00", mascota: "Firulais", servicio: "Paseo", dueño: "Marta R.", notas: "Pasear solo por el parque" }
];

let currentDate = new Date(); // Fecha actual

reservasbackend = [];
function reservasmes(mes, anio) {

    fetch(urlbackend + "reservas.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            action: "getreservasactivaspormes",
            mes: mes,
            anio: anio
        }),
    })
        .then((response) => response.json())
        .then((result) => {

            if (result.error) {
                console.error(result.error);
                return;
            }
            //limpiar el array
            reservasbackend = [];
            reservasbackend = result.data
            console.log(reservasbackend);
            // Inicializar vista
            //updateDisplay();
            // Inicializar
            //renderRequests();
            renderCalendar();

        })
        .catch((error) => {
            console.error("Error al listar registros:", error);
        });

}
reservasmes(currentDate.getMonth() + 1, currentDate.getFullYear());
function renderCalendar() {
    const grid = document.getElementById('calendar-days');
    const monthYearLabel = document.getElementById('month-year');
    grid.innerHTML = '';

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    // Configurar cabecera
    const monthNames = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
    monthYearLabel.innerText = `${monthNames[month]} ${year}`;

    // Primer día del mes y total de días
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    // Rellenar espacios en blanco antes del primer día
    for (let i = 0; i < firstDay; i++) {
        grid.innerHTML += `<div class="p-2 border-r border-b bg-gray-50/50"></div>`;
    }

    // Crear cada día
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

        // Buscar citas para este día
        const citasDia = reservasbackend.filter(c => c.date === dateStr);

        let citasHtml = citasDia.map(c => `
                    <div onclick="openModal(${c.id})" class="mt-1 px-2 py-1 bg-indigo-100 text-indigo-700 text-[10px] rounded border border-indigo-200 truncate cursor-pointer hover:bg-indigo-200 transition">
                        ${c.comment} - ${c.nombremascota}
                    </div>
                `).join('');

        grid.innerHTML += `
                    <div class="min-h-[100px] p-2 border-r border-b hover:bg-gray-50 transition">
                        <span class="text-sm font-semibold ${isToday(year, month, day) ? 'bg-indigo-600 text-white w-7 h-7 flex items-center justify-center rounded-full' : 'text-gray-500'}">${day}</span>
                        <div class="mt-1">${citasHtml}</div>
                    </div>
                `;
    }
}

// --- Funciones de Navegación ---
function changeMonth(step) {
    currentDate.setMonth(currentDate.getMonth() + step);
    reservasmes(currentDate.getMonth() + 1, currentDate.getFullYear());
}

function goToToday() {
    currentDate = new Date();
    reservasmes(currentDate.getMonth() + 1, currentDate.getFullYear());
}

function isToday(y, m, d) {
    const today = new Date();
    return y === today.getFullYear() && m === today.getMonth() && d === today.getDate();
}

// --- Lógica del PopUp ---
function openModal(id) {
    const citapopup = reservasbackend.find(c => c.id === id);
    if (!citapopup) return;

    document.getElementById('modal-pet-name').innerText = citapopup.nombremascota;
    document.getElementById('modal-service').innerText = citapopup.comment;
    document.getElementById('modal-time').innerText = `${citapopup.date}`;

    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

// Inicializar
renderCalendar();