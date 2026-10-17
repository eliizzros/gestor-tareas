<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfbf9] min-h-screen flex flex-col justify-between">

    <!-- Barra de navegación superior -->
    <header class="w-full px-8 py-6 flex justify-between items-center">
        <div class="flex items-center gap-6 text-sm font-semibold text-stone-600">
            <a href="<?= base_url('home') ?>" class="hover:text-stone-900 transition">Home</a>
            <a href="#" class="hover:text-stone-900 transition">English</a>
            <a href="#" class="hover:text-stone-900 transition">Español</a>
        </div>
        <div>
            <a href="<?= base_url('login') ?>" class="px-5 py-2 border border-stone-300 rounded-full text-sm font-semibold text-stone-700 hover:bg-stone-50 transition">Log in</a>
        </div>
    </header>

    <!-- Contenido Central -->
    <main class="flex-1 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-[420px] p-10 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100">
            
            <h1 class="text-3xl font-bold text-stone-900 mb-2">Restablecer</h1>
            <p class="text-xs text-stone-400 mb-8">Escribe tu nueva contraseña de acceso</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 border border-red-200 text-red-600 text-xs p-3 rounded-xl mb-6">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('reset-password') ?>" method="POST" class="space-y-6">
                <input type="hidden" name="token" value="<?= esc($token) ?>">

                <div>
                    <label class="block text-xs font-semibold text-stone-600 mb-2">Nueva Contraseña</label>
                    <input type="password" name="password" required placeholder="••••••••" 
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:outline-none focus:border-amber-500 text-stone-800 text-sm transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-stone-600 mb-2">Confirmar Contraseña</label>
                    <input type="password" name="confirm_password" required placeholder="••••••••" 
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:outline-none focus:border-amber-500 text-stone-800 text-sm transition">
                </div>

                <button type="submit" 
                        class="w-full bg-[#d97706] hover:bg-[#b45309] text-white font-semibold py-3 px-4 rounded-xl shadow-md transition text-sm">
                    Guardar nueva contraseña
                </button>
            </form>

        </div>
    </main>

    <footer class="py-4"></footer>

</body>
</html>
