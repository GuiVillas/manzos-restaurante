<?php include 'admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Gestão de Cardápio</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Cadastrar / Editar Prato -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-8">
    <h2 id="tituloForm" class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-5">Cadastrar Novo Prato</h2>

    <form id="formPrato" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <input type="hidden" name="id" id="id">

        <div>
            <label for="nome" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Nome do Prato</label>
            <input type="text" name="nome" id="nome" required
                   class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                   placeholder="Ex: Risoto de Funghi">
        </div>
        <div>
            <label for="preco" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Preço R$</label>
            <input type="number" step="0.01" name="preco" id="preco" required
                   class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                   placeholder="0.00">
        </div>
        <div>
            <label for="descricao" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Descrição</label>
            <input type="text" name="descricao" id="descricao"
                   class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                   placeholder="Breve descrição do prato">
        </div>
        <div>
            <label for="categoria_id" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Categoria</label>
            <select name="categoria_id" id="categoria_id"
                    class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                <option value="">Sem categoria</option>
            </select>
        </div>
        <div>
            <label for="ativo" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Status</label>
            <select name="ativo" id="ativo"
                    class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </div>
        <div class="md:col-span-2 lg:col-span-3 flex items-end gap-3">
            <button type="submit" id="btnSalvar"
                    class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Cadastrar Prato
            </button>
            <button type="button" id="btnCancelar" onclick="limparFormulario()" style="display:none"
                    class="bg-neutral-800 hover:bg-neutral-700 text-zinc-300 text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Cancelar Edição
            </button>
        </div>
    </form>
</div>

<!-- Tabela de Pratos -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-neutral-800 flex flex-col sm:flex-row sm:items-center gap-3">
        <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300">Pratos Cadastrados</h2>
        <input type="text" id="campoPesquisaPrato"
               placeholder="Filtrar por nome ou categoria..."
               oninput="filtrarPratos(this.value)"
               class="sm:ml-auto w-full sm:w-64 bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-neutral-900">
                <tr>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Nome</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Descrição</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Categoria</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Preço</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Status</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Ações</th>
                </tr>
            </thead>
            <tbody id="tabelaPratos">
                <!-- Preenchido via AJAX -->
            </tbody>
        </table>
    </div>
</div>

