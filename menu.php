<?php require_once 'header.php'; ?>

<!-- Main wrapper to accommodate split-screen design -->
<main class="flex-grow pt-24 min-h-screen bg-neutral-950 flex flex-col md:flex-row">
    
    <!-- Left Screen: Fixed Image on Desktop / Top Banner on Mobile -->
    <div class="w-full md:w-1/2 md:fixed md:top-24 md:left-0 md:bottom-0 h-[350px] md:h-auto overflow-hidden z-10 border-r border-neutral-900/50">
        <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=1200&q=80" 
             alt="Chef Preparando Carne Premium" 
             class="w-full h-full object-cover brightness-50 contrast-125 transition-transform duration-[15000ms] hover:scale-110">
        <!-- Vignette overlay -->
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/20 to-transparent md:bg-gradient-to-r md:from-transparent md:to-neutral-950/80"></div>
        
        <!-- Overlaid text for branding on image -->
        <div class="absolute bottom-10 left-10 right-10 hidden md:block">
            <span class="text-gold-400 font-semibold tracking-[0.3em] text-[10px] uppercase block mb-2">Manzo's Signature</span>
            <h2 class="font-serif text-3xl text-white font-medium mb-3">O Fogo Transforma</h2>
            <p class="text-zinc-400 text-xs font-light max-w-sm leading-relaxed">
                Nossos chefs dominam a ciência e a arte da grelha para extrair o máximo de sabor, textura e aroma de cada corte nobre.
            </p>
        </div>
    </div>

    <!-- Right Screen: Scrollable Menu Details -->
    <div class="w-full md:w-1/2 md:ml-auto px-6 py-16 md:px-16 md:py-24 z-20">
        <div class="max-w-xl mx-auto">
            
            <!-- Page Header -->
            <div class="mb-16">
                <span class="text-gold-500 font-semibold tracking-[0.4em] text-xs uppercase block mb-3">Alta Gastronomia</span>
                <h1 class="font-serif text-4xl md:text-5xl text-amber-100 font-normal tracking-wide">NOSSO MENU</h1>
                <div class="w-16 h-[1px] bg-gold-500 mt-6"></div>
            </div>

            <!-- Categories Section Wrapper -->
            <div class="space-y-16">
                
                <!-- Category: Entradas -->
                <div>
                    <h3 class="font-serif text-xl md:text-2xl text-amber-200 tracking-wide border-b border-neutral-900 pb-3 mb-8 flex items-center justify-between">
                        <span>Entradas</span>
                        <span class="text-[10px] tracking-[0.2em] font-sans text-zinc-500 uppercase">Starters</span>
                    </h3>
                    <div class="space-y-8">
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Steak Tartare Manzo's</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 68</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Tartare de filé mignon picado na ponta da faca, gema de codorna curada, alcaparras, mostarda Dijon antiga e torradas artesanais de fermentação natural.
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Carpaccio de Wagyu</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 74</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Fatias finíssimas de Wagyu altamente marmorizado, rúcula selvática orgânica, lascas de queijo Grana Padano de 24 meses e azeite de oliva extra virgem trufado.
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Tutano Assado na Brasa</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 56</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Tutano bovino assado em forno de carvão, servido com vinagrete chimichurri fresco e fatias de sourdough tostadas na manteiga de garrafa.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Category: Petiscos -->
                <div>
                    <h3 class="font-serif text-xl md:text-2xl text-amber-200 tracking-wide border-b border-neutral-900 pb-3 mb-8 flex items-center justify-between">
                        <span>Petiscos</span>
                        <span class="text-[10px] tracking-[0.2em] font-sans text-zinc-500 uppercase">Appetizers</span>
                    </h3>
                    <div class="space-y-8">
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Croqueta de Costela Defumada</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 48</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Croquetas ultra cremosas de costela defumada por 12 horas em lenha de macieira, servidas com maionese caseira de carvão ativado.
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Dadinhos de Tapioca com Coalho</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 42</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Crocantes por fora e macios por dentro, acompanhados de geleia de pimenta dedo-de-moça defumada produzida artesanalmente.
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Panceta Pururuca</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 52</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Barriga de porco crocante cozida lentamente em baixa temperatura e pururucada, acompanhada de redução de goiabada cascão e cachaça envelhecida.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Category: Carnes Premium -->
                <div>
                    <h3 class="font-serif text-xl md:text-2xl text-amber-200 tracking-wide border-b border-neutral-900 pb-3 mb-8 flex items-center justify-between">
                        <span>Carnes Premium</span>
                        <span class="text-[10px] tracking-[0.2em] font-sans text-zinc-500 uppercase">Noble Cuts</span>
                    </h3>
                    <div class="space-y-8">
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Prime Rib Wagyu A5</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 340</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Nível excepcional de marmoreio (BMS 10+). Grelhado ao ponto perfeito do chef, finalizado com flor de sal de Maldon e manteiga de tutano (600g).
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Bife Ancho Black Angus</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 165</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Retirado da parte dianteira do contrafilé Angus certificado. Maciez inigualável assada na brasa forte e servida com chimichurri da casa (400g).
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Tomahawk Selection</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 290</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Corte monumental com osso da costela que realça o sabor da carne. Selado na churrasqueira a carvão e regado com manteiga trufada e tomilho fresco (900g).
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Filet Mignon ao Jus de Trufas</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 138</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Medalhão alto de filé mignon selado, demi-glace artesanal infundido em trufas negras e acompanhado de aligot aveludado de queijo Canastra meia cura.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Category: Sobremesas -->
                <div>
                    <h3 class="font-serif text-xl md:text-2xl text-amber-200 tracking-wide border-b border-neutral-900 pb-3 mb-8 flex items-center justify-between">
                        <span>Sobremesas</span>
                        <span class="text-[10px] tracking-[0.2em] font-sans text-zinc-500 uppercase">Desserts</span>
                    </h3>
                    <div class="space-y-8">
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Texturas de Chocolate</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 44</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Combinação artística de mousse de chocolate belga 70%, ganache defumada em lenha doce, crumble de cacau com flor de sal e sorvete artesanal de baunilha Bourbon.
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Mil Folhas de Doce de Leite</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 38</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Massa folhada ultra fina e crocante intercalada com doce de leite artesanal cozido lentamente e um toque de flor de sal.
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Crème Brûlée de Pistache</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 42</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Creme aveludado francês aromatizado com pistache siciliano puro, coberto com a tradicional casquinha de açúcar demerara queimada no maçarico.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Category: Drinks -->
                <div>
                    <h3 class="font-serif text-xl md:text-2xl text-amber-200 tracking-wide border-b border-neutral-900 pb-3 mb-8 flex items-center justify-between">
                        <span>Drinks</span>
                        <span class="text-[10px] tracking-[0.2em] font-sans text-zinc-500 uppercase">Mixology</span>
                    </h3>
                    <div class="space-y-8">
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Manzo's Old Fashioned</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 48</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Bourbon premium envelhecido, xarope artesanal de açúcar mascavo defumado no momento do serviço sob cúpula com serragem de macieira e angostura bitter.
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Smoked Negroni</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 46</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                London Dry Gin artesanal, vermute tinto doce piemontês, Campari defumado e guarnição de casca de laranja bahia flambada.
                            </p>
                        </div>
                        <!-- Item -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-4 mb-2">
                                <h4 class="text-white font-medium text-sm md:text-base group-hover:text-gold-300 transition-colors duration-300">Basil & Ginger Gin & Tonic</h4>
                                <span class="text-gold-400 font-medium text-sm">R$ 42</span>
                            </div>
                            <p class="text-zinc-400 text-xs font-light leading-relaxed">
                                Gin infusionado, água tônica premium, folhas frescas de manjericão gigante, extrato fresco de gengibre e um toque cítrico de limão siciliano.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Call to Action -->
            <div class="mt-20 border-t border-neutral-900 pt-12 text-center">
                <p class="text-zinc-500 text-sm mb-6 font-light">
                    Deseja vivenciar esta experiência gastronômica pessoalmente?
                </p>
                <a href="reserva.php" class="inline-block bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-widest uppercase px-8 py-3.5 rounded-sm transition-all duration-300 shadow-md">
                    Reserve uma Mesa
                </a>
            </div>

        </div>
    </div>
</main>

<?php require_once 'footer.php'; ?>
