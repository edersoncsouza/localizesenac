-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 29-Maio-2015 às 20:33
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
  `matricula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `celular` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `autenticacao` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ativo` enum('N','S') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`matricula`,`autenticacao`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id`, `matricula`, `senha`, `nome`, `celular`, `email`, `autenticacao`, `ativo`) VALUES
(1, '630610028', 'qaz123', 'Ederson C Souza', '(51) 8424-8825', 'edersonadssenac@gmail.com', 'local', 'S'),
(2, 'aline', 'qaz123', 'Aline de Campos', NULL, 'alinedecampos@gmail.com', 'local', 'S'),
(26, 'edersonadssenac@gmail.com', '117364421816163498409', 'Ederson Senac Souza', '', 'edersonadssenac@gmail.com', 'google', 'S'),
(27, 'edersoncsouza@hotmail.com', '1615212108690478', 'Ederson Souza', '', 'edersoncsouza@hotmail.com', 'facebook', 'S');

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
  PRIMARY KEY (`dia_semana`,`turno`,`fk_id_aluno`),
  UNIQUE KEY `uq_aluno_disciplina` (`fk_id_aluno`,`fk_id_disciplina`),
  KEY `id` (`id`),
  KEY `fk_aluno_disciplina_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_aluno_disciplina_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`),
  KEY `fk_aluno_disciplina_disciplina1_idx` (`fk_id_disciplina`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;

--
-- Extraindo dados da tabela `aluno_disciplina`
--

INSERT INTO `aluno_disciplina` (`id`, `dia_semana`, `turno`, `fk_id_aluno`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`, `fk_id_disciplina`) VALUES
(3, 'QUA', 'N', 1, 1, 6, 603, 28),
(40, 'QUA', 'N', 26, 1, 6, 603, 28),
(16, 'QUI', 'N', 1, 1, 4, 409, 31),
(41, 'QUI', 'N', 26, 1, 4, 409, 31),
(27, 'SEG', 'N', 1, 1, 3, 301, 32),
(38, 'SEG', 'N', 26, 1, 3, 301, 32),
(17, 'SEX', 'N', 1, 1, 7, 704, 23),
(42, 'SEX', 'N', 26, 1, 7, 704, 23),
(14, 'TER', 'N', 1, 1, 6, 603, 30),
(39, 'TER', 'N', 26, 1, 6, 603, 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_lembrete`
--

CREATE TABLE IF NOT EXISTS `aluno_lembrete` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id do lembrete',
  `fk_id_aluno` int(11) NOT NULL COMMENT 'FK id do aluno',
  `dia_semana` char(3) COLLATE utf8_unicode_ci NOT NULL COMMENT 'dia da semana',
  `turno` char(1) COLLATE utf8_unicode_ci NOT NULL COMMENT 'turno da disciplina',
  `fk_sala_fk_id_unidade` int(11) NOT NULL COMMENT 'FK da unidade da sala',
  `fk_andar_sala` tinyint(4) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL COMMENT 'FK da sala',
  `fk_id_disciplina` int(11) NOT NULL COMMENT 'FK da disciplina',
  `tipo` char(6) COLLATE utf8_unicode_ci NOT NULL COMMENT 'tipo de lembrete',
  `minutosantec` int(11) DEFAULT NULL,
  `dt_inicio` date NOT NULL,
  `dt_final` date NOT NULL,
  PRIMARY KEY (`fk_id_aluno`,`dia_semana`,`turno`,`tipo`),
  KEY `id` (`id`),
  KEY `fk_aluno_lembrete_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_aluno_lembrete_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`),
  KEY `fk_aluno_lembrete_disciplina1_idx` (`fk_id_disciplina`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tabela de lembretes' AUTO_INCREMENT=210 ;

--
-- Extraindo dados da tabela `aluno_lembrete`
--

INSERT INTO `aluno_lembrete` (`id`, `fk_id_aluno`, `dia_semana`, `turno`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`, `fk_id_disciplina`, `tipo`, `minutosantec`, `dt_inicio`, `dt_final`) VALUES
(207, 1, 'QUA', 'N', 1, 6, 603, 28, 'icloud', 10, '2015-06-03', '2015-07-10'),
(208, 1, 'QUI', 'N', 1, 4, 409, 31, 'icloud', 10, '2015-06-04', '2015-07-10'),
(205, 1, 'SEG', 'N', 1, 3, 301, 32, 'icloud', 10, '2015-06-01', '2015-07-10'),
(209, 1, 'SEX', 'N', 1, 7, 704, 23, 'icloud', 10, '2015-05-29', '2015-07-10'),
(206, 1, 'TER', 'N', 1, 6, 603, 30, 'icloud', 10, '2015-06-02', '2015-07-10'),
(107, 26, 'QUA', 'N', 1, 6, 603, 28, 'sms', 15, '2015-05-27', '2015-07-10'),
(108, 26, 'QUI', 'N', 1, 4, 409, 31, 'sms', 20, '2015-05-28', '2015-07-10'),
(105, 26, 'SEG', 'N', 1, 3, 301, 32, 'email', 5, '2015-06-01', '2015-07-10'),
(104, 26, 'SEG', 'N', 1, 3, 301, 32, 'sms', 15, '2015-06-01', '2015-07-10'),
(109, 26, 'SEX', 'N', 1, 7, 704, 23, 'sms', 15, '2015-05-29', '2015-07-10'),
(106, 26, 'TER', 'N', 1, 6, 603, 30, 'sms', 15, '2015-05-26', '2015-07-10');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

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
(10, 1, 10, 'Design de Moda'),
(11, 1, 7, 'Bacharelado em Ciências Contábeis'),
(12, 1, 7, 'Comércio Exterior');

