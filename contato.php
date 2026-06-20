<?php require_once 'header.php'; ?>

<main class="flex-grow pt-24 bg-neutral-950">
    <!-- Banner Header -->
    <section class="relative h-[40vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1543007630-9710e4a00a20?auto=format&fit=crop&w=1920&q=80" 
                 alt="Mesa posta e taças de vinho" 
                 class="w-full h-full object-cover brightness-50 contrast-110">
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/40 to-neutral-950/60"></div>
        </div>
        <div class="relative z-10 text-center px-6">
            <span class="text-gold-400 font-semibold tracking-[0.4em] text-xs uppercase block mb-3">Onde nos Encontrar</span>
            <h1 class="font-serif text-4xl md:text-6xl text-white font-normal tracking-wide">CONTATO</h1>
            <div class="w-12 h-[1px] bg-gold-500 mx-auto mt-6"></div>
        </div>
    </section>

    <!-- Information and Map Grid -->
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Column: Address, Hours & Contact Info -->
                <div class="lg:col-span-5 space-y-12">
                    
                    <!-- Address & Phone Block -->
                    <div class="space-y-4">
                        <span class="text-gold-500 font-semibold tracking-[0.3em] text-xs uppercase block">Localização</span>
                        <h2 class="font-serif text-2xl text-amber-100 font-normal">Manzo's Jardins</h2>
                        <p class="text-zinc-400 text-sm font-light leading-relaxed max-w-sm">
                            Alameda Lorena, 1500<br>
                            Jardins, São Paulo - SP<br>
                            CEP: 01424-002
                        </p>
                        <div class="pt-2 space-y-2 text-sm">
                            <p class="text-zinc-300 font-light">
                                <span class="text-gold-400 font-medium tracking-wide uppercase text-xs">Telefone:</span> 
                                (11) 3088-2990
                            </p>
                            <p class="text-zinc-300 font-light">
                                <span class="text-gold-400 font-medium tracking-wide uppercase text-xs">E-mail:</span> 
                                reservas@manzos.com.br
                            </p>
                        </div>
                    </div>

                    <!-- Hours Block -->
                    <div class="space-y-6">
                        <span class="text-gold-500 font-semibold tracking-[0.3em] text-xs uppercase block">Horários de Funcionamento</span>
                        
                        <div class="border-t border-neutral-900 pt-4 space-y-3.5 max-w-sm">
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-400 font-light">Segunda-feira</span>
                                <span class="text-zinc-500 font-light uppercase text-xs">Fechado</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-300 font-light">Terça a Quinta</span>
                                <span class="text-zinc-400 font-light">19:00 &mdash; 23:30</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-300 font-light">Sexta e Sábado</span>
                                <span class="text-zinc-400 font-light">19:00 &mdash; 00:30</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-zinc-300 font-light">Domingo</span>
                                <span class="text-zinc-400 font-light">12:00 &mdash; 17:00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Concierge Advice -->
                    <div class="bg-neutral-900/40 border border-neutral-900 p-6 rounded-sm max-w-sm">
                        <h4 class="text-gold-400 font-semibold text-xs tracking-wider uppercase mb-2">Traje Recomendado</h4>
                        <p class="text-zinc-500 text-xs font-light leading-relaxed">
                            Para manter a atmosfera refinada de nosso salão, sugerimos traje Esporte Fino. Não é permitida a entrada com trajes de banho ou chinelos.
                        </p>
                    </div>

                </div>

                <!-- Right Column: Darkened Map -->
                <div class="lg:col-span-7 space-y-4">
                    <span class="text-gold-500 font-semibold tracking-[0.3em] text-xs uppercase block">Localização Interativa</span>
                    
                    <!-- Darkened Google Maps Container -->
                    <div class="w-full h-[400px] md:h-[500px] rounded-sm overflow-hidden border border-neutral-900/60 filter grayscale invert contrast-[1.15] brightness-[0.5] opacity-80 hover:opacity-95 transition-all duration-500">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.1852994017666!2d-46.66601662502213!3d-23.561790684681788!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c19fb77ff1%3A0xc39f99f1fa11fa67!2sAl.%20Lorena%2C%201500%20-%20Jardins%2C%20S%C3%A3o%20Paulo%20-%20SP%2C%2001424-002!5e0!3m2!1spt-BR!2sbr!4v1655000000000!5m2!1spt-BR!2sbr" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    
                    <div class="flex items-center justify-between text-[11px] text-zinc-600">
                        <span>Valet disponível no local</span>
                        <a href="https://maps.google.com" target="_blank" class="hover:text-gold-400 transition-colors duration-300">Abrir no Google Maps</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php require_once 'footer.php'; ?>
