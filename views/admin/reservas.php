<?php include __DIR__ . '/admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Gestão de Reservas</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Form Card -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6">
    <h2 id="tituloForm" class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-6">Nova Reserva</h2>

    <form id="formReserva" class="space-y-5">
        <input type="hidden" name="id" id="id">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Cliente -->
            <div>
                <label for="cliente_id" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Cliente</label>
                <select name="cliente_id" id="cliente_id" required
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                    <option value="">Selecione um cliente...</option>
                </select>
            </div>

            <!-- Mesa -->
            <div>
                <label for="mesa_id" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Mesa</label>
                <select name="mesa_id" id="mesa_id" required
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                    <option value="">Selecione uma mesa...</option>
                </select>
            </div>

            <!-- Data -->
            <div>
                <label for="data_reserva" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Data</label>
                <input type="date" name="data_reserva" id="data_reserva" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
            </div>

            <!-- Hora -->
            <div>
                <label for="hora_reserva" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Hora</label>
                <input type="time" name="hora_reserva" id="hora_reserva" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Nº Pessoas -->
            <div>
                <label for="num_pessoas" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Nº Pessoas</label>
                <input type="number" name="num_pessoas" id="num_pessoas" required min="1"
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Ex: 4">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Status</label>
                <select name="status" id="status"
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                    <option value="Confirmada">Confirmada</option>
                    <option value="Cancelada">Cancelada</option>
                    <option value="Concluída">Concluída</option>
                </select>
            </div>
        </div>

        <!-- Observações -->
        <div>
            <label for="observacoes" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Observações</label>
            <textarea name="observacoes" id="observacoes" rows="3"
                      class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20 resize-y"
                      placeholder="Informações adicionais sobre a reserva..."></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" id="btnSalvar"
                    class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Salvar Reserva
            </button>
            <button type="button" onclick="limparFormulario()"
                    class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Cancelar Edição
            </button>
        </div>
    </form>
</div>

<!-- Search Card -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6">
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-4">Pesquisar Reservas</h2>
    <div class="flex flex-col sm:flex-row gap-3">
        <input type="text" id="campoPesquisa" placeholder="Nome do cliente ou status..."
               class="flex-1 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
        <button type="button" onclick="pesquisarReservas()"
                class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
            Buscar
        </button>
        <button type="button" onclick="carregarReservas()"
                class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
            Ver Todos
        </button>
    </div>
</div>

<!-- Data Table -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-neutral-900">
                <tr>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">ID</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Cliente</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Mesa</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Data</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Hora</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Pessoas</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Status</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaReservas"></tbody>
        </table>
    </div>
</div>

<script>
    function getStatusBadge(status) {
        const badges = {
            'Confirmada': 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-400',
            'Cancelada':  'bg-red-500/10 border border-red-500/20 text-red-400',
            'Concluída':  'bg-blue-500/10 border border-blue-500/20 text-blue-400',
        };
        const classes = badges[status] || 'bg-neutral-800 border border-neutral-700 text-zinc-400';
        return `<span class="inline-block text-[11px] font-semibold tracking-wider uppercase px-2.5 py-1 rounded-sm ${classes}">${status}</span>`;
    }

    function renderizarTabela(dados) {
        const tbody = document.getElementById('tabelaReservas');
        tbody.innerHTML = '';

        if (dados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-sm text-zinc-500 px-5 py-8">Nenhuma reserva encontrada.</td></tr>';
            return;
        }

        dados.forEach(reserva => {
            let dataFormatada = reserva.data_reserva.split('-').reverse().join('/');
            tbody.innerHTML += `
                <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                    <td class="text-sm text-zinc-500 px-5 py-3 font-mono">${reserva.id}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3 font-medium">${reserva.cliente_nome}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">Mesa ${reserva.mesa_numero}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${dataFormatada}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${reserva.hora_reserva}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3 text-center">${reserva.num_pessoas}</td>
                    <td class="px-5 py-3">${getStatusBadge(reserva.status)}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <button onclick="editarReserva(${reserva.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-gold-400 hover:text-gold-300 transition-colors">
                                Editar
                            </button>
                            <span class="text-neutral-700">|</span>
                            <button onclick="deletarReserva(${reserva.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-red-400 hover:text-red-300 transition-colors">
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    function carregarReservas() {
        document.getElementById('campoPesquisa').value = '';
        fetch('../../controllers/ReservaController.php?acao=listar')
            .then(response => response.json())
            .then(dados => renderizarTabela(dados));
    }

    function pesquisarReservas() {
        let termo = document.getElementById('campoPesquisa').value;
        fetch('../../controllers/ReservaController.php?acao=pesquisar&termo=' + encodeURIComponent(termo))
            .then(response => response.json())
            .then(dados => renderizarTabela(dados));
    }

    document.getElementById('formReserva').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        let acao = document.getElementById('id').value ? 'atualizar' : 'cadastrar';
        formData.append('acao', acao);

        fetch('../../controllers/ReservaController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
            if (data.sucesso) {
                limparFormulario();
                carregarReservas();
            }
        });
    });

    function editarReserva(id) {
        fetch('../../controllers/ReservaController.php?acao=buscar&id=' + id)
            .then(response => response.json())
            .then(dados => {
                document.getElementById('id').value = dados.id;
                document.getElementById('cliente_id').value = dados.cliente_id;
                document.getElementById('mesa_id').value = dados.mesa_id;
                document.getElementById('data_reserva').value = dados.data_reserva;
                document.getElementById('hora_reserva').value = dados.hora_reserva;
                document.getElementById('num_pessoas').value = dados.num_pessoas;
                document.getElementById('status').value = dados.status;
                document.getElementById('observacoes').value = dados.observacoes;

                document.getElementById('tituloForm').innerText = "Editar Reserva #" + dados.id;
                document.getElementById('btnSalvar').innerText = "Atualizar Reserva";
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
    }

    function limparFormulario() {
        document.getElementById('formReserva').reset();
        document.getElementById('id').value = '';
        document.getElementById('tituloForm').innerText = "Nova Reserva";
        document.getElementById('btnSalvar').innerText = "Salvar Reserva";
    }

    function deletarReserva(id) {
        if (confirm('Tem certeza que deseja excluir esta reserva?')) {
            let formData = new FormData();
            formData.append('acao', 'deletar');
            formData.append('id', id);

            fetch('../../controllers/ReservaController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                if (data.sucesso) {
                    carregarReservas();
                }
            });
        }
    }

    carregarReservas();

    // Popula selects de cliente e mesa ao carregar a página
    fetch('../../controllers/ClienteController.php?acao=listar')
        .then(r => r.json())
        .then(clientes => {
            const sel = document.getElementById('cliente_id');
            clientes.forEach(c => {
                sel.innerHTML += `<option value="${c.id}">${c.nome} — ${c.telefone}</option>`;
            });
        });

    fetch('../../controllers/MesaController.php?acao=listar')
        .then(r => r.json())
        .then(mesas => {
            const sel = document.getElementById('mesa_id');
            mesas.forEach(m => {
                sel.innerHTML += `<option value="${m.id}">Mesa ${m.numero} (${m.capacidade} lugares — ${m.status})</option>`;
            });
        });
</script>

<?php include __DIR__ . '/admin_footer.php'; ?>