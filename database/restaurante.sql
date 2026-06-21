CREATE DATABASE IF NOT EXISTS manzos_restaurante;

USE manzos_restaurante;

CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    telefone VARCHAR(100) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email VARCHAR(100) UNIQUE NOT NULL,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE mesa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(100) NOT NULL,
    capacidade INT NOT NULL,
    numero INT NOT NULL
);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(256) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categoria_prato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao VARCHAR(255) UNIQUE
);

CREATE TABLE reserva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    mesa_id INT,
    hora_reserva TIME NOT NULL,
    data_reserva DATE NOT NULL,
    status VARCHAR(100) NOT NULL,
    observacoes VARCHAR(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    num_pessoas INT NOT NULL,
    FOREIGN KEY (cliente_id) REFERENCES cliente(id),
    FOREIGN KEY (mesa_id) REFERENCES mesa(id)
);

CREATE TABLE prato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_prato_id INT,
    preco DECIMAL(10, 2) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    ativo BOOLEAN NOT NULL,
    descricao VARCHAR(255),
    FOREIGN KEY (categoria_prato_id) REFERENCES categoria_prato(id)
);

CREATE TABLE pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mesa_id INT,
    usuario_id INT,
    cliente_id INT NULL,
    data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Ativa',
    FOREIGN KEY (mesa_id) REFERENCES mesa(id),
    FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    FOREIGN KEY (cliente_id) REFERENCES cliente(id)
);

CREATE TABLE prato_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prato_id INT,
    pedido_id INT,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (prato_id) REFERENCES prato(id),
    FOREIGN KEY (pedido_id) REFERENCES pedido(id)
);

INSERT INTO cliente (cpf, telefone, email, nome) VALUES
('123.456.789-00', '27999990001', 'carlos.silva@email.com', 'Carlos Silva'),
('234.567.890-11', '27999990002', 'ana.costa@email.com', 'Ana Costa'),
('345.678.901-22', '27999990003', 'marcos.oliveira@email.com', 'Marcos Oliveira'),
('456.789.012-33', '27999990004', 'juliana.santos@email.com', 'Juliana Santos'),
('567.890.123-44', '27999990005', 'pedro.almeida@email.com', 'Pedro Almeida');

INSERT INTO mesa (status, capacidade, numero) VALUES
('Disponível', 2, 1),
('Disponível', 2, 2),
('Ocupada', 4, 3),
('Reservada', 4, 4),
('Disponível', 6, 5),
('Disponível', 6, 6),
('Ocupada', 8, 7),
('Disponível', 8, 8),
('Reservada', 10, 9),
('Disponível', 12, 10);

INSERT INTO usuario (nome, email, senha, cargo) VALUES
('João Gerente', 'gerente@restaurante.com', '123456', 'Gerente'),
('Marina Chef', 'chef@restaurante.com', '123456', 'Chef'),
('Lucas Garçom', 'garcom1@restaurante.com', '123456', 'Garçom'),
('Fernanda Garçom', 'garcom2@restaurante.com', '123456', 'Garçom');

INSERT INTO categoria_prato (nome, descricao) VALUES
('Entradas', 'Pratos para iniciar a refeição'),
('Pratos Principais', 'Pratos principais do cardápio'),
('Sobremesas', 'Sobremesas gourmet'),
('Bebidas', 'Bebidas alcoólicas e não alcoólicas');

INSERT INTO prato (categoria_prato_id, preco, nome, ativo, descricao) VALUES
(1, 38.90, 'Bruschetta Italiana', TRUE, 'Pão artesanal com tomate e manjericão'),
(1, 45.50, 'Carpaccio de Filé', TRUE, 'Finas fatias de filé ao molho especial'),

(2, 120.00, 'Filé Mignon ao Molho Trufado', TRUE, 'Filé mignon com molho de trufas negras'),
(2, 98.50, 'Salmão Grelhado Premium', TRUE, 'Salmão com legumes salteados'),
(2, 89.90, 'Risoto de Camarão', TRUE, 'Risoto cremoso com camarões frescos'),

