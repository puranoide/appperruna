const formAddPost = document.getElementById("post-form-register");
const btnregistro = document.getElementById("btnregistro");
const horariosSeleccionados = {};
formAddPost.addEventListener("submit", function (event) {
    event.preventDefault();
    console.log("submit");
    const formData = new FormData(this);
    objetoRegistro = {};
    const inputs = document.querySelectorAll(
        "#post-form-register input, #post-form-register textarea, #post-form-register select"
    );
    inputs.forEach((input) => {
        console.log(input.name, input.value);
        objetoRegistro[input.name] = input.value;
    });
    console.log(objetoRegistro);
    console.log(typeof objetoRegistro);
    saveImageImgur("bac59c579ba9db1", objetoRegistro, formData.get("linkFoto"));
});


function saveImageImgur(idClient, objetoRegistro, linkFoto) {
    btnregistro.disabled = true;
    btnregistro.textContent = "guardando imagen...";
    const formData = new FormData();
    formData.append('image', linkFoto);

    fetch(`https://api.imgur.com/3/image`, {
        method: 'POST',
        headers: {
            Authorization: `Client-ID ${idClient}`
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            //console.log(data);
            if (data.success) {
                console.log(data.data.link);
                console.log(objetoRegistro);
                console.log(data);
                btnregistro.textContent = "imagen guardada, guardando registro...";
                registrarMedico(objetoRegistro, data.data.link);
               // registrarMedico(objetoRegistro, data.data.link);
            }
        })
        .catch(error => {
            console.log(error);
        });

}

function registrarMedico(registerobj, linkimgurl) {
    const dataregister = {
        action: "register",
        linkimgurl: linkimgurl,
        ...registerobj,
    };
    console.log(dataregister);
    fetch("controllers/register.php", {
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
                alert("Tu registro a sido exitoso");
                //window.location.href = "gestionPosts.php";
                btnregistro.disabled = false;
                btnregistro.textContent = "registrar";
                window.location.href = "app/client/login.html";
            }
        })
        .catch((error) => {
            console.log(error);
        });
}

function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');
    const icon = document.getElementById('placeholder-icon');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            // 1. Asignar la fuente de la imagen al resultado de la lectura
            preview.src = e.target.result;
            // 2. Mostrar la imagen
            preview.classList.remove('hidden');
            // 3. Ocultar el icono por defecto
            icon.classList.add('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}