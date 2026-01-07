<?php
session_start();
//print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Visita - PetCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes popIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-pop { animation: popIn 0.3s ease-out forwards; }
    </style>
</head>
<body class="bg-gray-50 font-sans min-h-screen flex items-center justify-center p-4">

    <div class="max-w-lg w-full">
        <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100">
            <div class="bg-indigo-600 p-8 text-white">
                <h1 class="text-2xl font-black">Solicitar una Cita</h1>
                <p class="text-indigo-100 mt-2 text-sm">Propón una fecha y nuestro equipo administrativo confirmará la disponibilidad pronto.</p>
            </div>

            <form id="booking-form" class="p-8 space-y-6">
                <input type="hidden" name="pet_id" value="<?php echo $_SESSION['id']; ?>">

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Fecha propuesta</label>
                    <div class="relative">
                        <input type="date" id="request-date" required
                            class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white outline-none transition font-medium text-gray-700">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Mensaje o Requerimientos</label>
                    <textarea id="request-comment" rows="4" required
                        placeholder="Ej: Necesito que el paseo sea por la tarde, Max tiene mucha energía hoy..."
                        class="w-full px-5 py-4 rounded-2xl bg-gray-50 border-2 border-transparent focus:border-indigo-500 focus:bg-white outline-none transition resize-none text-gray-700"></textarea>
                </div>

                <button type="submit" id="submit-btn"
                    class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black text-lg transition shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-[0.98] flex items-center justify-center gap-3">
                    <span id="btn-text">Enviar Solicitud</span>
                    <div id="loader" class="hidden w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                </button>
            </form>
        </div>
    </div>

    <div id="success-modal" class="fixed inset-0 bg-indigo-900/60 backdrop-blur-md hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-[3rem] p-10 max-w-sm w-full text-center shadow-2xl animate-pop">
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">
                ✓
            </div>
            <h2 class="text-2xl font-black text-gray-800 mb-2">¡Solicitud Enviada!</h2>
            <p class="text-gray-500 mb-8 leading-relaxed">
                Tu petición ha sido recibida. Te notificaremos en cuanto la administración confirme el horario.
            </p>
            <div class="space-y-3">
                <p class="text-xs text-gray-400 animate-pulse">Redireccionando a mis citas...</p>
            </div>
        </div>
    </div>
    
    <script src="assets/js/reserva.js"></script>
</body>
</html>