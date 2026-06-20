<?php
    require_once __DIR__ . '/../config/database.php';

    /**
     * Modelo para gerenciar as operações relacionadas aos fornecedores.
     *
     * Contém métodos estáticos para listar, pesquisar, buscar por ID,
     * cadastrar, atualizar e deletar fornecedores no banco de dados.
     */
    class Fornecedor {

        /**
         * Retorna a lista de todos os fornecedores, ordenados por nome.
         *
         * @return array Lista de fornecedores.
         */
        public static function listar() {
            $db = Database::getConnection();
            $sql = "SELECT * FROM fornecedor
                    ORDER BY nome ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna a lista de fornecedores que correspondem ao termo de pesquisa.
         *
         * Realiza uma consulta SQL utilizando LIKE para buscar por nome, categoria, email ou CNPJ.
         *
         * @param string $termo O termo de pesquisa para filtrar os fornecedores.
         * @return array Lista de fornecedores que correspondem ao termo.
         */
        public static function pesquisar($termo) {
            $db = Database::getConnection();
            $sql = "SELECT * FROM fornecedor
                    WHERE nome LIKE ? OR
                          categoria LIKE ? OR
                          email LIKE ? OR
                          cnpj LIKE ?
                    ORDER BY nome ASC";
            $stmt = $db->prepare($sql);
            $termoLike = "%" . $termo . "%";
            $stmt->execute([$termoLike, $termoLike, $termoLike, $termoLike]);
            return $stmt->fetchAll();
        }

        /**
         * Retorna os detalhes de um fornecedor específico por ID.
         *
         * @param int $id O ID do fornecedor a ser buscado.
         * @return array|false Os detalhes do fornecedor ou false se não encontrado.
         */
        public static function buscarPorId($id) {
            $db = Database::getConnection();
            $sql = "SELECT * FROM fornecedor
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        /**
         * Retorna a lista de categorias distintas de fornecedores.
         *
         * @return array Lista de categorias únicas.
         */
        public static function listarCategorias() {
            $db = Database::getConnection();
            $sql = "SELECT DISTINCT categoria FROM fornecedor ORDER BY categoria ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        /**
         * Cadastra um novo fornecedor com os dados fornecidos.
         *
         * @param string $nome     O nome do fornecedor.
         * @param string $cnpj     O CNPJ do fornecedor.
         * @param string $telefone O telefone do fornecedor.
         * @param string $email    O e-mail do fornecedor.
         * @param string $categoria A categoria do fornecedor.
         * @param string $contato  O nome do contato no fornecedor.
         * @param bool   $ativo    Se o fornecedor está ativo.
         * @return bool True se o cadastro foi bem-sucedido.
         */
        public static function cadastrar($nome, $cnpj, $telefone, $email, $categoria, $contato, $ativo) {
            $db = Database::getConnection();
            $sql = "INSERT INTO fornecedor (nome, cnpj, telefone, email, categoria, contato, ativo)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $cnpj ?: null, $telefone, $email, $categoria, $contato, $ativo ? 1 : 0]);
        }

        /**
         * Atualiza os dados de um fornecedor existente.
         *
         * @param int    $id       O ID do fornecedor a ser atualizado.
         * @param string $nome     O novo nome do fornecedor.
         * @param string $cnpj     O novo CNPJ do fornecedor.
         * @param string $telefone O novo telefone do fornecedor.
         * @param string $email    O novo e-mail do fornecedor.
         * @param string $categoria A nova categoria do fornecedor.
         * @param string $contato  O novo nome do contato.
         * @param bool   $ativo    O novo status do fornecedor.
         * @return bool True se a atualização foi bem-sucedida.
         */
        public static function atualizar($id, $nome, $cnpj, $telefone, $email, $categoria, $contato, $ativo) {
            $db = Database::getConnection();
            $sql = "UPDATE fornecedor
                    SET nome = ?, cnpj = ?, telefone = ?, email = ?, categoria = ?, contato = ?, ativo = ?
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $cnpj ?: null, $telefone, $email, $categoria, $contato, $ativo ? 1 : 0, $id]);
        }

        /**
         * Deleta um fornecedor pelo ID.
         *
         * @param int $id O ID do fornecedor a ser deletado.
         * @return bool True se a exclusão foi bem-sucedida, false se falhou.
         */
        public static function deletar($id) {
            $db = Database::getConnection();
            try {
                $sql = "DELETE FROM fornecedor
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
