-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/05/2026 às 18:29
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
-- Banco de dados: `pbe1comercios1a`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nomeCliente` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `estadoCivil` varchar(50) DEFAULT NULL,
  `quantidadeDependentes` int(11) DEFAULT NULL,
  `renda` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nomeCliente`, `email`, `telefone`, `estadoCivil`, `quantidadeDependentes`, `renda`) VALUES
(1, 'João Silva', 'joao@email.com', '11999999999', 'Solteiro', 0, 2057.00),
(2, 'Maria Souza', 'maria@gmail.com', '11988887777', 'Casada', 2, 3500.00),
(3, 'Carlos Pereira', 'carlos@gmail.com', '11977776666', 'Solteiro', 1, 2800.00),
(5, 'Pedro Santos', 'pedro@gmail.com', '11955554444', 'Casado', 3, 5100.00),
(6, 'Juliana Lima', 'juliana@gmail.com', '11944443333', 'Divorciada', 1, 3900.00),
(9, 'Lucas Rocha', 'lucas@gmail.com', '11911119999', 'Solteiro', 0, 1800.00),
(11, 'Gabriel Ferreira', 'gabriel@gmail.com', '11912121212', 'Casado', 4, 7200.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimento`
--

CREATE TABLE `movimento` (
  `idMovimento` int(11) NOT NULL,
  `idProduto` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,
  `tipoMovimento` varchar(20) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `dataMovimento` datetime NOT NULL,
  `observacao` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimento`
--

INSERT INTO `movimento` (`idMovimento`, `idProduto`, `idCliente`, `tipoMovimento`, `quantidade`, `dataMovimento`, `observacao`) VALUES
(1, 1, 1, 'ENTRADA', 10, '2026-05-18 15:20:02', 'Reposição de estoque inicial'),
(2, 2, 2, 'SAIDA', 2, '2026-05-18 15:20:02', 'Venda de mouse gamer'),
(3, 3, 3, 'SAIDA', 1, '2026-05-18 15:20:02', 'Venda de monitor'),
(4, 1, 2, 'SAIDA', 1, '2026-05-18 15:20:02', 'Venda de teclado'),
(5, 4, 1, 'ENTRADA', 5, '2026-05-18 15:20:02', 'Entrada de notebooks'),
(6, 5, 3, 'SAIDA', 1, '2026-05-18 15:20:02', 'Venda de cadeira gamer'),
(7, 2, 1, 'ENTRADA', 15, '2026-05-18 15:20:02', 'Reposição de mouses'),
(8, 6, 2, 'SAIDA', 3, '2026-05-18 15:20:02', 'Venda de mesas'),
(9, 3, 1, 'ENTRADA', 4, '2026-05-18 15:20:02', 'Reposição de monitores'),
(10, 4, 3, 'SAIDA', 1, '2026-05-18 15:20:02', 'Venda de notebook'),
(11, 9, 11, 'SAIDA', 10, '2026-05-19 14:38:51', 'Venda de smartphone');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `id` int(11) NOT NULL,
  `nomeProduto` varchar(100) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `preco` decimal(10,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`id`, `nomeProduto`, `descricao`, `preco`, `quantidade`, `categoria`) VALUES
(1, 'Teclado', 'Teclado mecânico', 120.00, 10, 'Eletrônico'),
(3, 'Teclado Mecânico', 'Teclado gamer com LED RGB', 199.90, 15, 'Eletrônicos'),
(6, 'Notebook Lenovo', 'Notebook i5 8GB RAM SSD 256GB', 3200.00, 5, 'Eletrônicos'),
(9, 'Smartphone Samsung', '128GB câmera tripla', 1800.00, 10, 'Eletrônicos'),
(12, 'Pen Drive 64GB', 'USB 3.0 alta velocidade', 45.90, 50, 'Eletrônicos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nomeUsuario`, `senhaUsuario`) VALUES
(1, 'admin', '123');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `movimento`
--
ALTER TABLE `movimento`
  ADD PRIMARY KEY (`idMovimento`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `movimento`
--
ALTER TABLE `movimento`
  MODIFY `idMovimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
