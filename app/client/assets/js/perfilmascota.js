const idusuario = document.getElementById('iddueño').value;
let listaMascotas = [];
const urlbackend = 'controllers/';

// --- CARGA DE DATOS ---
function getmascotas() {
    fetch(urlbackend + "mascotas.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            action: "get_all_by_user",
            idusuario: idusuario
        }),
    })
        .then(res => res.json())
        .then(result => {
            listaMascotas = result.data || [];
            console.log("Mascotas:", listaMascotas);
            renderPetsGrid();
        })
        .catch(err => console.error("Error:", err));
}

function renderPetsGrid() {
    const grid = document.getElementById('pets-grid');
    grid.innerHTML = '';

    listaMascotas.forEach(pet => {
        grid.innerHTML += `
            <div class="bg-white rounded-[2.5rem] shadow-lg overflow-hidden border border-gray-100 flex flex-col">
                <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-500 relative">
                    <img src="${pet.foto || 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?q=80&w=200'}" 
                         class="absolute -bottom-6 left-6 w-20 h-20 rounded-2xl border-4 border-white object-cover shadow-md bg-gray-200">
                </div>
                <div class="pt-10 p-6 flex-grow">
                    <h3 class="text-xl font-black text-gray-800">${pet.nombre}</h3>
                    <p class="text-indigo-600 font-bold text-xs uppercase">${pet.Especie} • ${pet.raza}</p>
                    <div class="flex gap-2 mt-4">
                        <button onclick="openEditModal(${pet.idmascota})" class="text-sm bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-xl font-bold transition">Editar</button>
                    </div>
                </div>
            </div>`;
    });

    grid.innerHTML += `
        <div onclick="openAddModal()" class="border-4 border-dashed border-gray-200 rounded-[2.5rem] flex flex-col items-center justify-center p-8 min-h-[250px] cursor-pointer hover:border-indigo-300 hover:bg-indigo-50 transition group">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-3xl group-hover:bg-indigo-600 group-hover:text-white transition">+</div>
            <p class="mt-4 font-black text-gray-400 group-hover:text-indigo-600">Agregar nueva mascota</p>
        </div>`;
}

// --- LÓGICA DEL MODAL ---
function openAddModal() {
    document.getElementById('add-pet-modal').classList.remove('hidden');
    nextStep(1);
}

function closeAddModal() {
    document.getElementById('add-pet-modal').classList.add('hidden');
    document.getElementById('add-pet-form').reset();
    document.getElementById('pet-photo-preview').classList.add('hidden');
    document.getElementById('placeholder-icon').classList.remove('hidden');
}

function nextStep(step) {
    // Si el usuario intenta ir hacia adelante (ej: del 1 al 2), validamos
    const currentVisibleStep = Array.from(document.querySelectorAll('[id^="form-step-"]'))
        .findIndex(s => !s.classList.contains('hidden')) + 1;

    // Solo validamos si intentamos avanzar (paso solicitado > paso actual)
    if (step > currentVisibleStep) {
        if (!validateStep(currentVisibleStep)) return;
    }

    const steps = [document.getElementById('form-step-1'), document.getElementById('form-step-2'), document.getElementById('form-step-3')];
    const dots = [document.getElementById('step-dot-1'), document.getElementById('step-dot-2'), document.getElementById('step-dot-3')];
    const title = document.getElementById('step-title');

    steps.forEach(s => s.classList.add('hidden'));
    dots.forEach(d => d.classList.replace('bg-white', 'bg-white/30'));

    steps[step - 1].classList.remove('hidden');
    dots[step - 1].classList.replace('bg-white/30', 'bg-white');

    const titles = ["Perfil del Engreído", "Salud y Seguridad", "Comportamiento y Notas"];
    title.innerText = titles[step - 1];
}

// Previsualización de Imagen
document.getElementById('pet-photo-input').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const preview = document.getElementById('pet-photo-preview');
    const placeholder = document.getElementById('placeholder-icon');

    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

});


