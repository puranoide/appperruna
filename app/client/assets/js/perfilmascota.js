const idusuario = document.getElementById('iddueño').value; // El ID del dueño
let listaMascotas = []; 
const urlbackend = 'controllers/';
function getmascotas() {
    fetch(urlbackend + "mascotas.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "get_all_by_user", // Asegúrate de manejar esta acción en tu PHP
            idusuario: idusuario
        }),
    })
    .then(res => res.json())
    .then(result => {
        listaMascotas = result.data || []; // Si no hay, es un array vacío
        renderPetsGrid();
    })
    .catch(err => console.error("Error:", err));
}

function renderPetsGrid() {
    const grid = document.getElementById('pets-grid');
    grid.innerHTML = ''; // Limpiar

    // 1. Renderizar mascotas existentes
    listaMascotas.forEach(pet => {
        grid.innerHTML += `
            <div class="bg-white rounded-[2.5rem] shadow-lg overflow-hidden border border-gray-100 flex flex-col">
                <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-500 relative">
                    <img src="${pet.linkimgurl || 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=200'}" 
                         class="absolute -bottom-6 left-6 w-20 h-20 rounded-2xl border-4 border-white object-cover shadow-md bg-gray-200">
                </div>
                <div class="pt-10 p-6 flex-grow">
                    <h3 class="text-xl font-black text-gray-800">${pet.nombremascota}</h3>
                    <p class="text-indigo-600 font-bold text-xs uppercase">${pet.tipomascota} • ${pet.raza}</p>
                    <div class="flex gap-2 mt-4">
                        <button onclick="openEditModal(${pet.id})" class="text-sm bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl font-bold transition">Editar</button>
                        <a href="detalles_mascota.php?id=${pet.id}" class="text-sm bg-indigo-50 text-indigo-600 hover:bg-indigo-100 px-4 py-2 rounded-xl font-bold transition">Ver más</a>
                    </div>
                </div>
            </div>
        `;
    });

    // 2. Agregar el mosaico de "Agregar Mascota"
    grid.innerHTML += `
        <div onclick="openAddModal()" class="border-4 border-dashed border-gray-200 rounded-[2.5rem] flex flex-col items-center justify-center p-8 min-h-[250px] cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition group">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-3xl group-hover:bg-indigo-600 group-hover:text-white transition">
                +
            </div>
            <p class="mt-4 font-black text-gray-400 group-hover:text-indigo-600">Agregar nueva mascota</p>
        </div>
    `;
}
function openEditModal(petId) {
    // Buscar la mascota en nuestra lista local
    const pet = listaMascotas.find(p => p.id == petId);
    if(!pet) return;

    // Llenar el formulario con los datos de esa mascota específica
    document.getElementById('input-idmascota-edit').value = pet.id;
    document.getElementById('input-name').value = pet.nombremascota;
    // ... resto de los campos ...
    
    // Mostrar modal
    document.getElementById('edit-modal').classList.remove('hidden');
}
// Llamar a la función al cargar
getmascotas();