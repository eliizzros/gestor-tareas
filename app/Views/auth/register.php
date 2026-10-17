<?php
$currentLang = session()->get('lang') ?? 'es';

$texts = [
    'es' => [
        'home'          => 'Home',
        'english'       => 'English',
        'spanish'       => 'Español',
        'signup'        => 'Sign up',
        'login'         => 'Log in',
        'title'         => 'Sign up',
        'subtitle'      => 'Crea una cuenta para empezar a gestionar tus actividades',
        'name_label'    => 'Nombre',
        'email_label'   => 'Correo',
        'pass_label'    => 'Contraseña',
        'btn_submit'    => 'Registrarse',
        'has_account'   => '¿Ya tienes cuenta?',
        'go_home'       => 'Volver a Home'
    ],
    'en' => [
        'home'          => 'Home',
        'english'       => 'English',
        'spanish'       => 'Spanish',
        'signup'        => 'Sign up',
        'login'         => 'Log in',
        'title'         => 'Sign up',
        'subtitle'      => 'Create an account to start managing your activities',
        'name_label'    => 'Name',
        'email_label'   => 'Email',
        'pass_label'    => 'Password',
        'btn_submit'    => 'Sign up',
        'has_account'   => 'Already have an account?',
        'go_home'       => 'Go back to Home'
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
            <a href="<?= base_url('/') ?>" class="hover:text-stone-900 transition"><?= $t['home'] ?></a>
            <a href="<?= base_url('lang/en') ?>" class="<?= $currentLang === 'en' ? 'text-[#d97706] font-bold' : 'hover:text-stone-900' ?> transition"><?= $t['english'] ?></a>
            <a href="<?= base_url('lang/es') ?>" class="<?= $currentLang === 'es' ? 'text-[#d97706] font-bold' : 'hover:text-stone-900' ?> transition"><?= $t['spanish'] ?></a>
        </div>

        <div class="flex items-center gap-4">
            <a href="<?= base_url('login') ?>" class="px-5 py-2 bg-[#d97706] hover:bg-amber-700 text-white rounded-full text-xs font-semibold shadow-sm transition">
                <?= $t['login'] ?>
            </a>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-1 max-w-4xl w-full mx-auto p-8 flex items-center justify-center">
        <div class="bg-white p-10 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100 w-full max-w-lg">
            
            <h1 class="text-3xl font-bold text-stone-900 mb-1"><?= $t['title'] ?></h1>
            <p class="text-xs text-stone-400 mb-6"><?= $t['subtitle'] ?></p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-50 border border-red-200 text-red-600 text-xs p-3 rounded-xl mb-4">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs p-3 rounded-xl mb-4">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register') ?>" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2"><?= $t['name_label'] ?></label>
                    <input type="text" name="username" required 
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:outline-none focus:border-amber-500 text-stone-800 text-sm transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2"><?= $t['email_label'] ?></label>
                    <input type="email" name="email" required 
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:outline-none focus:border-amber-500 text-stone-800 text-sm transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-600 uppercase tracking-wider mb-2"><?= $t['pass_label'] ?></label>
                    <input type="password" name="password" required placeholder="••••••••" 
                           class="w-full px-4 py-3 rounded-xl border border-stone-200 focus:outline-none focus:border-amber-500 text-stone-800 text-sm transition">
                </div>

                <button type="submit" class="w-full py-3 bg-[#d97706] hover:bg-amber-700 text-white font-semibold rounded-xl text-sm shadow-sm transition mt-2">
                    <?= $t['btn_submit'] ?>
                </button>
            </form>

            <div class="text-center mt-6 text-xs text-stone-500">
                <?= $t['has_account'] ?> 
                <a href="<?= base_url('login') ?>" class="text-[#d97706] font-bold hover:underline"><?= $t['login'] ?></a> | 
                <a href="<?= base_url('/') ?>" class="text-stone-700 font-bold hover:underline"><?= $t['go_home'] ?></a>
            </div>

        </div>
    </main>

    <footer class="py-4"></footer>

</body>
</html>
