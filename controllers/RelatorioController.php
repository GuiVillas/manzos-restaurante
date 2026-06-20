<?php
require_once __DIR__ . '/../models/Relatorio.php';

// Define o cabeçalho para resposta JSON
header('Content-Type: application/json');

// Inicia a sessão para validar autenticação
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Impede acesso de usuários não logados
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Acesso não autorizado. Por favor, faça login.']);
    exit;
}

$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

switch ($acao) {
    case 'faturamento_periodo':
        echo json_encode(Relatorio::faturamentoPorPeriodo());
        break;

    case 'pratos_mais_vendidos':
        echo json_encode(Relatorio::pratosMaisVendidos());
        break;

    case 'faturamento_garcom':
        echo json_encode(Relatorio::faturamentoPorGarcom());
        break;

    default:
        echo json_encode(['sucesso' => false, 'mensagem' => 'Ação de relatório inválida.']);
        break;
}
?>
