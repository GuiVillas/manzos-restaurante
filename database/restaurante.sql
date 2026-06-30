-- =============================================================================
--  MANZO'S — Restaurante de Alta Gastronomia
--  Script completo de criação e população do banco de dados
--  Todas as informações espelham o cardápio, a identidade e a operação real
--  do restaurante conforme apresentado no site público.
-- =============================================================================

CREATE DATABASE IF NOT EXISTS manzos_restaurante
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE manzos_restaurante;

-- =============================================================================
--  TABELAS
-- =============================================================================

CREATE TABLE cliente (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    cpf       VARCHAR(14)  UNIQUE NOT NULL,
    nome      VARCHAR(100) NOT NULL,
    email     VARCHAR(100) UNIQUE NOT NULL,
    telefone  VARCHAR(20)  NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mesa (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    numero     INT         NOT NULL,
    capacidade INT         NOT NULL,
    status     VARCHAR(50) NOT NULL DEFAULT 'Disponível'
);

CREATE TABLE usuario (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(100) NOT NULL,
    email     VARCHAR(100) UNIQUE NOT NULL,
    senha     VARCHAR(256) NOT NULL,
    cargo     VARCHAR(100) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categoria_prato (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(100) NOT NULL,
    descricao VARCHAR(255) UNIQUE
);

CREATE TABLE prato (
    id                    INT AUTO_INCREMENT PRIMARY KEY,
    categoria_prato_id    INT,
    nome                  VARCHAR(100)  NOT NULL,
    descricao             VARCHAR(255),
    preco                 DECIMAL(10,2) NOT NULL,
    desconto_multiplicador DECIMAL(4,2) NOT NULL DEFAULT 1.00,
    ativo                 BOOLEAN       NOT NULL DEFAULT TRUE,
    FOREIGN KEY (categoria_prato_id) REFERENCES categoria_prato(id)
);

CREATE TABLE reserva (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id   INT,
    mesa_id      INT,
    data_reserva DATE NOT NULL,
    hora_reserva TIME NOT NULL,
    num_pessoas  INT  NOT NULL,
    status       VARCHAR(50)  NOT NULL DEFAULT 'Pendente',
    observacoes  VARCHAR(255),
    criado_em    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id),
    FOREIGN KEY (mesa_id)    REFERENCES mesa(id)
);

CREATE TABLE pedido (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    mesa_id     INT,
    usuario_id  INT,
    cliente_id  INT NULL,
    status      VARCHAR(50) NOT NULL DEFAULT 'Ativa',
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mesa_id)    REFERENCES mesa(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    FOREIGN KEY (cliente_id) REFERENCES cliente(id)
);

CREATE TABLE prato_pedido (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id      INT,
    prato_id       INT,
    quantidade     INT           NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedido(id),
    FOREIGN KEY (prato_id)  REFERENCES prato(id)
);

CREATE TABLE pagamento (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id       INT           NOT NULL,
    forma_pagamento VARCHAR(50)   NOT NULL,
    valor           DECIMAL(10,2) NOT NULL,
    status          VARCHAR(50)   NOT NULL DEFAULT 'Pendente',
    observacoes     VARCHAR(255),
    pago_em         TIMESTAMP NULL,
    criado_em       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedido(id)
);

CREATE TABLE fornecedor (
    id        INT AUTO_INCREMENT PRIMARY KEY,
    nome      VARCHAR(100) NOT NULL,
    cnpj      VARCHAR(18)  UNIQUE,
    telefone  VARCHAR(20)  NOT NULL,
    email     VARCHAR(100),
    categoria VARCHAR(100) NOT NULL,
    contato   VARCHAR(100),
    ativo     BOOLEAN      NOT NULL DEFAULT TRUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =============================================================================
--  CLIENTES
-- =============================================================================

INSERT INTO cliente (cpf, nome, email, telefone) VALUES
('121.345.678-09', 'Rafael Drummond',         'rafael.drummond@email.com',      '27998801001'),
('232.456.789-10', 'Isabela Monteiro',         'isabela.monteiro@email.com',     '27998801002'),
('343.567.890-21', 'Gustavo Carvalho',         'gustavo.carvalho@email.com',     '27998801003'),
('454.678.901-32', 'Beatriz Fontes',           'beatriz.fontes@email.com',       '27998801004'),
('565.789.012-43', 'Leonardo Vasquez',         'leonardo.vasquez@email.com',     '27998801005'),
('676.890.123-54', 'Camila Pereira',           'camila.pereira@email.com',       '27998801006'),
('787.901.234-65', 'André Lustosa',            'andre.lustosa@email.com',        '27998801007'),
('898.012.345-76', 'Fernanda Braga',           'fernanda.braga@email.com',       '27998801008'),
('909.123.456-87', 'Thiago Menezes',           'thiago.menezes@email.com',       '27998801009'),
('010.234.567-98', 'Larissa Queiroz',          'larissa.queiroz@email.com',      '27998801010'),
('111.234.568-00', 'Carlos Eduardo Nogueira',  'carloseduardo@email.com',        '27998801011'),
('222.345.679-11', 'Mariana Vilaca',           'mariana.vilaca@email.com',       '27998801012'),
('333.456.780-22', 'Felipe Andrade',           'felipe.andrade@email.com',       '27998801013'),
('444.567.891-33', 'Sofia Rezende',            'sofia.rezende@email.com',        '27998801014'),
('555.678.902-44', 'Rodrigo Tavares',          'rodrigo.tavares@email.com',      '27998801015'),
('666.789.013-55', 'Amanda Figueiredo',        'amanda.figueiredo@email.com',    '27998801016'),
('777.890.124-66', 'Henrique Salomao',         'henrique.salomao@email.com',     '27998801017'),
('888.901.235-77', 'Natalia Cordeiro',         'natalia.cordeiro@email.com',     '27998801018');

-- =============================================================================
--  MESAS
-- =============================================================================

INSERT INTO mesa (numero, capacidade, status) VALUES
(1,  2,  'Disponível'),
(2,  2,  'Disponível'),
(3,  4,  'Disponível'),
(4,  4,  'Ocupada'),
(5,  4,  'Ocupada'),
(6,  4,  'Disponível'),
(7,  6,  'Disponível'),
(8,  6,  'Ocupada'),
(9,  8,  'Reservada'),
(10, 12, 'Disponível');

-- =============================================================================
--  USUARIOS
-- =============================================================================

INSERT INTO usuario (nome, email, senha, cargo) VALUES
('Ricardo Manzo',         'ricardo@manzos.com',     '123456', 'Gerente'),
('Chef Elcio Brandao',    'chef@manzos.com',         '123456', 'Chef Executivo'),
('Sous-Chef Priya Nair',  'souschef@manzos.com',     '123456', 'Sous-Chef'),
('Lucas Ferreira',        'lucas.f@manzos.com',      '123456', 'Garcom'),
('Sabrina Torres',        'sabrina.t@manzos.com',    '123456', 'Garcom'),
('Diego Campos',          'diego.c@manzos.com',      '123456', 'Garcom'),
('Leticia Prado',         'leticia.p@manzos.com',    '123456', 'Caixa');

-- =============================================================================
--  CATEGORIAS
-- =============================================================================

INSERT INTO categoria_prato (nome, descricao) VALUES
('Entradas',             'Starters - preparacoes finas para abrir o paladar'),
('Petiscos',             'Appetizers - porcoes para compartilhar antes do principal'),
('Carnes Premium',       'Noble Cuts - cortes bovinos de elite grelhados no fogo'),
('Acompanhamentos',      'Sides - guarnicoes artesanais para compor o prato principal'),
('Sobremesas',           'Desserts - finalizacoes esculpidas pela confeitaria da casa'),
('Drinks e Coquetel',    'Mixology - coquetelaria classica revisitada com destilados premium'),
('Vinhos e Destilados',  'Cave - adega climatizada com mais de 450 rotulos selecionados');

-- =============================================================================
--  PRATOS
-- =============================================================================

INSERT INTO prato (categoria_prato_id, nome, preco, descricao, ativo) VALUES

-- ENTRADAS
(1, 'Steak Tartare Manzos',    68.00, 'File mignon picado na ponta da faca, gema de codorna curada, alcaparras, mostarda Dijon antiga e torradas de fermentacao natural', TRUE),
(1, 'Carpaccio de Wagyu',      74.00, 'Fatias finissimas de Wagyu altamente marmorizado, rucula selvatica organica, lascas de Grana Padano 24 meses e azeite extra virgem trufado', TRUE),
(1, 'Tutano Assado na Brasa',  56.00, 'Tutano bovino assado em forno de carvao, vinagrete chimichurri fresco e fatias de sourdough tostadas na manteiga de garrafa', TRUE),

-- PETISCOS
(2, 'Croqueta de Costela Defumada',   48.00, 'Croquetas ultra cremosas de costela defumada por 12 horas em lenha de macieira, servidas com maionese artesanal de carvao ativado', TRUE),
(2, 'Dadinhos de Tapioca com Coalho', 42.00, 'Crocantes por fora e macios por dentro, acompanhados de geleia de pimenta dedo-de-moca defumada produzida artesanalmente', TRUE),
(2, 'Panceta Pururuca',               52.00, 'Barriga de porco crocante cozida em baixa temperatura e pururucada, com reducao de goiabada cascao e cachaca envelhecida', TRUE),

-- CARNES PREMIUM
(3, 'Prime Rib Wagyu A5',            340.00, 'BMS 10+ - marmoreio excepcional. Grelhado ao ponto do chef, flor de sal de Maldon e manteiga de tutano (600g)', TRUE),
(3, 'Bife Ancho Black Angus',        165.00, 'Contrefile Angus certificado da parte dianteira. Maciez inigualavel na brasa forte, chimichurri da casa (400g)', TRUE),
(3, 'Tomahawk Selection',            290.00, 'Corte monumental com osso da costela inteiro. Selado na churrasqueira a carvao, manteiga trufada e tomilho fresco (900g)', TRUE),
(3, 'Filet Mignon ao Jus de Trufas', 138.00, 'Medalhao alto de file mignon selado, demi-glace artesanal com trufas negras e aligot aveludado de queijo Canastra meia cura', TRUE),
(3, 'Costela Short Rib 36h',         175.00, 'Costela bovina maturada e cozida lentamente por 36 horas. Caramelizada na brasa, molho de tutano e pure de mandioquinha', TRUE),

-- ACOMPANHAMENTOS
(4, 'Pure Trufado de Batata Ratte', 42.00, 'Pure aveludado de batata Ratte com manteiga noisette, creme de leite fresco e trufas negras raladas na hora', TRUE),
(4, 'Batata Frita Gourmet',         36.00, 'Batatas Asterix fritas em azeite de oliva, temperadas com ervas frescas, alho confitado e flor de sal de Maldon', TRUE),
(4, 'Aspargos Grelhados',           38.00, 'Aspargos verdes frescos grelhados com manteiga clarificada, limao siciliano e raspas de limao', TRUE),
(4, 'Salada de Rucula ao Parmesao', 32.00, 'Rucula selvatica organica, tomate-cereja confitado, lascas de Parmesao Reggiano 18 meses e vinagrete balsamico envelhecido', TRUE),

-- SOBREMESAS
(5, 'Texturas de Chocolate',       44.00, 'Mousse de chocolate belga 70%, ganache defumada em lenha doce, crumble de cacau com flor de sal e sorvete de baunilha Bourbon', TRUE),
(5, 'Mil Folhas de Doce de Leite', 38.00, 'Massa folhada ultra fina e crocante com doce de leite artesanal cozido lentamente e toque de flor de sal', TRUE),
(5, 'Creme Brulee de Pistache',    42.00, 'Creme aveludado aromatizado com pistache siciliano puro, coberto com casquinha de acucar demerara queimada no macario', TRUE),
(5, 'Sorvete Artesanal da Casa',   28.00, 'Duas bolas de sorvete artesanal feito na casa - baunilha Bourbon, caramelo defumado ou chocolate amargo', TRUE),

-- DRINKS E COQUETEL
(6, 'Manzos Old Fashioned',        48.00, 'Bourbon premium envelhecido, xarope de acucar mascavo defumado sob cupula de serragem de macieira e angostura bitter', TRUE),
(6, 'Smoked Negroni',              46.00, 'London Dry Gin artesanal, vermute tinto doce piemontes, Campari defumado e guarniao de casca de laranja bahia flambada', TRUE),
(6, 'Basil e Ginger Gin Tonic',    42.00, 'Gin infusionado com manjericao gigante, agua tonica premium, extrato fresco de gengibre e limao siciliano', TRUE),
(6, 'Espresso Martini',            44.00, 'Vodka premium, licor de cafe Kahlua, espresso extraido na hora e espuma de cafe com 3 graos tostados de apresentacao', TRUE),

-- VINHOS E DESTILADOS
(7, 'Malbec Achaval Ferrer Taca',  68.00, 'Malbec argentino de Mendoza 2021. Corpo pleno, taninos sedosos - harmonizacao perfeita com cortes vermelhos', TRUE),
(7, 'Cabernet Gran Reserva Taca',  72.00, 'Cabernet Sauvignon chileno Valle del Maipo 2020. Estrutura elegante, notas de cassis e especiarias', TRUE),
(7, 'Prosecco Valdobiaddene Taca', 54.00, 'Prosecco DOCG italiano. Perlage fino e persistente, aroma de pessego branco - perfeito como aperitivo', TRUE),
(7, 'Whisky Single Malt 12 Anos',  85.00, 'Scotch single malt Highland 12 anos em barril de carvalho. Notas de mel, baunilha e defumado sutil', TRUE),
(7, 'San Pellegrino 500ml',        22.00, 'Agua mineral com gas italiana, garrafa de vidro', TRUE),
(7, 'Agua Mineral sem gas 500ml',  16.00, 'Agua mineral sem gas, garrafa de vidro', TRUE);

-- =============================================================================
--  FORNECEDORES
-- =============================================================================

INSERT INTO fornecedor (nome, cnpj, telefone, email, categoria, contato, ativo) VALUES
('Wagyu Brasil Importacao',        '11.223.344/0001-55', '1133990011', 'vendas@wagyubrasil.com.br',        'Carnes Premium',    'Alexandre Hoshi',    TRUE),
('Black Angus Farms ES',           '22.334.455/0001-66', '2733881100', 'comercial@blackangusfarms.com.br', 'Carnes Premium',    'Rodrigo Furtado',    TRUE),
('Frigorifico Nobre Capixaba',     '33.445.566/0001-77', '2733882200', 'pedidos@frigonobre.com.br',        'Carnes',            'Sonia Batista',      TRUE),
('Adega Paulista Premium',         '44.556.677/0001-88', '1133883300', 'adega@adegapaulista.com.br',       'Vinhos',            'Renata Albuquerque', TRUE),
('Premium Spirits Distribuidora',  '55.667.788/0001-99', '1133884400', 'spirits@premiumspirits.com.br',    'Destilados',        'Felipe Gomes',       TRUE),
('Organicos Serra Verde',          '66.778.899/0001-00', '2799885500', 'contato@organicosserraverde.com.br','Hortifruti',        'Maria do Carmo',     TRUE),
('Laticinios Canastra Minas',      '77.889.900/0001-11', '3733886600', 'vendas@latcanastra.com.br',        'Laticinios',        'Dorival Pereira',    TRUE),
('Forneria Artesanal Vitoria',     '88.990.011/0001-22', '2799887700', 'pedidos@forneriaartesanal.com.br', 'Paes e Massas',     'Carla Mendonca',     TRUE),
('Trufa Fungi Importados',         '99.001.122/0001-33', '1133888800', 'import@trufafungi.com.br',         'Especiarias',       'Giovanna Pasquali',  TRUE),
('Confeitaria Insumos Premium',    '10.112.233/0001-44', '1133889900', 'insumos@confpremium.com.br',       'Confeitaria',       'Andre Leclerc',      TRUE),
('GelaTech Nitrogenio Culinario',  '20.223.344/0001-55', '1133880011', 'comercial@gelatech.com.br',        'Insumos Tecnicos',  'Bruno Tanaka',       FALSE);

-- =============================================================================
--  RESERVAS
-- =============================================================================

INSERT INTO reserva (cliente_id, mesa_id, data_reserva, hora_reserva, num_pessoas, status, observacoes) VALUES
(1,  2,  '2025-06-01', '20:00:00',  2, 'Concluida',  'Jantar de aniversario de namoro - vela e rosas solicitadas'),
(3,  4,  '2025-06-05', '21:00:00',  4, 'Concluida',  'Reuniao de negocios'),
(5,  7,  '2025-06-10', '19:30:00',  6, 'Concluida',  'Aniversario de 40 anos - menu degustacao fechado'),
(7,  9,  '2025-06-14', '20:30:00',  8, 'Concluida',  'Confraternizacao de empresa'),
(2,  1,  '2025-06-18', '21:00:00',  2, 'Concluida',  'Proposta de casamento - solicitar petalas de rosa'),
(10, 3,  '2025-06-20', '20:00:00',  4, 'Concluida',  NULL),
(12, 6,  '2025-06-22', '19:00:00',  4, 'Concluida',  'Alergia a frutos do mar - alertar chef'),
(15, 4,  '2025-06-25', '21:30:00',  4, 'Concluida',  'Menu de carnes premium - harmonizacao de vinhos'),
(17, 2,  '2025-06-28', '20:00:00',  2, 'Concluida',  'Data especial - bolo surpresa solicitado'),
(4,  5,  '2025-07-02', '19:00:00',  4, 'Cancelada',  'Cancelamento pelo cliente - compromisso imprevisto'),
(8,  7,  '2025-07-08', '20:30:00',  6, 'Cancelada',  NULL),
(6,  5,  '2025-09-05', '20:00:00',  4, 'Confirmada', 'Mesa proxima a janela - casal com intolerancia a lactose'),
(9,  9,  '2025-09-06', '21:00:00',  8, 'Confirmada', 'Aniversario de 50 anos - salao privativo solicitado'),
(11, 1,  '2025-09-07', '20:30:00',  2, 'Confirmada', 'Jantar romantico - champagne para boas-vindas'),
(13, 3,  '2025-09-08', '19:30:00',  4, 'Confirmada', NULL),
(16, 6,  '2025-09-09', '21:00:00',  4, 'Confirmada', 'Vegetariano na mesa - verificar opcoes do chef'),
(18, 7,  '2025-09-10', '20:00:00',  5, 'Confirmada', NULL),
(14, 10, '2025-09-12', '19:00:00', 10, 'Pendente',   'Evento corporativo - menu fechado a confirmar'),
(2,  4,  '2025-09-14', '21:00:00',  4, 'Pendente',   NULL),
(7,  8,  '2025-09-15', '20:30:00',  6, 'Pendente',   'Jantar de formatura');

-- =============================================================================
--  PEDIDOS
-- =============================================================================

INSERT INTO pedido (mesa_id, usuario_id, cliente_id, status, data_pedido) VALUES
(1,  4, 1,    'Fechada', '2025-06-01 20:15:00'),
(2,  5, 2,    'Fechada', '2025-06-01 20:20:00'),
(4,  6, 3,    'Fechada', '2025-06-05 21:10:00'),
(3,  4, 4,    'Fechada', '2025-06-05 21:05:00'),
(7,  5, 5,    'Fechada', '2025-06-10 19:45:00'),
(9,  6, 7,    'Fechada', '2025-06-14 20:40:00'),
(1,  4, 2,    'Fechada', '2025-06-18 21:10:00'),
(3,  5, 10,   'Fechada', '2025-06-20 20:15:00'),
(6,  6, 12,   'Fechada', '2025-06-22 19:15:00'),
(4,  4, 15,   'Fechada', '2025-06-25 21:40:00'),
(2,  5, 17,   'Fechada', '2025-06-28 20:15:00'),
(8,  6, 6,    'Fechada', '2025-07-01 20:30:00'),
(3,  4, 8,    'Fechada', '2025-07-03 21:00:00'),
(4,  5, 9,    'Fechada', '2025-07-05 19:50:00'),
(7,  6, 11,   'Fechada', '2025-07-08 20:20:00'),
(6,  4, 13,   'Fechada', '2025-07-10 21:10:00'),
(1,  5, 14,   'Fechada', '2025-07-12 20:00:00'),
(9,  6, 16,   'Fechada', '2025-07-15 20:45:00'),
(4,  4, 6,    'Ativa',   NOW()),
(8,  5, 11,   'Ativa',   NOW()),
(5,  6, NULL, 'Ativa',   NOW());

-- =============================================================================
--  ITENS DOS PEDIDOS
-- =============================================================================

INSERT INTO prato_pedido (pedido_id, prato_id, quantidade, preco_unitario) VALUES
(1,2,1,74.00),(1,10,2,138.00),(1,12,2,42.00),(1,20,2,48.00),(1,16,2,44.00),
(2,1,1,68.00),(2,8,2,165.00),(2,15,2,32.00),(2,25,2,72.00),
(3,4,2,48.00),(3,5,2,42.00),(3,9,2,290.00),(3,13,4,36.00),(3,24,4,68.00),(3,17,2,38.00),
(4,1,1,68.00),(4,11,1,175.00),(4,14,1,38.00),(4,22,1,44.00),(4,19,1,42.00),
(5,2,3,74.00),(5,3,2,56.00),(5,7,2,340.00),(5,8,2,165.00),(5,9,1,290.00),
(5,12,6,42.00),(5,27,1,85.00),(5,24,6,68.00),(5,16,3,44.00),(5,17,3,38.00),
(6,4,4,48.00),(6,6,3,52.00),(6,7,3,340.00),(6,11,3,175.00),(6,14,8,38.00),
(6,13,8,36.00),(6,25,8,72.00),(6,19,4,42.00),(6,20,4,28.00),
(7,2,1,74.00),(7,10,2,138.00),(7,15,2,32.00),(7,26,2,54.00),(7,20,2,48.00),(7,19,2,42.00),
(8,3,1,56.00),(8,9,1,290.00),(8,12,1,42.00),(8,21,1,46.00),(8,24,2,68.00),(8,17,1,38.00),
(9,1,2,68.00),(9,8,2,165.00),(9,13,2,36.00),(9,22,2,44.00),(9,16,2,44.00),
(10,2,2,74.00),(10,7,1,340.00),(10,10,1,138.00),(10,12,2,42.00),(10,24,2,68.00),(10,25,2,72.00),(10,19,2,42.00),
(11,3,1,56.00),(11,10,2,138.00),(11,14,2,38.00),(11,26,2,54.00),(11,20,2,48.00),(11,16,2,44.00),
(12,5,3,42.00),(12,4,2,48.00),(12,8,3,165.00),(12,13,3,36.00),(12,24,3,68.00),(12,17,3,38.00),
(13,1,2,68.00),(13,9,1,290.00),(13,15,2,32.00),(13,21,2,46.00),(13,19,2,42.00),
(14,6,2,52.00),(14,11,2,175.00),(14,12,2,42.00),(14,25,2,72.00),(14,16,2,44.00),
(15,2,2,74.00),(15,7,2,340.00),(15,13,4,36.00),(15,27,2,85.00),(15,24,4,68.00),(15,17,2,38.00),(15,20,2,28.00),
(16,1,1,68.00),(16,8,1,165.00),(16,10,1,138.00),(16,12,2,42.00),(16,22,2,44.00),(16,19,2,42.00),
(17,2,1,74.00),(17,10,2,138.00),(17,14,2,38.00),(17,21,1,46.00),(17,26,2,54.00),(17,19,2,42.00),
(18,4,4,48.00),(18,5,4,42.00),(18,7,3,340.00),(18,9,2,290.00),(18,12,8,42.00),
(18,14,8,38.00),(18,24,6,68.00),(18,25,4,72.00),(18,16,4,44.00),(18,17,4,38.00),
(19,3,1,56.00),(19,8,2,165.00),(19,13,2,36.00),(19,22,2,44.00),
(20,6,2,52.00),(20,9,1,290.00),(20,12,2,42.00),(20,24,2,68.00),
(21,1,1,68.00),(21,21,2,46.00);

-- =============================================================================
--  PAGAMENTOS
-- =============================================================================

INSERT INTO pagamento (pedido_id, forma_pagamento, valor, status, observacoes, pago_em) VALUES
(1,  'Credito',       558.00, 'Pago',     NULL,                             '2025-06-01 22:10:00'),
(2,  'PIX',           502.00, 'Pago',     NULL,                             '2025-06-01 22:25:00'),
(3,  'Credito',      1682.00, 'Pago',     'Parcelado em 2x',                '2025-06-05 23:00:00'),
(4,  'Debito',        327.00, 'Pago',     NULL,                             '2025-06-05 22:40:00'),
(5,  'Credito',      3843.00, 'Pago',     'Parcelado em 3x',                '2025-06-10 22:30:00'),
(6,  'PIX',          4888.00, 'Pago',     'Nota fiscal emitida - CNPJ',     '2025-06-14 23:15:00'),
(7,  'Credito',       610.00, 'Pago',     'Champagne cortesia da casa',      '2025-06-18 22:50:00'),
(8,  'Debito',        572.00, 'Pago',     NULL,                             '2025-06-20 22:30:00'),
(9,  'PIX',           690.00, 'Pago',     NULL,                             '2025-06-22 21:45:00'),
(10, 'Credito',      1100.00, 'Pago',     'Degustacao harmonizada',          '2025-06-25 23:20:00'),
(11, 'Vale Refeicao', 558.00, 'Pago',     NULL,                             '2025-06-28 22:40:00'),
(12, 'PIX',           942.00, 'Pago',     NULL,                             '2025-07-01 22:45:00'),
(13, 'Credito',       774.00, 'Pago',     NULL,                             '2025-07-03 22:50:00'),
(14, 'Debito',        802.00, 'Pago',     NULL,                             '2025-07-05 22:10:00'),
(15, 'Credito',      2268.00, 'Pago',     'Nota fiscal emitida - CNPJ',     '2025-07-08 22:55:00'),
(16, 'PIX',           805.00, 'Pago',     NULL,                             '2025-07-10 23:10:00'),
(17, 'Credito',       650.00, 'Pago',     NULL,                             '2025-07-12 22:30:00'),
(18, 'Credito',      4804.00, 'Pago',     'Parcelado em 4x - corporativo',  '2025-07-15 23:30:00'),
(19, 'PIX',           546.00, 'Pendente', NULL,                             NULL),
(20, 'Credito',       804.00, 'Pendente', NULL,                             NULL);
