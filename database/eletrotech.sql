-- ============================================================
--  EletroTech - Banco de Dados MySQL
--  Versão: 1.0.0
--  Charset: utf8mb4
--
--  COMO IMPORTAR:
--  1. Acesse o phpMyAdmin: http://localhost/phpmyadmin
--  2. Crie o banco de dados 'eletrotech' (ou use o script abaixo)
--  3. Selecione o banco 'eletrotech'
--  4. Clique em 'Importar' e selecione este arquivo
--     OU via terminal: mysql -u root -p eletrotech < eletrotech.sql
--
--  CREDENCIAIS PADRÃO:
--  Usuário BD: root
--  Senha BD:   (vazio no XAMPP padrão)
--  Banco:      eletrotech
--
--  USUÁRIOS DE TESTE:
--  Admin:   admin@eletrotech.com / admin123
--  Cliente: cliente@teste.com / cliente123
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- Cria o banco se não existir
-- ============================================================
CREATE DATABASE IF NOT EXISTS `eletrotech`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `eletrotech`;

-- ============================================================
-- Tabela: categorias
-- ============================================================
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome`       VARCHAR(100) NOT NULL,
    `descricao`  TEXT DEFAULT NULL,
    `slug`       VARCHAR(120) NOT NULL,
    `ativo`      TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Tabela: usuarios
-- ============================================================
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome`            VARCHAR(150) NOT NULL,
    `email`           VARCHAR(150) NOT NULL,
    `cpf`             CHAR(11) DEFAULT NULL,
    `telefone`        VARCHAR(20)  DEFAULT NULL,
    `data_nascimento` DATE         DEFAULT NULL,
    `senha`           VARCHAR(255) NOT NULL,
    `role`            ENUM('cliente','admin') NOT NULL DEFAULT 'cliente',
    `remember_token`  VARCHAR(64)  DEFAULT NULL,
    `token_expires`   DATETIME     DEFAULT NULL,
    `created_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_email` (`email`),
    UNIQUE KEY `uk_cpf`   (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Tabela: produtos
-- ============================================================
DROP TABLE IF EXISTS `produtos`;
CREATE TABLE `produtos` (
    `id`                INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `categoria_id`      INT UNSIGNED DEFAULT NULL,
    `nome`              VARCHAR(200) NOT NULL,
    `descricao`         TEXT         DEFAULT NULL,
    `marca`             VARCHAR(100) DEFAULT NULL,
    `modelo`            VARCHAR(100) DEFAULT NULL,
    `preco`             DECIMAL(10,2) NOT NULL,
    `preco_promocional` DECIMAL(10,2) DEFAULT NULL,
    `estoque`           INT UNSIGNED NOT NULL DEFAULT 0,
    `imagem`            VARCHAR(255) DEFAULT NULL,
    `ativo`             TINYINT(1) NOT NULL DEFAULT 1,
    `destaque`          TINYINT(1) NOT NULL DEFAULT 0,
    `created_at`        DATETIME    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_categoria` (`categoria_id`),
    KEY `idx_ativo`     (`ativo`),
    KEY `idx_destaque`  (`destaque`),
    CONSTRAINT `fk_produto_categoria`
        FOREIGN KEY (`categoria_id`) REFERENCES `categorias`(`id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Tabela: pedidos
-- ============================================================
DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `usuario_id`  INT UNSIGNED NOT NULL,
    `total`       DECIMAL(10,2) NOT NULL,
    `status`      ENUM('pendente','processando','enviado','entregue','cancelado') NOT NULL DEFAULT 'pendente',
    `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_usuario` (`usuario_id`),
    KEY `idx_status`  (`status`),
    CONSTRAINT `fk_pedido_usuario`
        FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- Tabela: itens_pedido
-- ============================================================
DROP TABLE IF EXISTS `itens_pedido`;
CREATE TABLE `itens_pedido` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `pedido_id`       INT UNSIGNED NOT NULL,
    `produto_id`      INT UNSIGNED DEFAULT NULL,
    `quantidade`      INT UNSIGNED NOT NULL DEFAULT 1,
    `preco_unitario`  DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_pedido`  (`pedido_id`),
    KEY `idx_produto` (`produto_id`),
    CONSTRAINT `fk_item_pedido`
        FOREIGN KEY (`pedido_id`) REFERENCES `pedidos`(`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_item_produto`
        FOREIGN KEY (`produto_id`) REFERENCES `produtos`(`id`)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- DADOS INICIAIS
-- ============================================================

-- Categorias
INSERT INTO `categorias` (`nome`, `descricao`, `slug`, `ativo`) VALUES
('Smartphones',     'Celulares e smartphones das melhores marcas',               'smartphones',     1),
('Notebooks',       'Notebooks e ultrabooks para trabalho e estudo',             'notebooks',       1),
('Tablets',         'Tablets para produtividade e entretenimento',               'tablets',         1),
('Áudio',           'Fones de ouvido, caixas de som e acessórios de áudio',      'audio',           1),
('Televisores',     'Smart TVs e televisores de última geração',                 'televisores',     1),
('Câmeras',         'Câmeras fotográficas e filmadoras digitais',                'cameras',         1),
('Games',           'Consoles, jogos e acessórios para jogadores',               'games',           1),
('Acessórios',      'Capas, cabos, carregadores e outros acessórios eletrônicos','acessorios',      1),
('Computadores',    'Desktops e all-in-one para casa e escritório',              'computadores',    1),
('Wearables',       'Smartwatches, pulseiras fitness e óculos inteligentes',     'wearables',       1);

-- Usuários (senhas criptografadas com password_hash + bcrypt)
-- Admin:   admin@eletrotech.com / admin123
-- Cliente: cliente@teste.com / cliente123
INSERT INTO `usuarios` (`nome`, `email`, `cpf`, `telefone`, `data_nascimento`, `senha`, `role`) VALUES
(
    'Administrador EletroTech',
    'admin@eletrotech.com',
    '00000000001',
    '(11) 9999-9999',
    '1990-01-15',
    '$2y$12$FOIFfNaYiaKFC2fqVKOBT.f1Pqb.A88FXQOnBGHmP/UwDiJkN9nCu',
    'admin'
),
(
    'João da Silva',
    'cliente@teste.com',
    '12345678901',
    '(11) 98765-4321',
    '1995-06-20',
    '$2y$12$0aNWoh0K3cOXCaLsTrgp7OzIKGLFxUgZUGyTso0KCQfKNvTBxbt6S',
    'cliente'
),
(
    'Maria Oliveira',
    'maria@teste.com',
    '98765432100',
    '(21) 91234-5678',
    '1988-03-10',
    '$2y$12$0aNWoh0K3cOXCaLsTrgp7OzIKGLFxUgZUGyTso0KCQfKNvTBxbt6S',
    'cliente'
);

-- Produtos
INSERT INTO `produtos` (`categoria_id`, `nome`, `descricao`, `marca`, `modelo`, `preco`, `preco_promocional`, `estoque`, `ativo`, `destaque`) VALUES
-- Smartphones
(1, 'iPhone 15 Pro',
    'O iPhone 15 Pro vem com chip A17 Pro, câmera de 48MP com zoom óptico 5x, tela Super Retina XDR de 6.1" com ProMotion 120Hz e estrutura em titânio. Baterias de longa duração e USB-C.',
    'Apple', 'iPhone 15 Pro', 7999.90, 7499.00, 25, 1, 1),

(1, 'Samsung Galaxy S24 Ultra',
    'Galaxy S24 Ultra com processador Snapdragon 8 Gen 3, câmera de 200MP, S Pen integrada, tela Dynamic AMOLED de 6.8" com 120Hz e bateria de 5000mAh.',
    'Samsung', 'Galaxy S24 Ultra', 6499.90, 5999.00, 18, 1, 1),

(1, 'Xiaomi 14 Ultra',
    'Xiaomi 14 Ultra com câmera Leica, Snapdragon 8 Gen 3, tela AMOLED 120Hz de 6.73", 512GB de armazenamento e carregamento ultra-rápido de 90W.',
    'Xiaomi', '14 Ultra', 4999.90, NULL, 30, 1, 0),

(1, 'Motorola Edge 50 Pro',
    'Motorola Edge 50 com câmera de 50MP OIS, tela pOLED 144Hz, Snapdragon 7s Gen 2, carregamento de 125W TurboPower e bateria de 4500mAh.',
    'Motorola', 'Edge 50 Pro', 2499.90, 1999.90, 45, 1, 0),

-- Notebooks
(2, 'MacBook Pro 14" M3 Pro',
    'MacBook Pro com chip M3 Pro, 18GB RAM, SSD de 512GB, tela Liquid Retina XDR de 14.2", bateria de até 18 horas e até 14-core GPU. Perfeito para profissionais criativos.',
    'Apple', 'MacBook Pro M3 Pro', 16999.90, 15499.00, 10, 1, 1),

(2, 'Dell XPS 15',
    'Dell XPS 15 com Intel Core i7-13700H, 16GB DDR5, SSD 512GB NVMe, GPU NVIDIA RTX 4060, tela OLED 4K de 15.6" e bateria de 86Wh.',
    'Dell', 'XPS 15 9530', 9999.90, 8999.00, 8, 1, 1),

(2, 'Lenovo ThinkPad X1 Carbon',
    'ThinkPad X1 Carbon Gen 12 com Intel Core Ultra 7, 32GB LPDDR5, 1TB SSD, tela IPS 14" WUXGA e certificação MIL-SPEC. O notebook empresarial definitivo.',
    'Lenovo', 'ThinkPad X1 Carbon Gen12', 11499.90, NULL, 5, 1, 0),

(2, 'Acer Aspire 5',
    'Acer Aspire 5 com AMD Ryzen 5 7530U, 8GB RAM, SSD 256GB, tela Full HD de 15.6" e Windows 11. Excelente custo-benefício para estudantes.',
    'Acer', 'Aspire 5 A515-48M', 2799.90, 2499.90, 40, 1, 0),

-- Tablets
(3, 'iPad Pro 12.9" M4',
    'iPad Pro 12.9" com chip M4, tela Ultra Retina XDR OLED de 13", Apple Pencil Pro, Wi-Fi 6E e 5G. O tablet mais avançado já criado pela Apple.',
    'Apple', 'iPad Pro M4 13"', 12999.90, NULL, 12, 1, 1),

(3, 'Samsung Galaxy Tab S9+',
    'Galaxy Tab S9+ com tela Dynamic AMOLED 2X de 12.4", S Pen incluída, Snapdragon 8 Gen 2, 12GB RAM e bateria de 10090mAh. Ideal para criatividade.',
    'Samsung', 'Galaxy Tab S9+', 4999.90, 4499.00, 15, 1, 0),

-- Áudio
(4, 'AirPods Pro 2ª Geração',
    'AirPods Pro com cancelamento ativo de ruído adaptativo, Transparência Adaptável, chip H2, até 30 horas de bateria com case e som personalizado.',
    'Apple', 'AirPods Pro 2nd Gen', 1799.90, 1599.90, 50, 1, 1),

(4, 'Sony WH-1000XM5',
    'Headphone premium Sony com melhor cancelamento de ruído da categoria, 30 horas de bateria, drivers de 30mm e chamadas cristalinas com 8 microfones.',
    'Sony', 'WH-1000XM5', 1999.90, 1699.90, 22, 1, 1),

(4, 'JBL Charge 5',
    'Caixa de som JBL à prova d\'água (IP67) com 20W RMS, bateria de 20h, PartyBoost para conectar múltiplas caixas e porta de carregamento USB.',
    'JBL', 'Charge 5', 799.90, 649.90, 35, 1, 0),

-- Televisores
(5, 'Samsung Neo QLED 65" 8K',
    'Smart TV Samsung Neo QLED 65" com resolução 8K, processador Neo Quantum 8K AI, sistema Tizen e painel sem bordas. A imagem mais realista do mercado.',
    'Samsung', 'QN800C 65"', 12999.90, NULL, 3, 1, 1),

(5, 'LG OLED C3 55"',
    'LG OLED C3 55" com painel OLED evo, processador α9 Gen6, Game Optimizer com 120Hz, HDMI 2.1 e webOS 23. Referência em qualidade de imagem.',
    'LG', 'OLED55C3PSA', 6999.90, 5999.00, 7, 1, 0),

-- Games
(7, 'PlayStation 5 Slim',
    'PlayStation 5 Slim com leitor de disco, GPU de 10.28 TFLOPS, SSD de 1TB, DualSense com feedback háptico e gatilhos adaptáveis. A próxima geração chegou.',
    'Sony', 'PS5 Slim', 3999.90, NULL, 15, 1, 1),

(7, 'Xbox Series X',
    'Xbox Series X com 12 TFLOPS, SSD NVMe de 1TB, suporte a 8K, 120fps e retrocompatibilidade com milhares de jogos. O Xbox mais poderoso de todos os tempos.',
    'Microsoft', 'Xbox Series X', 3699.90, 3299.00, 12, 1, 0),

-- Câmeras
(6, 'Sony Alpha A7 IV',
    'Câmera mirrorless full-frame Sony A7 IV com sensor BSI CMOS de 33MP, processador BIONZ XR, gravação 4K 60fps, Eye Autofocus e bateria de 580 disparos.',
    'Sony', 'Alpha A7 IV', 14999.90, NULL, 4, 1, 0),

-- Wearables
(10, 'Apple Watch Series 9',
    'Apple Watch Series 9 com chip S9, tela Always-On Retina de 45mm, sensor de temperatura, ECG, SpO2, rastreamento de quedas e bateria de 18 horas.',
    'Apple', 'Apple Watch Series 9 45mm', 3499.90, 2999.90, 30, 1, 1),

-- Acessórios
(8, 'MagSafe Carregador Apple',
    'Carregador MagSafe Apple com alinhamento magnético preciso, carregamento de até 15W para iPhone 12 ou superior e 5W para AirPods.',
    'Apple', 'MagSafe Charger', 399.90, NULL, 80, 1, 0);

-- Pedidos de exemplo
INSERT INTO `pedidos` (`usuario_id`, `total`, `status`, `created_at`) VALUES
(2, 7499.00, 'entregue', '2026-04-10 14:30:00'),
(2, 1599.90, 'enviado',  '2026-05-01 09:15:00'),
(3, 5999.00, 'pendente', '2026-05-20 16:45:00');

-- Itens dos pedidos
INSERT INTO `itens_pedido` (`pedido_id`, `produto_id`, `quantidade`, `preco_unitario`) VALUES
(1, 1,  1, 7499.00),  -- iPhone 15 Pro
(2, 11, 1, 1599.90),  -- AirPods Pro
(3, 2,  1, 5999.00);  -- Galaxy S24 Ultra

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- VERIFICAÇÃO: Confira se tudo foi criado corretamente
-- ============================================================
-- SELECT 'Categorias' AS tabela, COUNT(*) AS registros FROM categorias
-- UNION ALL
-- SELECT 'Usuarios',  COUNT(*) FROM usuarios
-- UNION ALL
-- SELECT 'Produtos',  COUNT(*) FROM produtos
-- UNION ALL
-- SELECT 'Pedidos',   COUNT(*) FROM pedidos;
