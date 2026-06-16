-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16/06/2026 às 02:23
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `eletrotech`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `slug` varchar(120) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`, `descricao`, `slug`, `ativo`, `created_at`) VALUES
(1, 'Smartphones', 'Celulares e smartphones das melhores marcas', 'smartphones', 1, '2026-05-25 22:53:53'),
(2, 'Notebooks', 'Notebooks e ultrabooks para trabalho e estudo', 'notebooks', 1, '2026-05-25 22:53:53'),
(3, 'Tablets', 'Tablets para produtividade e entretenimento', 'tablets', 1, '2026-05-25 22:53:53'),
(4, 'Áudio', 'Fones de ouvido, caixas de som e acessórios de áudio', 'audio', 1, '2026-05-25 22:53:53'),
(5, 'Televisores', 'Smart TVs e televisores de última geração', 'televisores', 1, '2026-05-25 22:53:53'),
(6, 'Câmeras', 'Câmeras fotográficas e filmadoras digitais', 'cameras', 1, '2026-05-25 22:53:53'),
(7, 'Games', 'Consoles, jogos e acessórios para jogadores', 'games', 1, '2026-05-25 22:53:53'),
(8, 'Acessórios', 'Capas, cabos, carregadores e outros acessórios eletrônicos', 'acessorios', 1, '2026-05-25 22:53:53'),
(9, 'Computadores', 'Desktops e all-in-one para casa e escritório', 'computadores', 1, '2026-05-25 22:53:53'),
(10, 'Wearables', 'Smartwatches, pulseiras fitness e óculos inteligentes', 'wearables', 1, '2026-05-25 22:53:53');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(10) UNSIGNED NOT NULL,
  `pedido_id` int(10) UNSIGNED NOT NULL,
  `produto_id` int(10) UNSIGNED DEFAULT NULL,
  `quantidade` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `preco_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `pedido_id`, `produto_id`, `quantidade`, `preco_unitario`) VALUES
