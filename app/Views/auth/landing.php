<?php
$currentLang = session()->get('lang') ?? 'es';

$texts = [
    'es' => [
        'home'        => 'Home',
        'english'     => 'English',
        'spanish'     => 'Español',
        'signup'      => 'Sign up',
        'login'       => 'Log in',
        'welcome'     => 'Welcome',
        'subtitle'    => 'Gestor independiente de actividades con arquitectura renovada.',
        'btn_login'   => 'Iniciar Sesión',
        'btn_register'=> 'Registrarse'
    ],
    'en' => [
        'home'        => 'Home',
        'english'     => 'English',
        'spanish'     => 'Spanish',
        'signup'      => 'Sign up',
        'login'       => 'Log in',
        'welcome'     => 'Welcome',
        'subtitle'    => 'Independent activity manager with renewed architecture.',
        'btn_login'   => 'Log in',
        'btn_register'=> 'Sign up'
    ]
];

$t = $texts[$currentLang];
?>
<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#fcfbf9] min-h-screen flex flex-col justify-between">

    <!-- Header Público -->
    <header class="w-full px-8 py-5 flex justify-between items-center bg-white border-b border-stone-100 shadow-sm">
        <div class="flex items-center gap-6 text-sm font-semibold text-stone-600">
            <a href="<?= base_url('home') ?>" class="hover:text-stone-900 transition"><?= $t['home'] ?></a>
            <a href="<?= base_url('lang/en') ?>" class="<?= $currentLang === 'en' ? 'text-[#d97706] font-bold' : 'hover:text-stone-900' ?> transition"><?= $t['english'] ?></a>
            <a href="<?= base_url('lang/es') ?>" class="<?= $currentLang === 'es' ? 'text-[#d97706] font-bold' : 'hover:text-stone-900' ?> transition"><?= $t['spanish'] ?></a>
        </div>

        <div class="flex items-center gap-4">
            <a href="<?= base_url('register') ?>" class="px-5 py-2 border border-stone-300 rounded-full text-xs font-semibold text-stone-700 hover:bg-stone-100 transition">
                <?= $t['signup'] ?>
            </a>
            <a href="<?= base_url('login') ?>" class="px-5 py-2 bg-[#d97706] hover:bg-amber-700 text-white rounded-full text-xs font-semibold shadow-sm transition">
                <?= $t['login'] ?>
            </a>
        </div>
    </header>

    <!-- Contenido Landing -->
    <main class="flex-1 max-w-4xl w-full mx-auto p-8 flex items-center justify-center">
        <div class="bg-white p-12 rounded-3xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-stone-100 w-full max-w-2xl">
            <h1 class="text-5xl font-bold text-stone-900 mb-4"><?= $t['welcome'] ?></h1>
            <p class="text-stone-600 text-base mb-8"><?= $t['subtitle'] ?></p>

            <div class="flex items-center gap-4">
                <a href="<?= base_url('login') ?>" class="px-6 py-3 bg-[#d97706] hover:bg-amber-700 text-white font-semibold rounded-xl text-sm shadow-sm transition">
                    <?= $t['btn_login'] ?>
                </a>
                <a href="<?= base_url('register') ?>" class="px-6 py-3 border border-stone-300 hover:bg-stone-50 text-stone-800 font-semibold rounded-xl text-sm transition">
                    <?= $t['btn_register'] ?>
                </a>
            </div>
        </div>
    </main>

    <footer class="py-4"></footer>

</body>
</html>