(3, 32.00, 'Petit Gateau', TRUE, 'Bolo quente de chocolate com sorvete'),
(3, 28.50, 'Cheesecake de Frutas Vermelhas', TRUE, 'Cheesecake artesanal'),

(4, 12.00, 'Água Mineral', TRUE, 'Água mineral sem gás'),
(4, 18.00, 'Suco Natural', TRUE, 'Suco de frutas frescas'),
(4, 45.00, 'Vinho Tinto Taça', TRUE, 'Taça de vinho tinto selecionado');

INSERT INTO reserva (
    cliente_id,
    mesa_id,
    hora_reserva,
    data_reserva,
    status,
    observacoes,
    num_pessoas
) VALUES
(1, 4, '20:00:00', '2025-08-15', 'Confirmada', 'Aniversário de casamento', 4),
(2, 9, '21:00:00', '2025-08-15', 'Pendente', NULL, 8),
(3, 5, '19:30:00', '2025-08-16', 'Confirmada', 'Mesa próxima à janela', 5);

INSERT INTO pedido (mesa_id, usuario_id, status) VALUES
(3, 3, 'Ativa'),
(7, 4, 'Fechada'),
(4, 3, 'Cancelada'),
(5, 4, 'Ativa'),
(2, 3, 'Fechada');

INSERT INTO prato_pedido (
    prato_id,
    pedido_id,
    quantidade,
    preco_unitario
) VALUES

(1, 1, 2, 38.90),
(3, 1, 2, 120.00),
(10, 1, 2, 45.00),

(2, 2, 1, 45.50),
(5, 2, 3, 89.90),
(9, 2, 3, 18.00),

(4, 3, 2, 98.50),
(6, 3, 2, 32.00),
(8, 3, 2, 12.00),

(3, 4, 1, 120.00),
(9, 4, 2, 18.00),

(5, 5, 1, 89.90),
(6, 5, 1, 32.00),
(10, 5, 2, 45.00);

CREATE TABLE pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pendente',
    observacoes VARCHAR(255),
    pago_em TIMESTAMP NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pedido_id) REFERENCES pedido(id)
);

CREATE TABLE fornecedor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(18) UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    categoria VARCHAR(100) NOT NULL,
    contato VARCHAR(100),
    ativo BOOLEAN NOT NULL DEFAULT TRUE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO pagamento (pedido_id, forma_pagamento, valor, status, pago_em) VALUES
(1, 'Crédito', 407.80, 'Pago', NOW()),
(2, 'Débito', 374.20, 'Pago', NOW()),
(3, 'Dinheiro', 283.00, 'Cancelado', NULL),
(4, 'PIX', 156.00, 'Pendente', NULL),
(5, 'Crédito', 211.90, 'Pago', NOW());

INSERT INTO fornecedor (nome, cnpj, telefone, email, categoria, contato, ativo) VALUES
('Frigorífico Premium ES', '12.345.678/0001-90', '2733001100', 'vendas@frigopremium.com.br', 'Carnes', 'Roberta Lima', TRUE),
('Distribuidora Vinhos Sul', '23.456.789/0001-01', '2733002200', 'pedidos@vinhossel.com.br', 'Bebidas', 'Paulo Mendes', TRUE),
('Hortifruti Capixaba', '34.567.890/0001-12', '2799003300', 'contato@hortifruticap.com.br', 'Hortifruti', 'José Neto', TRUE),
('Laticínios Serra Verde', '45.678.901/0001-23', '2733004400', 'vendas@laticiniossv.com.br', 'Laticínios', 'Mariana Costa', TRUE),
('Embalagens FastPack', '56.789.012/0001-34', '2733005500', 'comercial@fastpack.com.br', 'Embalagens', 'Carlos Freitas', FALSE);

