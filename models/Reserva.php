<?php
    require_once __DIR__ . '/../config/database.php';

    /**
     * Modelo para gerenciar as operações relacionadas às reservas.
     * 
     * Contém métodos estáticos para listar, pesquisar, buscar por ID,
     * cadastrar, atualizar e deletar reservas no banco de dados.
     */
    class Reserva {

        /**
         * Retorna a lista de todas as reservas, ordenadas por data e hora.
         * 
         * Utiliza uma consulta SQL com JOIN para obter os dados da tabela reserva,
         * juntamente com o nome do cliente e o número da mesa.
         * 
         * @return array Lista de reservas com detalhes do cliente e mesa.
         */
        public static function listar() {
            $db = Database::getConnection();
            $sql = "SELECT r.id, r.data_reserva, r.hora_reserva, r.num_pessoas, r.status, 
                        c.nome AS cliente_nome, m.numero AS mesa_numero 
                    FROM reserva r
                    INNER JOIN cliente c ON r.cliente_id = c.id
                    INNER JOIN mesa m ON r.mesa_id = m.id
                    ORDER BY r.data_reserva ASC, r.hora_reserva ASC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        }

        /**
         * Retorna a lista de reservas que correspondem ao termo de pesquisa.
         * 
         * Realiza uma consulta SQL com JOIN para buscar reservas com base no nome do cliente ou status da reserva.
         * 
         * @param string $termo O termo de pesquisa para filtrar as reservas.
         * @return array Lista de reservas que correspondem ao termo.
         */
        public static function pesquisar($termo) {
            /* Pesquisar pelo nome do cliente ou pelo status */
            $db = Database::getConnection();
            $sql = "SELECT r.id, r.data_reserva, r.hora_reserva, r.num_pessoas, r.status,
                        c.nome AS cliente_nome, m.numero AS mesa_numero 
                    FROM reserva r
                    INNER JOIN cliente c ON r.cliente_id = c.id
                    INNER JOIN mesa m ON r.mesa_id = m.id
                    WHERE c.nome LIKE ? OR r.status LIKE ?
                    ORDER BY r.data_reserva ASC";
            $stmt = $db->prepare($sql);
            $termoLike = "%" . $termo . "%";
            $stmt->execute([$termoLike, $termoLike]);
            return $stmt->fetchAll();
        }
        
        public static function buscarPorId($id) {
            /* Puxa os dados pelo botão Editar */
            $db = Database::getConnection();
            $sql = "SELECT * FROM reserva 
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch();
        }

        public static function cadastrar($cliente_id, $mesa_id, $data, $hora, $pessoas, $status, $obs) {
            $db = Database::getConnection();
            $sql = "INSERT INTO reserva (cliente_id, mesa_id, data_reserva, hora_reserva, num_pessoas, status, observacoes)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$cliente_id, $mesa_id, $data, $hora, $pessoas, $status, $obs]);
        }

        public static function atualizar($id, $cliente_id, $mesa_id, $data, $hora, $pessoas, $status, $obs) {
            $db = Database::getConnection();
            $sql = "UPDATE reserva
                    SET cliente_id = ?, mesa_id = ?, data_reserva =?, hora_reserva = ?, num_pessoas = ?, status = ?, observacoes = ?
                    WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$cliente_id, $mesa_id, $data, $hora, $pessoas, $status, $obs, $id]);
        }

        public static function deletar($id) {
            $db = Database::getConnection();
            $sql = "DELETE FROM reserva WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute([$id]);
        }

        /**
         * Marca uma reserva como "Concluída" quando o cliente chega.
         * Atualiza o status da mesa para "Ocupada".
         * Retorna os dados necessários para abrir a comanda automaticamente.
         *
         * @param int $id O ID da reserva.
         * @return array|false Dados da reserva (cliente_id, mesa_id) ou false se falhar.
         */
        public static function receberCliente($id) {
            $db = Database::getConnection();

            // Busca dados da reserva antes de atualizar
            $stmtBusca = $db->prepare("SELECT cliente_id, mesa_id FROM reserva WHERE id = ?");
            $stmtBusca->execute([$id]);
            $reserva = $stmtBusca->fetch();

            if (!$reserva) return false;

            // Marca reserva como Concluída
            $stmtUpd = $db->prepare("UPDATE reserva SET status = 'Concluída' WHERE id = ?");
            $ok = $stmtUpd->execute([$id]);

            if ($ok) {
                // Mesa permanece "Reservada" até a comanda ser aberta pelo garçom
                return [
                    'cliente_id' => $reserva['cliente_id'],
                    'mesa_id'    => $reserva['mesa_id'],
                ];
            }
            return false;
        }
    }
?>