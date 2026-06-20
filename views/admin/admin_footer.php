        </main>

        <!-- Admin Footer -->
        <footer class="border-t border-neutral-900 px-6 py-4 flex items-center justify-between text-[11px] text-zinc-600">
            <p>&copy; <?= date('Y') ?> MANZO'S — Painel Administrativo</p>
            <p>v1.0</p>
        </footer>
    </div>

    <!-- Toast Container (for AJAX notifications) -->
    <div id="toastContainer" class="fixed top-20 right-6 z-50 space-y-3 pointer-events-none"></div>

    <!-- Sidebar toggle script -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        /**
         * Exibe uma notificação toast no canto superior direito.
         * @param {string} mensagem - Texto a exibir
         * @param {string} tipo - 'sucesso', 'erro' ou 'info'
         */
        function mostrarToast(mensagem, tipo = 'sucesso') {
            const container = document.getElementById('toastContainer');
            const cores = {
                sucesso: 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400',
                erro: 'bg-red-500/10 border-red-500/30 text-red-400',
                info: 'bg-blue-500/10 border-blue-500/30 text-blue-400',
            };
            const toast = document.createElement('div');
            toast.className = `toast pointer-events-auto border rounded-sm px-4 py-3 text-xs font-medium shadow-lg ${cores[tipo] || cores.info}`;
            toast.textContent = mensagem;
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s';
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }
    </script>
</body>
</html>
