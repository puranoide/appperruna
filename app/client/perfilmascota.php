<?php
session_start();
print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Mascota - PetCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans min-h-screen">

<input type="number" name="idmascota" id="idmascota" value="<?php echo $_SESSION['id']; ?>">

    <div class="max-w-2xl mx-auto p-4 md:pt-12">
        <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-gray-100">
             
            <div class="h-40 bg-gradient-to-r from-indigo-500 to-purple-500 relative">
                <div class="absolute -bottom-12 left-8">
                    <img id="display-photo" src="https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&q=80&w=200" 
                         class="w-32 h-32 rounded-[2rem] border-4 border-white object-cover shadow-lg bg-gray-200">
                </div>
            </div>

            <div class="pt-16 p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 id="display-name" class="text-3xl font-black text-gray-800">Max</h1>
                        <p id="display-species" class="text-indigo-600 font-bold tracking-wide uppercase text-sm">Perro • Beagle</p>
                    </div>
                    <button onclick="openEditModal()" class="flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-2xl font-bold transition">
                        <span>✏️</span> Editar
                    </button>
                </div>

                <div class="grid grid-cols-3 gap-4 my-8">
                    <div class="bg-indigo-50 p-4 rounded-3xl text-center">
                        <p class="text-xs text-indigo-400 font-bold uppercase">Edad</p>
                        <p id="display-age" class="text-xl font-black text-indigo-700">3 años</p>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-3xl text-center">
                        <p class="text-xs text-purple-400 font-bold uppercase">Peso</p>
                        <p id="display-weight" class="text-xl font-black text-purple-700">12 kg</p>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-3xl text-center">
                        <p class="text-xs text-orange-400 font-bold uppercase">Salud</p>
                        <p id="display-health" class="text-xl font-black text-orange-700">Óptima</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <h3 class="font-bold text-gray-800">Sobre mí</h3>
                    <p id="display-bio" class="text-gray-500 leading-relaxed italic">
                        "Me encanta perseguir pelotas de tenis y soy muy amigable con otros perros. Odio el sonido de la aspiradora."
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div id="edit-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300" id="modal-content">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-black text-gray-800">Editar Perfil</h2>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">✕</button>
                </div>

                <form id="edit-form" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Nombre</label>
                            <input type="text" id="input-name" class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Especie</label>
                            <input type="text" id="input-species" class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Edad</label>
                            <input type="text" id="input-age" class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Descripción</label>
                        <textarea id="input-bio" rows="3" class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition resize-none"></textarea>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="closeEditModal()" class="flex-1 py-4 bg-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-200 transition">Cancelar</button>
                        <button type="submit" class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script src="assets/js/perfilmascota.js"></script>
</body>
</html>