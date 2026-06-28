<?php
    require_once __DIR__ . '/../models/Prato.php';

    /**
     * Controlador para gerenciar as operações relacionadas aos pratos.
     * 
     * Recebe requisições HTTP, executa as operações no modelo Prato
     * e retorna respostas em formato JSON.
     */

    // Define o cabeçalho para resposta JSON
    header('Content-Type: application/json');

    // Obtém a ação a ser executada a partir dos parâmetros GET ou POST
    $acao = isset($_POST['acao']) ? $_POST['acao'] : (isset($_GET['acao']) ? $_GET['acao'] : '');

    /**
     * Switch para determinar qual operação executar com base na ação recebida.
     *  - 'listar': Retorna a lista de todos os pratos.
     *  - 'cadastrar': Cadastra um novo prato com os dados fornecidos.
     *  - 'deletar': Deleta um prato, se possível (verifica dependências).
     */
    switch ($acao) {
        case 'listar':
            $pratos = Prato::listar();
            echo json_encode($pratos);
            break;

        case 'listarCategorias':
            echo json_encode(Prato::listarCategorias());
            break;

        case 'buscar':
            $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
            echo json_encode(Prato::buscarPorId($id));
            break;

        case 'atualizar':
            $id           = isset($_POST['id'])           ? $_POST['id']                    : 0;
            $nome         = isset($_POST['nome'])         ? $_POST['nome']                  : '';
            $preco        = isset($_POST['preco'])        ? $_POST['preco']                 : 0.00;
            $categoria_id = !empty($_POST['categoria_id']) ? $_POST['categoria_id']         : null;
            $descricao    = isset($_POST['descricao'])    ? $_POST['descricao']             : '';
            $ativo        = isset($_POST['ativo'])        ? (int) $_POST['ativo']           : 1;

            if (Prato::atualizar($id, $nome, $preco, $categoria_id, $descricao, $ativo)) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Prato atualizado com sucesso.']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao atualizar prato.']);
            }
            break;

        case 'cadastrar':
            $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
            $preco = isset($_POST['preco']) ? $_POST['preco'] : 0.00;
            $categoria_id = !empty($_POST['categoria_id']) ? $_POST['categoria_id'] : null;
            $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
            $ativo = 1;

            if (Prato::cadastrar($nome, $preco, $categoria_id, $descricao, $ativo)) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Prato cadastrado com sucesso.']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao cadastrar.']);
            }
            break;

        case 'deletar':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;

            if (Prato::deletar($id)) {
                echo json_encode(['sucesso' => true]);
            } else {
                echo json_encode(['sucesso' => false]);
            }
            break;

        case 'aplicarDesconto':
            $id            = isset($_POST['id'])             ? $_POST['id']             : 0;
            $multiplicador = isset($_POST['multiplicador'])  ? $_POST['multiplicador']  : 1.00;

            if (Prato::aplicarDesconto($id, $multiplicador)) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Desconto aplicado com sucesso.']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao aplicar desconto.']);
            }
            break;

        case 'removerDesconto':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;

            if (Prato::removerDesconto($id)) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Desconto removido. Preço original restaurado.']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao remover desconto.']);
            }
            break;
        
        default:
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação não reconhecida.']);
            break;
    }
?>