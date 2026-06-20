<?php
    require_once __DIR__ . '/../config/database.php';

    /**
     * Modelo para gerenciar as operações relacionadas aos usuários do sistema.
     *
     * Contém métodos estáticos para listar, pesquisar, buscar por ID,
     * cadastrar, atualizar e deletar usuários no banco de dados.
     * Os cargos possíveis são: Gerente, Chef, Garçom e outros definidos pelo administrador.
     */
    class Usuario {

        /**
         * Retorna a lista de todos os usuários, ordenados por nome.
         *
         * @return array Lista de usuários.
         */
        public static function listar() {
            $db = Database::getConnection();
            $sql = "SELECT id, nome, email, cargo, criado_em FROM usuario
                    ORDER BY nome ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna a lista de usuários que correspondem ao termo de pesquisa.
         *
         * Realiza uma consulta SQL utilizando LIKE para buscar por nome, email ou cargo.
         *
         * @param string $termo O termo de pesquisa para filtrar os usuários.
         * @return array Lista de usuários que correspondem ao termo.
         */
        public static function pesquisar($termo) {
            $db = Database::getConnection();
            $sql = "SELECT id, nome, email, cargo, criado_em FROM usuario
                    WHERE nome LIKE ? OR
                          email LIKE ? OR
                          cargo LIKE ?
                    ORDER BY nome ASC";
            $stmt = $db->prepare($sql);
            $termoLike = "%" . $termo . "%";
            $stmt->execute([$termoLike, $termoLike, $termoLike]);
            return $stmt->fetchAll();
        }

        /**
         * Retorna os detalhes de um usuário específico por ID (sem a senha).
         *
         * @param int $id O ID do usuário a ser buscado.
         * @return array|false Os detalhes do usuário ou false se não encontrado.
         */
        public static function buscarPorId($id) {
            $db = Database::getConnection();
            $sql = "SELECT id, nome, email, cargo, criado_em FROM usuario
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        /**
         * Retorna os cargos distintos cadastrados no sistema.
         *
         * @return array Lista de cargos únicos.
         */
        public static function listarCargos() {
            $db = Database::getConnection();
            $sql = "SELECT DISTINCT cargo FROM usuario ORDER BY cargo ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        /**
         * Cadastra um novo usuário com os dados fornecidos.
         *
         * @param string $nome  O nome do usuário.
         * @param string $email O e-mail do usuário.
         * @param string $senha A senha do usuário.
         * @param string $cargo O cargo do usuário.
         * @return bool True se o cadastro foi bem-sucedido.
         */
        public static function cadastrar($nome, $email, $senha, $cargo) {
            $db = Database::getConnection();
            $sql = "INSERT INTO usuario (nome, email, senha, cargo)
                    VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $email, $senha, $cargo]);
        }

        /**
         * Atualiza os dados de um usuário existente (sem alterar a senha).
         *
         * @param int    $id    O ID do usuário a ser atualizado.
         * @param string $nome  O novo nome do usuário.
         * @param string $email O novo e-mail do usuário.
         * @param string $cargo O novo cargo do usuário.
         * @return bool True se a atualização foi bem-sucedida.
         */
        public static function atualizar($id, $nome, $email, $cargo) {
            $db = Database::getConnection();
            $sql = "UPDATE usuario
                    SET nome = ?, email = ?, cargo = ?
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$nome, $email, $cargo, $id]);
        }

        /**
         * Atualiza a senha de um usuário existente.
         *
         * @param int    $id    O ID do usuário.
         * @param string $senha A nova senha.
         * @return bool True se a atualização foi bem-sucedida.
         */
        public static function atualizarSenha($id, $senha) {
            $db = Database::getConnection();
            $sql = "UPDATE usuario SET senha = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$senha, $id]);
        }

        /**
         * Deleta um usuário, se possível (verifica dependências).
         *
         * Se o usuário tiver pedidos associados, a exclusão falhará
         * devido às restrições de chave estrangeira.
         *
         * @param int $id O ID do usuário a ser deletado.
         * @return bool True se a exclusão foi bem-sucedida, false se falhou.
         */
        public static function deletar($id) {
            $db = Database::getConnection();
            try {
                $sql = "DELETE FROM usuario WHERE id = ?";
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
