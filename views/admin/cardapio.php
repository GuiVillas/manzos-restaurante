<?php include 'admin_header.php'; ?>

<!-- Page Title -->
<div class="mb-8">
    <h1 class="font-serif text-2xl text-amber-100 font-normal">Gestão de Cardápio</h1>
    <div class="w-12 h-[1px] bg-gold-500 mt-3"></div>
</div>

<!-- Cadastrar Novo Prato -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm p-6 mb-8">
    <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300 mb-5">Cadastrar Novo Prato</h2>

    <form id="formPrato" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
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
            <label for="categoria_id" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">ID da Categoria</label>
            <input type="number" name="categoria_id" id="categoria_id"
                   class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                   placeholder="Ex: 1">
        </div>
        <div class="md:col-span-2 lg:col-span-4 flex items-end">
            <button type="submit"
                    class="bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-wider uppercase px-5 py-2.5 rounded-sm transition-all duration-300">
                Cadastrar Prato
            </button>
        </div>
    </form>
</div>

<!-- Tabela de Pratos -->
<div class="bg-neutral-900/50 border border-neutral-800 rounded-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-neutral-800">
        <h2 class="text-sm font-semibold tracking-wider uppercase text-zinc-300">Pratos Cadastrados</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-neutral-900">
                <tr>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">ID</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Nome</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Categoria</th>
                    <th class="text-left text-[11px] uppercase tracking-wider text-zinc-500 font-semibold px-6 py-3">Preço</th>
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
    function carregarPratos() {
        fetch('../../controllers/PratoController.php?acao=listar')
            .then(response => response.json())
            .then(dados => {
                const tbody = document.getElementById('tabelaPratos');
                tbody.innerHTML = '';

                if (dados.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-sm text-zinc-500">Nenhum prato cadastrado.</td></tr>';
                    return;
                }

                dados.forEach(prato => {
                    const precoFormatado = parseFloat(prato.preco).toFixed(2);
                    tbody.innerHTML += `
                        <tr class="border-b border-neutral-900 hover:bg-neutral-900/50 transition-colors">
                            <td class="px-6 py-3 text-sm text-zinc-500 font-mono">${prato.id}</td>
                            <td class="px-6 py-3 text-sm text-zinc-300">${prato.nome}</td>
                            <td class="px-6 py-3 text-sm text-zinc-400">${prato.categoria || '<span class="text-zinc-600 italic">Sem categoria</span>'}</td>
                            <td class="px-6 py-3 text-sm text-gold-400 font-medium">R$ ${precoFormatado}</td>
                            <td class="px-6 py-3">
                                <button onclick="deletarPrato(${prato.id})"
                                        class="bg-red-500/10 border border-red-500/20 text-red-400 text-xs font-semibold tracking-wider uppercase px-3 py-1.5 rounded-sm hover:bg-red-500/20 transition-all duration-300">
                                    Excluir
                                </button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

    document.getElementById('formPrato').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.append('acao', 'cadastrar');

        fetch('../../controllers/PratoController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                mostrarToast(data.mensagem, 'sucesso');
                this.reset();
                carregarPratos();
            } else {
                mostrarToast(data.mensagem, 'erro');
            }
        });
    });

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
</script>

<?php include 'admin_footer.php'; ?>