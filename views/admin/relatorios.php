<?php include 'admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Relatórios do Sistema</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Tab Buttons -->
<div class="flex flex-wrap gap-2 mb-6">
    <button id="btnFaturamento" onclick="carregarRelatorio('faturamento')"
            class="tab-btn bg-gold-400 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
        Faturamento Diário
    </button>
    <button id="btnPratos" onclick="carregarRelatorio('pratos')"
            class="tab-btn bg-neutral-800 hover:bg-neutral-700 text-zinc-400 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
        Pratos Mais Vendidos
    </button>
    <button id="btnGarcons" onclick="carregarRelatorio('garcons')"
            class="tab-btn bg-neutral-800 hover:bg-neutral-700 text-zinc-400 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
        Desempenho por Garçom
    </button>
</div>

<!-- Report Content -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-neutral-800">
        <h2 id="tituloRelatorio" class="font-serif text-lg text-amber-100 font-normal">Faturamento Diário</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-neutral-900">
                <tr id="cabecalhoTabela">
                    <!-- Dinamicamente preenchido -->
                </tr>
            </thead>
            <tbody id="corpoTabela">
                <!-- Dinamicamente preenchido -->
            </tbody>
        </table>
    </div>
</div>

<!-- Summary Card -->
<div id="cardConsolidado" class="bg-neutral-900 border border-gold-500/20 p-4 rounded-sm mt-4 hidden">
    <!-- Resumos consolidados -->
</div>

