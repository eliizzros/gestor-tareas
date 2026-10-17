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
        'title'       => 'User',
        'back'        => '<< back to index',
        'lbl_name'    => 'name',
        'lbl_email'   => 'email',
        'lbl_active'  => 'active',
        'lbl_admin'   => 'Administrator',
        'lbl_created' => 'Created at',
        'lbl_updated' => 'Updated at',
        'yes'         => 'yes',
        'no'          => 'No',
        'btn_edit'    => 'Edit',
        'btn_delete'  => 'Delete'
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
        'title'       => 'User',
        'back'        => '<< back to index',
        'lbl_name'    => 'name',
        'lbl_email'   => 'email',
        'lbl_active'  => 'active',
        'lbl_admin'   => 'Administrator',
        'lbl_created' => 'Created at',
        'lbl_updated' => 'Updated at',
        'yes'         => 'yes',
        'no'          => 'No',
        'btn_edit'    => 'Edit',
        'btn_delete'  => 'Delete'
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
            <a href="<?= base_url('admin/users') ?>" class="text-[#d97706] font-bold transition"><?= $t['users'] ?></a>
            <a href="<?= base_url('tasks') ?>" class="hover:text-stone-900 transition"><?= $t['tasks'] ?></a>

            <a href="<?= base_url('logout') ?>" class="px-4 py-1.5 border border-stone-300 rounded-full text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                <?= $t['logout'] ?>
            </a>
        </div>
    </header>

    <!-- Contenido: Detalle del Usuario -->
    <main class="flex-1 max-w-4xl w-full mx-auto p-8">

        <h1 class="text-3xl font-bold text-stone-900 mb-2"><?= $t['title'] ?></h1>
        <a href="<?= base_url('admin/users') ?>" class="text-amber-600 hover:underline text-xs font-semibold block mb-8">
            <?= $t['back'] ?>
        </a>

        <div class="bg-white p-8 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100 max-w-xl space-y-6">
            
            <div>
                <span class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-1"><?= $t['lbl_name'] ?></span>
                <p class="text-stone-900 font-semibold text-base pl-2"><?= esc($user['username']) ?></p>
            </div>

            <div>
                <span class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-1"><?= $t['lbl_email'] ?></span>
                <p class="text-stone-900 font-semibold text-base pl-2"><?= esc($user['email']) ?></p>
            </div>

            <div>
                <span class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-1"><?= $t['lbl_active'] ?></span>
                <p class="text-stone-900 font-semibold text-base pl-2"><?= $user['is_verified'] ? $t['yes'] : $t['no'] ?></p>
            </div>

            <div>
                <span class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-1"><?= $t['lbl_admin'] ?></span>
                <p class="text-stone-900 font-semibold text-base pl-2"><?= ($user['role'] === 'admin') ? $t['yes'] : $t['no'] ?></p>
            </div>

            <div>
                <span class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-1"><?= $t['lbl_created'] ?></span>
                <p class="text-stone-700 font-medium text-sm pl-2"><?= esc($user['created_at']) ?></p>
            </div>

            <div>
                <span class="block text-xs font-bold text-stone-500 uppercase tracking-wider mb-1"><?= $t['lbl_updated'] ?></span>
                <p class="text-stone-700 font-medium text-sm pl-2"><?= esc($user['created_at']) ?></p>
            </div>

            <div class="flex items-center gap-4 pt-4 border-t border-stone-100">
                <a href="<?= base_url('admin/users/edit/' . $user['id']) ?>" class="text-amber-600 hover:underline font-bold text-sm">
                    <?= $t['btn_edit'] ?>
                </a>
                <a href="<?= base_url('admin/users/delete/' . $user['id']) ?>" onclick="return confirm('¿Eliminar este estudiante?');" class="text-rose-600 hover:underline font-bold text-sm">
                    <?= $t['btn_delete'] ?>
                </a>
            </div>

        </div>

    </main>

    <footer class="py-4 text-center text-xs text-stone-400">
        &copy; <?= date('Y') ?> - Todos los derechos reservados.
    </footer>

</body>
</html>
