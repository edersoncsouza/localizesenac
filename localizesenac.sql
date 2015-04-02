-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 02-Abr-2015 às 20:43
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `localizesenac`
--
CREATE DATABASE IF NOT EXISTS `localizesenac` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `localizesenac`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

CREATE TABLE IF NOT EXISTS `aluno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ativo` enum('N','S') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `NR_MATRICULA` (`matricula`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_disciplina`
--

CREATE TABLE IF NOT EXISTS `aluno_disciplina` (
  `id` int(11) NOT NULL,
  `dia_semana` char(3) NOT NULL,
  `turno` char(1) NOT NULL,
  `fk_id_aluno` int(11) NOT NULL,
  `fk_sala_fk_id_unidade` int(11) NOT NULL,
  `fk_andar_sala` tinyint(4) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL,
  `fk_id_disciplina` int(11) NOT NULL,
  KEY `fk_aluno_disciplina_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_aluno_disciplina_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`),
  KEY `fk_aluno_disciplina_disciplina1_idx` (`fk_id_disciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `area_ensino`
--

CREATE TABLE IF NOT EXISTS `area_ensino` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `fk_id_nivel` tinyint(4) NOT NULL,
  `descricao` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_nivel` (`fk_id_nivel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Extraindo dados da tabela `area_ensino`
--

INSERT INTO `area_ensino` (`id`, `fk_id_nivel`, `descricao`) VALUES
(1, 2, 'Meio Ambiente'),
(2, 2, 'Beleza'),
(3, 2, 'Comércio'),
(4, 2, 'Comunicação'),
(5, 2, 'Design'),
(6, 2, 'Gastronomia'),
(7, 2, 'Gestão'),
(8, 2, 'Idiomas'),
(9, 2, 'Informática'),
(10, 2, 'Moda'),
(11, 2, 'Saúde'),
(12, 2, 'Segurança'),
(13, 2, 'Trânsito'),
(14, 2, 'Turismo'),
(15, 2, 'Zeladoria');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `parametro_imagem` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `parametro_imagem`) VALUES
(1, 'Apoio', 'glyphicon-wrench');

-- --------------------------------------------------------

--
-- Estrutura da tabela `coordenadas`
--

