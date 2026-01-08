

var loginButton = document.getElementById("btnloginadmin");
var usuario= document.getElementById("usuarioadmin");
var contrasena= document.getElementById("contrasenia");
//un lenguaje de eventos
loginButton.addEventListener("click", function() {
    //login(email.value, password.value);
    event.preventDefault(); // Evita que el formulario se envíe de manera tradicional
    console.log("login");
    console.log(usuario.value);
    console.log(contrasena.value);
    login(usuario.value, contrasena.value);
});


function login(usuario, contrasena) {

    fetch("controllers/login.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'login',
            usuario: usuario,
            contrasena: contrasena
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

        if (data.success) {
            console.log("Login exitoso");
            window.location.href = "listareservas.php";
            // Redirigir a la página de inicio
            
        } else {
            console.log("Error al iniciar sesión");
            alert("Error al iniciar sesión, por favor verifica tus credenciales.");
        }
    })
    .catch(error => {
        console.log(error);
    });

}