-- --------------------------------------------------------

--
-- Estrutura da tabela `disciplina`
--

CREATE TABLE IF NOT EXISTS `disciplina` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creditos` tinyint(4) DEFAULT '4',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=227 ;

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
(32, 'Tópicos Avançados em ADS ', 4),
(33, 'Laboratório de Redes I', 4),
(34, 'Administração de Sistemas Operacionais Não-Proprietários I', 4),
(35, 'Algoritmos e Programação', 4),
(36, 'Laboratório de Redes II', 4),
(37, 'Redes de Computadores II', 4),
(38, 'Administração de Sistemas Operacionais Não-Proprietários II', 4),
(39, 'Laboratório de Redes III', 4),
(40, 'Programação para Redes', 4),
(41, 'Redes de Computadores III', 4),
(42, 'Administração de Sistemas Operacionais Proprietários', 4),
(43, 'Projeto de Redes', 4),
(44, 'Serviços Multimídia em Redes', 4),
(45, 'Tópicos Especiais em Redes I', 2),
(46, 'Administração de Redes', 4),
(47, 'Programação para a Internet', 4),
(48, 'Projeto Integrador', 4),
(49, 'Qualidade de Serviço em Redes', 4),
(50, 'Segurança em Redes', 4),
(51, 'Redes sem Fio', 4),
(52, 'Tópicos Especiais em Redes II', 4),
(53, 'Comunicação Multimídia', 4),
(54, 'Design Web I', 4),
(55, 'Fundamentos do Design', 4),
(56, 'Imagem Digital I', 4),
(57, 'Storytelling', 2),
(58, 'Animação I', 4),
(59, 'Computação Gráfica I', 4),
(60, 'Design Web II', 4),
(61, 'Imagem Digital II', 4),
(62, 'User Experience', 4),
(63, 'Animação II', 4),
(64, 'Computação Gráfica II', 4),
(65, 'Jogos Digitais', 4),
(66, 'Produção de Áudio', 4),
(67, 'Produção de Vídeo', 4),
(68, 'Direção Multimídia', 4),
(69, 'Gestão de Projetos Multimídia', 4),
(70, 'Novas Mídias', 4),
(71, 'Projeto Interativo', 4),
(72, 'Efeitos Especiais', 4),
(73, 'Modelos de Negócios', 4),
(74, 'Tópicos Avançados', 4),
(75, 'Teorias da Administração', 4),
(76, 'Gestão da Produção e Operações', 4),
(77, 'Pesquisa Operacional', 4),
(78, 'Métodos e Técnicas de Pesquisa', 4),
(79, 'Gestão da Inovação', 4),
(80, 'Pensamento Sistêmico', 2),
(81, 'Contabilidade Atuarial', 4),
(82, 'Estrutura e Análise de Balanço', 4),
(83, 'Análise de Demonstrações Financeiras', 4),
(84, 'Normas e Práticas Contábeis do Setor Público', 4),
(85, 'Normas e Práticas Contábeis do Terceiro Setor', 4),
(86, 'Normas e Práticas em Instituições Financeiras', 4),
(87, 'Orçamento Empresarial', 4),
(88, 'Normas e Práticas Contábeis Avançadas', 4),
(89, 'Gerenciamento de Projetos', 4),
(90, 'Prática de Comércio Exterior I', 2),
(91, 'Mercado de Câmbio e Capitais Internacionais', 4),
(92, 'Prática de Comércio Exterior II', 2),
(93, 'Direito Internacional e Marítimo (EAD)', 4),
(94, 'Prática de Comércio Exterior III', 4),
(95, 'Prática de Comércio Exterior IV', 4),
(96, 'Introdução à Administração de Pessoal', 4),
(97, 'Cultura e Clima Organizacional', 4),
(98, 'Prática Profissional I', 2),
(99, 'Recrutamento e Seleção', 4),
(100, 'Consultoria Organizacional em Recursos Humanos', 4),
(101, 'Remuneração e Benefícios', 4),
(102, 'Treinamento e Desenvolvimento', 4),
(103, 'Gestão de Carreira e Desempenho', 4),
(104, 'Gestão do Conhecimento e Educação Corporativa', 4),
(105, 'Prática Profissional II', 4),
(106, 'Introdução à Gestão Financeira', 4),
(107, 'Finanças Pessoais', 4),
(108, 'Modelos Organizacionais', 4),
(109, 'Sistema Financeiro Nacional', 4),
(110, 'Formação de Preços de Ativos', 4),
(111, 'Mercado de Capitais', 4),
(112, 'Planejamento Financeiro', 4),
(113, 'Prática Logística I', 2),
(114, 'Prática Logística II', 2),
(115, 'Sistema de Produção e Operações', 4),
(116, 'Prática Logística III', 4),
(117, 'Logística Internacional', 4),
(118, 'Prática Logística IV', 2),
(119, 'Criatividade na Publicidade e Propaganda', 4),
(120, 'Marketing I', 4),
(121, 'Modelos de Gestão e Liderança', 4),
(122, 'Comportamento do Consumidor', 4),
(123, 'Comunicação Integrada', 4),
(124, 'Endomarketing', 2),
(125, 'Marketing II', 4),
(126, 'Gestão Comercial', 4),
(127, 'Pesquisa Mercadológica', 4),
(128, 'Tópicos Especiais', 4),
(129, 'Trade Marketing e Merchandising', 4),
(130, 'Branding e Inovação', 4),
(131, 'Direito Mercadológico', 2),
(132, 'Marketing III', 4),
(133, 'Arte e Moda I', 4),
(134, 'Construção de Moda I', 2),
(135, 'Desenho de Moda I', 4),
(136, 'Oficina de Confecção I', 4),
(137, 'Seminários Aplicados I', 4),
(138, 'Arte e Moda II', 4),
(139, 'Desenho de Moda II', 4),
(140, 'Design e Moda I', 2),
(141, 'Estudos de Materiais', 2),
(142, 'Modelagem I', 4),
(143, 'Oficina de Confecção II', 4),
(144, 'Desenvolvimento de Coleção de Moda I', 8),
(145, 'Design e Moda II', 2),
(146, 'Projeto de Moda', 4),
(147, 'Seminários Aplicados II', 2),
(148, 'Desenho Técnico de Moda com uso de Software', 4),
(149, 'Desenvolvimento de Coleção de Moda II', 8),
(150, 'Modelagem II', 4),
(151, 'Fotografia de Moda', 2),
(152, 'Modelagem com uso de Software', 4),
(153, 'Produção de Moda', 2),
(154, 'Seminários Aplicados III', 2),
(155, 'Desafio Profissional I', 2),
(156, 'Organizações da Hospitalidade', 4),
(157, 'Turismo e Hospitalidade', 4),
(158, 'Desafio Profissional II', 2),
(159, 'Gestão de Hospedagem I', 4),
(160, 'Gestão de Operações I', 4),
(161, 'Cenários da Hospitalidade', 2),
(162, 'Desafio Profissional III', 3),
(163, 'Gestão de Hospedagem II', 4),
(164, 'Gestão de Operações II', 4),
(165, 'Planejamento e Implantação de Projetos', 2),
(166, 'Estratégia de Negociação', 4),
(167, 'Gestão Estratégica Hoteleira e em Negócios de Hospitalidade', 4),
(168, 'Inovação e Tópicos em Hospitalidade', 4),
(169, 'Projeto Final', 2),
(170, 'Eletiva III', 4),
(171, 'Trabalho de Conclusão de Curso - TCC', 4),
(172, 'Administração de Pessoal', 4),
(173, 'Análise de Investimentos', 4),
(174, 'Auditoria', 4),
(175, 'Comportamento Organizacional', 4),
(176, 'Comunicação e Expressão', 4),
(177, 'Comunicação e Expressão (EAD)', 4),
(178, 'Contabilidade', 4),
(179, 'Contabilidade Executiva', 4),
(180, 'Contabilidade Gerencial', 4),
(181, 'Controladoria', 4),
(182, 'Custos e Orçamento', 4),
(183, 'Direito Empresarial', 4),
(184, 'Economia Contemporânea', 4),
(185, 'Economia e Mercado', 4),
(186, 'Eletiva', 4),
(187, 'Eletiva I', 4),
(188, 'Eletiva II', 4),
(189, 'Empreendedorismo', 4),
(190, 'Estatística', 4),
(191, 'Ética, Cidadania e Sustentabilidade', 2),
(192, 'Finanças', 4),
(193, 'Finanças Corporativas', 4),
(194, 'Gestão de Marketing', 4),
(195, 'Gestão de Pessoas', 4),
(196, 'Gestão Estratégica e Competitividade', 4),
(197, 'Inglês I', 4),
(198, 'Inglês II', 4),
(199, 'Inglês III', 4),
(200, 'Inglês IV', 4),
(201, 'Instituição do Direito', 4),
(202, 'Jogos Empresariais', 4),
(203, 'Logística Empresarial', 4),
(204, 'Logística Reversa e Sistema de Embalagem', 4),
(205, 'Marketing Digital', 4),
(206, 'Marketing do Varejo e Serviços', 4),
(207, 'Marketing Internacional', 2),
(208, 'Matemática', 4),
(209, 'Matemática Financeira', 4),
(210, 'Métodos Quantitativos', 4),
(211, 'Modelos de Gestão', 4),
(212, 'Negócios Internacionais', 4),
(213, 'Perícia, Mediação e Arbitragem', 4),
(214, 'Planejamento de Carreira', 2),
(215, 'Planejamento Tributário', 4),
(216, 'Processo Criativo', 2),
(217, 'Projeto - Cidadania e Sustentabilidade', 2),
(218, 'Projeto Foco Diagnóstico Empresarial', 2),
(219, 'Projeto TCC', 2),
(220, 'Saúde, Segurança e Qualidade de Vida no Trabalho', 4),
(221, 'Sistema de Estoques, Armazenagem e Movimentação', 4),
(222, 'Sistema de Transportes', 4),
(223, 'Sistemas de Informação e Processos (EAD)', 4),
(224, 'Trabalho de Conclusão', 4),
(225, 'Prática Profissional', 8),
(226, 'Estágio Supervisionado', 8);

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

--
-- Extraindo dados da tabela `disciplina_curso`
--

INSERT INTO `disciplina_curso` (`fk_id_disciplina`, `fk_id_curso`) VALUES
(1, 7),
(2, 7),
(3, 7),
(4, 7),
(5, 7),
(6, 7),
(7, 7),
(8, 7),
(9, 7),
(10, 7),
(11, 7),
(12, 7),
(13, 7),
(14, 7),
(15, 7),
(16, 7),
(17, 7),
(18, 7),
(19, 7),
(20, 7),
(21, 7),
(22, 7),
(23, 7),
(24, 7),
(25, 7),
(26, 7),
(27, 7),
(28, 7),
(29, 7),
(30, 7),
(31, 7),
(32, 7),
(2, 8),
(33, 8),
(9, 8),
(24, 8),
(21, 8),
(34, 8),
(35, 8),
(17, 8),
(36, 8),
(37, 8),
(38, 8),
(39, 8),
(40, 8),
(41, 8),
(30, 8),
(42, 8),
(14, 8),
(22, 8),
(43, 8),
(44, 8),
(45, 8),
(46, 8),
(47, 8),
(48, 8),
(49, 8),
(50, 8),
(27, 8),
(28, 8),
(29, 8),
(51, 8),
(52, 8),
(224, 8),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(216, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(205, 1),
(70, 1),
(71, 1),
(72, 1),
(191, 1),
(29, 1),
(73, 1),
(225, 1),
(74, 1),
(224, 1),
(178, 2),
(14, 2),
(201, 2),
(29, 2),
(208, 2),
(211, 2),
(214, 2),
(175, 2),
(17, 2),
(180, 2),
(190, 2),
(75, 2),
(182, 2),
(183, 2),
(185, 2),
(195, 2),
(209, 2),
(193, 2),
(76, 2),
(194, 2),
(203, 2),
(212, 2),
(184, 2),
(187, 2),
(188, 2),
(170, 2),
(217, 2),
(223, 2),
(173, 2),
(27, 2),
(22, 2),
(77, 2),
(215, 2),
(196, 2),
(206, 2),
(78, 2),
(213, 2),
(218, 2),
(219, 2),
(226, 2),
(79, 2),
(202, 2),
(80, 2),
(224, 2),
(178, 11),
(191, 11),
(201, 11),
(208, 11),
(211, 11),
(214, 11),
(175, 11),
(176, 11),
(180, 11),
(185, 11),
(209, 11),
(81, 11),
(182, 11),
(183, 11),
(190, 11),
(82, 11),
(83, 11),
(184, 11),
(193, 11),
(215, 11),
(5, 11),
(172, 11),
(189, 11),
(84, 11),
(85, 11),
(86, 11),
(173, 11),
(174, 11),
(187, 11),
(188, 11),
(87, 11),
(181, 11),
(196, 11),
(88, 11),
(213, 11),
(218, 11),
(219, 11),
(226, 11),
(89, 11),
(202, 11),
(29, 11),
(171, 11),
(17, 12),
(185, 12),
(14, 12),
(197, 12),
(212, 12),
(214, 12),
(90, 12),
(183, 12),
(198, 12),
(209, 12),
(91, 12),
(92, 12),
(223, 12),
(182, 12),
(93, 12),
(199, 12),
(94, 12),
(221, 12),
(222, 12),
(186, 12),
(27, 12),
(200, 12),
(29, 12),
(204, 12),
(207, 12),
(95, 12),
(175, 3),
(14, 3),
(195, 3),
(96, 3),
(210, 3),
(214, 3),
(172, 3),
(17, 3),
(97, 3),
(98, 3),
(99, 3),
(220, 3),
(100, 3),
(179, 3),
(187, 3),
(27, 3),
(101, 3),
(102, 3),
(188, 3),
(103, 3),
(104, 3),
(196, 3),
(29, 3),
(105, 3),
(223, 3),
(178, 4),
(185, 4),
(195, 4),
(106, 4),
(210, 4),
(182, 4),
(14, 4),
(107, 4),
(209, 4),
(108, 4),
(214, 4),
(218, 4),
(174, 4),
(17, 4),
(180, 4),
(192, 4),
(215, 4),
(109, 4),
(181, 4),
(27, 4),
(110, 4),
(29, 4),
(111, 4),
(213, 4),
(112, 4),
(176, 5),
(185, 5),
(190, 5),
(191, 5),
(197, 5),
(214, 5),
(113, 5),
(183, 5),
(198, 5),
(209, 5),
(114, 5),
(115, 5),
(5, 5),
(182, 5),
(199, 5),
(116, 5),
(220, 5),
(221, 5),
(222, 5),
(186, 5),
(189, 5),
(200, 5),
(29, 5),
(117, 5),
(204, 5),
(118, 5),
(17, 6),
(119, 6),
(192, 6),
(120, 6),
(121, 6),
(122, 6),
(123, 6),
(124, 6),
(205, 6),
(125, 6),
(214, 6),
(223, 6),
(14, 6),
(126, 6),
(206, 6),
(127, 6),
(128, 6),
(129, 6),
(130, 6),
(131, 6),
(27, 6),
(22, 6),
(29, 6),
(203, 6),
(132, 6),
(207, 6),
(133, 10),
(134, 10),
(135, 10),
(136, 10),
(216, 10),
(137, 10),
(138, 10),
(139, 10),
(140, 10),
(141, 10),
(142, 10),
(143, 10),
(144, 10),
(145, 10),
(27, 10),
(146, 10),
(147, 10),
(17, 10),
(148, 10),
(149, 10),
(150, 10),
(14, 10),
(151, 10),
(29, 10),
(152, 10),
(225, 10),
(153, 10),
(154, 10),
(155, 9),
(185, 9),
(14, 9),
(197, 9),
(156, 9),
(214, 9),
(217, 9),
(157, 9),
(17, 9),
(179, 9),
(158, 9),
(159, 9),
(160, 9),
(198, 9),
(161, 9),
(162, 9),
(27, 9),
(163, 9),
(164, 9),
(195, 9),
(165, 9),
(186, 9),
(166, 9),
(194, 9),
(167, 9),
(168, 9),
(29, 9),
(169, 9);

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
