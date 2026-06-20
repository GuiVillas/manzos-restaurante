<?php include 'admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Controle de Comandas</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Abrir Nova Comanda -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-8">
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-5">Abrir Nova Comanda</h2>

    <form id="formAbrirComanda" class="flex flex-col sm:flex-row items-end gap-4">
        <div class="w-full sm:w-auto">
            <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Mesa</label>
            <select name="mesa_id" required
                    class="w-full sm:w-52 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                    id="selectMesa">
                <option value="">Selecione uma mesa...</option>
            </select>
        </div>
        <div class="w-full sm:w-auto">
            <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Garçom</label>
            <select name="usuario_id" required
                    class="w-full sm:w-52 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                    id="selectGarcom">
                <option value="">Selecione um garçom...</option>
            </select>
        </div>
        <button type="submit"
                class="w-full sm:w-auto bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
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
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Nº Comanda</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Mesa</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Garçom</th>
                        <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody id="tabelaComandasAtivas">
                    <!-- Preenchido via AJAX -->
                </tbody>
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
            <form id="formAdicionarItem" class="flex flex-col sm:flex-row items-end gap-3">
                <input type="hidden" name="pedido_id" id="comanda_id_atual">
                <div class="w-full sm:w-auto">
                    <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Prato</label>
                    <select name="prato_id" required
                            class="w-full sm:w-64 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                            id="selectPrato">
                        <option value="">Selecione um prato...</option>
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Qtd</label>
                    <input type="number" name="quantidade" value="1" min="1" required
                           class="w-full sm:w-20 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                </div>
                <button type="submit"
                        class="w-full sm:w-auto bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
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
                            <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-4 py-3">Preço Unit.</th>
                            <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-4 py-3">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="itensConsumo">
                        <!-- Preenchido via AJAX -->
                    </tbody>
                </table>
            </div>

            <!-- Total -->
            <div class="flex items-center justify-between pt-2">
                <span class="text-xl text-gold-400 font-semibold font-serif">
                    Total: R$ <span id="totalComanda">0.00</span>
                </span>
                <button type="button" onclick="fecharConta()" id="btnFecharConta"
                        class="bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm hover:bg-red-500/20 transition-all duration-300">
                    Encerrar Comanda
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
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Nº Comanda</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Mesa</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Garçom</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaHistorico">
                <!-- Preenchido via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<script>
    function carregarAtivas() {
        fetch('../../controllers/PedidoController.php?acao=listar_ativas')
            .then(response => response.json())
            .then(dados => {
                const tbody = document.getElementById('tabelaComandasAtivas');
                tbody.innerHTML = '';

                if (dados.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhuma comanda ativa no momento.</td></tr>';
                    return;
                }

                dados.forEach(c => {
                    tbody.innerHTML += `
                        <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                            <td class="px-6 py-3 text-sm text-zinc-300 font-mono"># ${c.id}</td>
                            <td class="px-6 py-3 text-sm text-zinc-300">Mesa ${c.mesa_numero}</td>
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
            .then(response => response.json())
            .then(dados => {
                const tbody = document.getElementById('tabelaHistorico');
                tbody.innerHTML = '';

                if (dados.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum registro no histórico.</td></tr>';
                    return;
                }

                dados.forEach(c => {
                    tbody.innerHTML += `
                        <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                            <td class="px-6 py-3 text-sm text-zinc-300 font-mono"># ${c.id}</td>
                            <td class="px-6 py-3 text-sm text-zinc-300">Mesa ${c.mesa_numero}</td>
                            <td class="px-6 py-3 text-sm text-zinc-400">${c.garcom_nome}</td>
                            <td class="px-6 py-3">
                                <button onclick="verDetalhes(${c.id}, ${c.mesa_numero}, false)"
                                        class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-3 py-1.5 rounded-sm transition-all duration-300">
                                    Visualizar Extrato
                                </button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

    function verDetalhes(pedidoId, numMesa, isAtiva) {
        document.getElementById('comanda_id_atual').value = pedidoId;
        let statusTexto = isAtiva ? '(Em aberto)' : '(Fechada)';
        document.getElementById('tituloComandaSelecionada').innerText = `Consumo Mesa ${numMesa} ${statusTexto}`;

        const painel = document.getElementById('painelDetalhes');
        painel.classList.remove('hidden');

        document.getElementById('formAdicionarItem').style.display = isAtiva ? 'flex' : 'none';
        document.getElementById('btnFecharConta').style.display = isAtiva ? 'inline-block' : 'none';

        fetch(`../../controllers/PedidoController.php?acao=ver_comanda&pedido_id=${pedidoId}`)
            .then(response => response.json())
            .then(dados => {
                const tbody = document.getElementById('itensConsumo');
                tbody.innerHTML = '';

                if (dados.itens.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-6 text-center text-sm text-zinc-500">Nenhum consumo registrado.</td></tr>';
                } else {
                    dados.itens.forEach(item => {
                        const precoUnit = parseFloat(item.preco_unitario).toFixed(2);
                        const subtotal = parseFloat(item.subtotal).toFixed(2);
                        tbody.innerHTML += `
                            <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                                <td class="px-4 py-3 text-sm text-zinc-300">${item.prato_nome}</td>
                                <td class="px-4 py-3 text-sm text-zinc-400 text-center">${item.quantidade}</td>
                                <td class="px-4 py-3 text-sm text-zinc-400">R$ ${precoUnit}</td>
                                <td class="px-4 py-3 text-sm text-gold-400 font-medium">R$ ${subtotal}</td>
                            </tr>
                        `;
                    });
                }
                document.getElementById('totalComanda').innerText = parseFloat(dados.total_geral).toFixed(2);
            });
    }

    document.getElementById('formAbrirComanda').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('acao', 'abrir');

        fetch('../../controllers/PedidoController.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    mostrarToast(data.mensagem, 'sucesso');
                    this.reset();
                    carregarAtivas();
                } else {
                    mostrarToast(data.mensagem, 'erro');
                }
            });
    });

    document.getElementById('formAdicionarItem').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        formData.append('acao', 'adicionar_item');

        fetch('../../controllers/PedidoController.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    mostrarToast('Item lançado com sucesso.', 'sucesso');
                    let pedidoId = document.getElementById('comanda_id_atual').value;
                    document.getElementById('formAdicionarItem').reset();
                    document.getElementById('comanda_id_atual').value = pedidoId;
                    verDetalhes(pedidoId, '', true);
                } else {
                    mostrarToast(data.mensagem, 'erro');
                }
            });
    });

    function fecharConta() {
        let pedidoId = document.getElementById('comanda_id_atual').value;
        if (confirm('Deseja realmente encerrar esta comanda?')) {
            let formData = new FormData();
            formData.append('acao', 'fechar');
            formData.append('pedido_id', pedidoId);

            fetch('../../controllers/PedidoController.php', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso) {
                        mostrarToast(data.mensagem, 'sucesso');
                        document.getElementById('painelDetalhes').classList.add('hidden');
                        carregarAtivas();
                        carregarHistorico();
                    } else {
                        mostrarToast(data.mensagem, 'erro');
                    }
                });
        }
    }

    carregarAtivas();
    carregarHistorico();

    // Popula selects de mesa, garçom e pratos ao carregar a página
    fetch('../../controllers/MesaController.php?acao=listar')
        .then(r => r.json())
        .then(mesas => {
            const sel = document.getElementById('selectMesa');
            mesas.forEach(m => {
                sel.innerHTML += `<option value="${m.id}">Mesa ${m.numero} (${m.capacidade} lugares — ${m.status})</option>`;
            });
        });

    fetch('../../controllers/UsuarioController.php?acao=listar')
        .then(r => r.json())
        .then(usuarios => {
            const sel = document.getElementById('selectGarcom');
            usuarios.forEach(u => {
                sel.innerHTML += `<option value="${u.id}">${u.nome} — ${u.cargo}</option>`;
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
</script>

<?php include 'admin_footer.php'; ?>