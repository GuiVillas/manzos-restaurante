<?php include __DIR__ . '/admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Controle de Pagamentos</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Resumo Financeiro -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8" id="resumoCards">
    <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-5">
        <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Total Recebido</p>
        <p id="totalPago" class="font-serif text-2xl text-emerald-400 font-normal">—</p>
    </div>
    <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-5">
        <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Aguardando</p>
        <p id="totalPendente" class="font-serif text-2xl text-amber-400 font-normal">—</p>
    </div>
    <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-5">
        <p class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold mb-1">Cancelados</p>
        <p id="totalCancelado" class="font-serif text-2xl text-red-400 font-normal">—</p>
    </div>
</div>

<!-- Form Card -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6">
    <h2 id="tituloForm" class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-6">Registrar Pagamento</h2>

    <form id="formPagamento" class="space-y-5">
        <input type="hidden" name="id" id="id">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Pedido -->
            <div>
                <label for="pedido_id" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Pedido</label>
                <select name="pedido_id" id="pedido_id" required
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                    <option value="">Selecione um pedido...</option>
                </select>
            </div>

            <!-- Valor -->
            <div>
                <label for="valor" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Valor (R$)</label>
                <input type="number" name="valor" id="valor" step="0.01" min="0.01" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="0,00">
            </div>

            <!-- Forma de Pagamento -->
            <div>
                <label for="forma_pagamento" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Forma de Pagamento</label>
                <select name="forma_pagamento" id="forma_pagamento" required
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                    <option value="">Selecione...</option>
                    <option value="PIX">PIX</option>
                    <option value="Crédito">Crédito</option>
                    <option value="Débito">Débito</option>
                    <option value="Dinheiro">Dinheiro</option>
                    <option value="Vale Refeição">Vale Refeição</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Status -->
            <div>
                <label for="status" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Status</label>
                <select name="status" id="status" required
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                    <option value="Pendente">Pendente</option>
                    <option value="Pago">Pago</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div>

            <!-- Observações -->
            <div>
                <label for="observacoes" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Observações</label>
                <input type="text" name="observacoes" id="observacoes"
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Observações opcionais...">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" id="btnSalvar"
                    class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Salvar Pagamento
            </button>
            <button type="button" onclick="limparFormulario()"
                    class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Cancelar Edição
            </button>
        </div>
    </form>
</div>

<!-- Filter Card -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6">
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-4">Filtrar Pagamentos</h2>
    <div class="flex flex-wrap gap-3">
        <button onclick="filtrar('')"      id="filtroTodos"     class="filtro-btn ativo text-xs font-semibold tracking-wider uppercase px-4 py-2 rounded-sm transition-all duration-300">Todos</button>
        <button onclick="filtrar('Pago')"  id="filtroPago"      class="filtro-btn text-xs font-semibold tracking-wider uppercase px-4 py-2 rounded-sm transition-all duration-300">Pagos</button>
        <button onclick="filtrar('Pendente')" id="filtroPendente" class="filtro-btn text-xs font-semibold tracking-wider uppercase px-4 py-2 rounded-sm transition-all duration-300">Pendentes</button>
        <button onclick="filtrar('Cancelado')" id="filtroCancelado" class="filtro-btn text-xs font-semibold tracking-wider uppercase px-4 py-2 rounded-sm transition-all duration-300">Cancelados</button>
    </div>
</div>

