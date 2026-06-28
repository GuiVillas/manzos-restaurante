<?php include __DIR__ . '/admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Gerenciamento de Usuários</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Form Card -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6">
    <h2 id="tituloForm" class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-6">Novo Usuário</h2>

    <form id="formUsuario" class="space-y-5">
        <input type="hidden" name="id" id="id">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nome Completo -->
            <div>
                <label for="nome" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Nome Completo</label>
                <input type="text" name="nome" id="nome" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Nome completo do usuário">
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
            <!-- Cargo -->
            <div>
                <label for="cargo" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Cargo</label>
                <input type="text" name="cargo" id="cargo" required list="listaCargos"
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Ex.: Gerente, Garçom, Chef...">
                <datalist id="listaCargos">
                    <option value="Gerente">
                    <option value="Chef">
                    <option value="Garçom">
                    <option value="Caixa">
                    <option value="Auxiliar">
                </datalist>
            </div>

            <!-- Senha (só no cadastro) -->
            <div id="campoSenha">
                <label for="senha" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Senha</label>
                <input type="password" name="senha" id="senha" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Senha de acesso">
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" id="btnSalvar"
                    class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Salvar Usuário
            </button>
            <button type="button" onclick="limparFormulario()"
                    class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Cancelar Edição
            </button>
        </div>
    </form>
</div>

<!-- Alterar Senha (visível só na edição) -->
<div id="cardAlterarSenha" class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6 hidden">
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-5">Alterar Senha do Usuário</h2>
    <form id="formSenha" class="flex flex-col sm:flex-row gap-4 items-end">
        <input type="hidden" name="id" id="senhaUsuarioId">
        <div class="flex-1">
            <label class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Nova Senha</label>
            <input type="password" name="senha" id="novaSenha" required
                   class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                   placeholder="Nova senha">
        </div>
        <button type="submit"
                class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
            Atualizar Senha
        </button>
    </form>
</div>

<!-- Search Card -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6">
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-4">Pesquisar Usuário</h2>
    <div class="relative">
        <input type="text" id="campoPesquisa" placeholder="Filtrar por nome, e-mail ou cargo..." oninput="pesquisarUsuarios()"
               class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 pr-10 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
        <button type="button" onclick="document.getElementById('campoPesquisa').value=''; pesquisarUsuarios();"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-zinc-600 hover:text-zinc-300 transition-colors text-lg leading-none">✕</button>
    </div>
</div>

<!-- Data Table -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-neutral-900">
                <tr>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Nome</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">E-mail</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Cargo</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Cadastrado em</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaUsuarios"></tbody>
        </table>
    </div>
</div>

<script>
    const cargoCores = {
        'Gerente':  'bg-gold-500/10 text-gold-400 border border-gold-500/20',
        'Chef':     'bg-orange-500/10 text-orange-400 border border-orange-500/20',
        'Garçom':   'bg-sky-500/10 text-sky-400 border border-sky-500/20',
        'Caixa':    'bg-violet-500/10 text-violet-400 border border-violet-500/20',
        'Auxiliar': 'bg-zinc-500/10 text-zinc-400 border border-zinc-500/20',
    };

    function corCargo(cargo) {
        return cargoCores[cargo] || 'bg-teal-500/10 text-teal-400 border border-teal-500/20';
    }

    function renderizarTabela(dados) {
        const tbody = document.getElementById('tabelaUsuarios');
        tbody.innerHTML = '';

        if (dados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-sm text-zinc-500 px-5 py-8">Nenhum usuário encontrado.</td></tr>';
            return;
        }

        dados.forEach(u => {
            const dataCriacao = u.criado_em.split(' ')[0].split('-').reverse().join('/');

            tbody.innerHTML += `
                <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                    <td class="text-sm text-zinc-300 px-5 py-3 font-medium">${u.nome}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${u.email}</td>
                    <td class="px-5 py-3">
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-sm ${corCargo(u.cargo)}">${u.cargo}</span>
                    </td>
                    <td class="text-sm text-zinc-400 px-5 py-3">${dataCriacao}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <button onclick="editarUsuario(${u.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-gold-400 hover:text-gold-300 transition-colors">
                                Editar
                            </button>
                            <span class="text-neutral-700">|</span>
                            <button onclick="deletarUsuario(${u.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-red-400 hover:text-red-300 transition-colors">
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    function carregarUsuarios() {
        document.getElementById('campoPesquisa').value = '';
        fetch('../../controllers/UsuarioController.php?acao=listar')
            .then(r => r.json())
            .then(dados => renderizarTabela(dados));
    }

    function pesquisarUsuarios() {
        const termo = document.getElementById('campoPesquisa').value;
        fetch('../../controllers/UsuarioController.php?acao=pesquisar&termo=' + encodeURIComponent(termo))
            .then(r => r.json())
            .then(dados => renderizarTabela(dados));
    }

    document.getElementById('formUsuario').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const isEdicao = !!document.getElementById('id').value;
        formData.append('acao', isEdicao ? 'atualizar' : 'cadastrar');

        fetch('../../controllers/UsuarioController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
            if (data.sucesso) {
                limparFormulario();
                carregarUsuarios();
            }
        });
    });

    document.getElementById('formSenha').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('acao', 'atualizarSenha');

        fetch('../../controllers/UsuarioController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
            if (data.sucesso) document.getElementById('novaSenha').value = '';
        });
    });

    function editarUsuario(id) {
        fetch('../../controllers/UsuarioController.php?acao=buscar&id=' + id)
            .then(r => r.json())
            .then(u => {
                document.getElementById('id').value    = u.id;
                document.getElementById('nome').value  = u.nome;
                document.getElementById('email').value = u.email;
                document.getElementById('cargo').value = u.cargo;

                // Oculta campo senha no formulário principal durante edição
                document.getElementById('campoSenha').style.display = 'none';
                document.getElementById('senha').removeAttribute('required');

                // Exibe card de alteração de senha separado
                document.getElementById('senhaUsuarioId').value = u.id;
                document.getElementById('cardAlterarSenha').classList.remove('hidden');

                document.getElementById('tituloForm').innerText = 'Editar Usuário: ' + u.nome;
                document.getElementById('btnSalvar').innerText  = 'Atualizar Usuário';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
    }

    function limparFormulario() {
        document.getElementById('formUsuario').reset();
        document.getElementById('id').value = '';

        // Restaura campo senha
        document.getElementById('campoSenha').style.display = 'block';
        document.getElementById('senha').setAttribute('required', '');

        // Esconde card de senha
        document.getElementById('cardAlterarSenha').classList.add('hidden');
        document.getElementById('novaSenha').value = '';

        document.getElementById('tituloForm').innerText = 'Novo Usuário';
        document.getElementById('btnSalvar').innerText  = 'Salvar Usuário';
    }

    function deletarUsuario(id) {
        if (confirm('Tem certeza que deseja excluir este usuário?')) {
            const formData = new FormData();
            formData.append('acao', 'deletar');
            formData.append('id', id);

            fetch('../../controllers/UsuarioController.php', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                if (data.sucesso) carregarUsuarios();
            });
        }
    }

    carregarUsuarios();
</script>

<?php include __DIR__ . '/admin_footer.php'; ?>
