<?php
    // Definir fuso horário padrão para evitar warnings do PHP globalmente
    date_default_timezone_set('America/Sao_Paulo');

    /*
    Criado por: Guilherme Villas Boas Braz
    Data: 09/06/2026

    Código para conexão com o banco de dados.

    Ele usa as credenciais padrões do USBWebServer e 
    ativa o modo de erros do PDO para ajudar na hora 
    de achar as falhas durante o desenvolvimento.
    */

    define('DB_HOST', 'localhost'); // Definindo o host
    define('DB_USER', 'root'); // Definindo o usuário
    define('DB_PASS', ''); // Definindo a senha
    define('DB_NAME', 'restaurante_alta_gastronomia'); // Definindo o nome do banco de dados

    class Database { // Criando uma classe para o banco de dados
        private static $instance = null; // Criando uma variável para armazenar a conexão

        public static function getConnection() { // Criando um método para fazer a conexão
            if (self::$instance === null) { // Verifica se não existe conexão
                try { // Iniciando tentativa
                    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8"; // Definindo o DSN (Data Source Name)

                    self::$instance = new PDO($dsn, DB_USER, DB_PASS, [ // Criando o PDO (PHP Data Objects)
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Configurando para mostrar erros
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Configurando o retorno dos resultados
                        PDO::ATTR_EMULATE_PREPARES => false, // Por segurança
                    ]);
                } catch (PDOException $e) { // Tratamento de erros
                    // Se falhar, tenta o fallback automático com as credenciais padrão do USBWebServer (porta 3307 e senha 'usbw')
                    try {
                        $fallback_dsn = "mysql:host=127.0.0.1;port=3307;dbname=" . DB_NAME . ";charset=utf8";
                        self::$instance = new PDO($fallback_dsn, 'root', 'usbw', [
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                            PDO::ATTR_EMULATE_PREPARES => false,
                        ]);
                    } catch (PDOException $fallbackException) {
                        // Se o fallback também falhar, exibe uma tela de erro amigável e explicativa
                        echo "
                        <div style='background-color: #09090b; color: #f5f5f5; font-family: system-ui, -apple-system, sans-serif; padding: 2.5rem; border: 1px solid rgba(207, 166, 82, 0.3); max-width: 600px; margin: 5rem auto; border-radius: 8px; box-shadow: 0 10px 30px rgba(0,0,0,0.6);'>
                            <h2 style='color: #cfa652; border-bottom: 1px solid #27272a; padding-bottom: 0.75rem; margin-top: 0; font-size: 1.5rem; font-weight: 600; letter-spacing: 0.05em;'>ERRO DE CONEXÃO COM O BANCO</h2>
                            <p style='font-size: 0.9rem; line-height: 1.6; color: #a1a1aa; margin-top: 1rem;'>Não foi possível estabelecer uma conexão com o banco de dados MySQL do seu USBWebServer.</p>
                            
                            <div style='background-color: #18181b; padding: 1.25rem; border-radius: 6px; font-family: monospace; font-size: 0.85rem; color: #f43f5e; margin: 1.5rem 0; border-left: 4px solid #f43f5e; word-break: break-all; line-height: 1.4;'>
                                <strong>Detalhe técnico (Tentativa com Fallback):</strong><br>
                                " . htmlspecialchars($fallbackException->getMessage()) . "
                            </div>
                            
                            <h3 style='color: #e4e4e7; font-size: 1.05rem; margin-bottom: 0.75rem; font-weight: 500;'>Passos para Solução:</h3>
                            <ol style='font-size: 0.875rem; color: #a1a1aa; padding-left: 1.25rem; line-height: 1.7;'>
                                <li style='margin-bottom: 0.5rem;'><strong>Ative os serviços:</strong> Certifique-se de que o painel do <strong>USBWebServer</strong> está aberto e que tanto o <strong>Apache</strong> quanto o <strong>MySQL</strong> estão com luz verde (ativos).</li>
                                <li style='margin-bottom: 0.5rem;'><strong>Importe o banco de dados:</strong> Acesse o <a href='http://localhost:8080/phpmyadmin' target='_blank' style='color: #cfa652; text-decoration: underline;'>phpMyAdmin</a> (login: <code>root</code> / senha: <code>usbw</code>), crie um banco de dados chamado <code>restaurante_alta_gastronomia</code> e importe o arquivo em <code>database/restaurante.sql</code>.</li>
                                <li style='margin-bottom: 0.5rem;'><strong>Ajuste as credenciais:</strong> Se você alterou a porta ou a senha padrão do MySQL, configure-as manualmente no arquivo <code>config/database.php</code>.</li>
                            </ol>
                        </div>";
                        die();
                    }
                }
            }
            return self::$instance; // Retornando a conexão
        }
    }
?>