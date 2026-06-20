<?php
    require_once __DIR__ . '/../models/Fornecedor.php';

    /**
     * Controlador para gerenciar as operações relacionadas aos fornecedores.
     *
     * Recebe requisições HTTP, executa as operações no modelo Fornecedor
     * e retorna respostas em formato JSON.
     */

    // Define o cabeçalho para resposta JSON
    header('Content-Type: application/json');

    // Obtém a ação a ser executada a partir dos parâmetros GET ou POST
    $acao = isset($_POST['acao']) ? $_POST['acao'] : (isset($_GET['acao']) ? $_GET['acao'] : '');

    /**
     * Switch para determinar qual operação executar com base na ação recebida.
     *  - 'listar':     Retorna a lista de todos os fornecedores.
     *  - 'pesquisar':  Retorna fornecedores que correspondem ao termo de pesquisa.
     *  - 'buscar':     Retorna os detalhes de um fornecedor específico por ID.
     *  - 'categorias': Retorna a lista de categorias únicas cadastradas.
     *  - 'cadastrar':  Cadastra um novo fornecedor com os dados fornecidos.
     *  - 'atualizar':  Atualiza os dados de um fornecedor existente.
     *  - 'deletar':    Deleta um fornecedor, se possível.
     */
    switch ($acao) {
        case 'listar':
            echo json_encode(Fornecedor::listar());
            break;

        case 'pesquisar':
            $termo = isset($_GET['termo']) ? $_GET['termo'] : (isset($_POST['termo']) ? $_POST['termo'] : '');
            echo json_encode(!empty($termo) ? Fornecedor::pesquisar($termo) : Fornecedor::listar());
            break;

        case 'buscar':
            $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
            echo json_encode(Fornecedor::buscarPorId($id));
            break;

        case 'categorias':
            echo json_encode(Fornecedor::listarCategorias());
            break;

        case 'cadastrar':
            $nome      = isset($_POST['nome'])      ? $_POST['nome']      : '';
            $cnpj      = isset($_POST['cnpj'])      ? $_POST['cnpj']      : '';
            $telefone  = isset($_POST['telefone'])  ? $_POST['telefone']  : '';
            $email     = isset($_POST['email'])     ? $_POST['email']     : '';
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
            $contato   = isset($_POST['contato'])   ? $_POST['contato']   : '';
            $ativo     = isset($_POST['ativo'])     ? (bool) $_POST['ativo'] : true;

            try {
                $sucesso = Fornecedor::cadastrar($nome, $cnpj, $telefone, $email, $categoria, $contato, $ativo);
                $msg = $sucesso ? 'Fornecedor cadastrado com sucesso!' : 'Erro ao cadastrar fornecedor.';
            } catch (Exception $e) {
                $sucesso = false;
                $msg = 'Erro: Este CNPJ já está cadastrado.';
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'atualizar':
            $id        = isset($_POST['id'])        ? $_POST['id']        : null;
            $nome      = isset($_POST['nome'])      ? $_POST['nome']      : '';
            $cnpj      = isset($_POST['cnpj'])      ? $_POST['cnpj']      : '';
            $telefone  = isset($_POST['telefone'])  ? $_POST['telefone']  : '';
            $email     = isset($_POST['email'])     ? $_POST['email']     : '';
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
            $contato   = isset($_POST['contato'])   ? $_POST['contato']   : '';
            $ativo     = isset($_POST['ativo'])     ? (bool) $_POST['ativo'] : true;

            try {
                $sucesso = Fornecedor::atualizar($id, $nome, $cnpj, $telefone, $email, $categoria, $contato, $ativo);
                $msg = $sucesso ? 'Fornecedor atualizado com sucesso!' : 'Erro ao atualizar fornecedor.';
            } catch (Exception $e) {
                $sucesso = false;
                $msg = 'Erro: Este CNPJ já está cadastrado para outro fornecedor.';
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'deletar':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $sucesso = Fornecedor::deletar($id);

            if ($sucesso) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Fornecedor excluído com sucesso!']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Aviso: Não é possível excluir este fornecedor pois ele possui registros associados.']);
            }
            break;

        default:
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
            break;
    }
?>