<style>
    .filtro-btn { background: #262626; color: #a1a1aa; }
    .filtro-btn:hover { background: #333; color: #e5e5e5; }
    .filtro-btn.ativo { background: #cfa652; color: #000; }
</style>

<!-- Data Table -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-neutral-900">
                <tr>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">ID</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Pedido</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Mesa</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Forma</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Valor</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Status</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Registrado em</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaPagamentos"></tbody>
        </table>
    </div>
</div>

<script>
    const statusBadge = {
        'Pago':      'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20',
        'Pendente':  'bg-amber-500/10 text-amber-400 border border-amber-500/20',
        'Cancelado': 'bg-red-500/10 text-red-400 border border-red-500/20',
    };

    const formaBadge = {
        'PIX':           'bg-sky-500/10 text-sky-300',
        'Crédito':       'bg-violet-500/10 text-violet-300',
        'Débito':        'bg-indigo-500/10 text-indigo-300',
        'Dinheiro':      'bg-emerald-500/10 text-emerald-300',
        'Vale Refeição': 'bg-teal-500/10 text-teal-300',
    };

    function formatarMoeda(valor) {
        return 'R$ ' + parseFloat(valor).toFixed(2).replace('.', ',');
    }

    function renderizarTabela(dados) {
        const tbody = document.getElementById('tabelaPagamentos');
        tbody.innerHTML = '';

        if (dados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-sm text-zinc-500 px-5 py-8">Nenhum pagamento encontrado.</td></tr>';
            return;
        }

        dados.forEach(p => {
            const dataCriacao = p.criado_em.split(' ')[0].split('-').reverse().join('/');
            const statusClass = statusBadge[p.status] || 'bg-zinc-800 text-zinc-400';
            const formaClass  = formaBadge[p.forma_pagamento] || 'bg-zinc-800 text-zinc-400';

            tbody.innerHTML += `
                <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                    <td class="text-sm text-zinc-500 px-5 py-3 font-mono">${p.id}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3 font-mono">#${p.pedido_id}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${p.mesa_numero ? 'Mesa ' + p.mesa_numero : '—'}</td>
                    <td class="px-5 py-3">
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-sm ${formaClass}">${p.forma_pagamento}</span>
                    </td>
                    <td class="text-sm font-semibold text-zinc-200 px-5 py-3">${formatarMoeda(p.valor)}</td>
                    <td class="px-5 py-3">
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-sm ${statusClass}">${p.status}</span>
                    </td>
                    <td class="text-sm text-zinc-400 px-5 py-3">${dataCriacao}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <button onclick="editarPagamento(${p.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-gold-400 hover:text-gold-300 transition-colors">
                                Editar
                            </button>
                            <span class="text-neutral-700">|</span>
                            <button onclick="deletarPagamento(${p.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-red-400 hover:text-red-300 transition-colors">
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    function carregarResumo() {
        fetch('../../controllers/PagamentoController.php?acao=resumo')
            .then(r => r.json())
            .then(d => {
                document.getElementById('totalPago').innerText      = formatarMoeda(d.total_pago || 0);
                document.getElementById('totalPendente').innerText  = formatarMoeda(d.total_pendente || 0);
                document.getElementById('totalCancelado').innerText = formatarMoeda(d.total_cancelado || 0);
            });
    }

    function filtrar(status) {
        document.querySelectorAll('.filtro-btn').forEach(b => b.classList.remove('ativo'));
        const mapa = { '': 'filtroTodos', 'Pago': 'filtroPago', 'Pendente': 'filtroPendente', 'Cancelado': 'filtroCancelado' };
        if (mapa[status]) document.getElementById(mapa[status]).classList.add('ativo');

        const url = status
            ? '../../controllers/PagamentoController.php?acao=filtrar&status=' + encodeURIComponent(status)
            : '../../controllers/PagamentoController.php?acao=listar';
        fetch(url).then(r => r.json()).then(dados => renderizarTabela(dados));
    }

    document.getElementById('formPagamento').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const isEdicao = !!document.getElementById('id').value;
        formData.append('acao', isEdicao ? 'atualizar' : 'registrar');

        fetch('../../controllers/PagamentoController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
            if (data.sucesso) {
                limparFormulario();
                filtrar('');
                carregarResumo();
            }
        });
    });

    function editarPagamento(id) {
        fetch('../../controllers/PagamentoController.php?acao=buscar&id=' + id)
            .then(r => r.json())
            .then(p => {
                document.getElementById('id').value              = p.id;
                document.getElementById('pedido_id').value       = p.pedido_id;
                // Garante que o select já está populado antes de setar o valor
                if (!document.getElementById('pedido_id').value) {
                    popularSelectPedidos().then(() => {
                        document.getElementById('pedido_id').value = p.pedido_id;
                    });
                }
                document.getElementById('valor').value           = p.valor;
                document.getElementById('forma_pagamento').value = p.forma_pagamento;
                document.getElementById('status').value          = p.status;
                document.getElementById('observacoes').value     = p.observacoes || '';

                document.getElementById('tituloForm').innerText = 'Editar Pagamento #' + p.id;
                document.getElementById('btnSalvar').innerText  = 'Atualizar Pagamento';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
    }

    function limparFormulario() {
        document.getElementById('formPagamento').reset();
        document.getElementById('id').value = '';
        document.getElementById('tituloForm').innerText = 'Registrar Pagamento';
        document.getElementById('btnSalvar').innerText  = 'Salvar Pagamento';
    }

    function deletarPagamento(id) {
        if (confirm('Tem certeza que deseja excluir este pagamento?')) {
            const formData = new FormData();
            formData.append('acao', 'deletar');
            formData.append('id', id);

            fetch('../../controllers/PagamentoController.php', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                if (data.sucesso) {
                    filtrar('');
                    carregarResumo();
                }
            });
        }
    }

    filtrar('');
    carregarResumo();

    // Popula select de pedidos
    function popularSelectPedidos() {
        fetch('../../controllers/PedidoController.php?acao=listar')
            .then(r => r.json())
            .then(pedidos => {
                const sel = document.getElementById('pedido_id');
                const valorAtual = sel.value;
                sel.innerHTML = '<option value="">Selecione um pedido...</option>';
                pedidos.forEach(p => {
                    sel.innerHTML += `<option value="${p.id}">#${p.id} — Mesa ${p.mesa_numero} (${p.status})</option>`;
                });
                if (valorAtual) sel.value = valorAtual;
            });
    }

    popularSelectPedidos();
</script>

<?php include __DIR__ . '/admin_footer.php'; ?>
