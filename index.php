<?php require_once 'header.php'; ?>

<!-- Main Content wrapper to push down from fixed header -->
<main class="flex-grow pt-24">
    <!-- Hero Section -->
    <section class="relative h-[85vh] md:h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Image with zoom animation & overlay -->
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1920&q=80" 
                 alt="Corte de Carne Premium Manzo's" 
                 class="w-full h-full object-cover scale-105 animate-[pulse_10s_infinite] brightness-50 contrast-125">
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/40 to-neutral-950/60"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 text-center max-w-4xl px-6">
            <span class="text-gold-400 font-semibold tracking-[0.4em] text-xs md:text-sm uppercase block mb-4 md:mb-6 animate-fade-in">A Arte do Fogo e da Carne</span>
            <h1 class="font-serif text-5xl md:text-8xl font-normal text-amber-500/10 text-white tracking-wide leading-none mb-8">
                PROVE DO FRUTO
            </h1>
            <p class="text-zinc-300 text-sm md:text-lg max-w-xl mx-auto font-light tracking-wide leading-relaxed mb-12">
                Uma jornada sensorial definitiva. Seleção rigorosa de carnes premium preparadas com a precisão do fogo e o requinte da alta gastronomia.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="menu.php" class="w-full sm:w-auto bg-gold-400 hover:bg-gold-300 text-black text-xs font-semibold tracking-widest uppercase px-10 py-4.5 rounded-sm transition-all duration-300 shadow-lg shadow-gold-500/10">
                    Ver Nosso Menu
                </a>
                <a href="reserva.php" class="w-full sm:w-auto border border-zinc-500 hover:border-gold-300 text-zinc-100 hover:text-gold-100 hover:bg-zinc-950/40 text-xs font-semibold tracking-widest uppercase px-10 py-4.5 rounded-sm transition-all duration-300">
                    Reservar Mesa
                </a>
            </div>
        </div>

        <!-- Decorative Bottom Scroll Indicator -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-2">
            <span class="text-[9px] uppercase tracking-[0.3em] text-zinc-500">Descer</span>
            <div class="w-[1px] h-12 bg-gradient-to-b from-gold-500/60 to-transparent"></div>
        </div>
    </section>

    <!-- Previews Section (Asymmetric Grid) -->
    <section class="py-24 md:py-36 bg-neutral-950 border-t border-neutral-900/50">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center max-w-2xl mx-auto mb-20 md:mb-28">
                <span class="text-gold-500 font-semibold tracking-[0.3em] text-xs uppercase block mb-3">O Templo Gastronômico</span>
                <h2 class="font-serif text-3xl md:text-5xl text-amber-100 font-medium">A Experiência Manzo's</h2>
                <div class="w-16 h-[1px] bg-gold-500 mx-auto mt-6"></div>
            </div>

            <!-- Asymmetric Grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-12 items-stretch">
                <!-- Large Vertical Card (Left) -->
                <div class="md:col-span-7 group relative overflow-hidden rounded-sm min-h-[400px] md:min-h-[600px] flex flex-col justify-end p-8 md:p-12 transition-transform duration-700">
                    <img src="https://images.unsplash.com/photo-1543007630-9710e4a00a20?auto=format&fit=crop&w=1200&q=80" 
                         alt="Nosso Ambiente" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 brightness-[0.45]">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent z-0"></div>
                    
                    <div class="relative z-10">
                        <span class="text-gold-400 font-semibold tracking-wider text-[10px] uppercase block mb-2">Atmosfera</span>
                        <h3 class="font-serif text-2xl md:text-3xl text-white mb-4">O Ambiente</h3>
                        <p class="text-zinc-300 text-sm max-w-md font-light leading-relaxed">
                            Uma sinergia perfeita entre design minimalista e iluminação cênica, idealizada para valorizar a celebração e a intimidade.
                        </p>
                    </div>
                </div>

                <!-- Column of 2 Small Cards (Right) -->
                <div class="md:col-span-5 flex flex-col gap-8 md:gap-12 justify-between">
                    <!-- Top Small Card -->
                    <div class="group relative overflow-hidden rounded-sm h-[280px] md:h-[276px] flex flex-col justify-end p-8 transition-transform duration-700">
                        <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?auto=format&fit=crop&w=800&q=80" 
                             alt="Coquetéis Autorais" 
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 brightness-[0.4]">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent z-0"></div>
                        
                        <div class="relative z-10">
                            <span class="text-gold-400 font-semibold tracking-wider text-[10px] uppercase block mb-2">Mixologia</span>
                            <h3 class="font-serif text-xl text-white mb-2">Drinks e Elixires</h3>
                            <p class="text-zinc-300 text-xs font-light max-w-xs leading-relaxed">
                                Coquetelaria clássica recriada com destilados premium e infusões artesanais exclusivas da casa.
                            </p>
                        </div>
                    </div>

                    <!-- Bottom Small Card -->
                    <div class="group relative overflow-hidden rounded-sm h-[280px] md:h-[276px] flex flex-col justify-end p-8 transition-transform duration-700">
                        <img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?auto=format&fit=crop&w=800&q=80" 
                             alt="Alta Confeitaria" 
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 brightness-[0.4]">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/30 to-transparent z-0"></div>
                        
                        <div class="relative z-10">
                            <span class="text-gold-400 font-semibold tracking-wider text-[10px] uppercase block mb-2">Dolci</span>
                            <h3 class="font-serif text-xl text-white mb-2">Sobremesas Esculpidas</h3>
                            <p class="text-zinc-300 text-xs font-light max-w-xs leading-relaxed">
                                Finalizações surpreendentes que equilibram doçura, texturas e técnicas modernas de confeitaria.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Extra row in Grid for majestic asymmetry -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-12 mt-8 md:mt-12">
                <!-- Large horizontal Card (Bottom) -->
                <div class="md:col-span-12 group relative overflow-hidden rounded-sm h-[320px] md:h-[450px] flex flex-col justify-end p-8 md:p-12">
                    <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=1600&q=80" 
                         alt="Cozinha de Fogo" 
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105 brightness-[0.4]">
                    <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent z-0"></div>
                    
                    <div class="relative z-10 max-w-xl">
                        <span class="text-gold-400 font-semibold tracking-wider text-[10px] uppercase block mb-2">Artesanato</span>
                        <h3 class="font-serif text-2xl md:text-3xl text-white mb-3">O Fogo e o Carvão</h3>
                        <p class="text-zinc-300 text-sm font-light leading-relaxed mb-6">
                            Nossa grelha e forno a carvão artesanal elevam cortes selecionados a um patamar único de sabor e maciez, combinando calor intenso e técnicas refinadas de maturação.
                        </p>
                        <a href="sobre.php" class="inline-flex items-center gap-2 text-xs font-semibold text-gold-400 hover:text-gold-200 tracking-widest uppercase transition-colors duration-300">
                            Conheça Nossa História 
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>
