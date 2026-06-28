<?php
/**
 * Admin Header - Layout compartilhado para todas as páginas administrativas.
 * Inclui Tailwind via CDN, Google Fonts, sidebar de navegação e topbar.
 */
// Definir fuso horário padrão para evitar warnings do PHP
date_default_timezone_set('America/Sao_Paulo');

require_once __DIR__ . '/../../controllers/AuthController.php';
AuthController::protegerPagina();

$pagina_admin = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANZO'S Admin — Painel de Controle</title>

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
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #262626; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #cfa652; }

        .sidebar-link {
            position: relative;
            transition: all 0.2s;
        }
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background-color: #cfa652;
            border-radius: 0 2px 2px 0;
            transform: scaleY(0);
            transition: transform 0.2s;
        }
        .sidebar-link:hover::before, .sidebar-link-active::before {
            transform: scaleY(1);
        }

        /* Toast notification */
        .toast {
            animation: slideInRight 0.3s ease-out;
        }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed top-0 left-0 bottom-0 w-64 bg-neutral-950 border-r border-neutral-900 z-40 flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-neutral-900">
            <a href="../../index.php" target="_blank" rel="noopener" class="font-serif tracking-[0.25em] text-lg font-bold text-amber-100 hover:text-white transition-colors">MANZO'S</a>
            <span class="ml-auto text-[9px] tracking-wider uppercase text-gold-500 font-semibold bg-gold-500/10 px-2 py-1 rounded">Admin</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 py-6 px-3 space-y-1 overflow-y-auto">
            <p class="text-[10px] tracking-[0.2em] uppercase text-zinc-600 font-semibold px-3 mb-3">Principal</p>
            
            <a href="dashboard.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'dashboard.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <p class="text-[10px] tracking-[0.2em] uppercase text-zinc-600 font-semibold px-3 mt-6 mb-3">Operações</p>

            <a href="clientes.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'clientes.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Clientes
            </a>
            <a href="mesas.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'mesas.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                Mesas
            </a>
            <a href="reservas.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'reservas.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Reservas
            </a>
            <a href="cardapio.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'cardapio.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Cardápio
            </a>
            <a href="comandas.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'comandas.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Comandas
            </a>
            <a href="pagamentos.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'pagamentos.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Pagamentos
            </a>

            <p class="text-[10px] tracking-[0.2em] uppercase text-zinc-600 font-semibold px-3 mt-6 mb-3">Equipe & Parceiros</p>

            <a href="usuarios.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'usuarios.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Usuários
            </a>
            <a href="fornecedores.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'fornecedores.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                Fornecedores
            </a>

            <p class="text-[10px] tracking-[0.2em] uppercase text-zinc-600 font-semibold px-3 mt-6 mb-3">Análises</p>

            <a href="relatorios.php" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-sm text-sm <?= $pagina_admin == 'relatorios.php' ? 'sidebar-link-active bg-neutral-900 text-gold-400' : 'text-zinc-400 hover:text-amber-100 hover:bg-neutral-900/50' ?>">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Relatórios
            </a>
        </nav>

        <!-- User / Logout -->
        <div class="border-t border-neutral-900 px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gold-500/20 border border-gold-500/30 flex items-center justify-center text-gold-400 text-xs font-bold">
                    <?= strtoupper(substr(isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : 'U', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-white font-medium truncate"><?= htmlspecialchars(isset($_SESSION['usuario_nome']) ? $_SESSION['usuario_nome'] : 'Usuário') ?></p>
                    <p class="text-[10px] text-zinc-500 truncate"><?= htmlspecialchars(isset($_SESSION['usuario_cargo']) ? $_SESSION['usuario_cargo'] : '') ?></p>
                </div>
                <a href="logout.php" title="Sair" class="text-zinc-500 hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </a>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Main Content Area -->
    <div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
        <!-- Top Bar -->
        <header class="sticky top-0 z-20 bg-neutral-950/80 backdrop-blur-md border-b border-neutral-900 h-16 flex items-center px-6">
            <!-- Mobile hamburger -->
            <button onclick="toggleSidebar()" class="lg:hidden text-zinc-400 hover:text-white mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 text-xs">
                <span class="text-zinc-600">Admin</span>
                <span class="text-zinc-700">/</span>
                <span class="text-zinc-300 font-medium">
                    <?php
                    $titulos = [
                        'dashboard.php'    => 'Dashboard',
                        'clientes.php'     => 'Clientes',
                        'mesas.php'        => 'Mesas',
                        'reservas.php'     => 'Reservas',
                        'cardapio.php'     => 'Cardápio',
                        'comandas.php'     => 'Comandas',
                        'pagamentos.php'   => 'Pagamentos',
                        'garcons.php'      => 'Garçons',
                        'usuarios.php'     => 'Usuários',
                        'fornecedores.php' => 'Fornecedores',
                        'relatorios.php'   => 'Relatórios',
                    ];
                    echo isset($titulos[$pagina_admin]) ? $titulos[$pagina_admin] : 'Página';
                    ?>
                </span>
            </div>

            <!-- Right side: Link to site -->
            <a href="../../index.php" target="_blank" class="ml-auto flex items-center gap-2 text-[11px] text-zinc-500 hover:text-gold-400 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Ver Site
            </a>
        </header>

        <!-- Page Content Slot -->
        <main class="flex-1 p-6 lg:p-8">
