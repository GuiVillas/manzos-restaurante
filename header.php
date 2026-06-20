<?php
// Definir fuso horário padrão para evitar warnings do PHP
date_default_timezone_set('America/Sao_Paulo');

// Obter a página atual para aplicar a classe ativa no menu
$pagina_atual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-br" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MANZO'S - Restaurante de Alta Gastronomia</title>
    
    <!-- Google Fonts: Playfair Display (Serif) & Inter (Sans-serif) -->
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
    
    <!-- Estilos customizados e animações para efeito Premium -->
    <style>
        body {
            background-color: #0a0a0a;
            color: #e5e5e5;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0a0a0a;
        }
        ::-webkit-scrollbar-thumb {
            background: #262626;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #cfa652;
        }

        /* Glassmorphism utility */
        .glass-nav {
            background: rgba(10, 10, 10, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(250, 204, 21, 0.05);
        }

        /* Fine decorative underline effect */
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 1px;
            bottom: -4px;
            left: 0;
            background-color: #cfa652;
            transform-origin: bottom right;
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .nav-link:hover::after, .nav-link-active::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <!-- Header Fixo -->
    <header class="fixed top-0 left-0 right-0 z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 h-24 flex items-center justify-between">
            <!-- Logo -->
            <a href="index.php" class="font-serif tracking-[0.25em] text-2xl font-bold text-amber-100 hover:text-white transition-colors duration-300">
                MANZO'S
            </a>

            <!-- Navegação Desktop -->
            <nav class="hidden md:flex items-center space-x-10">
                <a href="index.php" class="nav-link text-xs tracking-widest uppercase font-medium transition-colors duration-300 <?= ($pagina_atual == 'index.php' || $pagina_atual == '') ? 'text-gold-400 nav-link-active' : 'text-zinc-400 hover:text-amber-100' ?>">Home</a>
                <a href="menu.php" class="nav-link text-xs tracking-widest uppercase font-medium transition-colors duration-300 <?= ($pagina_atual == 'menu.php') ? 'text-gold-400 nav-link-active' : 'text-zinc-400 hover:text-amber-100' ?>">Menu</a>
                <a href="sobre.php" class="nav-link text-xs tracking-widest uppercase font-medium transition-colors duration-300 <?= ($pagina_atual == 'sobre.php') ? 'text-gold-400 nav-link-active' : 'text-zinc-400 hover:text-amber-100' ?>">Sobre Nós</a>
                <a href="contato.php" class="nav-link text-xs tracking-widest uppercase font-medium transition-colors duration-300 <?= ($pagina_atual == 'contato.php') ? 'text-gold-400 nav-link-active' : 'text-zinc-400 hover:text-amber-100' ?>">Contato</a>
            </nav>

            <!-- Botão Reserva Desktop -->
            <div class="hidden md:block">
                <a href="reserva.php" class="border border-gold-500/60 hover:border-gold-300 text-gold-300 hover:text-gold-100 hover:bg-gold-500/10 px-6 py-2.5 rounded-sm text-xs font-semibold tracking-widest uppercase transition-all duration-300">
                    Faça sua Reserva
                </a>
            </div>

            <!-- Hamburger Button Mobile -->
            <button id="mobile-menu-btn" class="md:hidden text-amber-100 focus:outline-none" aria-label="Abrir Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="menu-icon-open" class="block" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                    <path id="menu-icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Menu Mobile Overlay -->
        <div id="mobile-menu" class="hidden md:hidden fixed inset-x-0 top-24 bg-neutral-950/95 border-b border-gold-500/10 backdrop-blur-lg transition-all duration-300 ease-in-out">
            <nav class="flex flex-col space-y-6 px-8 py-8">
                <a href="index.php" class="text-sm tracking-widest uppercase font-medium <?= ($pagina_atual == 'index.php' || $pagina_atual == '') ? 'text-gold-400' : 'text-zinc-400 hover:text-amber-100' ?>">Home</a>
                <a href="menu.php" class="text-sm tracking-widest uppercase font-medium <?= ($pagina_atual == 'menu.php') ? 'text-gold-400' : 'text-zinc-400 hover:text-amber-100' ?>">Menu</a>
                <a href="sobre.php" class="text-sm tracking-widest uppercase font-medium <?= ($pagina_atual == 'sobre.php') ? 'text-gold-400' : 'text-zinc-400 hover:text-amber-100' ?>">Sobre Nós</a>
                <a href="contato.php" class="text-sm tracking-widest uppercase font-medium <?= ($pagina_atual == 'contato.php') ? 'text-gold-400' : 'text-zinc-400 hover:text-amber-100' ?>">Contato</a>
                <a href="reserva.php" class="border border-gold-500 text-gold-400 text-center py-3 rounded-sm text-xs font-semibold tracking-widest uppercase hover:bg-gold-500 hover:text-black transition-colors duration-300">
                    Faça sua Reserva
                </a>
            </nav>
        </div>
    </header>

    <!-- Script para controle do menu mobile -->
    <script>
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-icon-open');
        const closeIcon = document.getElementById('menu-icon-close');

        menuBtn.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.contains('hidden');
            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                openIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                openIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    </script>
