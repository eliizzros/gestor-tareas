<?php
$currentLang = session()->get('lang') ?? 'es';

$texts = [
    'es' => [
        'home'        => 'Inicio',
        'english'     => 'Inglés',
        'spanish'     => 'Español',
        'hello'       => 'Hola,',
        'admin'       => 'Admin',
        'profile'     => 'Perfil',
        'users'       => 'Usuarios',
        'tasks'       => 'Tareas',
        'logout'      => 'Cerrar Sesión',
        'title'       => 'Usuarios',
        'new_user'    => 'Nuevo usuario',
        'col_name'    => 'Nombre',
        'col_email'   => 'Correo electrónico',
        'col_act'     => 'Activo',
        'col_admin'   => 'Administrador',
        'col_created' => 'Fecha de creación',
        'yes'         => 'Sí',
        'no'          => 'No',
        'newer'       => 'Más recientes',
        'older'       => 'Más antiguas'
    ],
    'en' => [
        'home'        => 'Home',
        'english'     => 'English',
        'spanish'     => 'Spanish',
        'hello'       => 'Hello,',
        'admin'       => 'Admin',
        'profile'     => 'Profile',
        'users'       => 'Users',
        'tasks'       => 'Tasks',
        'logout'      => 'Log out',
        'title'       => 'Users',
        'new_user'    => 'New user',
        'col_name'    => 'Name',
        'col_email'   => 'email',
        'col_act'     => 'Active',
        'col_admin'   => 'Administrator',
        'col_created' => 'Created at',
        'yes'         => 'Yes',
        'no'          => 'No',
        'newer'       => 'Newer',
        'older'       => 'Older'
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
            <a href="<?= base_url('admin/users') ?>" class="text-[#d97706] font-bold transition"><?= $t['users'] ?></a>
            <a href="<?= base_url('tasks') ?>" class="hover:text-stone-900 transition"><?= $t['tasks'] ?></a>

            <a href="<?= base_url('logout') ?>" class="px-4 py-1.5 border border-stone-300 rounded-full text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                <?= $t['logout'] ?>
            </a>
        </div>
    </header>

    <!-- Contenido Principal: Tabla de Usuarios -->
    <main class="flex-1 max-w-5xl w-full mx-auto p-8">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3 rounded-2xl mb-6 text-xs font-semibold">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <h1 class="text-3xl font-bold text-stone-900 mb-6"><?= $t['title'] ?></h1>

        <div class="mb-6">
            <a href="<?= base_url('admin/users/create') ?>" class="px-5 py-2.5 bg-amber-100 hover:bg-amber-200 text-[#d97706] font-semibold text-xs rounded-xl border border-amber-200 transition">
                <?= $t['new_user'] ?>
            </a>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100 overflow-x-auto">
            <table class="w-full text-left text-sm text-stone-700">
                <thead>
                    <tr class="border-b-2 border-stone-800 text-stone-900 font-bold">
                        <th class="pb-3 px-3"><?= $t['col_name'] ?></th>
                        <th class="pb-3 px-3"><?= $t['col_email'] ?></th>
                        <th class="pb-3 px-3 text-center"><?= $t['col_act'] ?></th>
                        <th class="pb-3 px-3 text-center"><?= $t['col_admin'] ?></th>
                        <th class="pb-3 px-3"><?= $t['col_created'] ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-200">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-stone-50 transition">
                            <td class="py-4 px-3 font-medium">
                                <a href="<?= base_url('admin/users/show/' . $user['id']) ?>" class="text-stone-900 hover:text-[#d97706] underline transition">
                                    <?= esc($user['username']) ?>
                                </a>
                            </td>
                            <td class="py-4 px-3 text-stone-600"><?= esc($user['email']) ?></td>
                            <td class="py-4 px-3 text-center"><?= $user['is_verified'] ? $t['yes'] : $t['no'] ?></td>
                            <td class="py-4 px-3 text-center"><?= ($user['role'] === 'admin') ? $t['yes'] : $t['no'] ?></td>
                            <td class="py-4 px-3 text-stone-500 text-xs"><?= esc($user['created_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Botones de Ordenamiento (Newer / Older) -->
        <div class="flex gap-3 mt-6">
            <a href="<?= base_url('admin/users?sort=desc') ?>" class="px-5 py-2 <?= (isset($currentSort) && $currentSort === 'DESC') ? 'bg-[#d97706] text-white font-bold' : 'bg-amber-100 text-[#d97706]' ?> hover:bg-amber-200 text-xs rounded-xl border border-amber-200 transition">
                <?= $t['newer'] ?>
            </a>
            <a href="<?= base_url('admin/users?sort=asc') ?>" class="px-5 py-2 <?= (isset($currentSort) && $currentSort === 'ASC') ? 'bg-[#d97706] text-white font-bold' : 'bg-amber-100 text-[#d97706]' ?> hover:bg-amber-200 text-xs rounded-xl border border-amber-200 transition">
                <?= $t['older'] ?>
            </a>
        </div>

    </main>

    <footer class="py-4"></footer>

</body>
</html>
