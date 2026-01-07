document.getElementById('booking-form').onsubmit = function (e) {
    e.preventDefault();

    // Referencias
    const btn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const loader = document.getElementById('loader');


    // 1. Simular estado de carga (Loading)
    btn.disabled = true;
    btnText.innerText = "Enviando...";
    loader.classList.remove('hidden');

    // Recoger datos para el futuro Fetch
    const formData = {
        pet_id: e.target.pet_id.value,
        date: document.getElementById('request-date').value,
        comment: document.getElementById('request-comment').value
    };

    console.log("Datos enviados al servidor:", formData);

    registrarreserva(formData);
};

function registrarreserva(reservaobj) {
    const dataregister = {
        action: "registerreserva",
        ...reservaobj,
    };
    console.log(dataregister);
    fetch("controllers/reservas.php", {
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
                    const modal = document.getElementById('success-modal');
                //window.location.href = "gestionPosts.php";
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                setTimeout(() => {
                    // Aquí pondrías la URL de tu otra vista
                    // window.location.href = "mis-visitas.html";
                    window.location.href = "perfilmascota.php";
                }, 3000);

            }
        })
        .catch((error) => {
            console.log(error);
        });
}