<script>
    let _todosPratos = [];

    function carregarPratos() {
        fetch('../../controllers/PratoController.php?acao=listar')
            .then(response => response.json())
            .then(dados => {
                _todosPratos = dados;
                renderizarPratos(dados);
            });
    }

    function filtrarPratos(termo) {
        const t = termo.toLowerCase().trim();
        const filtrados = t
            ? _todosPratos.filter(p =>
                p.nome.toLowerCase().includes(t) ||
                (p.categoria || '').toLowerCase().includes(t) ||
                (p.descricao || '').toLowerCase().includes(t))
            : _todosPratos;
        renderizarPratos(filtrados);
    }

    function renderizarPratos(dados) {
        const tbody = document.getElementById('tabelaPratos');
        tbody.innerHTML = '';
        if (dados.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum prato cadastrado.</td></tr>';
            return;
        }

        dados.forEach(prato => {
            const precoFormatado  = parseFloat(prato.preco).toFixed(2).replace('.',',');
            const mult            = parseFloat(prato.desconto_multiplicador || 1);
            const temDesconto     = mult < 1.00;
            const pctDesc         = temDesconto ? Math.round((1 - mult) * 100) : 0;
            const precoEfetivo    = (parseFloat(prato.preco) * mult).toFixed(2).replace('.',',');
            const precoExibido    = temDesconto
                ? `<span class="line-through text-zinc-600 text-xs mr-1">R$ ${precoFormatado}</span>
                    <span class="text-emerald-400 font-semibold">R$ ${precoEfetivo}</span>
                    <span class="ml-1 text-[10px] font-semibold px-1.5 py-0.5 rounded-sm bg-amber-500/10 text-amber-400 border border-amber-500/20">${pctDesc}% OFF</span>`
                : `<span class="text-gold-400 font-medium">R$ ${precoFormatado}</span>`;
            tbody.innerHTML += `
                <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                    <td class="px-6 py-3 text-sm text-zinc-300 font-medium">${prato.nome}</td>
                    <td class="px-6 py-3 text-sm text-zinc-500 max-w-xs">${prato.descricao ? prato.descricao.substring(0,45) + (prato.descricao.length > 45 ? '…' : '') : '<span class="text-zinc-700">—</span>'}</td>
                    <td class="px-6 py-3 text-sm text-zinc-400">${prato.categoria || '<span class="text-zinc-600 italic">Sem categoria</span>'}</td>
                    <td class="px-6 py-3 text-sm">${precoExibido}</td>
                    <td class="px-6 py-3">${prato.ativo == 1 ? '<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-400"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>Ativo</span>' : '<span class="inline-flex items-center gap-1 text-[11px] font-semibold text-zinc-500"><span class="w-1.5 h-1.5 rounded-full bg-zinc-600"></span>Inativo</span>'}</td>
                    <td class="px-6 py-3">
                        <div class="flex items-center gap-2">
                            <button onclick="editarPrato(${prato.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-gold-400 hover:text-gold-300 transition-colors">
                                Editar
                            </button>
                            <span class="text-neutral-700">|</span>
                            <button onclick="deletarPrato(${prato.id})"
                                    class="text-[11px] uppercase tracking-wider font-semibold text-red-400 hover:text-red-300 transition-colors">
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    document.getElementById('formPrato').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        const isEdicao = !!document.getElementById('id').value;
        formData.append('acao', isEdicao ? 'atualizar' : 'cadastrar');

        fetch('../../controllers/PratoController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                mostrarToast(data.mensagem, 'sucesso');
                limparFormulario();
                carregarPratos();
            } else {
                mostrarToast(data.mensagem, 'erro');
            }
        });
    });

    function editarPrato(id) {
        fetch('../../controllers/PratoController.php?acao=buscar&id=' + id)
            .then(r => r.json())
            .then(p => {
                document.getElementById('id').value           = p.id;
                document.getElementById('nome').value         = p.nome;
                document.getElementById('preco').value        = p.preco;
                document.getElementById('descricao').value    = p.descricao || '';
                document.getElementById('categoria_id').value = p.categoria_prato_id || '';
                document.getElementById('ativo').value        = p.ativo;

                document.getElementById('tituloForm').innerText   = 'Editar Prato: ' + p.nome;
                document.getElementById('btnSalvar').innerText    = 'Atualizar Prato';
                document.getElementById('btnCancelar').style.display = 'inline-block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
    }

    function limparFormulario() {
        document.getElementById('formPrato').reset();
        document.getElementById('id').value                  = '';
        document.getElementById('tituloForm').innerText      = 'Cadastrar Novo Prato';
        document.getElementById('btnSalvar').innerText       = 'Cadastrar Prato';
        document.getElementById('btnCancelar').style.display = 'none';
    }

    function deletarPrato(id) {
        if (confirm('Tem certeza que deseja excluir este prato?')) {
            let formData = new FormData();
            formData.append('acao', 'deletar');
            formData.append('id', id);

            fetch('../../controllers/PratoController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.sucesso) {
                    mostrarToast('Prato excluído com sucesso.', 'sucesso');
                    carregarPratos();
                } else {
                    mostrarToast(data.mensagem || 'Erro ao excluir prato.', 'erro');
                }
            });
        }
    }

    carregarPratos();

    // Popula select de categorias
    fetch('../../controllers/PratoController.php?acao=listarCategorias')
        .then(r => r.json())
        .then(cats => {
            const sel = document.getElementById('categoria_id');
            cats.forEach(c => {
                sel.innerHTML += `<option value="${c.id}">${c.nome}</option>`;
            });
        });
</script>

<?php include 'admin_footer.php'; ?>