CREATE TABLE IF NOT EXISTS `coordenadas` (
  `id` int(11) NOT NULL,
  `coordenada` decimal(25,0) NOT NULL,
  `sala_fk_id_unidade` int(11) NOT NULL,
  `sala_andar` tinyint(4) NOT NULL,
  `sala_numero` int(11) NOT NULL,
  PRIMARY KEY (`coordenada`),
  KEY `fk_coordenadas_sala1_idx` (`sala_fk_id_unidade`,`sala_andar`,`sala_numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

CREATE TABLE IF NOT EXISTS `curso` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `fk_id_nivel_ensino` tinyint(4) NOT NULL,
  `fk_id_area_ensino` tinyint(4) NOT NULL,
  `descricao` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_nivel_ensino` (`fk_id_nivel_ensino`),
  KEY `fk_id_area_ensino` (`fk_id_area_ensino`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id`, `fk_id_nivel_ensino`, `fk_id_area_ensino`, `descricao`) VALUES
(1, 1, 5, 'Produção Multimidia'),
(2, 1, 7, 'Bacharelado em Administração'),
(3, 1, 7, 'Gestão em Recursos Humanos'),
(4, 1, 7, 'Gestão Financeira'),
(5, 1, 7, 'Logística'),
(6, 1, 7, 'Marketing'),
(7, 1, 9, 'Análise e Desenvolvimento de Sistemas'),
(8, 1, 9, 'Redes de Computadores'),
(9, 1, 14, 'Hotelaria'),
(10, 1, 10, 'Design de Moda');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE IF NOT EXISTS `disciplina` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creditos` tinyint(4) DEFAULT '4',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=31 ;

--
-- Extraindo dados da tabela `disciplina`
--

INSERT INTO `disciplina` (`id`, `nome`, `creditos`) VALUES
(1, 'Algoritmos e Programação I', 4),
(2, 'Fundamentos de Informática', 4),
(3, 'Laboratório de Programação I', 4),
(4, 'Matemática Aplicada', 4),
(5, 'Sistemas de Informação e Processos', 4),
(6, 'Algoritmos e Programação II', 4),
(7, 'Banco de Dados I', 4),
(8, 'Engenharia de Software I', 4),
(9, 'Organização de Computadores', 4),
(10, 'Programação para Internet I', 4),
(11, 'Algoritmos e Programação III', 4),
(12, 'Banco de Dados II', 4),
(13, 'Engenharia de Software II', 4),
(14, 'Ética, Cidadania e Sustentabilidade (EAD)', 4),
(15, 'Interface Homem Computador', 4),
(16, 'Laboratório de Programação II', 4),
(17, 'Comunicação e Expressão (EAD)', 4),
(18, 'Engenharia de Software III', 4),
(19, 'Programação para Internet II', 4),
(20, 'Projeto de Desenvolvimento', 4),
(21, 'Sistemas Operacionais', 4),
(22, 'Gerência de Projetos', 4),
(23, 'Qualidade de Software', 4),
(24, 'Redes de Computadores I', 4),
(25, 'Sistemas Distribuídos', 4),
(26, 'TCC I', 4),
(27, 'Empreendedorismo (EAD)', 4),
(28, 'Gestão da TI', 4),
(29, 'Língua Brasileira De Sinais - Libras', 4),
(30, 'Segurança de Sistemas', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina_curso`
--

CREATE TABLE IF NOT EXISTS `disciplina_curso` (
  `fk_id_disciplina` int(11) NOT NULL,
  `fk_id_curso` int(3) NOT NULL,
  KEY `fk_disciplina_curso_disciplina1_idx` (`fk_id_disciplina`),
  KEY `fk_disciplina_curso_curso1_idx` (`fk_id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento_aluno`
--

CREATE TABLE IF NOT EXISTS `evento_aluno` (
  `id` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `dia_semana` char(3) NOT NULL,
  `fk_id_aluno` int(11) NOT NULL,
  `fk_sala_fk_id_unidade` int(11) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL,
  `fk_andar_sala` tinyint(4) NOT NULL,
  `dt_inicio` date NOT NULL,
  `dt_final` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evento_aluno_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_evento_aluno_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `info_locais`
--

CREATE TABLE IF NOT EXISTS `info_locais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `horario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fk_sala_fk_id_unidade` int(11) NOT NULL,
  `fk_andar_sala` tinyint(4) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_info_locais_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_ensino`
--

CREATE TABLE IF NOT EXISTS `nivel_ensino` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `nivel_ensino`
--

INSERT INTO `nivel_ensino` (`id`, `descricao`) VALUES
(1, 'Técnico'),
(2, 'Livre'),
(3, 'Graduação'),
(4, 'Extensão'),
(5, 'Pós-Graduação');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_ensino_area`
--

CREATE TABLE IF NOT EXISTS `nivel_ensino_area` (
  `fk_id_area_ensino` tinyint(4) NOT NULL,
  `fk_id_nivel_ensino` tinyint(4) NOT NULL,
  KEY `fk_nivelensinoarea_area_ensino1_idx` (`fk_id_area_ensino`),
  KEY `fk_nivelensinoarea_nivel_ensino1_idx` (`fk_id_nivel_ensino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala`
--

CREATE TABLE IF NOT EXISTS `sala` (
  `id` int(11) NOT NULL,
  `fk_id_unidade` int(11) NOT NULL,
  `andar` tinyint(4) NOT NULL,
  `numero` int(11) NOT NULL,
  `fk_id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`fk_id_unidade`,`andar`,`numero`),
  KEY `fk_sala_unidade1_idx` (`fk_id_unidade`),
  KEY `fk_sala_categoria1_idx` (`fk_id_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade`
--

CREATE TABLE IF NOT EXISTS `unidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `endereco` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `aluno_disciplina`
--
ALTER TABLE `aluno_disciplina`
  ADD CONSTRAINT `fk_aluno_disciplina_aluno1` FOREIGN KEY (`fk_id_aluno`) REFERENCES `aluno` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aluno_disciplina_disciplina1` FOREIGN KEY (`fk_id_disciplina`) REFERENCES `disciplina` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_aluno_disciplina_sala1` FOREIGN KEY (`fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`) REFERENCES `sala` (`fk_id_unidade`, `andar`, `numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `coordenadas`
--
ALTER TABLE `coordenadas`
  ADD CONSTRAINT `fk_coordenadas_sala1` FOREIGN KEY (`sala_fk_id_unidade`, `sala_andar`, `sala_numero`) REFERENCES `sala` (`fk_id_unidade`, `andar`, `numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `curso`
--
ALTER TABLE `curso`
  ADD CONSTRAINT `fk_curso_nivel_ensino1` FOREIGN KEY (`fk_id_nivel_ensino`) REFERENCES `nivel_ensino` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `disciplina_curso`
--
ALTER TABLE `disciplina_curso`
  ADD CONSTRAINT `fk_disciplina_curso_curso1` FOREIGN KEY (`fk_id_curso`) REFERENCES `curso` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_disciplina_curso_disciplina1` FOREIGN KEY (`fk_id_disciplina`) REFERENCES `disciplina` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `evento_aluno`
--
ALTER TABLE `evento_aluno`
  ADD CONSTRAINT `fk_evento_aluno_aluno1` FOREIGN KEY (`fk_id_aluno`) REFERENCES `aluno` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_evento_aluno_sala1` FOREIGN KEY (`fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`) REFERENCES `sala` (`fk_id_unidade`, `andar`, `numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `info_locais`
--
ALTER TABLE `info_locais`
  ADD CONSTRAINT `fk_info_locais_sala1` FOREIGN KEY (`fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`) REFERENCES `sala` (`fk_id_unidade`, `andar`, `numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `nivel_ensino_area`
--
ALTER TABLE `nivel_ensino_area`
  ADD CONSTRAINT `fk_nivelensinoarea_area_ensino1` FOREIGN KEY (`fk_id_area_ensino`) REFERENCES `area_ensino` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nivelensinoarea_nivel_ensino1` FOREIGN KEY (`fk_id_nivel_ensino`) REFERENCES `nivel_ensino` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `sala`
--
ALTER TABLE `sala`
  ADD CONSTRAINT `fk_sala_unidade1` FOREIGN KEY (`fk_id_unidade`) REFERENCES `unidade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sala_categoria1` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
