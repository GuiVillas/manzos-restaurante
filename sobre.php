<?php require_once 'header.php'; ?>

<main class="flex-grow pt-24">
    <!-- Intro Hero / Banner -->
    <section class="relative h-[50vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1541614101331-1a5a3a194e92?auto=format&fit=crop&w=1920&q=80" 
                 alt="Preparação Artesanal da Carne" 
                 class="w-full h-full object-cover brightness-50 contrast-125">
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/40 to-neutral-950/60"></div>
        </div>
        <div class="relative z-10 text-center px-6">
            <span class="text-gold-400 font-semibold tracking-[0.4em] text-xs uppercase block mb-3">Artesanato Culinário</span>
            <h1 class="font-serif text-4xl md:text-6xl text-white font-normal tracking-wide">A HISTÓRIA</h1>
            <div class="w-12 h-[1px] bg-gold-500 mx-auto mt-6"></div>
        </div>
    </section>

    <!-- Narrative Section -->
    <section class="py-24 bg-neutral-950">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                <!-- Left Text Column -->
                <div class="lg:col-span-7 space-y-8">
                    <span class="text-gold-500 font-semibold tracking-[0.3em] text-xs uppercase block">O Começo de Tudo</span>
                    <h2 class="font-serif text-3xl md:text-4xl text-amber-100 font-normal">
                        Redefinindo a Alta Gastronomia de Carnes
                    </h2>
                    <p class="text-zinc-300 text-sm md:text-base font-light leading-relaxed">
                        Fundado pelo desejo de elevar o churrasco e os cortes premium ao patamar das artes plásticas, o **MANZO'S** nasceu no coração da culinária contemporânea. Nós não apenas grelhamos carne; nós homenageamos o ingrediente através da precisão térmica, do tempo de maturação e da perfeita alquimia do fogo de madeira e carvão.
                    </p>
                    <p class="text-zinc-400 text-sm font-light leading-relaxed">
                        Nossos cortes provêm exclusivamente de produtores certificados parceiros, que compartilham de nossa filosofia de manejo ético e alimentação natural. Cada pedaço de bife ancho, tomahawk ou filé que servimos passa por um rigoroso processo de seleção antes de tocar a brasa, garantindo que o mármore, a maciez e o sabor atinjam seu ápice absoluto.
                    </p>
                    
                    <!-- Core values list -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6">
                        <div class="border-l border-gold-500/30 pl-4 py-2">
                            <h4 class="text-amber-100 font-medium text-xs tracking-wider uppercase mb-2">Origem Rara</h4>
                            <p class="text-zinc-500 text-[11px] font-light leading-relaxed">Gado criado solto com pastagem selecionada e linhagem genética nobre.</p>
                        </div>
                        <div class="border-l border-gold-500/30 pl-4 py-2">
                            <h4 class="text-amber-100 font-medium text-xs tracking-wider uppercase mb-2">Maturação Controlada</h4>
                            <p class="text-zinc-500 text-[11px] font-light leading-relaxed">Dry aging próprio para concentrar sabor, textura e maciez incomparáveis.</p>
                        </div>
                        <div class="border-l border-gold-500/30 pl-4 py-2">
                            <h4 class="text-amber-100 font-medium text-xs tracking-wider uppercase mb-2">Cozinha de Fogo</h4>
                            <p class="text-zinc-500 text-[11px] font-light leading-relaxed">Lenha frutífera e carvão artesanal em equilíbrio aromático sublime.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Visual Column -->
                <div class="lg:col-span-5 relative">
                    <div class="border border-gold-500/20 p-2 rounded-sm">
                        <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1000&q=80" 
                             alt="Grelha de Fogo Alto" 
                             class="w-full h-[450px] object-cover rounded-xs brightness-75">
                    </div>
                    <!-- Decorative absolute block -->
                    <div class="absolute -bottom-6 -left-6 bg-neutral-900 border border-neutral-800 p-6 max-w-[200px] hidden sm:block">
                        <span class="text-3xl font-serif text-gold-400 block mb-1">100%</span>
                        <span class="text-[10px] text-zinc-400 tracking-wider uppercase block">Angus & Wagyu Certificados</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Awards Section -->
    <section class="py-24 bg-black border-t border-neutral-900/40">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-gold-500 font-semibold tracking-[0.3em] text-xs uppercase block mb-3">Reconhecimento</span>
                <h2 class="font-serif text-3xl md:text-4xl text-amber-100 font-normal">Prêmios e Distinções</h2>
                <p class="text-zinc-500 text-xs font-light mt-4">Nossa dedicação incansável à perfeição reconhecida pela crítica especializada.</p>
                <div class="w-12 h-[1px] bg-gold-500 mx-auto mt-6"></div>
            </div>

            <!-- Awards Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12">
                <!-- Award 1 -->
                <div class="bg-neutral-950 border border-neutral-900/60 p-8 rounded-sm text-center flex flex-col items-center hover:border-gold-500/20 transition-colors duration-500">
                    <!-- Star Icons -->
                    <div class="flex items-center space-x-1.5 text-gold-400 mb-6">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <h3 class="font-serif text-lg text-white mb-2">Duas Estrelas Michelin</h3>
                    <p class="text-gold-400 font-semibold tracking-wider text-[10px] uppercase mb-4">Guia Michelin 2025</p>
                    <p class="text-zinc-500 text-xs font-light leading-relaxed">
                        Condecorado com duas estrelas pela excelência na precisão de preparo, pureza de ingredientes e consistência excepcional no menu degustação de carnes.
                    </p>
                </div>

                <!-- Award 2 -->
                <div class="bg-neutral-950 border border-neutral-900/60 p-8 rounded-sm text-center flex flex-col items-center hover:border-gold-500/20 transition-colors duration-500">
                    <!-- Star Icons -->
                    <div class="flex items-center space-x-1.5 text-gold-400 mb-6">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <h3 class="font-serif text-lg text-white mb-2">Melhor Steakhouse das Américas</h3>
                    <p class="text-gold-400 font-semibold tracking-wider text-[10px] uppercase mb-4">Star Dining Awards 2026</p>
                    <p class="text-zinc-500 text-xs font-light leading-relaxed">
                        Reconhecido como a churrascaria de elite líder no continente pela curadoria insuperável de cortes bovinos e técnicas revolucionárias de grelha.
                    </p>
                </div>

                <!-- Award 3 -->
                <div class="bg-neutral-950 border border-neutral-900/60 p-8 rounded-sm text-center flex flex-col items-center hover:border-gold-500/20 transition-colors duration-500">
                    <!-- Trophy Icon style -->
                    <div class="flex items-center space-x-1.5 text-gold-400 mb-6">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <h3 class="font-serif text-lg text-white mb-2">Excelência em Carta de Vinhos</h3>
                    <p class="text-gold-400 font-semibold tracking-wider text-[10px] uppercase mb-4">Wine Spectator Grand Award</p>
                    <p class="text-zinc-500 text-xs font-light leading-relaxed">
                        Prêmio de excelência máxima concedido à nossa adega climatizada que abriga mais de 450 rótulos do velho e novo mundo selecionados para harmonização.
                    </p>
                </div>
            </div>

        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>
