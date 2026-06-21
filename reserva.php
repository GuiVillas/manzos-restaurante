<?php
require_once 'header.php';
require_once __DIR__ . '/config/database.php';

$reserva_confirmada = false;
$erro = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
    $pessoas = filter_input(INPUT_POST, 'pessoas', FILTER_VALIDATE_INT);
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_SPECIAL_CHARS);
    $horario = filter_input(INPUT_POST, 'horario', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($cpf && $nome && $email && $telefone && $pessoas && $data && $horario) {
        try {
            $db = Database::getConnection();

            // 1. Buscar ou criar o cliente pelo CPF (identificador único)
            $stmtCliente = $db->prepare("SELECT id FROM cliente WHERE cpf = ? LIMIT 1");
            $stmtCliente->execute([$cpf]);
            $cliente = $stmtCliente->fetch();

            if ($cliente) {
                $cliente_id = $cliente['id'];
                // Atualizar dados do cliente caso tenham mudado
                $stmtUpdate = $db->prepare("UPDATE cliente SET nome = ?, email = ?, telefone = ? WHERE id = ?");
                $stmtUpdate->execute([$nome, $email, $telefone, $cliente_id]);
            } else {
                $stmtInsert = $db->prepare("INSERT INTO cliente (cpf, nome, email, telefone) VALUES (?, ?, ?, ?)");
                $stmtInsert->execute([$cpf, $nome, $email, $telefone]);
                $cliente_id = $db->lastInsertId();
            }

            // 2. Buscar uma mesa disponível com capacidade suficiente
            $stmtMesa = $db->prepare("SELECT id FROM mesa WHERE status = 'Disponível' AND capacidade >= ? ORDER BY capacidade ASC LIMIT 1");
            $stmtMesa->execute([$pessoas]);
            $mesa = $stmtMesa->fetch();

            $mesa_id = $mesa ? $mesa['id'] : 1; // Fallback para mesa 1 se nenhuma estiver livre

            // 3. Criar a reserva
            $stmtReserva = $db->prepare("INSERT INTO reserva (cliente_id, mesa_id, data_reserva, hora_reserva, num_pessoas, status, observacoes) VALUES (?, ?, ?, ?, ?, 'Confirmada', 'Reserva pelo site')");
            $stmtReserva->execute([$cliente_id, $mesa_id, $data, $horario, $pessoas]);

            // 4. Atualizar status da mesa
            if ($mesa) {
                $db->prepare("UPDATE mesa SET status = 'Reservada' WHERE id = ?")->execute([$mesa_id]);
            }

            $reserva_confirmada = true;
        } catch (Exception $e) {
            $erro = "Ocorreu um erro ao processar sua reserva. Por favor, tente novamente ou entre em contato pelo telefone.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos corretamente para efetuar sua solicitação.";
    }
}
?>

<main class="flex-grow pt-24 min-h-screen bg-neutral-950 flex flex-col md:flex-row">
    
    <!-- Left Screen: Image (Fixed on Desktop, Banner on Mobile) -->
    <div class="w-full md:w-1/2 md:fixed md:top-24 md:left-0 md:bottom-0 h-[300px] md:h-auto overflow-hidden z-10 border-r border-neutral-900/50">
        <img src="https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?auto=format&fit=crop&w=1200&q=80" 
             alt="Taças de Vinho e Atmosfera de Jantar" 
             class="w-full h-full object-cover brightness-50 contrast-110">
        <!-- Vignette overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/20 to-transparent md:bg-gradient-to-r md:from-transparent md:to-neutral-950/80"></div>
        
        <!-- Overlaid text -->
        <div class="absolute bottom-10 left-10 right-10 hidden md:block">
            <span class="text-gold-400 font-semibold tracking-[0.3em] text-[10px] uppercase block mb-2">Exclusividade</span>
            <h2 class="font-serif text-3xl text-white font-medium mb-3">Reserve seu Momento</h2>
            <p class="text-zinc-400 text-xs font-light max-w-sm leading-relaxed">
                Garanta sua mesa em nosso salão principal ou reserve salas exclusivas para eventos privados. Recomendamos realizar a reserva com antecedência.
            </p>
        </div>
    </div>

    <!-- Right Screen: Reservation Form -->
    <div class="w-full md:w-1/2 md:ml-auto px-6 py-16 md:px-16 md:py-24 z-20 flex items-center">
        <div class="max-w-md w-full mx-auto">
            
            <!-- Page Header -->
            <div class="mb-12">
                <span class="text-gold-500 font-semibold tracking-[0.4em] text-xs uppercase block mb-3">Planeje sua Visita</span>
                <h1 class="font-serif text-4xl text-amber-100 font-normal tracking-wide">FAÇA SUA RESERVA</h1>
                <div class="w-16 h-[1px] bg-gold-500 mt-6"></div>
            </div>

            <!-- Success State -->
            <?php if ($reserva_confirmada): ?>
                <div class="bg-neutral-900 border border-gold-500/30 p-8 rounded-sm text-center space-y-6 animate-[fadeIn_0.5s_ease-out]">
                    <div class="w-16 h-16 bg-gold-500/10 border border-gold-500/30 rounded-full flex items-center justify-center mx-auto text-gold-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div class="space-y-2">
                        <h3 class="font-serif text-xl text-white">Solicitação Recebida</h3>
                        <p class="text-zinc-400 text-xs font-light leading-relaxed">
                            Obrigado, <strong class="text-amber-100"><?= htmlspecialchars($nome) ?></strong>. Nossa equipe de concierge está analisando a disponibilidade para o dia <span class="text-gold-400 font-medium"><?= date('d/m/Y', strtotime($data)) ?></span> às <span class="text-gold-400 font-medium"><?= htmlspecialchars($horario) ?></span> para <span class="text-gold-400 font-medium"><?= htmlspecialchars($pessoas) ?> pessoas</span>.
                        </p>
                    </div>
                    <p class="text-[11px] text-zinc-500 font-light">
                        Você receberá um e-mail de confirmação ou contato telefônico em até 30 minutos.
                    </p>
                    <a href="index.php" class="inline-block border border-neutral-700 hover:border-gold-400 text-zinc-300 hover:text-white text-xs font-semibold tracking-widest uppercase px-6 py-3 rounded-sm transition-colors duration-300">
                        Voltar ao Início
                    </a>
                </div>
            
            <!-- Form State -->
            <?php else: ?>
                
                <?php if (!empty($erro)): ?>
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-xs p-4 rounded-sm mb-6 font-light">
                        <?= htmlspecialchars($erro) ?>
                    </div>
                <?php endif; ?>

                <form action="reserva.php" method="POST" class="space-y-6" id="formReserva">

                    <!-- CPF com busca -->
                    <div>
                        <label for="cpf" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">CPF</label>
                        <div class="relative">
                            <input type="text" id="cpf" name="cpf" required maxlength="14"
                                   class="w-full bg-transparent border border-neutral-800 focus:border-gold-400 text-white placeholder-zinc-700 text-sm px-4 py-3 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20 pr-12"
                                   placeholder="000.000.000-00"
                                   inputmode="numeric">
                            <!-- Ícone de status (loading / encontrado / novo) -->
                            <div id="cpfStatus" class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center">
                            </div>
                        </div>
                        <!-- Feedback do CPF -->
                        <div id="cpfFeedback" class="mt-2 text-xs font-light hidden"></div>
                    </div>

                    <!-- Nome (preenchido automaticamente se cliente existir) -->
                    <div>
                        <label for="nome" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Nome Completo</label>
                        <input type="text" id="nome" name="nome" required 
                               class="w-full bg-transparent border border-neutral-800 focus:border-gold-400 text-white placeholder-zinc-700 text-sm px-4 py-3 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                               placeholder="Ex: Alexandre de Bourbon">
                    </div>

                    <!-- Grid Fone & Email -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="telefone" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Telefone</label>
                            <input type="tel" id="telefone" name="telefone" required 
                                   class="w-full bg-transparent border border-neutral-800 focus:border-gold-400 text-white placeholder-zinc-700 text-sm px-4 py-3 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                                   placeholder="(11) 99999-9999">
                        </div>
                        <div>
                            <label for="email" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">E-mail</label>
                            <input type="email" id="email" name="email" required 
                                   class="w-full bg-transparent border border-neutral-800 focus:border-gold-400 text-white placeholder-zinc-700 text-sm px-4 py-3 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20"
                                   placeholder="seuemail@exemplo.com">
                        </div>
                    </div>

                    <!-- Grid Pessoas, Data & Horário -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div>
                            <label for="pessoas" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Pessoas</label>
                            <select id="pessoas" name="pessoas" required 
                                    class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-3 py-3 rounded-sm outline-none transition-all duration-300">
                                <option value="1">1 Pessoa</option>
                                <option value="2" selected>2 Pessoas</option>
                                <option value="3">3 Pessoas</option>
                                <option value="4">4 Pessoas</option>
                                <option value="5">5 Pessoas</option>
                                <option value="6">6 Pessoas</option>
                                <option value="8">8+ Pessoas</option>
                            </select>
                        </div>
                        <div>
                            <label for="data" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Data</label>
                            <input type="date" id="data" name="data" required 
                                   min="<?= date('Y-m-d') ?>"
                                   class="w-full bg-transparent border border-neutral-800 focus:border-gold-400 text-white text-sm px-4 py-2.5 rounded-sm outline-none transition-all duration-300 focus:ring-1 focus:ring-gold-400/20">
                        </div>
                        <div>
                            <label for="horario" class="block text-zinc-400 text-xs font-medium tracking-wider uppercase mb-2">Horário</label>
                            <select id="horario" name="horario" required 
                                    class="w-full bg-neutral-900 border border-neutral-800 focus:border-gold-400 text-white text-sm px-3 py-3 rounded-sm outline-none transition-all duration-300">
                                <option value="19:00">19:00</option>
                                <option value="19:30">19:30</option>
                                <option value="20:00">20:00</option>
                                <option value="20:30">20:30</option>
                                <option value="21:00">21:00</option>
                                <option value="21:30">21:30</option>
                                <option value="22:00">22:00</option>
                                <option value="22:30">22:30</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full bg-gold-400 hover:bg-gold-300 text-black font-semibold text-xs tracking-widest uppercase py-4 rounded-sm transition-all duration-300 shadow-lg shadow-gold-500/10">
                            Enviar Solicitação de Reserva
                        </button>
                    </div>
                </form>

                <script>
                    // ============================================
                    // Máscara de CPF e Busca Automática por CPF
                    // ============================================
                    
                    const cpfInput = document.getElementById('cpf');
                    const cpfStatus = document.getElementById('cpfStatus');
                    const cpfFeedback = document.getElementById('cpfFeedback');
                    const nomeInput = document.getElementById('nome');
                    const emailInput = document.getElementById('email');
                    const telefoneInput = document.getElementById('telefone');

                    let buscaTimeout = null;

                    // Máscara de CPF: 000.000.000-00
                    cpfInput.addEventListener('input', function(e) {
                        let valor = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
                        
                        if (valor.length > 11) valor = valor.slice(0, 11);
                        
                        // Aplica a máscara
                        if (valor.length > 9) {
                            valor = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
                        } else if (valor.length > 6) {
                            valor = valor.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                        } else if (valor.length > 3) {
                            valor = valor.replace(/(\d{3})(\d{1,3})/, '$1.$2');
                        }
                        
                        e.target.value = valor;

                        // Limpa feedback anterior
                        cpfFeedback.classList.add('hidden');
                        cpfStatus.innerHTML = '';

                        // Busca quando o CPF estiver completo (14 caracteres com máscara)
                        if (valor.length === 14) {
                            clearTimeout(buscaTimeout);
                            buscaTimeout = setTimeout(() => buscarClientePorCpf(valor), 300);
                        }
                    });

                    function buscarClientePorCpf(cpf) {
                        // Mostra loading
                        cpfStatus.innerHTML = `
                            <svg class="w-4 h-4 text-gold-400 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>`;

                        fetch('controllers/ClienteController.php?acao=buscar_por_cpf&cpf=' + encodeURIComponent(cpf))
                            .then(response => response.json())
                            .then(dados => {
                                if (dados && dados.id) {
                                    // Cliente encontrado — preenche os campos
                                    nomeInput.value = dados.nome || '';
                                    emailInput.value = dados.email || '';
                                    telefoneInput.value = dados.telefone || '';

                                    // Torna os campos somente leitura quando o cliente já existe
                                    nomeInput.readOnly = true;
                                    emailInput.readOnly = true;
                                    telefoneInput.readOnly = true;
                                    nomeInput.classList.add('opacity-60');
                                    emailInput.classList.add('opacity-60');
                                    telefoneInput.classList.add('opacity-60');

                                    // Ícone de sucesso
                                    cpfStatus.innerHTML = `
                                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>`;

                                    // Feedback visual
                                    cpfFeedback.innerHTML = `
                                        <span class="text-emerald-400">✓ Cliente encontrado:</span> 
                                        <span class="text-zinc-300">${dados.nome}</span>`;
                                    cpfFeedback.classList.remove('hidden');
                                    cpfInput.classList.remove('border-neutral-800');
                                    cpfInput.classList.add('border-emerald-500/50');
                                } else {
                                    // Cliente novo — libera campos para preenchimento
                                    nomeInput.value = '';
                                    emailInput.value = '';
                                    telefoneInput.value = '';
                                    nomeInput.readOnly = false;
                                    emailInput.readOnly = false;
                                    telefoneInput.readOnly = false;
                                    nomeInput.classList.remove('opacity-60');
                                    emailInput.classList.remove('opacity-60');
                                    telefoneInput.classList.remove('opacity-60');

                                    // Ícone de novo
                                    cpfStatus.innerHTML = `
                                        <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>`;

                                    cpfFeedback.innerHTML = `
                                        <span class="text-gold-400">Novo cliente</span> — 
                                        <span class="text-zinc-500">preencha os dados abaixo para cadastro automático.</span>`;
                                    cpfFeedback.classList.remove('hidden');
                                    cpfInput.classList.remove('border-neutral-800', 'border-emerald-500/50');
                                    cpfInput.classList.add('border-gold-400/50');

                                    nomeInput.focus();
                                }
                            })
                            .catch(() => {
                                cpfStatus.innerHTML = '';
                                cpfFeedback.innerHTML = `<span class="text-red-400">Erro ao buscar CPF. Preencha os dados manualmente.</span>`;
                                cpfFeedback.classList.remove('hidden');

                                // Libera campos
                                nomeInput.readOnly = false;
                                emailInput.readOnly = false;
                                telefoneInput.readOnly = false;
                                nomeInput.classList.remove('opacity-60');
                                emailInput.classList.remove('opacity-60');
                                telefoneInput.classList.remove('opacity-60');
                            });
                    }

                    // Quando limpar o campo CPF, reseta tudo
                    cpfInput.addEventListener('change', function() {
                        if (this.value.length < 14) {
                            nomeInput.readOnly = false;
                            emailInput.readOnly = false;
                            telefoneInput.readOnly = false;
                            nomeInput.classList.remove('opacity-60');
                            emailInput.classList.remove('opacity-60');
                            telefoneInput.classList.remove('opacity-60');
                            cpfInput.classList.remove('border-emerald-500/50', 'border-gold-400/50');
                            cpfInput.classList.add('border-neutral-800');
                            cpfFeedback.classList.add('hidden');
                            cpfStatus.innerHTML = '';
                        }
                    });
                </script>

            <?php endif; ?>

        </div>
    </div>
</main>

<?php require_once 'footer.php'; ?>
