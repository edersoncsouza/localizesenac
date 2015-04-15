-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 15-Abr-2015 às 19:14
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id`, `matricula`, `senha`, `nome`, `celular`, `email`, `ativo`) VALUES
(2, '630610028', 'qaz123', 'Ederson Souza', NULL, 'edersonadssenac@gmail.com', 'S'),
(3, 'aline', 'qaz123', 'Aline de Campos', NULL, 'alinedecampos@gmail.com', 'S');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_disciplina`
--

CREATE TABLE IF NOT EXISTS `aluno_disciplina` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dia_semana` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `turno` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `fk_id_aluno` int(11) NOT NULL,
  `fk_sala_fk_id_unidade` int(11) NOT NULL,
  `fk_andar_sala` tinyint(4) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL,
  `fk_id_disciplina` int(11) NOT NULL,
  KEY `id` (`id`),
  KEY `fk_aluno_disciplina_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_aluno_disciplina_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`),
  KEY `fk_aluno_disciplina_disciplina1_idx` (`fk_id_disciplina`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `aluno_disciplina`
--

INSERT INTO `aluno_disciplina` (`id`, `dia_semana`, `turno`, `fk_id_aluno`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`, `fk_id_disciplina`) VALUES
(1, 'SEG', 'N', 2, 1, 3, 301, 32),
(2, 'TER', 'N', 2, 1, 6, 603, 30),
(3, 'QUA', 'N', 2, 1, 6, 603, 28),
(4, 'QUI', 'N', 2, 1, 4, 409, 31),
(5, 'SEX', 'N', 2, 1, 7, 704, 23);

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
(1, 5, 'Ambiente'),
(2, 5, 'Beleza'),
(3, 3, 'Comércio'),
(4, 2, 'Comunicação'),
(5, 1, 'Design'),
(6, 5, 'Gastronomia'),
(7, 1, 'Gestão'),
(8, 5, 'Idiomas'),
(9, 1, 'Informática'),
(10, 1, 'Moda'),
(11, 4, 'Saúde'),
(12, 4, 'Segurança'),
(13, 5, 'Trânsito'),
(14, 1, 'Turismo'),
(15, 5, 'Zeladoria');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parametro_imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`nome`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`id`, `nome`, `parametro_imagem`) VALUES
(5, 'Acessos', 'glyphicon glyphicon-screenshot'),
(3, 'Alimentação', 'glyphicon glyphicon glyphicon-cutlery'),
(6, 'Apoio', 'glyphicon glyphicon-wrench'),
(2, 'Salas de Aula', 'glyphicon glyphicon glyphicon-book'),
(4, 'Serviços', 'glyphicon glyphicon glyphicon-list-alt'),
(1, 'Serviços Administrativos', 'glyphicon glyphicon glyphicon-file');

-- --------------------------------------------------------

--
-- Estrutura da tabela `coordenadas`
--

