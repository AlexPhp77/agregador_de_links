-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 21-Abr-2020 às 00:40
-- Versão do servidor: 5.7.26
-- versão do PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `agregador_links`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `anuncios`
--

DROP TABLE IF EXISTS `anuncios`;
CREATE TABLE IF NOT EXISTS `anuncios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `descricao` text NOT NULL,
  `ativado` tinyint(4) DEFAULT NULL,
  `link` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `anuncios`
--

INSERT INTO `anuncios` (`id`, `id_usuario`, `id_categoria`, `titulo`, `descricao`, `ativado`, `link`) VALUES
(105, 44, 1, 'dfdddddddddddd', 'dfffffffffffffffffffff', 0, 'http://www.themezaa.com/html/pofo/home-classic-corporate.html'),
(106, 44, 3, 'teste cafÃ©', 'dffffffffffffffff', 1, 'http://www.themezaa.com/html/pofo/home-classic-corporate.html'),
(104, 44, 1, 'teste cafÃ©', 'fdddddddddddddddddd', 1, 'http://www.themezaa.com/html/pofo/home-classic-corporate.html'),
(102, 44, 4, 'Batedeira 22', 'fdddddddddddddddddddddd', 0, 'http://www.themezaa.com/html/pofo/home-classic-corporate.html'),
(103, 44, 4, 'Tenis nike', 'fddddddddddddddddddddddd', 0, 'http://www.themezaa.com/html/pofo/home-classic-corporate.html'),
(100, 44, 5, 'Estou editando para teste', 'Editando para novos testes', 0, 'http://www.themezaa.com/html/pofo/home-classic-corporate.html'),
(101, 44, 1, 'Teste para tÃ­tulo', 'fdddddddddddddddddddddddddd', 1, 'http://www.themezaa.com/html/pofo/home-classic-corporate.html');

-- --------------------------------------------------------

--
-- Estrutura da tabela `anuncios_imagens`
--

DROP TABLE IF EXISTS `anuncios_imagens`;
CREATE TABLE IF NOT EXISTS `anuncios_imagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_anuncio` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=352 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `anuncios_imagens`
--

INSERT INTO `anuncios_imagens` (`id`, `id_anuncio`, `url`) VALUES
(351, 106, 'url_imagem'),
(347, 102, '53e827fd5deb4f3bd9b6e273c6a17232.jpg'),
(348, 103, '17db3302437973ddbfa389a75b0a295c.jpg'),
(349, 104, 'url_imagem'),
(350, 105, '05d173f54c81846f7c260e5c262735c4.jpg'),
(345, 100, '88f479e670e19ca0b3bf6e9e6dd103de.jpg'),
(346, 101, 'url_imagem');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'humor'),
(2, 'esportes'),
(3, 'saúde'),
(4, 'notícias'),
(5, 'outros');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(32) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `permissoes` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `telefone`, `permissoes`) VALUES
(52, 'Henrique', 'dragaoguerreiro569@gmail.com', '9265727dadab8e2166cfb02d6e861cde', NULL, NULL),
(51, 'VitÃ³ria SÃ©kula Gutubir', 'vitoria@gmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, NULL),
(44, 'alex', 'alex.rai@hotmail.com', '25d55ad283aa400af464c76d713c07ad', NULL, 'ADMINISTRADOR');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
