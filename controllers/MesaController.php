<?php
    require_once __DIR__ . "/../models/Mesa.php";

    /**
     * Controlador para gerenciar as operações relacionadas às mesas.
     * 
     * Recebe requisições HTTP, executa as operações no modelo Mesa
     * e retorna respostas em formato JSON.
     */

    // Define o cabeçalho para resposta JSON
    header('Content-Type: application/json');

    // Obtém a ação a ser executada a partir dos parâmetros GET ou POST
    $acao = isset($_POST['acao']) ? $_POST['acao'] : (isset($_GET['acao']) ? $_GET['acao'] : '');

    /**
     * Switch para determinar qual operação executar com base na ação recebida.
     *  - 'listar': Retorna a lista de todas as mesas.
     *  - 'pesquisar': Retorna mesas que correspondem ao termo de pesquisa.
     *  - 'buscar': Retorna os detalhes de uma mesa específica por ID.
     *  - 'cadastrar': Cadastra uma nova mesa com os dados fornecidos.
     *  - 'atualizar': Atualiza os dados de uma mesa existente.
     *  - 'deletar': Deleta uma mesa, se possível (verifica dependências).
     */
    switch ($acao) {
        case 'listar':
            echo json_encode(Mesa::listar());
            break;
        
        case 'pesquisar':
            $termo = isset($_GET['termo']) ? $_GET['termo'] : '';
            echo json_encode(!empty($termo) ? Mesa::pesquisar($termo) : Mesa::listar());
            break;
        
        case 'buscar':
            $id = isset($_GET['id']) ? $_GET['id'] : 0;
            echo json_encode(Mesa::buscarPorId($id));
            break;
        
        case 'cadastrar':
            $numero = isset($_POST['numero']) ? $_POST['numero'] : '';
            $capacidade = isset($_POST['capacidade']) ? $_POST['capacidade'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : 'Livre';

            $sucesso = Mesa::cadastrar($numero, $capacidade, $status);
            $msg = $sucesso ? 'Mesa cadastrada com sucesso!' : 'Erro ao cadastrar mesa.';

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'atualizar':
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $numero = isset($_POST['numero']) ? $_POST['numero'] : '';
            $capacidade = isset($_POST['capacidade']) ? $_POST['capacidade'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : 'Livre';

            $sucesso = Mesa::atualizar($id, $numero, $capacidade, $status);
            $msg = $sucesso ? 'Mesa atualizada com sucesso!' : 'Erro ao atualizar mesa.';
            
            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'deletar':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $sucesso = Mesa::deletar($id);
            
            if ($sucesso) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Mesa removida do salão.']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Aviso: Não é possível excluir esta mesa pois ela possui histórico de pedidos ou reservas.']);
            }
            break;

        default:
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
            break;
    }
?>