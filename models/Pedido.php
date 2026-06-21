<?php
    require_once __DIR__ . '/../config/database.php';
    require_once __DIR__ . '/Mesa.php';

    /**
     * Classe responsável pelo gerenciamento dos pedidos/comandas.
     *
     * Contém métodos para listar comandas ativas, listar histórico,
     * abrir e fechar comandas, adicionar itens e calcular totais.
     * Ao abrir uma comanda, a mesa é automaticamente marcada como "Ocupada".
     * Ao fechar, a mesa volta para "Disponível".
     */
    class Pedido {

        /**
         * Retorna todos os pedidos com mesa e status (para selects de formulários).
         *
         * @return array Lista de pedidos com id, status e número da mesa.
         */
        public static function listar() {
            $db = Database::getConnection();
            $sql = "SELECT p.id, p.status, m.numero AS mesa_numero
                    FROM pedido p
                    LEFT JOIN mesa m ON p.mesa_id = m.id
                    ORDER BY p.id DESC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna todas as comandas ativas com cliente, mesa e garçom.
         *
         * @return array Lista de pedidos ativos.
         */
        public static function listarAtivas() {
            $db = Database::getConnection();
            $sql = "SELECT p.id, p.data_pedido, m.numero AS mesa_numero,
                           u.nome AS garcom_nome, c.nome AS cliente_nome
                    FROM pedido p
                    INNER JOIN mesa m    ON p.mesa_id    = m.id
                    INNER JOIN usuario u ON p.usuario_id = u.id
                    LEFT  JOIN cliente c ON p.cliente_id = c.id
                    WHERE p.status = 'Ativa'
                    ORDER BY p.id ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna o histórico de comandas fechadas com cliente, mesa e garçom.
         *
         * @return array Lista de pedidos fechados.
         */
        public static function listarHistorico() {
            $db = Database::getConnection();
            $sql = "SELECT p.id, p.data_pedido, m.numero AS mesa_numero,
                           u.nome AS garcom_nome, c.nome AS cliente_nome
                    FROM pedido p
                    INNER JOIN mesa m    ON p.mesa_id    = m.id
                    INNER JOIN usuario u ON p.usuario_id = u.id
                    LEFT  JOIN cliente c ON p.cliente_id = c.id
                    WHERE p.status = 'Fechada'
                    ORDER BY p.id DESC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Abre uma nova comanda para a mesa e marca a mesa como "Ocupada".
         *
         * @param int      $mesa_id    ID da mesa.
         * @param int      $usuario_id ID do garçom responsável.
         * @param int|null $cliente_id ID do cliente (opcional — walk-ins podem não ter cadastro).
         * @return int|false ID do pedido criado ou false em caso de erro.
         */
        public static function abrirComanda($mesa_id, $usuario_id, $cliente_id = null) {
            $db = Database::getConnection();

            try {
                $sql  = "INSERT INTO pedido (mesa_id, usuario_id, cliente_id) VALUES (?, ?, ?)";
                $stmt = $db->prepare($sql);
                $ok   = $stmt->execute([$mesa_id, $usuario_id, $cliente_id ?: null]);
            } catch (PDOException $e) {
                // Coluna cliente_id ainda não existe no banco (ALTER TABLE pendente)
                // Faz o INSERT sem ela para não bloquear a operação
                $sql  = "INSERT INTO pedido (mesa_id, usuario_id) VALUES (?, ?)";
                $stmt = $db->prepare($sql);
                $ok   = $stmt->execute([$mesa_id, $usuario_id]);
            }

            if ($ok) {
                Mesa::atualizarStatus($mesa_id, 'Ocupada');
                return $db->lastInsertId();
            }
            return false;
        }

        /**
         * Fecha uma comanda e libera a mesa automaticamente (status → "Disponível").
         *
         * @param int $pedido_id ID do pedido a ser fechado.
         * @return array Retorna ['sucesso', 'total', 'mesa_id'] para uso no controller.
         */
        public static function fecharComanda($pedido_id) {
            $db = Database::getConnection();

            // Busca mesa_id antes de fechar para liberar depois
            $stmtMesa = $db->prepare("SELECT mesa_id FROM pedido WHERE id = ?");
            $stmtMesa->execute([$pedido_id]);
            $pedido = $stmtMesa->fetch();

            $sql = "UPDATE pedido SET status = 'Fechada' WHERE id = ?";
            $stmt = $db->prepare($sql);
            $ok = $stmt->execute([$pedido_id]);

            if ($ok && $pedido) {
                Mesa::atualizarStatus($pedido['mesa_id'], 'Disponível');
            }

            return $ok;
        }

        /**
         * Retorna o valor total de um pedido (soma de todos os itens).
         * Usado para auto-preencher o campo valor no registro de pagamento.
         *
         * @param int $pedido_id ID do pedido.
         * @return float Total do pedido.
         */
        public static function buscarTotal($pedido_id) {
            $db = Database::getConnection();
            $sql = "SELECT COALESCE(SUM(quantidade * preco_unitario), 0) AS total
                    FROM prato_pedido
                    WHERE pedido_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$pedido_id]);
            $row = $stmt->fetch();
            return (float) $row['total'];
        }

        /**
         * Adiciona um item à comanda.
         *
         * O preço do prato é armazenado no momento da venda para
         * preservar o histórico caso o valor do prato seja alterado futuramente.
         *
         * @param int $pedido_id  ID do pedido.
         * @param int $prato_id   ID do prato.
         * @param int $quantidade Quantidade solicitada.
         * @return bool True em caso de sucesso, False caso contrário.
         */
        public static function adicionarItem($pedido_id, $prato_id, $quantidade) {
            $db = Database::getConnection();

            $stmtPrato = $db->prepare('SELECT preco FROM prato WHERE id = ? LIMIT 1');
            $stmtPrato->execute([$prato_id]);
            $prato = $stmtPrato->fetch();

            if (!$prato) {
                return false;
            }

            $sql = 'INSERT INTO prato_pedido (pedido_id, prato_id, quantidade, preco_unitario)
                    VALUES (?, ?, ?, ?)';
            $stmt = $db->prepare($sql);
            return $stmt->execute([$pedido_id, $prato_id, $quantidade, $prato['preco']]);
        }

        /**
         * Lista todos os itens da comanda com nome do prato, quantidade e subtotal.
         *
         * @param int $pedido_id ID do pedido.
         * @return array Lista de itens da comanda.
         */
        public static function listarItensComanda($pedido_id) {
            $db = Database::getConnection();
            $sql = 'SELECT pp.id, pr.nome AS prato_nome, pp.quantidade,
                           pp.preco_unitario, (pp.quantidade * pp.preco_unitario) AS subtotal
                    FROM prato_pedido pp
                    INNER JOIN prato pr ON pp.prato_id = pr.id
                    WHERE pp.pedido_id = ?';
            $stmt = $db->prepare($sql);
            $stmt->execute([$pedido_id]);
            return $stmt->fetchAll();
        }
    }
?>
