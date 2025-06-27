{{-- @extends('components.layouts.app')

@section('content') --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="min-h-screen bg-gradient-to-br from-green-100 via-emerald-200 to-teal-100 flex flex-col">
    <!-- Header -->
    <header class="flex justify-between items-center px-8 py-6 bg-white/80 shadow-md">
        <div class="flex items-center gap-3">
            <span class="inline-block bg-emerald-500 rounded-full w-10 h-10 flex items-center justify-center text-white text-2xl font-bold">VC</span>
            <span class="text-3xl font-extrabold text-emerald-700 tracking-wide">Verde Caribe</span>
        </div>
        <nav class="space-x-8 text-emerald-700 font-medium">
            <a href="#servicios" class="hover:text-emerald-900 transition">Servicios</a>
            <a href="#galeria" class="hover:text-emerald-900 transition">Galería</a>
            <a href="#contacto" class="hover:text-emerald-900 transition">Contacto</a>
        </nav>
    </header>

    <!-- Hero -->
    <section class="flex-1 flex flex-col md:flex-row items-center justify-between px-8 py-20 gap-10">
        <div class="max-w-xl">
            <h1 class="text-5xl md:text-6xl font-extrabold text-emerald-700 mb-6 leading-tight drop-shadow-lg">Cultivando Naturaleza y Belleza en tu Hogar</h1>
            <p class="text-lg md:text-xl text-emerald-800 mb-8">En Verde Caribe transformamos tus espacios con jardines vibrantes, paisajismo profesional y un toque caribeño único. ¡Haz de tu hogar un paraíso natural!</p>
            <a href="#contacto" class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-8 py-3 rounded-lg shadow transition">Solicita tu cotización</a>
        </div>
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80" alt="Jardinería Verde Caribe" class="rounded-3xl shadow-2xl w-full max-w-md">
    </section>

    <!-- Servicios -->
    <section id="servicios" class="py-16 bg-white/70">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-emerald-700 mb-12">Nuestros Servicios</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="bg-emerald-50 rounded-xl p-8 shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🌱</div>
                    <h3 class="text-2xl font-semibold mb-2 text-emerald-800">Diseño de Jardines</h3>
                    <p class="text-emerald-700">Creamos jardines personalizados que se adaptan a tu espacio y estilo de vida.</p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-8 shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🪴</div>
                    <h3 class="text-2xl font-semibold mb-2 text-emerald-800">Mantenimiento</h3>
                    <p class="text-emerald-700">Cuidamos de tus plantas y áreas verdes para que siempre luzcan espectaculares.</p>
                </div>
                <div class="bg-emerald-50 rounded-xl p-8 shadow hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🌸</div>
                    <h3 class="text-2xl font-semibold mb-2 text-emerald-800">Paisajismo</h3>
                    <p class="text-emerald-700">Transformamos espacios con técnicas de paisajismo y selección de plantas tropicales.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Galería -->
    <section id="galeria" class="py-16 bg-gradient-to-r from-emerald-100 via-white to-emerald-50">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-emerald-700 mb-12">Galería</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <img src="https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80" class="rounded-xl shadow-md h-40 w-full object-cover" alt="Jardín 1">
                <img src="https://images.unsplash.com/photo-1444392061186-6e23071c6127?auto=format&fit=crop&w=400&q=80" class="rounded-xl shadow-md h-40 w-full object-cover" alt="Jardín 2">
                <img src="https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=400&q=80" class="rounded-xl shadow-md h-40 w-full object-cover" alt="Jardín 3">
                <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=400&q=80" class="rounded-xl shadow-md h-40 w-full object-cover" alt="Jardín 4">
            </div>
        </div>
    </section>

    <!-- Contacto -->
    <section id="contacto" class="py-16 bg-white/80">
        <div class="max-w-2xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-emerald-700 mb-8">Contáctanos</h2>
            <form class="bg-emerald-50 rounded-xl p-8 shadow space-y-6">
                <div>
                    <label class="block text-emerald-800 font-semibold mb-2">Nombre</label>
                    <input type="text" class="w-full px-4 py-2 rounded border border-emerald-200 focus:ring-2 focus:ring-emerald-400 outline-none" placeholder="Tu nombre">
                </div>
                <div>
                    <label class="block text-emerald-800 font-semibold mb-2">Correo electrónico</label>
                    <input type="email" class="w-full px-4 py-2 rounded border border-emerald-200 focus:ring-2 focus:ring-emerald-400 outline-none" placeholder="tucorreo@email.com">
                </div>
                <div>
                    <label class="block text-emerald-800 font-semibold mb-2">Mensaje</label>
                    <textarea class="w-full px-4 py-2 rounded border border-emerald-200 focus:ring-2 focus:ring-emerald-400 outline-none" rows="4" placeholder="¿En qué podemos ayudarte?"></textarea>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">Enviar mensaje</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-6 text-emerald-800 bg-white/70 mt-8">
        © 2025 Verde Caribe. Todos los derechos reservados.
    </footer>
</div>
{{-- @endsection --}}
