<?php
require_once __DIR__ . '/../config/database.php';

/**
 * Modelo responsável pela geração de relatórios de faturamento e desempenho.
 */
class Relatorio {

    /**
     * Retorna o faturamento diário consolidado das comandas fechadas.
     * 
     * @return array Lista de datas com quantidade de pedidos e faturamento.
     */
    public static function faturamentoPorPeriodo() {
        $db = Database::getConnection();
        $sql = "SELECT DATE(p.data_pedido) AS data, 
                       COUNT(DISTINCT p.id) AS total_pedidos, 
                       SUM(pp.quantidade * pp.preco_unitario) AS faturamento
                FROM pedido p
                INNER JOIN prato_pedido pp ON p.id = pp.pedido_id
                WHERE p.status = 'Fechada'
                GROUP BY DATE(p.data_pedido)
                ORDER BY data DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Retorna o ranking de pratos mais vendidos e receita gerada por cada um.
     * 
     * @return array Ranking de pratos por quantidade vendida.
     */
    public static function pratosMaisVendidos() {
        $db = Database::getConnection();
        $sql = "SELECT pr.nome AS prato_nome, 
                       SUM(pp.quantidade) AS total_vendido, 
                       SUM(pp.quantidade * pp.preco_unitario) AS receita_gerada
                FROM prato_pedido pp
                INNER JOIN prato pr ON pp.prato_id = pr.id
                INNER JOIN pedido p ON pp.pedido_id = p.id
                WHERE p.status = 'Fechada'
                GROUP BY pr.id, pr.nome
                ORDER BY total_vendido DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Retorna o faturamento gerado por cada garçom com base nos pedidos atendidos e fechados.
     * 
     * @return array Desempenho de vendas por garçom.
     */
    public static function faturamentoPorGarcom() {
        $db = Database::getConnection();
        $sql = "SELECT u.nome AS garcom_nome, 
                       COUNT(DISTINCT p.id) AS total_pedidos, 
                       SUM(pp.quantidade * pp.preco_unitario) AS faturamento
                FROM pedido p
                INNER JOIN usuario u ON p.usuario_id = u.id
                INNER JOIN prato_pedido pp ON p.id = pp.pedido_id
                WHERE p.status = 'Fechada'
                GROUP BY u.id, u.nome
                ORDER BY faturamento DESC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll();
    }
}
?>