(1, 1, 1, 1, 7499.00),
(2, 2, 11, 1, 1599.90),
(3, 3, 2, 1, 5999.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pendente','processando','enviado','entregue','cancelado') NOT NULL DEFAULT 'pendente',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `status`, `created_at`) VALUES
(1, 2, 7499.00, 'entregue', '2026-04-10 14:30:00'),
(2, 2, 1599.90, 'enviado', '2026-05-01 09:15:00'),
(3, 3, 5999.00, 'pendente', '2026-05-20 16:45:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(10) UNSIGNED NOT NULL,
  `categoria_id` int(10) UNSIGNED DEFAULT NULL,
  `nome` varchar(200) NOT NULL,
  `descricao` text DEFAULT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `preco_promocional` decimal(10,2) DEFAULT NULL,
  `estoque` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `imagem` varchar(255) DEFAULT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  `destaque` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `categoria_id`, `nome`, `descricao`, `marca`, `modelo`, `preco`, `preco_promocional`, `estoque`, `imagem`, `ativo`, `destaque`, `created_at`) VALUES
(1, 1, 'iPhone 15 Pro', 'O iPhone 15 Pro vem com chip A17 Pro, câmera de 48MP com zoom óptico 5x, tela Super Retina XDR de 6.1\" com ProMotion 120Hz e estrutura em titânio. Baterias de longa duração e USB-C.', 'Apple', 'iPhone 15 Pro', 7999.90, 7499.00, 25, NULL, 1, 1, '2026-05-25 22:53:53'),
(2, 1, 'Samsung Galaxy S24 Ultra', 'Galaxy S24 Ultra com processador Snapdragon 8 Gen 3, câmera de 200MP, S Pen integrada, tela Dynamic AMOLED de 6.8\" com 120Hz e bateria de 5000mAh.', 'Samsung', 'Galaxy S24 Ultra', 6499.90, 5999.00, 18, NULL, 1, 1, '2026-05-25 22:53:53'),
(3, 1, 'Xiaomi 14 Ultra', 'Xiaomi 14 Ultra com câmera Leica, Snapdragon 8 Gen 3, tela AMOLED 120Hz de 6.73\", 512GB de armazenamento e carregamento ultra-rápido de 90W.', 'Xiaomi', '14 Ultra', 4999.90, NULL, 30, NULL, 1, 0, '2026-05-25 22:53:53'),
(4, 1, 'Motorola Edge 50 Pro', 'Motorola Edge 50 com câmera de 50MP OIS, tela pOLED 144Hz, Snapdragon 7s Gen 2, carregamento de 125W TurboPower e bateria de 4500mAh.', 'Motorola', 'Edge 50 Pro', 2499.90, 1999.90, 45, NULL, 1, 0, '2026-05-25 22:53:53'),
(5, 2, 'MacBook Pro 14\" M3 Pro', 'MacBook Pro com chip M3 Pro, 18GB RAM, SSD de 512GB, tela Liquid Retina XDR de 14.2\", bateria de até 18 horas e até 14-core GPU. Perfeito para profissionais criativos.', 'Apple', 'MacBook Pro M3 Pro', 16999.90, 15499.00, 10, NULL, 1, 1, '2026-05-25 22:53:53'),
(6, 2, 'Dell XPS 15', 'Dell XPS 15 com Intel Core i7-13700H, 16GB DDR5, SSD 512GB NVMe, GPU NVIDIA RTX 4060, tela OLED 4K de 15.6\" e bateria de 86Wh.', 'Dell', 'XPS 15 9530', 9999.90, 8999.00, 8, NULL, 1, 1, '2026-05-25 22:53:53'),
(7, 2, 'Lenovo ThinkPad X1 Carbon', 'ThinkPad X1 Carbon Gen 12 com Intel Core Ultra 7, 32GB LPDDR5, 1TB SSD, tela IPS 14\" WUXGA e certificação MIL-SPEC. O notebook empresarial definitivo.', 'Lenovo', 'ThinkPad X1 Carbon Gen12', 11499.90, NULL, 5, NULL, 1, 0, '2026-05-25 22:53:53'),
(8, 2, 'Acer Aspire 5', 'Acer Aspire 5 com AMD Ryzen 5 7530U, 8GB RAM, SSD 256GB, tela Full HD de 15.6\" e Windows 11. Excelente custo-benefício para estudantes.', 'Acer', 'Aspire 5 A515-48M', 2799.90, 2499.90, 40, NULL, 1, 0, '2026-05-25 22:53:53'),
(9, 3, 'iPad Pro 12.9\" M4', 'iPad Pro 12.9\" com chip M4, tela Ultra Retina XDR OLED de 13\", Apple Pencil Pro, Wi-Fi 6E e 5G. O tablet mais avançado já criado pela Apple.', 'Apple', 'iPad Pro M4 13\"', 12999.90, NULL, 12, NULL, 1, 1, '2026-05-25 22:53:53'),
(10, 3, 'Samsung Galaxy Tab S9+', 'Galaxy Tab S9+ com tela Dynamic AMOLED 2X de 12.4\", S Pen incluída, Snapdragon 8 Gen 2, 12GB RAM e bateria de 10090mAh. Ideal para criatividade.', 'Samsung', 'Galaxy Tab S9+', 4999.90, 4499.00, 15, NULL, 1, 0, '2026-05-25 22:53:53'),
(11, 4, 'AirPods Pro 2ª Geração', 'AirPods Pro com cancelamento ativo de ruído adaptativo, Transparência Adaptável, chip H2, até 30 horas de bateria com case e som personalizado.', 'Apple', 'AirPods Pro 2nd Gen', 1799.90, 1599.90, 50, NULL, 1, 1, '2026-05-25 22:53:53'),
(12, 4, 'Sony WH-1000XM5', 'Headphone premium Sony com melhor cancelamento de ruído da categoria, 30 horas de bateria, drivers de 30mm e chamadas cristalinas com 8 microfones.', 'Sony', 'WH-1000XM5', 1999.90, 1699.90, 22, NULL, 1, 1, '2026-05-25 22:53:53'),
(13, 4, 'JBL Charge 5', 'Caixa de som JBL à prova d\'água (IP67) com 20W RMS, bateria de 20h, PartyBoost para conectar múltiplas caixas e porta de carregamento USB.', 'JBL', 'Charge 5', 799.90, 649.90, 35, NULL, 1, 0, '2026-05-25 22:53:53'),
(14, 5, 'Samsung Neo QLED 65\" 8K', 'Smart TV Samsung Neo QLED 65\" com resolução 8K, processador Neo Quantum 8K AI, sistema Tizen e painel sem bordas. A imagem mais realista do mercado.', 'Samsung', 'QN800C 65\"', 12999.90, NULL, 3, NULL, 1, 1, '2026-05-25 22:53:53'),
(15, 5, 'LG OLED C3 55\"', 'LG OLED C3 55\" com painel OLED evo, processador α9 Gen6, Game Optimizer com 120Hz, HDMI 2.1 e webOS 23. Referência em qualidade de imagem.', 'LG', 'OLED55C3PSA', 6999.90, 5999.00, 7, NULL, 1, 0, '2026-05-25 22:53:53'),
(16, 7, 'PlayStation 5 Slim', 'PlayStation 5 Slim com leitor de disco, GPU de 10.28 TFLOPS, SSD de 1TB, DualSense com feedback háptico e gatilhos adaptáveis. A próxima geração chegou.', 'Sony', 'PS5 Slim', 3999.90, NULL, 15, NULL, 1, 1, '2026-05-25 22:53:53'),
(17, 7, 'Xbox Series X', 'Xbox Series X com 12 TFLOPS, SSD NVMe de 1TB, suporte a 8K, 120fps e retrocompatibilidade com milhares de jogos. O Xbox mais poderoso de todos os tempos.', 'Microsoft', 'Xbox Series X', 3699.90, 3299.00, 12, NULL, 1, 0, '2026-05-25 22:53:53'),
(18, 6, 'Sony Alpha A7 IV', 'Câmera mirrorless full-frame Sony A7 IV com sensor BSI CMOS de 33MP, processador BIONZ XR, gravação 4K 60fps, Eye Autofocus e bateria de 580 disparos.', 'Sony', 'Alpha A7 IV', 14999.90, NULL, 4, NULL, 1, 0, '2026-05-25 22:53:53'),
(19, 10, 'Apple Watch Series 9', 'Apple Watch Series 9 com chip S9, tela Always-On Retina de 45mm, sensor de temperatura, ECG, SpO2, rastreamento de quedas e bateria de 18 horas.', 'Apple', 'Apple Watch Series 9 45mm', 3499.90, 2999.90, 30, NULL, 1, 1, '2026-05-25 22:53:53'),
(20, 8, 'MagSafe Carregador Apple', 'Carregador MagSafe Apple com alinhamento magnético preciso, carregamento de até 15W para iPhone 12 ou superior e 5W para AirPods.', 'Apple', 'MagSafe Charger', 399.90, NULL, 80, NULL, 1, 0, '2026-05-25 22:53:53'),
(21, 4, 'Fone de Ouvido', 'Fone de ouvido personalizado', 'JBL', '20u3P', 350.00, 315.00, 10, '', 1, 1, '2026-06-15 20:17:33'),
(22, 7, 'Xbox 360', 'Video-Game', 'Xbox', '20pUreL', 1700.00, 1500.00, 21, '', 1, 1, '2026-06-15 20:22:51');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `cpf` char(11) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `senha` varchar(255) NOT NULL,
  `role` enum('cliente','admin') NOT NULL DEFAULT 'cliente',
  `remember_token` varchar(64) DEFAULT NULL,
  `token_expires` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `cpf`, `telefone`, `data_nascimento`, `senha`, `role`, `remember_token`, `token_expires`, `created_at`) VALUES
