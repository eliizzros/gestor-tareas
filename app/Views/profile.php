<?php
$currentLang = session()->get('lang') ?? 'es';

$texts = [
    'es' => [
        'home'             => 'Inicio',
        'english'          => 'Inglés',
        'spanish'          => 'Español',
        'hello'            => 'Hola,',
        'admin'            => 'Admin',
        'profile'          => 'Perfil',
        'users'            => 'Usuarios',
        'tasks'            => 'Tareas',
        'logout'           => 'Cerrar Sesión',
        'profile_title'    => 'Perfil',
        'del_image'        => 'Eliminar imagen de perfil',
        'name_label'       => 'Nombre',
        'email_label'      => 'Correo electrónico',
        'btn_edit'         => 'Editar',
        'btn_change_pass'  => 'Cambiar contraseña',
        'btn_change_img'   => 'Cambiar imagen de perfil'
    ],
    'en' => [
        'home'             => 'Home',
        'english'          => 'English',
        'spanish'          => 'Spanish',
        'hello'            => 'Hello,',
        'admin'            => 'Admin',
        'profile'          => 'Profile',
        'users'            => 'Users',
        'tasks'            => 'Tasks',
        'logout'           => 'Log out',
        'profile_title'    => 'Profile',
        'del_image'        => 'Delete Profile image',
        'name_label'       => 'Name',
        'email_label'      => 'Email',
        'btn_edit'         => 'Edit',
        'btn_change_pass'  => 'Change password',
        'btn_change_img'   => 'Change profile image'
    ]
];

$t = $texts[$currentLang];
$profileImg = session()->get('profile_image');
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $t['profile_title'] ?> - Gestor de Tareas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfbf9] min-h-screen flex flex-col justify-between">

    <!-- Header / Barra de Navegación -->
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

            <a href="<?= base_url('profile') ?>" class="text-[#d97706] font-bold transition"><?= $t['profile'] ?></a>

            <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= base_url('admin/users') ?>" class="hover:text-stone-900 transition font-bold"><?= $t['users'] ?></a>
            <?php endif; ?>

            <a href="<?= base_url('tasks') ?>" class="hover:text-stone-900 transition"><?= $t['tasks'] ?></a>

            <a href="<?= base_url('logout') ?>" class="px-4 py-1.5 border border-stone-300 rounded-full text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                <?= $t['logout'] ?>
            </a>
        </div>
    </header>

    <main class="flex-1 max-w-4xl w-full mx-auto p-8">

        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl mb-8 shadow-sm flex items-center justify-between">
                <span class="text-sm font-semibold"><?= session()->getFlashdata('success') ?></span>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 font-bold text-sm">✕</button>
            </div>
        <?php endif; ?>

        <h1 class="text-4xl font-bold text-stone-900 mb-8"><?= $t['profile_title'] ?></h1>

        <div class="bg-white p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100 max-w-xl">
            
            <div class="mb-6">
                <div class="w-36 h-36 bg-stone-100 border border-stone-200 rounded-2xl flex items-center justify-center overflow-hidden mb-3">
                    <?php if (!empty($profileImg)): ?>
                        <img src="<?= base_url('uploads/profiles/' . $profileImg) ?>" alt="Profile" class="w-full h-full object-cover">
                    <?php else: ?>
                        <svg class="w-16 h-16 text-stone-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    <?php endif; ?>
                </div>

                <?php if (!empty($profileImg)): ?>
                    <a href="<?= base_url('profile/delete-image') ?>" class="inline-block px-4 py-2 bg-rose-100 hover:bg-rose-200 text-rose-700 text-xs font-semibold rounded-xl border border-rose-200 transition">
                        <?= $t['del_image'] ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="space-y-4 mb-8">
                <div>
                    <span class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-1"><?= $t['name_label'] ?></span>
                    <p class="text-stone-800 font-semibold text-base"><?= esc(session()->get('username')) ?></p>
                </div>

                <div>
                    <span class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-1"><?= $t['email_label'] ?></span>
                    <p class="text-stone-800 font-semibold text-base"><?= esc(session()->get('email')) ?></p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <a href="<?= base_url('profile/edit') ?>" class="px-5 py-2.5 bg-amber-100 hover:bg-amber-200 text-[#d97706] font-semibold text-xs rounded-xl border border-amber-200 transition">
                    <?= $t['btn_edit'] ?>
                </a>

                <a href="<?= base_url('profile/change-password') ?>" class="px-5 py-2.5 bg-amber-100 hover:bg-amber-200 text-[#d97706] font-semibold text-xs rounded-xl border border-amber-200 transition">
                    <?= $t['btn_change_pass'] ?>
                </a>

                <a href="<?= base_url('profile/change-image') ?>" class="px-5 py-2.5 bg-amber-100 hover:bg-amber-200 text-[#d97706] font-semibold text-xs rounded-xl border border-amber-200 transition">
                    <?= $t['btn_change_img'] ?>
                </a>
            </div>

        </div>

    </main>

    <footer class="py-4 text-center text-xs text-stone-400">
        &copy; <?= date('Y') ?> - Todos los derechos reservados.
    </footer>

</body>
</html>