CREATE TABLE IF NOT EXISTS `coordenadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `longitude` double NOT NULL DEFAULT '0',
  `latitude` double NOT NULL DEFAULT '0',
  `fk_sala_fk_id_unidade` int(11) NOT NULL,
  `fk_andar_sala` tinyint(4) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL,
  PRIMARY KEY (`longitude`,`latitude`),
  KEY `id` (`id`),
  KEY `fk_coordenadas_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=33 ;

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
(30, 'Segurança de Sistemas', 4),
(31, 'TCC II', 4),
(32, 'Tópicos Avançados em ADS ', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina_curso`
--

CREATE TABLE IF NOT EXISTS `disciplina_curso` (
  `fk_id_disciplina` int(11) NOT NULL,
  `fk_id_curso` int(3) NOT NULL,
  KEY `fk_disciplina_curso_disciplina1_idx` (`fk_id_disciplina`),
  KEY `fk_disciplina_curso_curso1_idx` (`fk_id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento_aluno`
--

CREATE TABLE IF NOT EXISTS `evento_aluno` (
  `id` int(11) NOT NULL,
  `descricao` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dia_semana` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `fk_id_aluno` int(11) NOT NULL,
  `fk_sala_fk_id_unidade` int(11) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL,
  `fk_andar_sala` tinyint(4) NOT NULL,
  `dt_inicio` date NOT NULL,
  `dt_final` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_evento_aluno_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_evento_aluno_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `info_locais`
--

CREATE TABLE IF NOT EXISTS `info_locais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nome descritivo da sala',
  `tags_local` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Tags para usar com ferramenta de busca',
  `imagem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `horario` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fk_sala_fk_id_unidade` int(11) NOT NULL,
  `fk_andar_sala` tinyint(4) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_info_locais_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=50 ;

--
-- Extraindo dados da tabela `info_locais`
--

INSERT INTO `info_locais` (`id`, `descricao`, `tags_local`, `imagem`, `email`, `telefone`, `horario`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`) VALUES
(8, 'Portaria', 'portaria', '', '', '', '', 1, 0, 160),
(9, 'Elevador 1', 'elevador', '', '', '', '', 1, 0, 161),
(10, 'Elevador 2', 'elevador', '', '', '', '', 1, 0, 162),
(11, 'Coordenação de turno', 'coordenação turno', '', '', '', '', 1, 0, 163),
(12, 'Sanitário Masculino - 1', 'sanitário masculino banheiro', '', '', '', '', 1, 0, 164),
(13, 'Sanitário Feminino - 1', 'sanitário feminino banheiro', '', '', '', '', 1, 0, 165),
(14, 'Escada', 'escada acesso', '', '', '', '', 1, 0, 166),
(15, 'Shaft', 'shaft', '', '', '', '', 1, 0, 167),
(16, 'Elevador de carga', 'elevador acesso vertical', '', '', '', '', 1, 0, 168),
(17, 'Administrativo Comunicação Marketing Eventos', 'administrativo comunicação marketing eventos', '', '', '', '', 1, 0, 169),
(18, 'Indeterminado', '', '', '', '', '', 1, 0, 170),
(19, 'Porta corta-fogo', 'incêndio porta emergência fogo saída', '', '', '', '', 1, 0, 171),
(20, 'Escada', 'escada', '', '', '', '', 1, 0, 172),
(21, 'Área da Cantina', 'cantina alimentação lancheria lanche comida', '', '', '', '', 1, 0, 173),
(22, 'Cantina', 'cantina alimentação lancheria lanche comida', '', '', '', '', 1, 0, 174),
(23, 'Reprografia', 'xerox cópias encadernação', '', '', '', '', 1, 0, 175),
(24, 'Coordenação de Ensino Superior', 'coordenação curso coordenador', '', '', '', '', 1, 0, 176),
(25, 'Sala dos Professores', 'professor professores', '', '', '', '', 1, 0, 177),
(26, 'Laboratório Produção Multimídia - 1', 'laboratório produção multimídia design', '', '', '', '', 1, 0, 102),
(27, 'Laboratório Produção Multimídia - 2', 'laboratório produção multimídia design', '', '', '', '', 1, 0, 103),
(28, 'Interagir', 'interagir', '', '', '', '', 1, 0, 178),
(29, 'Coordenação de Pós Graduação', 'coordenação pós coordenador', '', '', '', '', 1, 0, 179),
(30, 'Soluções Corporativas', 'soluções corporativas corporativo', '', '', '', '', 1, 0, 180),
(31, 'Área de Convivência Terceirizados', 'área convivência terceirizados terceiros', '', '', '', '', 1, 0, 181),
(32, 'Sanitário Masculino - 3', 'sanitário masculino banheiro', '', '', '', '', 1, 0, 182),
(33, 'Sanitário Feminino- 3', 'sanitário feminino banheiro', '', '', '', '', 1, 0, 183),
(34, 'Financeiro', 'financeiro pagamentos', '', '', '', '', 1, 0, 184),
(35, 'Atendimento SEAP - Outros Cursos', 'serviço estágio aperfeiçoamento profissional ', '', '', '', '', 1, 0, 185),
(36, 'Ouvidoria', 'ouvidoria', '', '', '', '', 1, 0, 186),
(37, 'Atendimento SEAP Graduação', 'serviço estágio aperfeiçoamento profissional ', '', '', '', '', 1, 0, 187),
(38, 'Sanitário Feminino - 2', 'sanitário feminino banheiro wc', '', '', '', '', 1, 0, 188),
(39, 'Sanitário Masculino - 2', 'sanitário masculino banheiro wc', '', '', '', '', 1, 0, 189),
(40, 'Estúdio de rádio', 'estúdio rádio', '', '', '', '', 1, 0, 190),
(41, 'Escada', 'escada', '', '', '', '', 1, 0, 191),
(42, 'Direção', 'direção diretoria', '', '', '', '', 1, 0, 192),
(43, 'Assessoria Direção', 'assessoria direção', '', '', '', '', 1, 0, 193),
(44, 'Escada', 'escada', '', '', '', '', 1, 0, 194),
(45, 'Protocolo Secretaria', 'protocolo secretaria', '', '', '', '', 1, 0, 195),
(46, 'Direção de Ensino', 'direção ensino', '', '', '', '', 1, 0, 196),
(47, 'Secretaria', 'secretaria', 'secretaria', 'atendimentofatecpoa@senacrs.com.br', '(51) 30221044', '8:00 às 21:00', 1, 0, 197),
(49, 'Atendimento ao Público', 'atendimento publico venda informações', '', '', '', '', 1, 0, 198);

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
(1, 'Graduação'),
(2, 'Pós-Graduação'),
(3, 'Extensão'),
(4, 'Técnico'),
(5, 'Livre');

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_ensino_area`
--

CREATE TABLE IF NOT EXISTS `nivel_ensino_area` (
  `fk_id_area_ensino` tinyint(4) NOT NULL,
  `fk_id_nivel_ensino` tinyint(4) NOT NULL,
  KEY `fk_nivelensinoarea_area_ensino1_idx` (`fk_id_area_ensino`),
  KEY `fk_nivelensinoarea_nivel_ensino1_idx` (`fk_id_nivel_ensino`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala`
