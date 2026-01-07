<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Visitas - PetCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans p-4 md:p-8">

    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Solicitudes de Visita</h1>
            <p class="text-gray-500">Gestiona las reservas pendientes de tus clientes.</p>
        </div>

        <div class="flex gap-2 mb-6">
            <span class="px-4 py-1 bg-indigo-600 text-white rounded-full text-sm font-medium">Pendientes</span>
            <span class="px-4 py-1 bg-white border border-gray-200 text-gray-600 rounded-full text-sm font-medium hover:bg-gray-50 cursor-pointer">Historial</span>
        </div>

        <div id="requests-list" class="space-y-4">
            </div>
    </div>

    <div id="toast" class="fixed bottom-5 right-5 bg-gray-800 text-white px-6 py-3 rounded-2xl shadow-2xl transform translate-y-20 opacity-0 transition-all duration-300">
        Acción realizada con éxito
    </div>

    <script>
        // --- DATA JSON (Simulación de backend) ---
        let solicitudes = [
            {
                id: 101,
                mascota: "Kira",
                especie: "Perro (Golden Retriever)",
                foto: "https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&q=80&w=100",
                dueño: "Beatriz López",
                fecha: "2026-01-15",
                hora: "10:00 - 12:00",
                mensaje: "Kira necesita un paseo largo porque tengo una reunión importante.",
                monto: "S/.25.00"
            },
            {
                id: 102,
                mascota: "Simba",
                especie: "Gato (Persa)",
                foto: "https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&q=80&w=100",
                dueño: "Marcos Ruiz",
                fecha: "2026-01-16",
                hora: "17:00 - 18:00",
                mensaje: "Solo es darle de comer y limpiar la arena. Es muy tímido.",
                monto: "15.00€"
            }
        ];

        function renderRequests() {
            const container = document.getElementById('requests-list');
            
            if (solicitudes.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-400">No tienes solicitudes pendientes por ahora 🐾</p>
                    </div>`;
                return;
            }

            container.innerHTML = solicitudes.map(s => `
                <div id="card-${s.id}" class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6 transition-all hover:shadow-md">
                    <div class="flex-shrink-0 flex items-center gap-4">
                        <img src="${s.foto}" class="w-16 h-16 rounded-2xl object-cover border-2 border-indigo-50">
                        <div>
                            <h3 class="font-bold text-gray-800 text-lg">${s.mascota}</h3>
                            <p class="text-xs text-indigo-600 font-semibold uppercase tracking-wider">${s.especie}</p>
                        </div>
                    </div>

                    <div class="flex-grow space-y-2">
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <span>📅</span> <strong>${s.fecha}</strong>
                            </div>
                            <div class="flex items-center gap-1">
                                <span>⏰</span> ${s.hora}
                            </div>
                            <div class="flex items-center gap-1 text-green-600 font-bold">
                                <span>💰</span> ${s.monto}
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 italic bg-gray-50 p-3 rounded-xl border border-gray-100">
                            "${s.mensaje}"
                        </p>
                        <p class="text-xs text-gray-400">Solicitado por: <span class="font-medium text-gray-600">${s.dueño}</span></p>
                    </div>

                    <div class="flex md:flex-col justify-center gap-2 border-t md:border-t-0 md:border-l border-gray-100 pt-4 md:pt-0 md:pl-6">
                        <button onclick="handleAction(${s.id}, 'aprobar')" class="flex-1 px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition active:scale-95 text-sm">
                            Aprobar
                        </button>
                        <button onclick="handleAction(${s.id}, 'rechazar')" class="flex-1 px-6 py-2 bg-white text-red-500 border border-red-100 rounded-xl font-bold hover:bg-red-50 transition active:scale-95 text-sm">
                            Rechazar
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function handleAction(id, type) {
            const card = document.getElementById(`card-${id}`);
            
            // Animación de salida
            card.classList.add('opacity-50', 'scale-95');
            
            setTimeout(() => {
                // Eliminar del array (esto es lo que harías tras el fetch al backend)
                solicitudes = solicitudes.filter(s => s.id !== id);
                renderRequests();
                showToast(type === 'aprobar' ? '✅ Visita confirmada' : '❌ Solicitud rechazada');
            }, 400);
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.innerText = message;
            toast.classList.remove('translate-y-20', 'opacity-0');
            
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        }

        // Inicializar
        renderRequests();
    </script>
</body>
</html>