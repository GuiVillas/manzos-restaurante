<?php include 'admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Controle de Comandas</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Abrir Nova Comanda -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-8">
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-5">Abrir Nova Comanda</h2>

    <form id="formAbrirComanda" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Mesa</label>
            <select name="mesa_id" id="selectMesa" required
                    class="w-52 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                <option value="">Selecione uma mesa...</option>
            </select>
        </div>
        <div>
            <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Garçom</label>
            <select name="usuario_id" id="selectGarcom" required
                    class="w-52 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                <option value="">Selecione um garçom...</option>
            </select>
        </div>
        <div>
            <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Cliente <span class="text-zinc-600 normal-case font-normal">(opcional)</span></label>
            <select name="cliente_id" id="selectCliente"
                    class="w-52 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                <option value="">Walk-in / sem cadastro</option>
            </select>
        </div>
        <button type="submit"
                class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
            Abrir Comanda
        </button>
    </form>
</div>

<!-- Two-Column Layout: Ativas + Detalhes -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <!-- Left: Comandas Ativas -->
    <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-neutral-800 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300">Comandas Ativas</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-neutral-900">
                    <tr>
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Nº</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Mesa</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Cliente</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Garçom</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaComandasAtivas"></tbody>
            </table>
        </div>
    </div>

    <!-- Right: Painel de Detalhes -->
    <div id="painelDetalhes" class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden hidden">
        <div class="px-6 py-4 border-b border-neutral-800">
            <h2 id="tituloComandaSelecionada" class="text-sm font-semibold tracking-wider uppercase text-zinc-300">Detalhes da Comanda</h2>
        </div>

        <div class="p-6 space-y-5">
            <!-- Mini Form: Lançar Item -->
            <form id="formAdicionarItem" class="flex flex-wrap items-end gap-3">
                <input type="hidden" name="pedido_id" id="comanda_id_atual">
                <div>
                    <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Prato</label>
                    <select name="prato_id" id="selectPrato" required
                            class="w-64 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                        <option value="">Selecione um prato...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Qtd</label>
                    <input type="number" name="quantidade" value="1" min="1" required
                           class="w-20 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                </div>
                <button type="submit"
                        class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                    Lançar
                </button>
            </form>

            <!-- Itens Table -->
            <div class="overflow-x-auto border border-neutral-800 rounded-sm">
                <table class="w-full">
                    <thead class="bg-neutral-900">
                        <tr>
                            <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-4 py-3">Item</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-4 py-3">Qtd</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-4 py-3">Unit.</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-4 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="itensConsumo"></tbody>
                </table>
            </div>

            <!-- Total + Encerrar -->
            <div class="flex items-center justify-between pt-2">
                <span class="text-xl text-gold-400 font-semibold font-serif">
                    Total: R$ <span id="totalComanda">0,00</span>
                </span>
                <button type="button" onclick="encerrarComanda()" id="btnFecharConta"
                        class="bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm hover:bg-red-500/20 transition-all duration-300">
                    Encerrar e Registrar Pagamento
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Histórico de Vendas -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-neutral-800">
        <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300">Histórico de Vendas</h2>
        <p class="text-xs text-zinc-600 mt-1">Comandas encerradas e finalizadas</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-neutral-900">
                <tr>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Nº</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Mesa</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Cliente</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Garçom</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaHistorico"></tbody>
        </table>
    </div>
</div>

