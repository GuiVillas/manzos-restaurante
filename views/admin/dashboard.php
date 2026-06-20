<?php include __DIR__ . '/admin_header.php'; ?>

    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="font-serif text-2xl text-amber-100 font-normal">Dashboard</h1>
        <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
    </div>

    <!-- Welcome Message -->
    <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-8">
        <p class="text-sm text-zinc-300">
            Bem-vindo(a), <strong class="text-amber-100"><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong>
            <span class="text-zinc-500 ml-1">(Cargo: <?= htmlspecialchars($_SESSION['usuario_cargo']) ?>)</span>
        </p>
    </div>

    <!-- Quick Access Cards -->
    <div class="mb-6">
        <p class="text-[10px] tracking-[0.2em] uppercase text-zinc-600 font-semibold mb-4">Acesso Rápido</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4">

        <!-- Clientes -->
        <a href="clientes.php" class="group bg-neutral-900 border border-neutral-800 hover:border-gold-500/30 rounded-sm p-6 transition-all duration-300">
            <div class="w-10 h-10 rounded-sm bg-gold-500/10 border border-gold-500/20 flex items-center justify-center mb-4 group-hover:bg-gold-500/20 transition-all duration-300">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <h3 class="text-sm text-amber-100 font-medium mb-1">Clientes</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Cadastro e gerenciamento de clientes do restaurante.</p>
        </a>

        <!-- Mesas -->
        <a href="mesas.php" class="group bg-neutral-900 border border-neutral-800 hover:border-gold-500/30 rounded-sm p-6 transition-all duration-300">
            <div class="w-10 h-10 rounded-sm bg-gold-500/10 border border-gold-500/20 flex items-center justify-center mb-4 group-hover:bg-gold-500/20 transition-all duration-300">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <h3 class="text-sm text-amber-100 font-medium mb-1">Mesas</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Controle de mesas, capacidade e disponibilidade do salão.</p>
        </a>

        <!-- Reservas -->
        <a href="reservas.php" class="group bg-neutral-900 border border-neutral-800 hover:border-gold-500/30 rounded-sm p-6 transition-all duration-300">
            <div class="w-10 h-10 rounded-sm bg-gold-500/10 border border-gold-500/20 flex items-center justify-center mb-4 group-hover:bg-gold-500/20 transition-all duration-300">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-sm text-amber-100 font-medium mb-1">Reservas</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Agendamento e acompanhamento de reservas dos clientes.</p>
        </a>

        <!-- Cardápio -->
        <a href="cardapio.php" class="group bg-neutral-900 border border-neutral-800 hover:border-gold-500/30 rounded-sm p-6 transition-all duration-300">
            <div class="w-10 h-10 rounded-sm bg-gold-500/10 border border-gold-500/20 flex items-center justify-center mb-4 group-hover:bg-gold-500/20 transition-all duration-300">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-sm text-amber-100 font-medium mb-1">Cardápio</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Gestão de pratos, categorias e preços do menu.</p>
        </a>

        <!-- Comandas -->
        <a href="comandas.php" class="group bg-neutral-900 border border-neutral-800 hover:border-gold-500/30 rounded-sm p-6 transition-all duration-300">
            <div class="w-10 h-10 rounded-sm bg-gold-500/10 border border-gold-500/20 flex items-center justify-center mb-4 group-hover:bg-gold-500/20 transition-all duration-300">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <h3 class="text-sm text-amber-100 font-medium mb-1">Comandas</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Abertura, itens e fechamento de comandas por mesa.</p>
        </a>

        <!-- Relatórios -->
        <a href="relatorios.php" class="group bg-neutral-900 border border-neutral-800 hover:border-gold-500/30 rounded-sm p-6 transition-all duration-300">
            <div class="w-10 h-10 rounded-sm bg-gold-500/10 border border-gold-500/20 flex items-center justify-center mb-4 group-hover:bg-gold-500/20 transition-all duration-300">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="text-sm text-amber-100 font-medium mb-1">Relatórios</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Análises de faturamento, desempenho e estatísticas.</p>
        </a>

    </div>

<?php include __DIR__ . '/admin_footer.php'; ?>