<?php
    // Definir fuso horário padrão para evitar warnings do PHP
    date_default_timezone_set('America/Sao_Paulo');

    require_once __DIR__ . "/../../controllers/AuthController.php";

    $mensagem_erro = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

        if (AuthController::login($email, $senha)) {
            header("Location: dashboard.php");
            exit;
        } else {
            $mensagem_erro = "E-mail ou senha incorretos.";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANZO'S — Login</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Playfair Display"', 'serif'],
                        sans: ['"Inter"', 'sans-serif'],
                    },
                    colors: {
                        gold: {
                            50: '#fbf7ee',
                            100: '#f5ebd3',
                            200: '#ebd7aa',
                            300: '#dec07a',
                            400: '#cfa652',
                            500: '#b2873c',
                            600: '#916a2f',
                            700: '#735125',
                            800: '#563c1f',
                            900: '#3c2918',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0a0a;
            color: #e5e5e5;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-neutral-950 px-4">

    <!-- Login Card -->
    <div class="w-full max-w-sm">

        <!-- Logo -->
        <div class="text-center mb-10">
            <h1 class="font-serif text-2xl text-amber-100 tracking-[0.25em] font-bold">MANZO'S</h1>
            <div class="w-12 h-[1px] bg-gold-500 mx-auto mt-3"></div>
            <p class="text-[10px] tracking-[0.2em] uppercase text-zinc-600 font-semibold mt-4">Acesso Restrito</p>
        </div>

        <!-- Card -->
        <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-8">

            <?php if (!empty($mensagem_erro)): ?>
                <div class="bg-red-500/10 border border-red-500/20 rounded-sm px-4 py-3 mb-6 flex items-center gap-3">
                    <svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <p class="text-red-400 text-xs font-medium"><?= htmlspecialchars($mensagem_erro) ?></p>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-5">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">E-mail</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        required
                        placeholder="admin@restaurante.com"
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20 placeholder-zinc-600"
                    >
                </div>

                <!-- Senha -->
                <div>
                    <label for="senha" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Senha</label>
                    <input
                        type="password"
                        name="senha"
                        id="senha"
                        required
                        placeholder="••••••••"
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20 placeholder-zinc-600"
                    >
                </div>

                <!-- Submit -->
                <button
                    type="submit"
                    class="w-full bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300 mt-2"
                >
                    Entrar no Sistema
                </button>
            </form>
        </div>

        <!-- Footer -->
        <p class="text-center text-[10px] text-zinc-700 mt-8">&copy; <?= date('Y') ?> MANZO'S — Painel Administrativo</p>
    </div>

</body>
</html>