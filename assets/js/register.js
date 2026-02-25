let currentStep = 1;
const totalSteps = 3;

const form = document.getElementById("post-form-register");
const btnSubmit = document.getElementById("btnregistro");



// --- ENVÍO FINAL ---

form.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    const objetoRegistro = {};
    
    // Convertir FormData a Objeto (excepto el archivo de imagen)
    formData.forEach((value, key) => {
        if (key !== 'linkFoto') {
            objetoRegistro[key] = value;
        }
    });

        registrarDueño(objetoRegistro);
});


function registrarDueño(registerobj) {
    const dataregister = {
        action: "registeruser",
        ...registerobj,
    };

    fetch("controllers/register.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(dataregister),
    })
    .then(async res => {
        const text = await res.text(); // Leemos la respuesta como texto primero
        try {
            return JSON.parse(text); // Intentamos convertir a JSON
        } catch (err) {
            // Si falla, es porque PHP mandó un error de sintaxis o un Warning
            throw new Error("El servidor respondió con un error de formato (posible error PHP): " + text);
        }
    })
    .then(data => {
        if (data.success) {
            console.log("Respuesta exitosa:", data);
            // Redirigir o mostrar éxito aquí
        } else {
            // Aquí capturamos los errores controlados ('Lo sentimos, este correo...')
            alert("Atención: " + (data.error || "No se pudo registrar"));
            resetButton();
        }
    })
    .catch(err => {
        console.error("Error capturado:", err.message);
        alert("Ocurrió un error técnico. Revisa la consola.");
        resetButton();
    });
}

function resetButton() {
    btnSubmit.disabled = false;
    btnSubmit.textContent = "Finalizar Registro";
}
