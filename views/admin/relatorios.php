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
    <button id="btnMenosVendidos" onclick="carregarRelatorio('menos_vendidos')"
            class="tab-btn bg-neutral-800 hover:bg-neutral-700 text-zinc-400 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
        Pratos Menos Vendidos
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
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.className = 'tab-btn bg-neutral-800 hover:bg-neutral-700 text-zinc-400 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
        });

        const cabecalho = document.getElementById('cabecalhoTabela');
        const corpo     = document.getElementById('corpoTabela');
        const titulo    = document.getElementById('tituloRelatorio');
        const card      = document.getElementById('cardConsolidado');
        const thClass   = 'text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3';

        corpo.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-sm text-zinc-500">Carregando dados...</td></tr>';
        card.classList.add('hidden');

        if (tipo === 'faturamento') {
            document.getElementById('btnFaturamento').className = 'tab-btn bg-gold-400 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
            titulo.innerText = 'Faturamento Diário (Comandas Fechadas)';
            cabecalho.innerHTML = `<th class="${thClass}">Data</th><th class="${thClass}">Pedidos Fechados</th><th class="${thClass}">Faturamento Total</th>`;

            fetch('../../controllers/RelatorioController.php?acao=faturamento_periodo')
                .then(r => r.json()).then(dados => {
                    corpo.innerHTML = '';
                    if (!dados.length) { corpo.innerHTML = '<tr><td colspan="3" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum faturamento registrado ainda.</td></tr>'; return; }
                    let totalGeral = 0, totalPedidos = 0;
                    dados.forEach(d => {
                        let dataF = d.data.split('-').reverse().join('/');
                        let valor = parseFloat(d.faturamento);
                        totalGeral += valor; totalPedidos += parseInt(d.total_pedidos);
                        corpo.innerHTML += `<tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors"><td class="px-6 py-3 text-sm text-zinc-300">${dataF}</td><td class="px-6 py-3 text-sm text-zinc-400">${d.total_pedidos}</td><td class="px-6 py-3 text-sm text-gold-400 font-medium">R$ ${valor.toFixed(2).replace('.',',')}</td></tr>`;
                    });
                    card.classList.remove('hidden');
                    card.innerHTML = `<div class="grid grid-cols-1 sm:grid-cols-3 gap-4"><div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Faturamento Consolidado</p><p class="text-lg text-gold-400 font-semibold">R$ ${totalGeral.toFixed(2).replace('.',',')}</p></div><div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Total de Pedidos</p><p class="text-lg text-amber-100 font-semibold">${totalPedidos}</p></div><div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Ticket Médio</p><p class="text-lg text-amber-100 font-semibold">R$ ${(totalPedidos > 0 ? totalGeral/totalPedidos : 0).toFixed(2).replace('.',',')}</p></div></div>`;
                });

        } else if (tipo === 'pratos') {
            document.getElementById('btnPratos').className = 'tab-btn bg-gold-400 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
            titulo.innerText = 'Ranking de Consumo — Pratos Mais Vendidos';
            cabecalho.innerHTML = `<th class="${thClass}">Nome do Prato</th><th class="${thClass}">Unidades Vendidas</th><th class="${thClass}">Receita Gerada</th>`;

            fetch('../../controllers/RelatorioController.php?acao=pratos_mais_vendidos')
                .then(r => r.json()).then(dados => {
                    corpo.innerHTML = '';
                    if (!dados.length) { corpo.innerHTML = '<tr><td colspan="3" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhuma venda registrada.</td></tr>'; return; }
                    let totalQtd = 0, totalReceita = 0;
                    dados.forEach((d, i) => {
                        let receita = parseFloat(d.receita_gerada);
                        totalQtd += parseInt(d.total_vendido); totalReceita += receita;
                        corpo.innerHTML += `<tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors"><td class="px-6 py-3 text-sm text-zinc-300"><span class="text-zinc-600 font-mono mr-2">#${i+1}</span>${d.prato_nome}</td><td class="px-6 py-3 text-sm text-zinc-400">${d.total_vendido}</td><td class="px-6 py-3 text-sm text-gold-400 font-medium">R$ ${receita.toFixed(2).replace('.',',')}</td></tr>`;
                    });
                    card.classList.remove('hidden');
                    card.innerHTML = `<div class="grid grid-cols-1 sm:grid-cols-2 gap-4"><div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Total de Pratos Servidos</p><p class="text-lg text-amber-100 font-semibold">${totalQtd}</p></div><div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Receita Acumulada</p><p class="text-lg text-gold-400 font-semibold">R$ ${totalReceita.toFixed(2).replace('.',',')}</p></div></div>`;
                });

        } else if (tipo === 'menos_vendidos') {
            document.getElementById('btnMenosVendidos').className = 'tab-btn bg-gold-400 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
            titulo.innerText = 'Pratos Menos Vendidos — Gestão de Descontos';
            cabecalho.innerHTML = `
                <th class="${thClass}">Prato</th>
                <th class="${thClass}">Vendas</th>
                <th class="${thClass}">Preço Original</th>
                <th class="${thClass}">Desconto Atual</th>
                <th class="${thClass}">Preço com Desconto</th>
                <th class="${thClass}">Aplicar Desconto</th>
            `;

            fetch('../../controllers/RelatorioController.php?acao=pratos_menos_vendidos')
                .then(r => r.json()).then(dados => {
                    corpo.innerHTML = '';
                    if (!dados.length) { corpo.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum prato ativo cadastrado.</td></tr>'; return; }

                    dados.forEach(d => {
                        const mult        = parseFloat(d.desconto_multiplicador);
                        const temDesconto = mult < 1.00;
                        const pctDesc     = temDesconto ? Math.round((1 - mult) * 100) : 0;

                        const descontoLabel = temDesconto
                            ? `<span class="text-[11px] font-semibold px-2 py-0.5 rounded-sm bg-amber-500/10 text-amber-400 border border-amber-500/20">${pctDesc}% OFF</span>`
                            : `<span class="text-[11px] text-zinc-600">Sem desconto</span>`;

                        const precoEfetivo = temDesconto
                            ? `<span class="text-emerald-400 font-semibold">R$ ${parseFloat(d.preco_efetivo).toFixed(2).replace('.',',')}</span>`
                            : `<span class="text-zinc-600">—</span>`;

                        const btnRemover = temDesconto
                            ? `<button onclick="removerDesconto(${d.id})" class="text-[11px] uppercase tracking-wider font-semibold text-red-400 hover:text-red-300 transition-colors">Remover</button>`
                            : '';

                        corpo.innerHTML += `
                            <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                                <td class="px-6 py-3 text-sm text-zinc-300 font-medium">${d.nome}</td>
                                <td class="px-6 py-3 text-sm text-zinc-400">${d.total_vendido}</td>
                                <td class="px-6 py-3 text-sm text-zinc-300">R$ ${parseFloat(d.preco).toFixed(2).replace('.',',')}</td>
                                <td class="px-6 py-3">${descontoLabel}</td>
                                <td class="px-6 py-3">${precoEfetivo}</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="relative flex items-center">
                                            <input type="number" id="desc-${d.id}" min="1" max="90" step="1"
                                                   value="${pctDesc || ''}" placeholder="%"
                                                   class="w-16 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-3 py-1.5 rounded-sm outline-none">
                                            <span class="absolute right-2 text-zinc-500 text-xs pointer-events-none">%</span>
                                        </div>
                                        <button onclick="aplicarDesconto(${d.id})"
                                                class="bg-gold-400 hover:bg-gold-300 text-black text-[11px] font-semibold tracking-wider uppercase px-3 py-1.5 rounded-sm transition-all duration-300">
                                            Aplicar
                                        </button>
                                        ${btnRemover}
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    const comDesconto = dados.filter(d => parseFloat(d.desconto_multiplicador) < 1).length;
                    const semVendas   = dados.filter(d => parseInt(d.total_vendido) === 0).length;
                    card.classList.remove('hidden');
                    card.innerHTML = `
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Pratos Ativos</p><p class="text-lg text-amber-100 font-semibold">${dados.length}</p></div>
                            <div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Com Desconto Ativo</p><p class="text-lg text-amber-400 font-semibold">${comDesconto}</p></div>
                            <div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Sem Nenhuma Venda</p><p class="text-lg text-red-400 font-semibold">${semVendas}</p></div>
                        </div>
                    `;
                });

        } else if (tipo === 'garcons') {
            document.getElementById('btnGarcons').className = 'tab-btn bg-gold-400 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300';
            titulo.innerText = 'Desempenho por Garçom (Faturamento por Atendimento)';
            cabecalho.innerHTML = `<th class="${thClass}">Garçom</th><th class="${thClass}">Pedidos Atendidos</th><th class="${thClass}">Faturamento Gerado</th>`;

            fetch('../../controllers/RelatorioController.php?acao=faturamento_garcom')
                .then(r => r.json()).then(dados => {
                    corpo.innerHTML = '';
                    if (!dados.length) { corpo.innerHTML = '<tr><td colspan="3" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum atendimento finalizado.</td></tr>'; return; }
                    let totalPedidos = 0, totalFaturamento = 0;
                    dados.forEach(d => {
                        let fat = parseFloat(d.faturamento);
                        totalPedidos += parseInt(d.total_pedidos); totalFaturamento += fat;
                        corpo.innerHTML += `<tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors"><td class="px-6 py-3 text-sm text-zinc-300">${d.garcom_nome}</td><td class="px-6 py-3 text-sm text-zinc-400">${d.total_pedidos}</td><td class="px-6 py-3 text-sm text-gold-400 font-medium">R$ ${fat.toFixed(2).replace('.',',')}</td></tr>`;
                    });
                    card.classList.remove('hidden');
                    card.innerHTML = `<div class="grid grid-cols-1 sm:grid-cols-2 gap-4"><div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Atendimentos Totais</p><p class="text-lg text-amber-100 font-semibold">${totalPedidos}</p></div><div><p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Faturamento Total</p><p class="text-lg text-gold-400 font-semibold">R$ ${totalFaturamento.toFixed(2).replace('.',',')}</p></div></div>`;
                });
        }
    }

    function aplicarDesconto(pratoId) {
        const input = document.getElementById('desc-' + pratoId);
        const pct   = parseFloat(input.value);
        if (isNaN(pct) || pct < 1 || pct > 90) { mostrarToast('Informe um desconto entre 1% e 90%.', 'erro'); return; }
        const multiplicador = ((100 - pct) / 100).toFixed(2);
        const fd = new FormData();
        fd.append('acao', 'aplicarDesconto');
        fd.append('id', pratoId);
        fd.append('multiplicador', multiplicador);
        fetch('../../controllers/PratoController.php', { method: 'POST', body: fd })
            .then(r => r.json()).then(data => {
                mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                if (data.sucesso) carregarRelatorio('menos_vendidos');
            });
    }

    function removerDesconto(pratoId) {
        const fd = new FormData();
        fd.append('acao', 'removerDesconto');
        fd.append('id', pratoId);
        fetch('../../controllers/PratoController.php', { method: 'POST', body: fd })
            .then(r => r.json()).then(data => {
                mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                if (data.sucesso) carregarRelatorio('menos_vendidos');
            });
    }

    carregarRelatorio('faturamento');
</script>

<?php include 'admin_footer.php'; ?>