(1, 'Administrador EletroTech', 'admin@eletrotech.com', '00000000001', '(11) 9999-9999', '1990-01-15', '$2y$12$FOIFfNaYiaKFC2fqVKOBT.f1Pqb.A88FXQOnBGHmP/UwDiJkN9nCu', 'admin', NULL, NULL, '2026-05-25 22:53:53'),
(2, 'João da Silva', 'cliente@teste.com', '12345678901', '(11) 98765-4321', '1995-06-20', '$2y$12$0aNWoh0K3cOXCaLsTrgp7OzIKGLFxUgZUGyTso0KCQfKNvTBxbt6S', 'cliente', NULL, NULL, '2026-05-25 22:53:53'),
(3, 'Maria Oliveira', 'maria@teste.com', '98765432100', '(21) 91234-5678', '1988-03-10', '$2y$12$0aNWoh0K3cOXCaLsTrgp7OzIKGLFxUgZUGyTso0KCQfKNvTBxbt6S', 'cliente', NULL, NULL, '2026-05-25 22:53:53');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_slug` (`slug`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pedido` (`pedido_id`),
  ADD KEY `idx_produto` (`produto_id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario` (`usuario_id`),
  ADD KEY `idx_status` (`status`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_categoria` (`categoria_id`),
  ADD KEY `idx_ativo` (`ativo`),
  ADD KEY `idx_destaque` (`destaque`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_email` (`email`),
  ADD UNIQUE KEY `uk_cpf` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_item_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_item_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
