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
    console.log(objetoRegistro);
    registrarDueño(objetoRegistro);
});


function registrarDueño(registerobj) {
    const dataregister = {
        action: "registeruser",
        ...registerobj,
    };

    var popup = document.getElementById("popup");
    popup.classList.remove("hidden");

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
                //tengo que redirigir a la pagina main del usuario con una sesion mediante id que carge los datos del usuario
                var msg = document.getElementById("popupmsg");
                msg.innerHTML = "";
                msg.textContent = "Se ha registrado con exito";
                crearsesioninicial(data.id);
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

function crearsesioninicial(id) {
    const dataupdate = {
        action: "login",
        id: id,
    }

    fetch("controllers/auth.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(dataupdate),
    }).then(res => res.json())
        .then(data => {
            if (data.success) {
                console.log("Respuesta exitosa:", data);
                //tengo que redirigir a la pagina main del usuario con una sesion mediante id que carge los datos del usuario
                var msg = document.getElementById("popupmsg");
                msg.innerHTML = "";
                msg.textContent = "Se ha registrado con exito, redirigiendo...";
                setTimeout(() => window.location.href = "app/client/perfilmascota.php", 1500);

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
