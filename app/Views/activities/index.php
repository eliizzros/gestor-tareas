<?php
$currentLang = session()->get('lang') ?? 'es';

$texts = [
    'es' => [
        'home'       => 'Inicio',
        'english'    => 'Inglés',
        'spanish'    => 'Español',
        'hello'      => 'Hola,',
        'admin'      => 'Admin',
        'profile'    => 'Perfil',
        'users'      => 'Usuarios',
        'tasks'      => 'Tareas',
        'logout'     => 'Cerrar Sesión',
        'welcome'    => 'Bienvenido',
        'logged_msg' => 'Has iniciado sesión correctamente en el sistema. Selecciona una opción en el menú superior para comenzar.'
    ],
    'en' => [
        'home'       => 'Home',
        'english'    => 'English',
        'spanish'    => 'Spanish',
        'hello'      => 'Hello,',
        'admin'      => 'Admin',
        'profile'    => 'Profile',
        'users'      => 'Users',
        'tasks'      => 'Tasks',
        'logout'     => 'Log out',
        'welcome'    => 'Welcome',
        'logged_msg' => 'You have successfully logged into the system. Select an option from the top menu to get started.'
    ]
];

$t = $texts[$currentLang];
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $t['welcome'] ?> - Gestor de Tareas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfbf9] min-h-screen flex flex-col justify-between">

    <!-- Header / Barra de Navegación -->
    <header class="w-full px-8 py-5 flex justify-between items-center bg-white border-b border-stone-100 shadow-sm">
        
        <!-- Navegación Izquierda (Botones de Idioma Funcionales) -->
        <div class="flex items-center gap-6 text-sm font-semibold text-stone-600">
            <a href="<?= base_url('home') ?>" class="hover:text-stone-900 transition"><?= $t['home'] ?></a>
            <a href="<?= base_url('lang/en') ?>" class="<?= $currentLang === 'en' ? 'text-[#d97706] font-bold' : 'hover:text-stone-900' ?> transition"><?= $t['english'] ?></a>
            <a href="<?= base_url('lang/es') ?>" class="<?= $currentLang === 'es' ? 'text-[#d97706] font-bold' : 'hover:text-stone-900' ?> transition"><?= $t['spanish'] ?></a>
        </div>

        <!-- Navegación Derecha -->
        <div class="flex items-center gap-6 text-sm font-semibold text-stone-600">
            <span class="text-stone-800">
                <?= $t['hello'] ?> <?= esc(session()->get('username')) ?>
                <?php if (session()->get('role') === 'admin'): ?>
                    <span class="ml-1 text-[#d97706] font-bold"><?= $t['admin'] ?></span>
                <?php endif; ?>
            </span>

            <a href="<?= base_url('profile') ?>" class="hover:text-stone-900 transition"><?= $t['profile'] ?></a>

            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('admin/users') ?>" class="text-[#d97706] hover:underline transition font-bold"><?= $t['users'] ?></a>
            <?php endif; ?>

            <a href="<?= base_url('tasks') ?>" class="hover:text-stone-900 transition"><?= $t['tasks'] ?></a>

            <a href="<?= base_url('logout') ?>" class="px-4 py-1.5 border border-stone-300 rounded-full text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                <?= $t['logout'] ?>
            </a>
        </div>

    </header>

    <!-- Contenido Principal -->
    <main class="flex-1 max-w-5xl w-full mx-auto p-8">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-8 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-semibold"><?= session()->getFlashdata('success') ?></span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold text-sm">✕</button>
            </div>
        <?php endif; ?>

        <h1 class="text-4xl font-bold text-stone-900 mb-6"><?= $t['welcome'] ?></h1>

        <div class="bg-white p-10 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100">
            <p class="text-stone-600 text-sm"><?= $t['logged_msg'] ?></p>
        </div>

    </main>

    <footer class="py-4 text-center text-xs text-stone-400">
        &copy; <?= date('Y') ?> - Todos los derechos reservados.
    </footer>

</body>
</html>
