-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/07/2024 às 16:56
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
-- Banco de dados: `sw1ta3bim`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `cat_codigo` int(11) NOT NULL,
  `cat_nome` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `eve_codigo` int(11) NOT NULL,
  `eve_nome` varchar(100) DEFAULT NULL,
  `eve_datainicio` date DEFAULT NULL,
  `eve_datafim` date DEFAULT NULL,
  `eve_descritivo` varchar(5000) DEFAULT NULL,
  `eve_periodo` varchar(20) DEFAULT NULL,
  `eve_area` varchar(50) DEFAULT NULL,
  `eve_local` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `usu_codigo` int(11) NOT NULL,
  `usu_nome` varchar(50) DEFAULT NULL,
  `usu_email` varchar(70) DEFAULT NULL,
  `usu_senha` varchar(20) DEFAULT NULL,
  `usu_cep` varchar(10) DEFAULT NULL,
  `usu_logradouro` varchar(70) DEFAULT NULL,
  `usu_numero` varchar(20) DEFAULT NULL,
  `usu_complemento` varchar(50) DEFAULT NULL,
  `usu_bairro` varchar(40) DEFAULT NULL,
  `usu_cidade` varchar(70) DEFAULT NULL,
  `usu_uf` varchar(2) DEFAULT NULL,
  `cat_codigo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_eventos`
--

CREATE TABLE `usuario_eventos` (
  `usu_codigo` int(11) NOT NULL,
  `eve_codigo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_eventospresenca`
--

CREATE TABLE `usuario_eventospresenca` (
  `usu_codigo` int(11) NOT NULL,
  `eve_codigo` int(11) NOT NULL,
  `uep_codigo` int(11) NOT NULL,
  `uep_data` date DEFAULT NULL,
  `uep_avaliacao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`cat_codigo`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`eve_codigo`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_codigo`),
  ADD KEY `cat_codigo` (`cat_codigo`);

--
-- Índices de tabela `usuario_eventos`
--
ALTER TABLE `usuario_eventos`
  ADD KEY `eve_codigo` (`eve_codigo`),
  ADD KEY `usu_codigo` (`usu_codigo`);

--
-- Índices de tabela `usuario_eventospresenca`
--
ALTER TABLE `usuario_eventospresenca`
  ADD PRIMARY KEY (`usu_codigo`,`eve_codigo`,`uep_codigo`),
  ADD KEY `eve_codigo` (`eve_codigo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `cat_codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `eve_codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`cat_codigo`) REFERENCES `categorias` (`cat_codigo`);

--
-- Restrições para tabelas `usuario_eventos`
--
ALTER TABLE `usuario_eventos`
  ADD CONSTRAINT `usuario_eventos_ibfk_1` FOREIGN KEY (`eve_codigo`) REFERENCES `eventos` (`eve_codigo`),
  ADD CONSTRAINT `usuario_eventos_ibfk_2` FOREIGN KEY (`usu_codigo`) REFERENCES `usuario` (`usu_codigo`);

--
-- Restrições para tabelas `usuario_eventospresenca`
--
ALTER TABLE `usuario_eventospresenca`
  ADD CONSTRAINT `usuario_eventospresenca_ibfk_1` FOREIGN KEY (`eve_codigo`) REFERENCES `eventos` (`eve_codigo`),
  ADD CONSTRAINT `usuario_eventospresenca_ibfk_2` FOREIGN KEY (`usu_codigo`) REFERENCES `usuario` (`usu_codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
