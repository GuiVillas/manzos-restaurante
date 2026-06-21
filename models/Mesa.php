<?php
    require_once __DIR__ . "/../config/database.php";

    /**
     * Modelo para gerenciar as operações relacionadas às mesas.
     * 
     * Contém métodos estáticos para listar, pesquisar, buscar por ID, 
     * cadastrar, atualizar e deletar mesas no banco de dados.
     */
    class Mesa {

        /**
         * Retorna a lista de todas as mesas, ordenadas pelo número.
         * 
         * Utiliza uma consulta SQL simples para obter os dados da tabela mesa.
         * 
         * @return array Lista de mesas.
         */
        public static function listar() {
            $db = Database::getConnection();
            $sql = "SELECT * FROM mesa
                    ORDER BY numero ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna a lista de mesas que correspondem ao termo de pesquisa.
         * 
         * Realiza uma consulta SQL utilizando LIKE para buscar por número ou status.
         * 
         * @param string $termo O termo de pesquisa para filtrar as mesas.
         * @return array Lista de mesas que correspondem ao termo.
         */
        public static function pesquisar($termo) {
            $db = Database::getConnection();
            $sql = "SELECT * FROM mesa
                    WHERE numero = ? OR status = ?
                    ORDER BY numero ASC";
            $stmt = $db->prepare($sql);
            $termoLike = "%" . $termo . "%";
            $stmt->execute([$termoLike, $termoLike]);
            return $stmt->fetchAll();
        }

        /**
         * Retorna os detalhes de uma mesa específica por ID.
         * 
         * Realiza uma consulta SQL para buscar uma mesa com base no ID fornecido.
         * 
         * @param int $id O ID da mesa a ser buscada.
         * @return array|false Os detalhes da mesa ou false se não encontrada.
         */
        public static function buscarPorId($id) {
            $db = Database::getConnection();
            $sql = "SELECT * FROM mesa
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        /**
         * Cadastra uma nova mesa com os dados fornecidos.
         * 
         * Realiza uma inserção SQL para adicionar uma nova mesa à tabela mesa.
         * 
         * @param int $numero O número da mesa.
         * @param int $capacidade A capacidade de pessoas da mesa.
         * @param string $status O status da mesa (disponível, ocupada, etc).
         * @return bool True se o cadastro foi bem-sucedido, false caso contrário.
         */
        public static function cadastrar($numero, $capacidade, $status) {
            $db = Database::getConnection();
            $sql = "INSERT INTO mesa (numero, capacidade, status)
                    VALUES (?, ?, ?)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$numero, $capacidade, $status]);
        }

        /**
         * Atualiza apenas o status de uma mesa (usado internamente ao abrir/fechar comandas e receber reservas).
         *
         * @param int    $id     O ID da mesa.
         * @param string $status O novo status ('Disponível', 'Ocupada', 'Reservada').
         * @return bool True se a atualização foi bem-sucedida.
         */
        public static function atualizarStatus($id, $status) {
            $db = Database::getConnection();
            $sql = "UPDATE mesa SET status = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$status, $id]);
        }

        /**
         * Atualiza os dados de uma mesa existente.
         * 
         * Realiza uma atualização SQL para modificar os dados de uma mesa com base no ID fornecido.
         * 
         * @param int $id O ID da mesa a ser atualizada.
         * @param int $numero O novo número da mesa.
         * @param int $capacidade A nova capacidade de pessoas da mesa.
         * @param string $status O novo status da mesa.
         * @return bool True se a atualização foi bem-sucedida, false caso contrário.
         */
        public static function atualizar($id, $numero, $capacidade, $status) {
            $db = Database::getConnection();
            $sql = "UPDATE mesa 
                    SET numero = ?, capacidade = ?, status = ?
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$numero, $capacidade, $status, $id]);
        }

        /**
         * Deleta uma mesa, se possível (verifica dependências).
         * 
         * Realiza uma exclusão SQL para remover uma mesa da tabela mesa.
         * 
         * Se a mesa tiver reservas ou pedidos associados, 
         * a exclusão falhará devido às restrições de chave estrangeira.
         * 
         * @param int $id O ID da mesa a ser deletada.
         * @return bool True se a exclusão foi bem-sucedida, false caso contrário.
         */
        public static function deletar($id) {
            $db = Database::getConnection();
            try {
                $sql = "DELETE FROM mesa
                        WHERE id = ?";
                $stmt = $db->prepare($sql);
                return $stmt->execute([$id]);
            } catch (PDOException $e) {
                if ($e->getCode() == '23000') {
                    return false;
                }
                throw $e;
            }
        }
    }
?>