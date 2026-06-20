<?php
    require_once __DIR__ . '/../models/Usuario.php';

    /**
     * Controlador para gerenciar as operações relacionadas aos usuários do sistema.
     *
     * Recebe requisições HTTP, executa as operações no modelo Usuario
     * e retorna respostas em formato JSON.
     */

    // Define o cabeçalho para resposta JSON
    header('Content-Type: application/json');

    // Obtém a ação a ser executada a partir dos parâmetros GET ou POST
    $acao = isset($_POST['acao']) ? $_POST['acao'] : (isset($_GET['acao']) ? $_GET['acao'] : '');

    /**
     * Switch para determinar qual operação executar com base na ação recebida.
     *  - 'listar':         Retorna a lista de todos os usuários.
     *  - 'pesquisar':      Retorna usuários que correspondem ao termo de pesquisa.
     *  - 'buscar':         Retorna os detalhes de um usuário específico por ID.
     *  - 'cargos':         Retorna os cargos distintos cadastrados.
     *  - 'cadastrar':      Cadastra um novo usuário com os dados fornecidos.
     *  - 'atualizar':      Atualiza nome, e-mail e cargo de um usuário existente.
     *  - 'atualizarSenha': Atualiza apenas a senha de um usuário.
     *  - 'deletar':        Deleta um usuário, se possível (verifica dependências).
     */
    switch ($acao) {
        case 'listar':
            echo json_encode(Usuario::listar());
            break;

        case 'pesquisar':
            $termo = isset($_GET['termo']) ? $_GET['termo'] : (isset($_POST['termo']) ? $_POST['termo'] : '');
            echo json_encode(!empty($termo) ? Usuario::pesquisar($termo) : Usuario::listar());
            break;

        case 'buscar':
            $id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : 0);
            echo json_encode(Usuario::buscarPorId($id));
            break;

        case 'cargos':
            echo json_encode(Usuario::listarCargos());
            break;

        case 'cadastrar':
            $nome  = isset($_POST['nome'])  ? $_POST['nome']  : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $senha = isset($_POST['senha']) ? $_POST['senha'] : '';
            $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';

            try {
                $sucesso = Usuario::cadastrar($nome, $email, $senha, $cargo);
                $msg = $sucesso ? 'Usuário cadastrado com sucesso!' : 'Erro ao cadastrar usuário.';
            } catch (Exception $e) {
                $sucesso = false;
                $msg = 'Erro: Este e-mail já está cadastrado.';
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'atualizar':
            $id    = isset($_POST['id'])    ? $_POST['id']    : null;
            $nome  = isset($_POST['nome'])  ? $_POST['nome']  : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';

            try {
                $sucesso = Usuario::atualizar($id, $nome, $email, $cargo);
                $msg = $sucesso ? 'Usuário atualizado com sucesso!' : 'Erro ao atualizar usuário.';
            } catch (Exception $e) {
                $sucesso = false;
                $msg = 'Erro: Este e-mail já está cadastrado para outro usuário.';
            }

            echo json_encode(['sucesso' => $sucesso, 'mensagem' => $msg]);
            break;

        case 'atualizarSenha':
            $id    = isset($_POST['id'])    ? $_POST['id']    : null;
            $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

            if (empty($senha)) {
                echo json_encode(['sucesso' => false, 'mensagem' => 'A nova senha não pode ser vazia.']);
                break;
            }

            $sucesso = Usuario::atualizarSenha($id, $senha);
            echo json_encode([
                'sucesso'  => $sucesso,
                'mensagem' => $sucesso ? 'Senha atualizada com sucesso!' : 'Erro ao atualizar senha.',
            ]);
            break;

        case 'deletar':
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $sucesso = Usuario::deletar($id);

            if ($sucesso) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Usuário excluído com sucesso!']);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Aviso: Não é possível excluir este usuário pois ele possui pedidos associados.']);
            }
            break;

        default:
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
            break;
    }
?>