<script>
    function carregarAtivas() {
        fetch('../../controllers/PedidoController.php?acao=listar_ativas')
            .then(r => r.json())
            .then(dados => {
                const tbody = document.getElementById('tabelaComandasAtivas');
                tbody.innerHTML = '';

                if (dados.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhuma comanda ativa no momento.</td></tr>';
                    return;
                }

                dados.forEach(c => {
                    tbody.innerHTML += `
                        <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                            <td class="px-6 py-3 text-sm text-zinc-300 font-mono">#${c.id}</td>
                            <td class="px-6 py-3 text-sm text-zinc-300">Mesa ${c.mesa_numero}</td>
                            <td class="px-6 py-3 text-sm text-zinc-400">${c.cliente_nome || '<span class="text-zinc-600 italic">Walk-in</span>'}</td>
                            <td class="px-6 py-3 text-sm text-zinc-400">${c.garcom_nome}</td>
                            <td class="px-6 py-3">
                                <button onclick="verDetalhes(${c.id}, ${c.mesa_numero}, true)"
                                        class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-3 py-1.5 rounded-sm transition-all duration-300">
                                    Ver Conta
                                </button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

    function carregarHistorico() {
        fetch('../../controllers/PedidoController.php?acao=listar_historico')
            .then(r => r.json())
            .then(dados => {
                const tbody = document.getElementById('tabelaHistorico');
                tbody.innerHTML = '';

                if (dados.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum registro no histórico.</td></tr>';
                    return;
                }

                dados.forEach(c => {
                    tbody.innerHTML += `
                        <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                            <td class="px-6 py-3 text-sm text-zinc-300 font-mono">#${c.id}</td>
                            <td class="px-6 py-3 text-sm text-zinc-300">Mesa ${c.mesa_numero}</td>
                            <td class="px-6 py-3 text-sm text-zinc-400">${c.cliente_nome || '<span class="text-zinc-600 italic">Walk-in</span>'}</td>
                            <td class="px-6 py-3 text-sm text-zinc-400">${c.garcom_nome}</td>
                            <td class="px-6 py-3">
                                <button onclick="verDetalhes(${c.id}, ${c.mesa_numero}, false)"
                                        class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-3 py-1.5 rounded-sm transition-all duration-300">
                                    Extrato
                                </button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

    function verDetalhes(pedidoId, numMesa, isAtiva) {
        document.getElementById('comanda_id_atual').value = pedidoId;
        document.getElementById('tituloComandaSelecionada').innerText =
            `Mesa ${numMesa} — Comanda #${pedidoId} ${isAtiva ? '(Em aberto)' : '(Fechada)'}`;

        document.getElementById('painelDetalhes').classList.remove('hidden');
        document.getElementById('formAdicionarItem').style.display = isAtiva ? 'flex' : 'none';
        document.getElementById('btnFecharConta').style.display    = isAtiva ? 'inline-block' : 'none';

        fetch(`../../controllers/PedidoController.php?acao=ver_comanda&pedido_id=${pedidoId}`)
            .then(r => r.json())
            .then(dados => {
                const tbody = document.getElementById('itensConsumo');
                tbody.innerHTML = '';

                if (dados.itens.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-sm text-zinc-500">Nenhum consumo registrado.</td></tr>';
                } else {
                    dados.itens.forEach(item => {
                        tbody.innerHTML += `
                            <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-zinc-300">${item.prato_nome}</td>
                                <td class="px-4 py-3 text-sm text-zinc-400 text-center">${item.quantidade}</td>
                                <td class="px-4 py-3 text-sm text-zinc-400">R$ ${parseFloat(item.preco_unitario).toFixed(2).replace('.',',')}</td>
                                <td class="px-4 py-3 text-sm text-gold-400 font-medium">R$ ${parseFloat(item.subtotal).toFixed(2).replace('.',',')}</td>
                            </tr>
                        `;
                    });
                }
                document.getElementById('totalComanda').innerText =
                    parseFloat(dados.total_geral).toFixed(2).replace('.', ',');
            });
    }

    document.getElementById('formAbrirComanda').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('acao', 'abrir');

        fetch('../../controllers/PedidoController.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.sucesso) {
                    mostrarToast(data.mensagem, 'sucesso');
                    this.reset();
                    // Recarrega select de mesas para refletir novo status
                    popularSelectMesas();
                    carregarAtivas();
                } else {
                    mostrarToast(data.mensagem, 'erro');
                }
            });
    });

    document.getElementById('formAdicionarItem').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('acao', 'adicionar_item');

        fetch('../../controllers/PedidoController.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.sucesso) {
                    mostrarToast('Item lançado com sucesso.', 'sucesso');
                    const pedidoId = document.getElementById('comanda_id_atual').value;
                    const mesaNum  = document.getElementById('tituloComandaSelecionada').innerText.match(/Mesa (\d+)/)?.[1] || '';
                    document.querySelector('[name="quantidade"]').value = 1;
                    document.getElementById('selectPrato').value = '';
                    verDetalhes(pedidoId, mesaNum, true);
                } else {
                    mostrarToast(data.mensagem, 'erro');
                }
            });
    });

    function encerrarComanda() {
        const pedidoId = document.getElementById('comanda_id_atual').value;
        if (!confirm('Deseja encerrar esta comanda e ir para o registro de pagamento?')) return;

        const formData = new FormData();
        formData.append('acao', 'fechar');
        formData.append('pedido_id', pedidoId);

        fetch('../../controllers/PedidoController.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.sucesso) {
                    // Redireciona para pagamentos com o pedido pré-selecionado
                    window.location.href = `pagamentos.php?pedido_id=${pedidoId}`;
                } else {
                    mostrarToast(data.mensagem, 'erro');
                }
            });
    }

    // --- Populate selects ---

    function popularSelectMesas() {
        fetch('../../controllers/MesaController.php?acao=listar')
            .then(r => r.json())
            .then(mesas => {
                const sel = document.getElementById('selectMesa');
                const valorAtual = sel.value;
                sel.innerHTML = '<option value="">Selecione uma mesa...</option>';
                mesas.forEach(m => {
                    // Destaca mesas disponíveis; desabilita as ocupadas
                    const disabled = (m.status === 'Ocupada') ? 'disabled' : '';
                    sel.innerHTML += `<option value="${m.id}" ${disabled}>Mesa ${m.numero} — ${m.status} (${m.capacidade} lugares)</option>`;
                });
                if (valorAtual) sel.value = valorAtual;
            });
    }

    popularSelectMesas();

    fetch('../../controllers/UsuarioController.php?acao=listar')
        .then(r => r.json())
        .then(usuarios => {
            const sel = document.getElementById('selectGarcom');
            usuarios.forEach(u => {
                sel.innerHTML += `<option value="${u.id}">${u.nome} — ${u.cargo}</option>`;
            });
        });

    fetch('../../controllers/ClienteController.php?acao=listar')
        .then(r => r.json())
        .then(clientes => {
            const sel = document.getElementById('selectCliente');
            clientes.forEach(c => {
                sel.innerHTML += `<option value="${c.id}">${c.nome}</option>`;
            });
        });

    fetch('../../controllers/PratoController.php?acao=listar')
        .then(r => r.json())
        .then(pratos => {
            const sel = document.getElementById('selectPrato');
            pratos.forEach(p => {
                const preco = parseFloat(p.preco).toFixed(2).replace('.', ',');
                sel.innerHTML += `<option value="${p.id}">${p.nome} — R$ ${preco}</option>`;
            });
        });

    carregarAtivas();
    carregarHistorico();

    // Lê parâmetros da URL (vindos de "Receber Cliente" na tela de reservas)
    const urlParams = new URLSearchParams(window.location.search);
    const mesaIdParam    = urlParams.get('mesa_id');
    const clienteIdParam = urlParams.get('cliente_id');

    if (mesaIdParam || clienteIdParam) {
        // Aguarda os selects serem populados antes de selecionar
        setTimeout(() => {
            if (mesaIdParam)    document.getElementById('selectMesa').value    = mesaIdParam;
            if (clienteIdParam) document.getElementById('selectCliente').value = clienteIdParam;
            if (mesaIdParam || clienteIdParam) {
                mostrarToast('Cliente e mesa pré-selecionados. Escolha o garçom e abra a comanda.', 'sucesso');
            }
        }, 800);
    }
</script>

<?php include 'admin_footer.php'; ?>
