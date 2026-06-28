<?php
    require_once __DIR__ . '/../config/database.php';

    /**
     * Modelo para gerenciar as operações relacionadas aos pratos.
     *
     * O campo desconto_multiplicador define o fator aplicado sobre o preço original:
     *   - 1.00 = sem desconto (padrão)
     *   - 0.80 = 20% de desconto
     *   - 0.50 = 50% de desconto
     *
     * O preço efetivo sempre é calculado como: preco * desconto_multiplicador.
     * O preço original nunca é alterado, garantindo reversibilidade total.
     */
    class Prato {

        /**
         * Retorna todos os pratos com categoria e preço efetivo calculado.
         *
         * @return array Lista de pratos.
         */
        public static function listar() {
            $db = Database::getConnection();
            $sql = "SELECT p.id, p.nome, p.preco, p.desconto_multiplicador,
                           ROUND(p.preco * p.desconto_multiplicador, 2) AS preco_efetivo,
                           p.ativo, p.descricao, c.nome AS categoria
                    FROM prato p
                    LEFT JOIN categoria_prato c ON p.categoria_prato_id = c.id
                    ORDER BY p.id ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna todas as categorias de pratos cadastradas.
         *
         * @return array Lista de categorias com id e nome.
         */
        public static function listarCategorias() {
            $db = Database::getConnection();
            $sql = "SELECT id, nome FROM categoria_prato ORDER BY nome ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna os pratos ativos ordenados pelos menos vendidos (incluindo zero vendas).
         * Usado no relatório de desempenho para identificar itens candidatos a desconto.
         *
         * @return array Lista de pratos com total vendido, preço original e preço efetivo.
         */
        public static function menosVendidos() {
            $db = Database::getConnection();
            $sql = "SELECT pr.id, pr.nome, pr.preco, pr.desconto_multiplicador,
                           ROUND(pr.preco * pr.desconto_multiplicador, 2) AS preco_efetivo,
                           COALESCE(SUM(pp.quantidade), 0) AS total_vendido
                    FROM prato pr
                    LEFT JOIN prato_pedido pp ON pr.id = pp.prato_id
                    LEFT JOIN pedido p ON pp.pedido_id = p.id AND p.status = 'Fechada'
                    WHERE pr.ativo = 1
                    GROUP BY pr.id, pr.nome, pr.preco, pr.desconto_multiplicador
                    ORDER BY total_vendido ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna os dados de um prato específico por ID (para preencher o formulário de edição).
         *
         * @param int $id ID do prato.
         * @return array|false Dados do prato ou false se não encontrado.
         */
        public static function buscarPorId($id) {
            $db = Database::getConnection();
            $sql = "SELECT p.id, p.nome, p.preco, p.desconto_multiplicador,
                           p.ativo, p.descricao, p.categoria_prato_id,
                           c.nome AS categoria
                    FROM prato p
                    LEFT JOIN categoria_prato c ON p.categoria_prato_id = c.id
                    WHERE p.id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        /**
         * Cadastra um novo prato. O multiplicador começa em 1.00 (sem desconto).
         *
         * @param string $nome        Nome do prato.
         * @param float  $preco       Preço original do prato.
         * @param int    $categoria_id ID da categoria.
         * @param string $descricao   Descrição do prato.
         * @param bool   $ativo       Status de ativação.
         * @return bool True se cadastrado com sucesso.
         */
        public static function cadastrar($nome, $preco, $categoria_id, $descricao, $ativo) {
            $db = Database::getConnection();
            $sql = "INSERT INTO prato (nome, preco, desconto_multiplicador, categoria_prato_id, descricao, ativo)
                    VALUES (?, ?, 1.00, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $preco, $categoria_id, $descricao, $ativo]);
        }

        /**
         * Atualiza os dados de um prato existente (sem alterar o desconto_multiplicador).
         *
         * @param int    $id          ID do prato.
         * @param string $nome        Novo nome.
         * @param float  $preco       Novo preço original.
         * @param int    $categoria_id Nova categoria.
         * @param string $descricao   Nova descrição.
         * @param bool   $ativo       Novo status.
         * @return bool True se atualizado com sucesso.
         */
        public static function atualizar($id, $nome, $preco, $categoria_id, $descricao, $ativo) {
            $db = Database::getConnection();
            $sql = "UPDATE prato
                    SET nome = ?, preco = ?, categoria_prato_id = ?, descricao = ?, ativo = ?
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $preco, $categoria_id, $descricao, $ativo, $id]);
        }

        /**
         * Aplica um desconto ao prato via multiplicador.
         * Ex: 0.80 aplica 20% de desconto. O preço original permanece intacto.
         *
         * @param int   $id             ID do prato.
         * @param float $multiplicador  Fator de desconto (entre 0.01 e 1.00).
         * @return bool True se aplicado com sucesso.
         */
        public static function aplicarDesconto($id, $multiplicador) {
            $db = Database::getConnection();
            $multiplicador = max(0.01, min(1.00, (float) $multiplicador));
            $sql = "UPDATE prato SET desconto_multiplicador = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$multiplicador, $id]);
        }

        /**
         * Remove o desconto do prato, restaurando o multiplicador para 1.00.
         *
         * @param int $id ID do prato.
         * @return bool True se removido com sucesso.
         */
        public static function removerDesconto($id) {
            $db = Database::getConnection();
            $sql = "UPDATE prato SET desconto_multiplicador = 1.00 WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$id]);
        }

        /**
         * Deleta um prato, se não houver dependências.
         *
         * @param int $id ID do prato.
         * @return bool True se deletado com sucesso.
         */
        public static function deletar($id) {
            $db = Database::getConnection();
            try {
                $sql = "DELETE FROM prato WHERE id = ?";
                $stmt = $db->prepare($sql);
                return $stmt->execute([$id]);
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') return false;
                throw $e;
            }
        }
    }
?>
