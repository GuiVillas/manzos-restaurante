<?php
    require_once __DIR__ . '/../models/Cliente.php';

    /**
     * Controlador para gerenciar as operações relacionadas aos clientes.
     * 
     * Recebe requisições HTTP, executa as operações no modelo Cliente
     * e retorna respostas em formato JSON.
     */

    // Define o cabeçalho para resposta JSON
    header('Content-Type: application/json');

    // Obtém a ação a ser executada a partir dos parâmetros GET ou POST
    $acao = isset($_POST['acao']) ? $_POST['acao'] : (isset($_GET['acao']) ? $_GET['acao'] : '');

    /**
     * Switch para determinar qual operação executar com base na ação recebida.
     *  - 'listar': Retorna a lista de todos os clientes.
     *  - 'pesquisar': Retorna clientes que correspondem ao termo de pesquisa.
     *  - 'buscar': Retorna os detalhes de um cliente específico por ID.
     *  - 'cadastrar': Cadastra um novo cliente com os dados fornecidos.
     *  - 'atualizar': Atualiza os dados de um cliente existente.
     *  - 'deletar': Deleta um cliente, se possível (verifica dependências).
     */
    switch ($acao) {
        case 'listar':
            echo json_encode(Cliente::listar());
            break;

        case 'pesquisar':
            $termo = isset($_GET['termo']) ? $_GET['termo'] : (isset($_POST['termo']) ? $_POST['termo'] : '');
            echo json_encode(!empty($termo) ? Cliente::pesquisar($termo) : Cliente::listar());
            break;

        case 'buscar':
            $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
            echo json_encode(Cliente::buscarPorId($id));
            break;

        case 'buscar_por_cpf':
            $cpf = isset($_GET['cpf']) ? $_GET['cpf'] : (isset($_POST['cpf']) ? $_POST['cpf'] : '');
            $resultado = Cliente::buscarPorCpf($cpf);
            echo json_encode($resultado ? $resultado : ['encontrado' => false]);
            break;

        case 'cadastrar':
            $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
            $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';

            try {
                $sucesso = Cliente::cadastrar($nome, $email, $telefone, $cpf);
                $msg = $sucesso ? 'Cliente cadastrado com sucesso!' : 'Erro ao cadastrar cliente.';
            } catch (Exception $e) {
                $sucesso = false;
                if (strpos($e->getMessage(), 'cpf') !== false) {
                    $msg = 'Erro: Este CPF já está cadastrado.';
                } else {
                    $msg = 'Erro: Este e-mail já está cadastrado.';
                }
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'atualizar':
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : '';
            $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : '';

            try {
                $sucesso = Cliente::atualizar($id, $nome, $email, $telefone, $cpf);
                $msg = $sucesso ? 'Cliente atualizado com sucesso!' : 'Erro ao atualizar cliente.';
            } catch (Exception $e) {
                $sucesso = false;
                if (strpos($e->getMessage(), 'cpf') !== false) {
                    $msg = 'Erro: Este CPF já está cadastrado para outro cliente.';
                } else {
                    $msg = 'Erro: Este e-mail já está cadastrado para outro cliente.';
                }
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'deletar':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $sucesso = Cliente::deletar($id);

            if ($sucesso) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Cliente deletado com sucesso!']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Aviso: Não é possível excluir este cliente pois ele possui reservas cadastradas.']);
            }
            break;

        default:
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
            break;
    }
?>