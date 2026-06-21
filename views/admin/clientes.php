<?php include __DIR__ . '/admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Cadastro de Clientes</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Form Card -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6">
    <h2 id="tituloForm" class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-6">Novo Cliente</h2>

    <form id="formCliente" class="space-y-5">
        <input type="hidden" name="id" id="id">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nome Completo -->
            <div>
                <label for="nome" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Nome Completo</label>
                <input type="text" name="nome" id="nome" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Nome completo do cliente">
            </div>

            <!-- E-mail -->
            <div>
                <label for="email" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">E-mail</label>
                <input type="email" name="email" id="email" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="email@exemplo.com">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- CPF -->
            <div>
                <label for="cpf" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">CPF</label>
                <input type="text" name="cpf" id="cpf" required maxlength="14"
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="000.000.000-00" inputmode="numeric">
            </div>

            <!-- Telefone -->
            <div>
                <label for="telefone" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Telefone</label>
                <input type="text" name="telefone" id="telefone" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="(XX) XXXXX-XXXX">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" id="btnSalvar"
                    class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Salvar Cliente
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
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-4">Pesquisar Cliente</h2>
    <div class="flex flex-col sm:flex-row gap-3">
        <input type="text" id="campoPesquisa" placeholder="CPF, nome, email ou telefone..."
               class="flex-1 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
        <button type="button" onclick="pesquisarClientes()"
                class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
            Buscar
        </button>
        <button type="button" onclick="carregarClientes()"
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
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">CPF</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Nome</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">E-mail</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Telefone</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Cadastrado em</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaClientes"></tbody>
        </table>
    </div>
</div>

<script>
    function renderizarTabela(dados) {
        const tbody = document.getElementById('tabelaClientes');
        tbody.innerHTML = '';

        if (dados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-sm text-zinc-500 px-5 py-8">Nenhum cliente encontrado.</td></tr>';
            return;
        }

        dados.forEach(cliente => {
            let dataCriacao = cliente.criado_em.split(' ')[0].split('-').reverse().join('/');

            tbody.innerHTML += `
                <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                    <td class="text-sm text-zinc-500 px-5 py-3 font-mono">${cliente.id}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3 font-mono">${cliente.cpf || '—'}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3 font-medium">${cliente.nome}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${cliente.email}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${cliente.telefone}</td>
                    <td class="text-sm text-zinc-400 px-5 py-3">${dataCriacao}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <button onclick="editarCliente(${cliente.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-gold-400 hover:text-gold-300 transition-colors">
                                Editar
                            </button>
                            <span class="text-neutral-700">|</span>
                            <button onclick="deletarCliente(${cliente.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-red-400 hover:text-red-300 transition-colors">
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    function carregarClientes() {
        document.getElementById('campoPesquisa').value = '';
        fetch('../../controllers/ClienteController.php?acao=listar')
            .then(response => response.json())
            .then(dados => renderizarTabela(dados));
    }

    function pesquisarClientes() {
        let termo = document.getElementById('campoPesquisa').value;
        fetch('../../controllers/ClienteController.php?acao=pesquisar&termo=' + encodeURIComponent(termo))
            .then(response => response.json())
            .then(dados => renderizarTabela(dados));
    }

    document.getElementById('formCliente').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let acao = document.getElementById('id').value ? 'atualizar' : 'cadastrar';
        formData.append('acao', acao);

        fetch('../../controllers/ClienteController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
            if (data.sucesso) {
                limparFormulario();
                carregarClientes();
            }
        });
    });

    function editarCliente(id) {
        fetch('../../controllers/ClienteController.php?acao=buscar&id=' + id)
            .then(response => response.json())
            .then(dados => {
                document.getElementById('id').value = dados.id;
                document.getElementById('cpf').value = dados.cpf || '';
                document.getElementById('nome').value = dados.nome;
                document.getElementById('email').value = dados.email;
                document.getElementById('telefone').value = dados.telefone;

                document.getElementById('tituloForm').innerText = "Editar Cliente #" + dados.id;
                document.getElementById('btnSalvar').innerText = "Atualizar Cliente";
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
    }

    function limparFormulario() {
        document.getElementById('formCliente').reset();
        document.getElementById('id').value = '';
        document.getElementById('tituloForm').innerText = "Novo Cliente";
        document.getElementById('btnSalvar').innerText = "Salvar Cliente";
    }

    function deletarCliente(id) {
        if (confirm('Tem certeza que deseja excluir este cliente?')) {
            let formData = new FormData();
            formData.append('acao', 'deletar');
            formData.append('id', id);

            fetch('../../controllers/ClienteController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                if (data.sucesso) {
                    carregarClientes();
                }
            });
        }
    }

    carregarClientes();
</script>

<?php include __DIR__ . '/admin_footer.php'; ?>