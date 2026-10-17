<?php
$currentLang = session()->get('lang') ?? 'es';

$texts = [
    'es' => [
        'home'      => 'Inicio',
        'english'   => 'Inglés',
        'spanish'   => 'Español',
        'hello'     => 'Hola,',
        'admin'     => 'Admin',
        'profile'   => 'Perfil',
        'users'     => 'Usuarios',
        'tasks'     => 'Tareas',
        'logout'    => 'Cerrar Sesión',
        'title'     => 'Tareas',
        'new_task'  => 'Nueva Tarea',
        'search'    => 'Buscar',
        'newer'     => 'Más recientes',
        'older'     => 'Más antiguas',
        'no_tasks'  => 'No hay tareas registradas.'
    ],
    'en' => [
        'home'      => 'Home',
        'english'   => 'English',
        'spanish'   => 'Spanish',
        'hello'     => 'Hello,',
        'admin'     => 'Admin',
        'profile'   => 'Profile',
        'users'     => 'Users',
        'tasks'     => 'Tasks',
        'logout'    => 'Log out',
        'title'     => 'Tasks',
        'new_task'  => 'New Task',
        'search'    => 'Search',
        'newer'     => 'Newer',
        'older'     => 'Older',
        'no_tasks'  => 'No tasks found.'
    ]
];

$t = $texts[$currentLang];
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $t['title'] ?> - Gestor de Tareas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfbf9] min-h-screen flex flex-col justify-between">

    <!-- Header / Navegación -->
    <header class="w-full px-8 py-5 flex justify-between items-center bg-white border-b border-stone-100 shadow-sm">
        <div class="flex items-center gap-6 text-sm font-semibold text-stone-600">
            <a href="<?= base_url('home') ?>" class="hover:text-stone-900 transition"><?= $t['home'] ?></a>
            <a href="<?= base_url('lang/en') ?>" class="<?= $currentLang === 'en' ? 'text-[#d97706] font-bold' : 'hover:text-stone-900' ?> transition"><?= $t['english'] ?></a>
            <a href="<?= base_url('lang/es') ?>" class="<?= $currentLang === 'es' ? 'text-[#d97706] font-bold' : 'hover:text-stone-900' ?> transition"><?= $t['spanish'] ?></a>
        </div>

        <div class="flex items-center gap-6 text-sm font-semibold text-stone-600">
            <span class="text-stone-800">
                <?= $t['hello'] ?> <?= esc(session()->get('username')) ?>
                <?php if (session()->get('role') === 'admin'): ?>
                    <span class="ml-1 text-[#d97706] font-bold"><?= $t['admin'] ?></span>
                <?php endif; ?>
            </span>

            <a href="<?= base_url('profile') ?>" class="hover:text-stone-900 transition"><?= $t['profile'] ?></a>
            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('admin/users') ?>" class="hover:text-stone-900 transition font-bold"><?= $t['users'] ?></a>
            <?php endif; ?>
            <a href="<?= base_url('tasks') ?>" class="text-[#d97706] font-bold transition"><?= $t['tasks'] ?></a>

            <a href="<?= base_url('logout') ?>" class="px-4 py-1.5 border border-stone-300 rounded-full text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                <?= $t['logout'] ?>
            </a>
        </div>
    </header>

    <!-- Contenido Principal: Tareas -->
    <main class="flex-1 max-w-4xl w-full mx-auto p-8">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3 rounded-2xl mb-6 text-xs font-semibold">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <h1 class="text-3xl font-bold text-stone-900 mb-6"><?= $t['title'] ?></h1>

        <div class="mb-6">
            <a href="<?= base_url('tasks/create') ?>" class="px-5 py-2.5 bg-amber-100 hover:bg-amber-200 text-[#d97706] font-semibold text-xs rounded-xl border border-amber-200 transition">
                <?= $t['new_task'] ?>
            </a>
        </div>

        <!-- Barra de Búsqueda -->
        <form action="<?= base_url('tasks') ?>" method="GET" class="mb-8 flex items-center gap-2 max-w-md">
            <div class="relative w-full">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-stone-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="<?= $t['search'] ?>..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-stone-200 focus:outline-none focus:border-amber-500 text-sm text-stone-800 bg-white">
            </div>
            <input type="hidden" name="sort" value="<?= esc($currentSort ?? 'DESC') ?>">
        </form>

        <!-- Listado de Tareas -->
        <div class="bg-white p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100 space-y-4 mb-6">
            <?php if (empty($tasks)): ?>
                <p class="text-stone-400 text-sm"><?= $t['no_tasks'] ?></p>
            <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="pb-3 border-b border-stone-100 last:border-0 flex justify-between items-center">
                        <a href="<?= base_url('tasks/edit/' . $task['id']) ?>" class="text-[#d97706] hover:underline font-medium text-base">
                            <?= esc($task['description']) ?>
                        </a>
                        <a href="<?= base_url('tasks/delete/' . $task['id']) ?>" onclick="return confirm('¿Eliminar esta tarea?');" class="text-xs text-rose-500 hover:underline">✕</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Botones Newer / Older -->
        <div class="flex gap-3">
            <a href="<?= base_url('tasks?sort=desc' . (!empty($search) ? '&search=' . urlencode($search) : '')) ?>" class="px-5 py-2 <?= (isset($currentSort) && $currentSort === 'DESC') ? 'bg-[#d97706] text-white font-bold' : 'bg-amber-100 text-[#d97706]' ?> hover:bg-amber-200 text-xs rounded-xl border border-amber-200 transition">
                <?= $t['newer'] ?>
            </a>
            <a href="<?= base_url('tasks?sort=asc' . (!empty($search) ? '&search=' . urlencode($search) : '')) ?>" class="px-5 py-2 <?= (isset($currentSort) && $currentSort === 'ASC') ? 'bg-[#d97706] text-white font-bold' : 'bg-amber-100 text-[#d97706]' ?> hover:bg-amber-200 text-xs rounded-xl border border-amber-200 transition">
                <?= $t['older'] ?>
            </a>
        </div>

    </main>

    <footer class="py-4"></footer>

</body>
</html>
