<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Visitas - PetCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans p-4 md:p-8">
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">

                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                        <div class="bg-indigo-600 p-2 rounded-xl">
                            <span class="text-2xl">🐾</span>
                        </div>
                        <span class="text-xl font-black text-gray-800 tracking-tight hidden sm:block">PetCare</span>
                    </div>

                    <div class="hidden md:ml-8 md:flex md:space-x-4">
                        <a href="#" class="px-3 py-2 text-sm font-bold text-indigo-600 border-b-2 border-indigo-600">Reservas</a>
                        <a href="reservar.php"
                            class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">Calendario</a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-400 hover:text-indigo-600 transition">
                        <span class="absolute top-2 right-2 flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-50 px-4 pt-2 pb-6 space-y-2">
            <a href="#"
                class="block px-4 py-3 text-base font-bold text-indigo-600 bg-indigo-50 rounded-xl">Dashboard</a>
            <a href="#" class="block px-4 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-xl">Mis
                Mascotas</a>
            <a href="#" class="block px-4 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-xl">Buscar
                Cuidador</a>
            <a href="#"
                class="block px-4 py-3 text-base font-medium text-gray-600 hover:bg-gray-50 rounded-xl">Agenda</a>
        </div>
    </nav>
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Solicitudes de Visita</h1>
            <p class="text-gray-500">Gestiona las reservas pendientes de tus clientes.</p>
        </div>

        <div class="flex gap-2 mb-6">
            <span class="px-4 py-1 bg-indigo-600 text-white rounded-full text-sm font-medium">Pendientes</span>
            <span
                class="px-4 py-1 bg-white border border-gray-200 text-gray-600 rounded-full text-sm font-medium hover:bg-gray-50 cursor-pointer">Historial</span>
        </div>

        <div id="requests-list" class="space-y-4">
        </div>
    </div>

    <div id="toast"
        class="fixed bottom-5 right-5 bg-gray-800 text-white px-6 py-3 rounded-2xl shadow-2xl transform translate-y-20 opacity-0 transition-all duration-300">
        Acción realizada con éxito
    </div>
    <script src="assets/js/reservas.js"></script>
</body>

</html>