<?php
    require_once __DIR__ . '/../models/Pagamento.php';

    /**
     * Controlador para gerenciar as operações relacionadas aos pagamentos.
     *
     * Recebe requisições HTTP, executa as operações no modelo Pagamento
     * e retorna respostas em formato JSON.
     */

    // Define o cabeçalho para resposta JSON
    header('Content-Type: application/json');

    // Obtém a ação a ser executada a partir dos parâmetros GET ou POST
    $acao = isset($_POST['acao']) ? $_POST['acao'] : (isset($_GET['acao']) ? $_GET['acao'] : '');

    /**
     * Switch para determinar qual operação executar com base na ação recebida.
     *  - 'listar':           Retorna a lista de todos os pagamentos.
     *  - 'filtrar':          Retorna pagamentos filtrados por status.
     *  - 'buscar':           Retorna os detalhes de um pagamento por ID.
     *  - 'buscarPorPedido':  Retorna o pagamento associado a um pedido.
     *  - 'registrar':        Registra um novo pagamento.
     *  - 'atualizar':        Atualiza os dados de um pagamento existente.
     *  - 'deletar':          Deleta um pagamento.
     *  - 'resumo':           Retorna o resumo financeiro consolidado.
     */
    switch ($acao) {
        case 'listar':
            echo json_encode(Pagamento::listar());
            break;

        case 'filtrar':
            $status = isset($_GET['status']) ? $_GET['status'] : (isset($_POST['status']) ? $_POST['status'] : '');
            echo json_encode(!empty($status) ? Pagamento::filtrarPorStatus($status) : Pagamento::listar());
            break;

        case 'buscar':
            $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
            echo json_encode(Pagamento::buscarPorId($id));
            break;

        case 'buscarPorPedido':
            $pedidoId = isset($_GET['pedido_id']) ? $_GET['pedido_id'] : (isset($_POST['pedido_id']) ? $_POST['pedido_id'] : 0);
            echo json_encode(Pagamento::buscarPorPedido($pedidoId));
            break;

        case 'registrar':
            $pedidoId       = isset($_POST['pedido_id'])       ? $_POST['pedido_id']       : 0;
            $formaPagamento = isset($_POST['forma_pagamento']) ? $_POST['forma_pagamento'] : '';
            $valor          = isset($_POST['valor'])           ? (float) $_POST['valor']   : 0.0;
            $status         = isset($_POST['status'])          ? $_POST['status']          : 'Pendente';
            $observacoes    = isset($_POST['observacoes'])     ? $_POST['observacoes']     : '';

            try {
                $sucesso = Pagamento::registrar($pedidoId, $formaPagamento, $valor, $status, $observacoes);
                $msg = $sucesso ? 'Pagamento registrado com sucesso!' : 'Erro ao registrar pagamento.';
            } catch (Exception $e) {
                $sucesso = false;
                $msg = 'Erro ao registrar pagamento: ' . $e->getMessage();
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'atualizar':
            $id             = isset($_POST['id'])              ? $_POST['id']              : null;
            $formaPagamento = isset($_POST['forma_pagamento']) ? $_POST['forma_pagamento'] : '';
            $valor          = isset($_POST['valor'])           ? (float) $_POST['valor']   : 0.0;
            $status         = isset($_POST['status'])          ? $_POST['status']          : 'Pendente';
            $observacoes    = isset($_POST['observacoes'])     ? $_POST['observacoes']     : '';

            try {
                $sucesso = Pagamento::atualizar($id, $formaPagamento, $valor, $status, $observacoes);
                $msg = $sucesso ? 'Pagamento atualizado com sucesso!' : 'Erro ao atualizar pagamento.';
            } catch (Exception $e) {
                $sucesso = false;
                $msg = 'Erro ao atualizar pagamento: ' . $e->getMessage();
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'deletar':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $sucesso = Pagamento::deletar($id);

            if ($sucesso) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Pagamento excluído com sucesso!']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao excluir pagamento.']);
            }
            break;

        case 'resumo':
            echo json_encode(Pagamento::resumoFinanceiro());
            break;

        default:
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
            break;
    }
?>
