<?php
session_start();
//print_r($_SESSION);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Mascota - Luchi Petpackers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 font-sans min-h-screen">

    <input type="number" name="iddueño" id="iddueño"
        value="<?php echo isset($_SESSION['idusuario']) ? $_SESSION['idusuario'] : ''; ?>" hidden>

    <nav class="bg-white border-b border-gray-100 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">

                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2 cursor-pointer">
                        <div class="bg-indigo-600 p-2 rounded-xl">
                            <span class="text-2xl">🐾</span>
                        </div>
                        <span class="text-xl font-black text-gray-800 tracking-tight hidden sm:block">Luchi Petpackers</span>
                    </div>

                    <div class="hidden md:ml-8 md:flex md:space-x-4">
                        <a href="#" class="px-3 py-2 text-sm font-bold text-indigo-600 border-b-2 border-indigo-600">Mi
                            mascota</a>
                        <a href="reservar.php"
                            class="px-3 py-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition">Agendar</a>
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

    <div class="max-w-7xl mx-auto p-4 md:pt-12">
        <h2 class="text-3xl font-black text-gray-800 mb-8">Mis Mascotas</h2>

        <div id="pets-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        </div>
    </div>


    <div id="edit-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all scale-95 opacity-0 duration-300"
            id="modal-content">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-black text-gray-800">Editar Perfil</h2>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">✕</button>
                </div>

                <form id="edit-form" class="space-y-4">
                    <input type="number" id="input-idmascota-edit" value="<?php echo $_SESSION['id']; ?>">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Nombre</label>
                            <input type="text" id="input-name"
                                class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Especie</label>
                            <input type="text" id="input-species"
                                class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">raza</label>
                            <input type="text" id="input-raza"
                                class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Estado de
                                salud</label>
                            <select name="estadosalud" id="input-estadosalud"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none bg-white">
                                <option value="Optimo">Optimo</option>
                                <option value="Tiene observacion">Tiene observacion</option>
                                <option value="Requiere cuidado especial">Requiere cuidado especial</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">edad</label>
                            <input type="text" id="input-age"
                                class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Mi
                            comportamiento</label>
                        <textarea id="input-comportamiento" rows="3"
                            class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition resize-none"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Indicaciones
                            extras</label>
                        <textarea id="input-indicaciones-extras" rows="3"
                            class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition resize-none"></textarea>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="closeEditModal()"
                            class="flex-1 py-4 bg-gray-100 text-gray-500 rounded-2xl font-bold hover:bg-gray-200 transition">Cancelar</button>
                        <button type="submit" id="save-changes"
                            class="flex-1 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition">Guardar
                            Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="add-pet-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4 text-left">
        <div
            class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden transform transition-all duration-300">

            <div class="bg-indigo-600 p-6 text-center text-white">
                <h2 class="text-2xl font-bold mb-2 text-white">Registro de Mascota</h2>
                <div
                    class="flex justify-center items-center gap-4 text-xs font-bold uppercase tracking-widest opacity-80">
                    <div class="flex flex-col items-center">
                        <span id="step-dot-1" class="w-3 h-3 rounded-full bg-white mb-1"></span>
                        <span>Paso 1</span>
                    </div>
                    <div class="h-[2px] w-8 bg-white/30"></div>
                    <div class="flex flex-col items-center">
                        <span id="step-dot-2" class="w-3 h-3 rounded-full bg-white/30 mb-1"></span>
                        <span>Paso 2</span>
                    </div>
                    <div class="h-[2px] w-8 bg-white/30"></div>
                    <div class="flex flex-col items-center">
                        <span id="step-dot-3" class="w-3 h-3 rounded-full bg-white/30 mb-1"></span>
                        <span>Paso 3</span>
                    </div>
                </div>
                <p id="step-title" class="text-[10px] mt-2 font-bold uppercase tracking-tighter text-white">Perfil del
                    Engreído</p>
            </div>

            <form id="add-pet-form" class="p-8">
                <div id="form-step-1" class="space-y-4">
                    <div class="flex flex-col items-center mb-4">
                        <input type="file" id="pet-photo-input" accept="image/*" class="hidden">
                        <div onclick="document.getElementById('pet-photo-input').click()"
                            class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center border-2 border-dashed border-gray-300 relative group cursor-pointer overflow-hidden">
                            <span id="placeholder-icon" class="text-2xl">🐾</span>
                            <img id="pet-photo-preview" src=""
                                class="absolute inset-0 w-full h-full object-cover hidden">
                            <div
                                class="absolute bottom-0 right-0 bg-indigo-600 p-1.5 rounded-full text-white text-[10px] z-10">
                                📷</div>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-2 uppercase font-bold text-center">Sube una foto de tu
                            mascota</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nombre</label>
                        <input type="text" name="nombremascota" required
                            class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none focus:border-indigo-500 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Domicilio</label>
                        <input type="text" name="domiciliomascota" required
                            class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none focus:border-indigo-500 transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Especie</label>
                            <select name="tipomascota" required
                                class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none">
                                <option value="Perro">Perro</option>
                                <option value="Gato">Gato</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Raza</label>
                            <input type="text" name="raza" required
                                class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">estado</label>
                            <select name="estadosexual" required
                                class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none">
                                <option value="esterilizado">Esterilizado</option>
                                <option value="noesterilizado">No esterilizado</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Sexo</label>
                            <select name="sexo" required
                                class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none">
                                <option value="Macho">Macho</option>
                                <option value="Hembra">Hembra</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Peso (kg)</label>
                            <input type="number" name="peso" required
                                class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">F. Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" required
                                class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none">
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="closeAddModal()"
                            class="flex-1 py-3 bg-gray-100 text-gray-500 rounded-xl font-bold hover:bg-gray-200 transition">Cancelar</button>
                        <button type="button" onclick="nextStep(2)"
                            class="flex-1 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition">Siguiente</button>
                    </div>
                </div>

                <div id="form-step-2" class="hidden space-y-4">
                    <div class="bg-indigo-50 p-4 rounded-xl mb-4">
                        <p class="text-[11px] text-indigo-700 leading-tight">Verifica los requerimientos de salud:</p>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition">
                            <input  required type="checkbox" id="chk-vacunas" class="w-4 h-4 text-indigo-600 rounded">
                            <span class="ml-3 text-sm text-gray-600">Certificado de Vacunación al día</span>
                        </label>
                        <label
                            class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition">
                            <input required type="checkbox" id="chk-kc" class="w-4 h-4 text-indigo-600 rounded">
                            <span class="ml-3 text-sm text-gray-600">Vacuna KC (Tos de las perreras)</span>
                        </label>
                        <label
                            class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition">
                            <input required type="checkbox" id="chk-desparasitacion" class="w-4 h-4 text-indigo-600 rounded">
                            <span class="ml-3 text-sm text-gray-600">Desparasitación vigente</span>
                        </label>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Veterinaria de
                                confianza</label>
                            <input type="text" name="veterinariaconfianza"
                                class="w-full px-4 py-2.5 rounded-xl bg-gray-50 border border-gray-200 outline-none focus:border-indigo-500 transition">
                        </div>

                        <label
                            class="flex items-center p-3 rounded-xl border border-gray-100 hover:bg-gray-50 cursor-pointer transition">
                            <input type="checkbox" id="chk-aceptacion" required class="w-4 h-4 text-indigo-600 rounded">
                            <span class="ml-3 text-sm text-gray-600">Declaro que la información proporcionada es
                                verídica y acepto entregar los certificados en caso sean solicitados.
                            </span>
                        </label>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="nextStep(1)"
                            class="flex-1 py-3 bg-gray-100 text-gray-500 rounded-xl font-bold hover:bg-gray-200 transition">Atrás</button>
                        <button type="button" onclick="nextStep(3)"
                            class="flex-1 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 shadow-lg transition">Siguiente</button>
                    </div>
                </div>

                <div id="form-step-3" class="hidden space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Comportamiento</label>
                        <textarea name="comportamiento" rows="3"
                            class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition resize-none text-sm" placeholder="Escribe si tu mascota es sociable con otras o algún comportamiento que debamos tener en cuenta"></textarea >
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1 ml-1">Indicaciones
                            Extras</label>
                        <textarea name="indicacionesextra" rows="3"
                            class="w-full px-4 py-3 rounded-2xl bg-gray-50 border border-transparent focus:border-indigo-500 focus:bg-white outline-none transition resize-none text-sm" placeholder="Tiene algún requerimiento especial en su alimentación, paseos o medicación"></textarea >
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" onclick="nextStep(2)"
                            class="flex-1 py-3 bg-gray-100 text-gray-500 rounded-xl font-bold hover:bg-gray-200 transition">Atrás</button>
                        <button type="submit" id="save-changes"
                            class="flex-1 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 shadow-lg transition">Finalizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/perfilmascota.js"></script>
</body>

</html>