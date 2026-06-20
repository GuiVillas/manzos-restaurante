    <!-- Footer -->
    <footer class="bg-black border-t border-neutral-900 py-16 mt-auto">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Branding -->
                <div class="space-y-4 md:col-span-2">
                    <span class="font-serif tracking-[0.25em] text-xl font-bold text-amber-100 block">MANZO'S</span>
                    <p class="text-zinc-500 text-sm max-w-sm">
                        Uma experiência culinária inesquecível focada na excelência dos cortes de carnes nobres e na alta gastronomia artesanal.
                    </p>
                </div>
                <!-- Links rápidos -->
                <div>
                    <h4 class="text-gold-400 font-semibold tracking-wider text-xs uppercase mb-4">Navegação</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="index.php" class="text-zinc-400 hover:text-amber-100 transition-colors duration-300">Home</a></li>
                        <li><a href="menu.php" class="text-zinc-400 hover:text-amber-100 transition-colors duration-300">Menu</a></li>
                        <li><a href="sobre.php" class="text-zinc-400 hover:text-amber-100 transition-colors duration-300">Sobre Nós</a></li>
                        <li><a href="contato.php" class="text-zinc-400 hover:text-amber-100 transition-colors duration-300">Contato</a></li>
                    </ul>
                </div>
                <!-- Redes sociais e Reservas -->
                <div>
                    <h4 class="text-gold-400 font-semibold tracking-wider text-xs uppercase mb-4">Experiência</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="reserva.php" class="text-zinc-400 hover:text-amber-100 transition-colors duration-300">Reservar Mesa</a></li>
                        <li><a href="#" class="text-zinc-400 hover:text-amber-100 transition-colors duration-300">Instagram</a></li>
                        <li><a href="#" class="text-zinc-400 hover:text-amber-100 transition-colors duration-300">Facebook</a></li>
                        <li><a href="views/admin/login.php" class="text-zinc-600 hover:text-zinc-400 transition-colors duration-300 text-xs">Acesso Restrito</a></li>
                    </ul>
                </div>
            </div>

            <hr class="border-neutral-900 my-8">

            <div class="flex flex-col md:flex-row items-center justify-between text-xs text-zinc-600 space-y-4 md:space-y-0">
                <p>&copy; <?= date('Y') ?> MANZO'S. Todos os direitos reservados.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-zinc-400 transition-colors duration-300">Privacidade</a>
                    <a href="#" class="hover:text-zinc-400 transition-colors duration-300">Termos de Uso</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