function validateStep(stepNumber) {
    const currentStep = document.getElementById(`form-step-${stepNumber}`);
    let isValid = true;

    // Validar inputs, selects y textareas con required
    const inputs = currentStep.querySelectorAll('input[required], select[required], textarea[required]');
    inputs.forEach(input => {
        // Caso especial: checkbox required → verificar que esté marcado
        if (input.type === 'checkbox') {
            if (!input.checked) {
                isValid = false;
                input.closest('label').classList.add('border-red-400', 'bg-red-50');
                input.onchange = () => {
                    input.closest('label').classList.remove('border-red-400', 'bg-red-50');
                };
            }
        } else {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500', 'bg-red-50');
                input.oninput = () => {
                    input.classList.remove('border-red-500', 'bg-red-50');
                };
            }
        }
    });

    if (!isValid) {
        console.warn("Faltan campos por llenar en el paso " + stepNumber);
    }
    return isValid;
}


// --- ENVÍO DE DATOS ---
document.getElementById('add-pet-form').onsubmit = function (e) {
    e.preventDefault();

    // Validar todos los pasos antes de enviar
    for (let i = 1; i <= 3; i++) {
        if (!validateStep(i)) {
            nextStep(i); // Te regresa al primer paso que tenga errores
            return;
        }
    }

    const formData = new FormData(this);
    const petData = Object.fromEntries(formData.entries());

    // Lógica de checkboxes (1 o 2)
    petData.vacunas = document.getElementById('chk-vacunas').checked ? 1 : 2;
    petData.vacuna_kc = document.getElementById('chk-kc').checked ? 1 : 2;
    petData.desparasitacion = document.getElementById('chk-desparasitacion').checked ? 1 : 2;

    // Foto
    const previewImg = document.getElementById('pet-photo-preview');
    petData.foto = !previewImg.classList.contains('hidden') ? previewImg.src : "";
    const fotoFile = document.getElementById('pet-photo-input').files[0];
    petData.idusuario = idusuario;

    // Tu fetch aquí...
    console.log("Formulario válido, enviando...", petData, fotoFile);

    if (fotoFile) {
        saveImageImgur("bac59c579ba9db1", petData, fotoFile);
    } else {
        // Imagen por defecto si no suben nada
        registrarFinal(petData, "https://i.imgur.com/39p6m8P.png");
        console.log("No hay foto, usando imagen por defecto");

    }

    // Ejemplo de Fetch:
    /*
    fetch(urlbackend + "mascotas.php", {
        method: "POST",
        body: JSON.stringify(petData)
    }).then(...)
    */
};

function saveImageImgur(idClient, objetoRegistro, file) {
    console.log(objetoRegistro);
    var btnSubmit = document.getElementById("save-changes");
    btnSubmit.disabled = true;
    btnSubmit.innerHTML = `
        <span class="flex items-center justify-center">
            <svg class="animate-spin h-5 w-5 mr-3" viewBox="0 0 24 24"></svg>
            Subiendo Foto...
        </span>`;

    const formData = new FormData();
    formData.append('image', file);

    fetch(`https://api.imgur.com/3/image`, {
        method: 'POST',
        headers: { Authorization: `Client-ID ${idClient}` },
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btnSubmit.textContent = "Guardando Datos...";
                console.log("podemos registrar la mascota", objetoRegistro, data.data.link);
                registrarFinal(objetoRegistro, data.data.link);
                //registrarFinal(objetoRegistro, data.data.link);
            } else {
                throw new Error("Error en Imgur");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Error al subir la imagen. Intenta de nuevo.");
            btnSubmit.disabled = false;
            btnSubmit.textContent = "Finalizar Registro";
        });
}

function registrarFinal(registerobj, linkimgurl) {
    var btnSubmit = document.getElementById("save-changes");
    const dataregister = {
        action: "insert",
        linkimgurl: linkimgurl,
        ...registerobj,
    };

    fetch("controllers/mascotas.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(dataregister),
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("¡Registro completado con éxito!");
                closeAddModal();
                getmascotas();
            } else {
                alert("Error en el servidor: " + (data.message || "No se pudo registrar"));
                btnSubmit.disabled = false;
                btnSubmit.textContent = "Finalizar Registro";
            }
        })
        .catch(err => {
            console.error(err);
            btnSubmit.disabled = false;
            btnSubmit.textContent = "Finalizar Registro";
        });
}

// Iniciar carga
getmascotas();