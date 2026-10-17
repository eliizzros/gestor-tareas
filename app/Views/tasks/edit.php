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
        'title'      => 'Edit Task',
        'desc'       => 'Description',
        'btn_save'   => 'Save',
        'btn_cancel' => 'Cancel'
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
        'title'      => 'Edit Task',
        'desc'       => 'Description',
        'btn_save'   => 'Save',
        'btn_cancel' => 'Cancel'
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

    <!-- Header -->
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

    <!-- Contenido: Editar Tarea -->
    <main class="flex-1 max-w-4xl w-full mx-auto p-8">
        <h1 class="text-3xl font-bold text-stone-900 mb-8"><?= $t['title'] ?></h1>

        <div class="bg-white p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100 max-w-2xl">
            <form action="<?= base_url('tasks/update/' . $task['id']) ?>" method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2"><?= $t['desc'] ?></label>
                    <input type="text" name="description" required value="<?= esc($task['description']) ?>" 
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:outline-none focus:border-amber-500 text-stone-800 text-sm transition">
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <button type="submit" class="bg-emerald-400 hover:bg-emerald-500 text-stone-900 font-semibold py-2.5 px-6 rounded-xl border border-emerald-500 shadow-sm transition text-sm">
                        <?= $t['btn_save'] ?>
                    </button>
                    <a href="<?= base_url('tasks') ?>" class="bg-rose-200 hover:bg-rose-300 text-stone-900 font-semibold py-2.5 px-6 rounded-xl border border-rose-300 shadow-sm transition text-sm">
                        <?= $t['btn_cancel'] ?>
                    </a>
                </div>
            </form>
        </div>
    </main>

    <footer class="py-4"></footer>

</body>
</html>
