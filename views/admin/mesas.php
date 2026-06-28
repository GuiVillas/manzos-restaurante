<?php include __DIR__ . '/admin_header.php'; ?>

    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="font-serif text-2xl text-amber-100 font-normal">Mesas</h1>
        <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- Form Section -->
        <div class="xl:col-span-1">
            <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6">
                <h2 id="tituloForm" class="text-sm text-amber-100 font-medium mb-5">Nova Mesa</h2>
                <div class="w-8 h-[1px] bg-gold-500/40 mb-6"></div>

                <form id="formMesa" class="space-y-5">
                    <input type="hidden" name="id" id="id">

                    <!-- Número -->
                    <div>
                        <label for="numero" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Número</label>
                        <input
                            type="number"
                            name="numero"
                            id="numero"
                            required
                            min="1"
                            placeholder="Ex: 1"
                            class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20 placeholder-zinc-600"
                        >
                    </div>

                    <!-- Capacidade -->
                    <div>
                        <label for="capacidade" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Capacidade</label>
                        <input
                            type="number"
                            name="capacidade"
                            id="capacidade"
                            required
                            min="1"
                            placeholder="Ex: 4"
                            class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20 placeholder-zinc-600"
                        >
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Status</label>
                        <select
                            name="status"
                            id="status"
                            required
                            class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20 appearance-none"
                        >
                            <option value="Disponível">Disponível</option>
                            <option value="Ocupada">Ocupada</option>
                            <option value="Reservada">Reservada</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3 pt-2">
                        <button
                            type="submit"
                            id="btnSalvar"
                            class="flex-1 bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300"
                        >
                            Salvar Mesa
                        </button>
                        <button
                            type="button"
                            onclick="limparFormulario()"
                            class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300"
                        >
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="xl:col-span-2">

            <!-- Search Bar -->
            <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-4 mb-6">
                <div class="flex flex-col sm:flex-row gap-3">
                    <input
                        type="text"
                        id="campoPesquisa"
                        placeholder="Pesquisar por número ou status..." oninput="pesquisarMesas()"
                        class="flex-1 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20 placeholder-zinc-600"
                    >
                    <div class="flex gap-3">
                        <button
                            type="button"
                            onclick="pesquisarMesas()"
                            class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300"
                        >
                            Buscar
                        </button>
                        <button
                            type="button"
                            onclick="carregarMesas()"
                            class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300"
                        >
                            Ver Todos
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-neutral-900">
                            <tr>
                                <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-5 py-3">Número</th>
                                <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-5 py-3">Capacidade</th>
                                <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-5 py-3">Status</th>
                                <th class="text-right text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-5 py-3">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaMesas" class="divide-y divide-neutral-900"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        /**
         * Retorna as classes CSS do badge conforme o status da mesa.
         */
        function badgeStatus(status) {
            switch (status) {
                case 'Disponível':
                    return 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-400';
                case 'Ocupada':
                    return 'bg-red-500/10 border border-red-500/20 text-red-400';
                case 'Reservada':
                    return 'bg-amber-500/10 border border-amber-500/20 text-amber-400';
                default:
                    return 'bg-zinc-500/10 border border-zinc-500/20 text-zinc-400';
            }
        }

        /**
         * Renderiza as linhas da tabela com os dados recebidos.
         */
        function renderizarTabela(dados) {
            const tbody = document.getElementById('tabelaMesas');
            tbody.innerHTML = '';

            if (dados.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center text-sm text-zinc-500 py-8">Nenhuma mesa encontrada.</td></tr>';
                return;
            }

            dados.forEach(mesa => {
                tbody.innerHTML += `
                    <tr class="hover:bg-neutral-900/50 transition-colors">
                        <td class="px-5 py-3.5 text-sm text-zinc-300 font-medium">Mesa ${mesa.numero}</td>
                        <td class="px-5 py-3.5 text-sm text-zinc-300">${mesa.capacidade} lugares</td>
                        <td class="px-5 py-3.5">
                            <span class="inline-block text-[11px] font-semibold tracking-wider uppercase px-2.5 py-1 rounded-sm ${badgeStatus(mesa.status)}">
                                ${mesa.status}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="editarMesa(${mesa.id})" class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-[11px] font-semibold tracking-wider uppercase px-3 py-1.5 rounded-sm transition-all duration-300">
                                    Editar
                                </button>
                                <button onclick="deletarMesa(${mesa.id})" class="bg-red-500/10 border border-red-500/20 hover:bg-red-500/20 text-red-400 text-[11px] font-semibold tracking-wider uppercase px-3 py-1.5 rounded-sm transition-all duration-300">
                                    Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }

        /**
         * Carrega todas as mesas e limpa o campo de pesquisa.
         */
        function carregarMesas() {
            document.getElementById('campoPesquisa').value = '';
            fetch('../../controllers/MesaController.php?acao=listar')
                .then(response => response.json())
                .then(dados => renderizarTabela(dados));
        }

        /**
         * Pesquisa mesas pelo termo digitado.
         */
        function pesquisarMesas() {
            let termo = document.getElementById('campoPesquisa').value;
            fetch('../../controllers/MesaController.php?acao=pesquisar&termo=' + encodeURIComponent(termo))
                .then(response => response.json())
                .then(dados => renderizarTabela(dados));
        }

        /**
         * Busca uma mesa por ID e preenche o formulário para edição.
         */
        function editarMesa(id) {
            fetch('../../controllers/MesaController.php?acao=buscar&id=' + id)
                .then(response => response.json())
                .then(dados => {
                    document.getElementById('id').value = dados.id;
                    document.getElementById('numero').value = dados.numero;
                    document.getElementById('capacidade').value = dados.capacidade;
                    document.getElementById('status').value = dados.status;

                    document.getElementById('tituloForm').innerText = "Editar Mesa " + dados.numero;
                    document.getElementById('btnSalvar').innerText = "Atualizar Mesa";
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
        }

        /**
         * Limpa o formulário e restaura o estado de criação.
         */
        function limparFormulario() {
            document.getElementById('formMesa').reset();
            document.getElementById('id').value = '';
            document.getElementById('tituloForm').innerText = "Nova Mesa";
            document.getElementById('btnSalvar').innerText = "Salvar Mesa";
        }

        /**
         * Exclui uma mesa após confirmação.
         */
        function deletarMesa(id) {
            if (confirm('Tem certeza que deseja excluir esta mesa?')) {
                let formData = new FormData();
                formData.append('acao', 'deletar');
                formData.append('id', id);

                fetch('../../controllers/MesaController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                    if (data.sucesso) {
                        carregarMesas();
                    }
                });
            }
        }

        /**
         * Handler do formulário — cadastra ou atualiza conforme o campo ID.
         */
        document.getElementById('formMesa').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let acao = document.getElementById('id').value ? 'atualizar' : 'cadastrar';
            formData.append('acao', acao);

            fetch('../../controllers/MesaController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                if (data.sucesso) {
                    limparFormulario();
                    carregarMesas();
                }
            });
        });

        // Carrega as mesas ao abrir a página
        carregarMesas();
    </script>

<?php include __DIR__ . '/admin_footer.php'; ?>