<script>
    function carregarRelatorio(tipo) {
        // Reset all tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = 'tab-btn bg-neutral-800 hover:bg-neutral-700 text-zinc-400 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
        });

        const cabecalho = document.getElementById('cabecalhoTabela');
        const corpo = document.getElementById('corpoTabela');
        const titulo = document.getElementById('tituloRelatorio');
        const card = document.getElementById('cardConsolidado');

        corpo.innerHTML = '<tr><td colspan="4" class="px-6 py-8 text-center text-sm text-zinc-500">Carregando dados...</td></tr>';
        card.classList.add('hidden');

        const thClass = 'text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3';

        if (tipo === 'faturamento') {
            document.getElementById('btnFaturamento').className = 'tab-btn bg-gold-400 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
            titulo.innerText = 'Faturamento Diário (Comandas Fechadas)';

            cabecalho.innerHTML = `
                <th class="${thClass}">Data</th>
                <th class="${thClass}">Pedidos Fechados</th>
                <th class="${thClass}">Faturamento Total</th>
            `;

            fetch('../../controllers/RelatorioController.php?acao=faturamento_periodo')
                .then(response => response.json())
                .then(dados => {
                    corpo.innerHTML = '';
                    if (dados.length === 0) {
                        corpo.innerHTML = '<tr><td colspan="3" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum faturamento registrado ainda.</td></tr>';
                        return;
                    }

                    let totalGeral = 0;
                    let totalPedidos = 0;
                    dados.forEach(d => {
                        let dataFormatada = d.data.split('-').reverse().join('/');
                        let valor = parseFloat(d.faturamento);
                        totalGeral += valor;
                        totalPedidos += parseInt(d.total_pedidos);

                        corpo.innerHTML += `
                            <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                                <td class="px-6 py-3 text-sm text-zinc-300">${dataFormatada}</td>
                                <td class="px-6 py-3 text-sm text-zinc-400">${d.total_pedidos}</td>
                                <td class="px-6 py-3 text-sm text-gold-400 font-medium">R$ ${valor.toFixed(2)}</td>
                            </tr>
                        `;
                    });

                    let ticketMedio = totalPedidos > 0 ? (totalGeral / totalPedidos) : 0;
                    card.classList.remove('hidden');
                    card.innerHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Faturamento Consolidado</p>
                                <p class="text-lg text-gold-400 font-semibold">R$ ${totalGeral.toFixed(2)}</p>
                            </div>
                            <div>
                                <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Total de Pedidos</p>
                                <p class="text-lg text-amber-100 font-semibold">${totalPedidos}</p>
                            </div>
                            <div>
                                <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Ticket Médio</p>
                                <p class="text-lg text-amber-100 font-semibold">R$ ${ticketMedio.toFixed(2)}</p>
                            </div>
                        </div>
                    `;
                });

        } else if (tipo === 'pratos') {
            document.getElementById('btnPratos').className = 'tab-btn bg-gold-400 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
            titulo.innerText = 'Ranking de Consumo — Pratos Mais Vendidos';

            cabecalho.innerHTML = `
                <th class="${thClass}">Nome do Prato</th>
                <th class="${thClass}">Unidades Vendidas</th>
                <th class="${thClass}">Receita Gerada</th>
            `;

            fetch('../../controllers/RelatorioController.php?acao=pratos_mais_vendidos')
                .then(response => response.json())
                .then(dados => {
                    corpo.innerHTML = '';
                    if (dados.length === 0) {
                        corpo.innerHTML = '<tr><td colspan="3" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhuma venda registrada.</td></tr>';
                        return;
                    }

                    let totalQtd = 0;
                    let totalReceita = 0;
                    dados.forEach((d, index) => {
                        let receita = parseFloat(d.receita_gerada);
                        totalQtd += parseInt(d.total_vendido);
                        totalReceita += receita;

                        corpo.innerHTML += `
                            <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                                <td class="px-6 py-3 text-sm text-zinc-300">
                                    <span class="text-zinc-600 font-mono mr-2">#${index + 1}</span>
                                    ${d.prato_nome}
                                </td>
                                <td class="px-6 py-3 text-sm text-zinc-400">${d.total_vendido}</td>
                                <td class="px-6 py-3 text-sm text-gold-400 font-medium">R$ ${receita.toFixed(2)}</td>
                            </tr>
                        `;
                    });

                    card.classList.remove('hidden');
                    card.innerHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Total de Pratos Servidos</p>
                                <p class="text-lg text-amber-100 font-semibold">${totalQtd}</p>
                            </div>
                            <div>
                                <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Receita Acumulada</p>
                                <p class="text-lg text-gold-400 font-semibold">R$ ${totalReceita.toFixed(2)}</p>
                            </div>
                        </div>
                    `;
                });

        } else if (tipo === 'garcons') {
            document.getElementById('btnGarcons').className = 'tab-btn bg-gold-400 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
            titulo.innerText = 'Desempenho por Garçom (Faturamento por Atendimento)';

            cabecalho.innerHTML = `
                <th class="${thClass}">Garçom</th>
                <th class="${thClass}">Pedidos Atendidos</th>
                <th class="${thClass}">Faturamento Gerado</th>
            `;

            fetch('../../controllers/RelatorioController.php?acao=faturamento_garcom')
                .then(response => response.json())
                .then(dados => {
                    corpo.innerHTML = '';
                    if (dados.length === 0) {
                        corpo.innerHTML = '<tr><td colspan="3" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum atendimento finalizado.</td></tr>';
                        return;
                    }

                    let totalPedidos = 0;
                    let totalFaturamento = 0;
                    dados.forEach(d => {
                        let faturamento = parseFloat(d.faturamento);
                        totalPedidos += parseInt(d.total_pedidos);
                        totalFaturamento += faturamento;

                        corpo.innerHTML += `
                            <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                                <td class="px-6 py-3 text-sm text-zinc-300">${d.garcom_nome}</td>
                                <td class="px-6 py-3 text-sm text-zinc-400">${d.total_pedidos}</td>
                                <td class="px-6 py-3 text-sm text-gold-400 font-medium">R$ ${faturamento.toFixed(2)}</td>
                            </tr>
                        `;
                    });

                    card.classList.remove('hidden');
                    card.innerHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Atendimentos Totais</p>
                                <p class="text-lg text-amber-100 font-semibold">${totalPedidos}</p>
                            </div>
                            <div>
                                <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Faturamento Total</p>
                                <p class="text-lg text-gold-400 font-semibold">R$ ${totalFaturamento.toFixed(2)}</p>
                            </div>
                        </div>
                    `;
                });
        }
    }

    // Carregar o primeiro relatório ao iniciar a página
    carregarRelatorio('faturamento');
</script>

<?php include 'admin_footer.php'; ?>