--

CREATE TABLE IF NOT EXISTS `sala` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `fk_id_unidade` int(11) NOT NULL,
  `andar` tinyint(4) NOT NULL,
  `numero` int(11) NOT NULL,
  `fk_id_categoria` int(11) NOT NULL,
  PRIMARY KEY (`fk_id_unidade`,`andar`,`numero`),
  KEY `id` (`id`),
  KEY `fk_sala_unidade1_idx` (`fk_id_unidade`),
  KEY `fk_sala_categoria1_idx` (`fk_id_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46 ;

--
-- Extraindo dados da tabela `sala`
--

INSERT INTO `sala` (`id`, `fk_id_unidade`, `andar`, `numero`, `fk_id_categoria`) VALUES
(19, 1, 0, 102, 2),
(20, 1, 0, 103, 2),
(1, 1, 0, 160, 6),
(2, 1, 0, 161, 5),
(3, 1, 0, 162, 5),
(4, 1, 0, 163, 6),
(5, 1, 0, 164, 6),
(6, 1, 0, 165, 6),
(7, 1, 0, 166, 5),
(8, 1, 0, 167, 6),
(9, 1, 0, 168, 5),
(10, 1, 0, 169, 1),
(11, 1, 0, 170, 1),
(12, 1, 0, 171, 5),
(13, 1, 0, 172, 5),
(14, 1, 0, 173, 3),
(15, 1, 0, 174, 3),
(16, 1, 0, 175, 4),
(17, 1, 0, 176, 1),
(18, 1, 0, 177, 6),
(21, 1, 0, 178, 1),
(22, 1, 0, 179, 1),
(23, 1, 0, 180, 1),
(24, 1, 0, 181, 6),
(25, 1, 0, 182, 6),
(26, 1, 0, 183, 6),
(27, 1, 0, 184, 1),
(28, 1, 0, 185, 1),
(29, 1, 0, 186, 1),
(30, 1, 0, 187, 1),
(31, 1, 0, 188, 6),
(32, 1, 0, 189, 6),
(33, 1, 0, 190, 2),
(34, 1, 0, 191, 5),
(35, 1, 0, 192, 1),
(36, 1, 0, 193, 1),
(37, 1, 0, 194, 5),
(38, 1, 0, 195, 1),
(39, 1, 0, 196, 1),
(40, 1, 0, 197, 1),
(41, 1, 0, 198, 1),
(42, 1, 3, 301, 2),
(44, 1, 4, 409, 2),
(43, 1, 6, 603, 2),
(45, 1, 7, 704, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade`
--

CREATE TABLE IF NOT EXISTS `unidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `endereco` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `unidade`
--

INSERT INTO `unidade` (`id`, `nome`, `endereco`) VALUES
(1, 'Unidade 1', 'Rua Coronel Genuino, 130 - Centro Histórico, Porto Alegre'),
(2, 'Unidade 2', 'Rua Coronel Genuino, 358 - Centro Histórico, Porto Alegre');

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
  ADD CONSTRAINT `fk_coordenadas_sala1` FOREIGN KEY (`fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`) REFERENCES `sala` (`fk_id_unidade`, `andar`, `numero`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
  ADD CONSTRAINT `fk_sala_categoria1` FOREIGN KEY (`fk_id_categoria`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sala_unidade1` FOREIGN KEY (`fk_id_unidade`) REFERENCES `unidade` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
