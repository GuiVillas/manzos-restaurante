<?php
    require_once __DIR__ . '/../config/database.php';

    /**
     * Modelo para gerenciar as operações relacionadas aos pagamentos.
     *
     * Contém métodos estáticos para listar, pesquisar, buscar por ID,
     * registrar, atualizar e deletar pagamentos no banco de dados.
     */
    class Pagamento {

        /**
         * Retorna a lista de todos os pagamentos com dados do pedido e mesa associados.
         *
         * @return array Lista de pagamentos.
         */
        public static function listar() {
            $db = Database::getConnection();
            $sql = "SELECT p.*, pd.mesa_id, m.numero AS mesa_numero
                    FROM pagamento p
                    LEFT JOIN pedido pd ON p.pedido_id = pd.id
                    LEFT JOIN mesa m ON pd.mesa_id = m.id
                    ORDER BY p.criado_em DESC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna pagamentos filtrados por status.
         *
         * @param string $status O status a filtrar (ex: 'Pendente', 'Pago', 'Cancelado').
         * @return array Lista de pagamentos com o status informado.
         */
        public static function filtrarPorStatus($status) {
            $db = Database::getConnection();
            $sql = "SELECT p.*, pd.mesa_id, m.numero AS mesa_numero
                    FROM pagamento p
                    LEFT JOIN pedido pd ON p.pedido_id = pd.id
                    LEFT JOIN mesa m ON pd.mesa_id = m.id
                    WHERE p.status = ?
                    ORDER BY p.criado_em DESC";
            $stmt = $db->prepare($sql);
            $stmt->execute([$status]);
            return $stmt->fetchAll();
        }

        /**
         * Retorna os detalhes de um pagamento específico por ID.
         *
         * @param int $id O ID do pagamento a ser buscado.
         * @return array|false Os detalhes do pagamento ou false se não encontrado.
         */
        public static function buscarPorId($id) {
            $db = Database::getConnection();
            $sql = "SELECT p.*, pd.mesa_id, m.numero AS mesa_numero
                    FROM pagamento p
                    LEFT JOIN pedido pd ON p.pedido_id = pd.id
                    LEFT JOIN mesa m ON pd.mesa_id = m.id
                    WHERE p.id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        /**
         * Busca pagamento associado a um pedido específico.
         *
         * @param int $pedidoId O ID do pedido.
         * @return array|false O pagamento do pedido ou false se não existir.
         */
        public static function buscarPorPedido($pedidoId) {
            $db = Database::getConnection();
            $sql = "SELECT * FROM pagamento WHERE pedido_id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$pedidoId]);
            return $stmt->fetch();
        }

        /**
         * Registra um novo pagamento.
         *
         * @param int    $pedidoId       O ID do pedido relacionado.
         * @param string $formaPagamento A forma de pagamento (PIX, Crédito, etc.).
         * @param float  $valor          O valor do pagamento.
         * @param string $status         O status inicial do pagamento.
         * @param string $observacoes    Observações opcionais.
         * @return bool True se o registro foi bem-sucedido.
         */
        public static function registrar($pedidoId, $formaPagamento, $valor, $status, $observacoes) {
            $db = Database::getConnection();
            $pagoEm = ($status === 'Pago') ? date('Y-m-d H:i:s') : null;
            $sql = "INSERT INTO pagamento (pedido_id, forma_pagamento, valor, status, observacoes, pago_em)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$pedidoId, $formaPagamento, $valor, $status, $observacoes, $pagoEm]);
        }

        /**
         * Atualiza os dados de um pagamento existente.
         *
         * @param int    $id             O ID do pagamento.
         * @param string $formaPagamento A nova forma de pagamento.
         * @param float  $valor          O novo valor.
         * @param string $status         O novo status.
         * @param string $observacoes    As novas observações.
         * @return bool True se a atualização foi bem-sucedida.
         */
        public static function atualizar($id, $formaPagamento, $valor, $status, $observacoes) {
            $db = Database::getConnection();
            $pagoEm = ($status === 'Pago') ? date('Y-m-d H:i:s') : null;
            $sql = "UPDATE pagamento
                    SET forma_pagamento = ?, valor = ?, status = ?, observacoes = ?, pago_em = ?
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$formaPagamento, $valor, $status, $observacoes, $pagoEm, $id]);
        }

        /**
         * Deleta um pagamento pelo ID.
         *
         * @param int $id O ID do pagamento a ser deletado.
         * @return bool True se a exclusão foi bem-sucedida.
         */
        public static function deletar($id) {
            $db = Database::getConnection();
            $sql = "DELETE FROM pagamento WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$id]);
        }

        /**
         * Retorna resumo financeiro: total arrecadado, pendente e cancelado.
         *
         * @return array Resumo com totais por status.
         */
        public static function resumoFinanceiro() {
            $db = Database::getConnection();
            $sql = "SELECT
                        SUM(CASE WHEN status = 'Pago' THEN valor ELSE 0 END) AS total_pago,
                        SUM(CASE WHEN status = 'Pendente' THEN valor ELSE 0 END) AS total_pendente,
                        SUM(CASE WHEN status = 'Cancelado' THEN valor ELSE 0 END) AS total_cancelado,
                        COUNT(*) AS total_registros
                    FROM pagamento";
            $stmt = $db->query($sql);
            return $stmt->fetch();
        }
    }
?>
