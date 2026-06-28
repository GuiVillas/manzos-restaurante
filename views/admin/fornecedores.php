<?php include __DIR__ . '/admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Cadastro de Fornecedores</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Form Card -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-6">
    <h2 id="tituloForm" class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-6">Novo Fornecedor</h2>

    <form id="formFornecedor" class="space-y-5">
        <input type="hidden" name="id" id="id">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Nome -->
            <div>
                <label for="nome" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Razão Social / Nome</label>
                <input type="text" name="nome" id="nome" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Nome ou razão social">
            </div>

            <!-- CNPJ -->
            <div>
                <label for="cnpj" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">CNPJ</label>
                <input type="text" name="cnpj" id="cnpj"
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="XX.XXX.XXX/XXXX-XX">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Telefone -->
            <div>
                <label for="telefone" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Telefone</label>
                <input type="text" name="telefone" id="telefone" required
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="(XX) XXXX-XXXX">
            </div>

            <!-- E-mail -->
            <div>
                <label for="email" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">E-mail</label>
                <input type="email" name="email" id="email"
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="email@fornecedor.com.br">
            </div>

            <!-- Contato -->
            <div>
                <label for="contato" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Pessoa de Contato</label>
                <input type="text" name="contato" id="contato"
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Nome do responsável">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Categoria -->
            <div>
                <label for="categoria" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Categoria</label>
                <input type="text" name="categoria" id="categoria" required list="listaCategorias"
                       class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                       placeholder="Ex.: Carnes, Bebidas, Hortifruti...">
                <datalist id="listaCategorias"></datalist>
            </div>

            <!-- Status -->
            <div>
                <label for="ativo" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Status</label>
                <select name="ativo" id="ativo"
                        class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center gap-3 pt-2">
            <button type="submit" id="btnSalvar"
                    class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Salvar Fornecedor
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
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-4">Pesquisar Fornecedor</h2>
    <div class="relative">
        <input type="text" id="campoPesquisa" placeholder="Filtrar por nome, categoria, e-mail ou CNPJ..." oninput="pesquisarFornecedores()"
               class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 pr-10 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
        <button type="button" onclick="document.getElementById('campoPesquisa').value=''; pesquisarFornecedores();"
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
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">CNPJ</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Telefone</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Categoria</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Contato</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">E-mail</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Status</th>
                    <th class="text-[11px] uppercase tracking-wider text-zinc-500 font-semibold text-left px-5 py-3">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaFornecedores"></tbody>
        </table>
    </div>
</div>

<script>
    const categoriaCores = {};
    const paleta = [
        'bg-amber-500/10 text-amber-400',
        'bg-sky-500/10 text-sky-400',
        'bg-violet-500/10 text-violet-400',
        'bg-emerald-500/10 text-emerald-400',
        'bg-rose-500/10 text-rose-400',
        'bg-teal-500/10 text-teal-400',
        'bg-orange-500/10 text-orange-400',
    ];
    let paletaIdx = 0;

    function corCategoria(cat) {
        if (!categoriaCores[cat]) {
            categoriaCores[cat] = paleta[paletaIdx % paleta.length];
            paletaIdx++;
        }
        return categoriaCores[cat];
    }

    function renderizarTabela(dados) {
        const tbody = document.getElementById('tabelaFornecedores');
        tbody.innerHTML = '';

        if (dados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-sm text-zinc-500 px-5 py-8">Nenhum fornecedor encontrado.</td></tr>';
            return;
        }

        dados.forEach(f => {
            const ativoLabel = f.ativo == 1
                ? '<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-400"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Ativo</span>'
                : '<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-zinc-500"><span class="w-1.5 h-1.5 rounded-full bg-zinc-600"></span>Inativo</span>';

            tbody.innerHTML += `
                <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                    <td class="text-sm text-zinc-300 px-5 py-3 font-medium">${f.nome}</td>
                    <td class="text-sm text-zinc-400 px-5 py-3 font-mono">${f.cnpj || '—'}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${f.telefone}</td>
                    <td class="px-5 py-3">
                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-sm ${corCategoria(f.categoria)}">${f.categoria}</span>
                    </td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${f.contato || '—'}</td>
                    <td class="text-sm text-zinc-300 px-5 py-3">${f.email || '—'}</td>
                    <td class="px-5 py-3">${ativoLabel}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-2">
                            <button onclick="editarFornecedor(${f.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-gold-400 hover:text-gold-300 transition-colors">
                                Editar
                            </button>
                            <span class="text-neutral-700">|</span>
                            <button onclick="deletarFornecedor(${f.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-red-400 hover:text-red-300 transition-colors">
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    function carregarCategorias() {
        fetch('../../controllers/FornecedorController.php?acao=categorias')
            .then(r => r.json())
            .then(cats => {
                const dl = document.getElementById('listaCategorias');
                dl.innerHTML = '';
                cats.forEach(c => { dl.innerHTML += `<option value="${c}">`; });
            });
    }

    function carregarFornecedores() {
        document.getElementById('campoPesquisa').value = '';
        fetch('../../controllers/FornecedorController.php?acao=listar')
            .then(r => r.json())
            .then(dados => renderizarTabela(dados));
    }

    function pesquisarFornecedores() {
        const termo = document.getElementById('campoPesquisa').value;
        fetch('../../controllers/FornecedorController.php?acao=pesquisar&termo=' + encodeURIComponent(termo))
            .then(r => r.json())
            .then(dados => renderizarTabela(dados));
    }

    document.getElementById('formFornecedor').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const isEdicao = !!document.getElementById('id').value;
        formData.append('acao', isEdicao ? 'atualizar' : 'cadastrar');
        formData.set('ativo', document.getElementById('ativo').value);

        fetch('../../controllers/FornecedorController.php', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
            if (data.sucesso) {
                limparFormulario();
                carregarFornecedores();
                carregarCategorias();
            }
        });
    });

    function editarFornecedor(id) {
        fetch('../../controllers/FornecedorController.php?acao=buscar&id=' + id)
            .then(r => r.json())
            .then(f => {
                document.getElementById('id').value        = f.id;
                document.getElementById('nome').value      = f.nome;
                document.getElementById('cnpj').value      = f.cnpj || '';
                document.getElementById('telefone').value  = f.telefone;
                document.getElementById('email').value     = f.email || '';
                document.getElementById('categoria').value = f.categoria;
                document.getElementById('contato').value   = f.contato || '';
                document.getElementById('ativo').value     = f.ativo;

                document.getElementById('tituloForm').innerText = 'Editar Fornecedor: ' + f.nome;
                document.getElementById('btnSalvar').innerText  = 'Atualizar Fornecedor';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
    }

    function limparFormulario() {
        document.getElementById('formFornecedor').reset();
        document.getElementById('id').value = '';
        document.getElementById('tituloForm').innerText = 'Novo Fornecedor';
        document.getElementById('btnSalvar').innerText  = 'Salvar Fornecedor';
    }

    function deletarFornecedor(id) {
        if (confirm('Tem certeza que deseja excluir este fornecedor?')) {
            const formData = new FormData();
            formData.append('acao', 'deletar');
            formData.append('id', id);

            fetch('../../controllers/FornecedorController.php', {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(data => {
                mostrarToast(data.mensagem, data.sucesso ? 'sucesso' : 'erro');
                if (data.sucesso) carregarFornecedores();
            });
        }
    }

    carregarFornecedores();
    carregarCategorias();
</script>

<?php include __DIR__ . '/admin_footer.php'; ?>
