let currentStep = 1;
const totalSteps = 3;

const form = document.getElementById("post-form-register");
const btnNext = document.getElementById("nextBtn");
const btnPrev = document.getElementById("prevBtn");
const btnSubmit = document.getElementById("btnregistro");
const stepTitle = document.getElementById("step-title");

// Prevenir el comportamiento por defecto de validación del navegador
form.addEventListener("invalid", (e) => {
    e.preventDefault();
}, true);

// --- NAVEGACIÓN ---

btnNext.addEventListener("click", () => {
    if (validateStep(currentStep)) {
        currentStep++;
        updateFormUI();
    } else {
        // Opcional: una pequeña alerta o scroll al primer error
        console.warn("Validación fallida en el paso " + currentStep);
    }
});

btnPrev.addEventListener("click", () => {
    currentStep--;
    updateFormUI();
});

function updateFormUI() {
    // Mostrar/Ocultar Secciones
    for (let i = 1; i <= totalSteps; i++) {
        const section = document.getElementById(`step-${i}`);
        const dot = document.getElementById(`dot-${i}`);
        
        section.classList.toggle("step-hidden", i !== currentStep);
        
        // Actualizar puntos indicadores
        if (i <= currentStep) {
            dot.classList.replace("bg-indigo-400", "bg-white");
        } else {
            dot.classList.replace("bg-white", "bg-indigo-400");
        }
    }

    // Títulos dinámicos
    const titles = {
        1: "Paso 1: Perfil Pet Parent",
        2: "Paso 2: Perfil del Engreído",
        3: "Paso 3: Salud y Seguridad"
    };
    stepTitle.textContent = titles[currentStep];

    // Visibilidad de botones
    btnPrev.classList.toggle("hidden", currentStep === 1);
    
    if (currentStep === totalSteps) {
        btnNext.classList.add("hidden");
        btnSubmit.classList.remove("hidden");
    } else {
        btnNext.classList.remove("hidden");
        btnSubmit.classList.add("hidden");
    }
}

// VALIDACIÓN MANUAL
function validateStep(step) {
    const activeSection = document.getElementById(`step-${step}`);
    const inputs = activeSection.querySelectorAll("input[required], select[required]");
    let stepIsValid = true;

    inputs.forEach(input => {
        let isFieldValid = true;

        if (input.type === "checkbox") {
            isFieldValid = input.checked;
        } else {
            isFieldValid = input.value.trim() !== "";
        }

        if (!isFieldValid) {
            input.classList.add("border-red-500", "bg-red-50");
            stepIsValid = false;
        } else {
            input.classList.remove("border-red-500", "bg-red-50");
        }
    });

    if (!stepIsValid) {
        alert("Por favor, completa todos los campos obligatorios de este paso.");
    }

    return stepIsValid;
}

// --- ENVÍO FINAL ---

form.addEventListener("submit", function (e) {
    e.preventDefault();

    // Validar último paso antes de procesar
    if (!validateStep(3)) return;

    const formData = new FormData(this);
    const objetoRegistro = {};
    
    // Convertir FormData a Objeto (excepto el archivo de imagen)
    formData.forEach((value, key) => {
        if (key !== 'linkFoto') {
            objetoRegistro[key] = value;
        }
    });

    const fotoFile = document.getElementById('pet-photo').files[0];

    // Iniciar proceso de guardado
    if (fotoFile) {
        saveImageImgur("bac59c579ba9db1", objetoRegistro, fotoFile);
    } else {
        // Imagen por defecto si no suben nada
        registrarFinal(objetoRegistro, "https://i.imgur.com/39p6m8P.png");
    }
});

function saveImageImgur(idClient, objetoRegistro, file) {
    console.log(objetoRegistro);
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
            registrarFinal(objetoRegistro, data.data.link);
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
    const dataregister = {
        action: "register",
        linkimgurl: linkimgurl,
        ...registerobj,
    };

    fetch("controllers/register.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(dataregister),
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("¡Registro completado con éxito!");
            window.location.href = "app/client/login.html";
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

// Vista previa de imagen
document.getElementById('pet-photo').addEventListener('change', function(e) {
    const preview = document.getElementById('image-preview');
    const icon = document.getElementById('placeholder-icon');
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            icon.classList.add('hidden');
        }
        reader.readAsDataURL(this.files[0]);
    }
});