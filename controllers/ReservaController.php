<?php
    require_once __DIR__ . '/../models/Reserva.php';

    /**
     * Controlador para gerenciar as operações relacionadas às reservas.
     * 
     * Recebe requisições HTTP, executa as operações no modelo Reserva
     * e retorna respostas em formato JSON.
     */

    // Define o cabeçalho para resposta JSON
    header('Content-Type: application/json');

    // Obtém a ação a ser executada a partir dos parâmetros GET ou POST
    $acao = isset($_POST['acao']) ? $_POST['acao'] : (isset($_GET['acao']) ? $_GET['acao'] : '');

    /**
     * Switch para determinar qual operação executar com base na ação recebida.
     *  - 'listar': Retorna a lista de todos as reservas.
     *  - 'pesquisar': Retorna reservas que correspondem ao termo de pesquisa.
     *  - 'buscar': Retorna os detalhes de uma reserva específica por ID.
     *  - 'cadastrar': Cadastra uma nova reserva com os dados fornecidos.
     *  - 'atualizar': Atualiza os dados de uma reserva existente.
     *  - 'deletar': Deleta uma reserva, se possível (verifica dependências).
     */
    switch ($acao) {
        case 'listar':
            $reservas = Reserva::listar();
            echo json_encode($reservas);
            break;

        case 'pesquisar':
            $termo = isset($_GET['termo']) ? $_GET['termo'] : '';
            if (!empty($termo)) {
                $reservas = Reserva::pesquisar($termo);
            } else {
                $reservas = Reserva::listar();
            }
            echo json_encode($reservas);
            break;
        
        case 'buscar':
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            echo json_encode(Reserva::buscarPorId($id));
            break;

        case 'cadastrar':
        case 'atualizar':
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : null;
            $mesa_id = isset($_POST['mesa_id']) ? $_POST['mesa_id'] : null;
            $data = isset($_POST['data_reserva']) ? $_POST['data_reserva'] : '';
            $hora = isset($_POST['hora_reserva']) ? $_POST['hora_reserva'] : '';
            $pessoas = isset($_POST['num_pessoas']) ? $_POST['num_pessoas'] : 1;
            $status = isset($_POST['status']) ? $_POST['status'] : 'Confirmada';
            $obs = isset($_POST['observacoes']) ? $_POST['observacoes'] : '';

            if ($acao === 'cadastrar') {
                $sucesso = Reserva::cadastrar($cliente_id, $mesa_id, $data, $hora, $pessoas, $status, $obs);
                $msg = $sucesso ? 'Reserva cadastrada!' : 'Erro ao cadastrar!';
            } else {
                $sucesso = Reserva::atualizar($id, $cliente_id, $mesa_id, $data, $hora, $pessoas, $status, $obs);
                $msg = $sucesso ? 'Reserva atualizada!' : 'Erro ao atualizar!';
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'deletar':
            $id = $_POST['id'];
            $sucesso = Reserva::deletar($id);
            echo json_encode(['sucesso' => $sucesso]);
            break;

        case 'receber':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $dados = Reserva::receberCliente($id);
            if ($dados) {
                echo json_encode(['sucesso' => true, 'cliente_id' => $dados['cliente_id'], 'mesa_id' => $dados['mesa_id']]);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao receber cliente.']);
            }
            break;

        default:
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação não reconhecida.']);
            break;
    }
?>