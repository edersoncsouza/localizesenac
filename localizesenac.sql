-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 25-Jun-2015 às 03:52
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=64 ;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id`, `matricula`, `senha`, `nome`, `celular`, `email`, `autenticacao`, `ativo`) VALUES
(1, '630610028', '$2y$10$U1AXK3KiVs3TIhuV/1UYb.wplqhEIPvsXZJrvX.0SHj7R2Taptn0e', 'Ederson Chivelas Souza', '(51) 8424-8825', 'edersonadssenac@gmail.com', 'local', 'S'),
(2, 'aline', '$2y$10$e15gcnMd2lDVwVRnAiPZku3G8QzauFTEkHvmHFBhfLryD.LEjB6e2', 'Aline de Campos', NULL, 'alinedecampos@gmail.com', 'local', 'S'),
(38, 'edersonadssenac@gmail.com', '117364421816163498409', 'Ederson Senac Souza', '', 'edersonadssenac@gmail.com', 'google', 'S'),
(39, 'edersoncsouza@hotmail.com', '1615212108690478', 'Ederson Souza', '', 'edersoncsouza@hotmail.com', 'facebook', 'S');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=60 ;

--
-- Extraindo dados da tabela `aluno_disciplina`
--

INSERT INTO `aluno_disciplina` (`id`, `dia_semana`, `turno`, `fk_id_aluno`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`, `fk_id_disciplina`) VALUES
(59, 'QUA', 'M', 1, 1, 1, 102, 1),
(56, 'SEG', 'M', 38, 1, 3, 301, 1);

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
  `fk_andar_sala` tinyint(4) NOT NULL COMMENT 'FK do andar da sala',
  `fk_numero_sala` int(11) NOT NULL COMMENT 'FK da sala',
  `fk_id_disciplina` int(11) NOT NULL COMMENT 'FK da disciplina',
  `fk_id_lembrete_tipo` int(11) NOT NULL COMMENT 'FK id de tipo de lembrete',
  `minutosantec` int(11) DEFAULT NULL COMMENT 'minutos de antecedencia do lembrete',
  `dt_inicio` date NOT NULL COMMENT 'data de inicio de envio do lembrete',
  `dt_final` date NOT NULL COMMENT 'data final de envio do lembrete',
  PRIMARY KEY (`fk_id_aluno`,`dia_semana`,`turno`,`fk_id_lembrete_tipo`),
  KEY `id` (`id`),
  KEY `fk_aluno_lembrete_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_aluno_lembrete_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`),
  KEY `fk_aluno_lembrete_disciplina1_idx` (`fk_id_disciplina`),
  KEY `fk_aluno_lembrete_lembrete_tipo1_idx` (`fk_id_lembrete_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tabela de lembretes' AUTO_INCREMENT=23 ;

--
-- Extraindo dados da tabela `aluno_lembrete`
--

INSERT INTO `aluno_lembrete` (`id`, `fk_id_aluno`, `dia_semana`, `turno`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`, `fk_id_disciplina`, `fk_id_lembrete_tipo`, `minutosantec`, `dt_inicio`, `dt_final`) VALUES
(22, 1, 'QUA', 'M', 1, 1, 102, 1, 3, 2, '2015-06-24', '2015-07-10'),
(17, 38, 'SEG', 'M', 1, 3, 301, 1, 3, 10, '2015-06-22', '2015-07-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_perfil`
--

CREATE TABLE IF NOT EXISTS `aluno_perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_id_aluno` int(11) NOT NULL,
  `fk_id_perfil` int(11) NOT NULL,
  PRIMARY KEY (`fk_id_aluno`,`fk_id_perfil`),
  KEY `id` (`id`),
  KEY `fk_aluno_perfil_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_aluno_perfil_perfil1_idx` (`fk_id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `aluno_perfil`
--

INSERT INTO `aluno_perfil` (`id`, `fk_id_aluno`, `fk_id_perfil`) VALUES
(1, 1, 1),
(2, 2, 3);

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
  PRIMARY KEY (`longitude`,`latitude`,`fk_andar_sala`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=236 ;

--
-- Extraindo dados da tabela `coordenadas`
--

INSERT INTO `coordenadas` (`id`, `longitude`, `latitude`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`) VALUES
(13, -51.22667384024385, -30.035280309344365, 1, 1, 159),
(10, -51.22659259044656, -30.03517054674161, 1, 1, 159),
(12, -51.226580646303375, -30.035332011416102, 1, 1, 159),
(215, -51.226580316181014, -30.0353361161403, 1, 1, 198),
(17, -51.22655358305417, -30.035118723013777, 1, 1, 160),
(4, -51.22655358305417, -30.035118723013777, 1, 3, 301),
(14, -51.22653419020298, -30.03509282853612, 1, 1, 160),
(1, -51.22653419020298, -30.03509282853612, 1, 3, 301),
(212, -51.226514488204145, -30.035247105662087, 1, 1, 198),
(202, -51.2265038840132, -30.035247723164662, 1, 1, 195),
(11, -51.22649939650603, -30.03522224887061, 1, 1, 159),
(16, -51.2264823870475, -30.035158684698104, 1, 1, 160),
(3, -51.2264823870475, -30.035158684698104, 1, 3, 301),
(203, -51.226473405393904, -30.035204415898065, 1, 1, 195),
(214, -51.22646608399975, -30.035400153680705, 1, 1, 198),
(15, -51.226462994196254, -30.03513279023087, 1, 1, 160),
(2, -51.226462994196254, -30.03513279023087, 1, 3, 301),
(216, -51.22646185756821, -30.035404687901774, 1, 1, 199),
(201, -51.22644980677296, -30.035276246585347, 1, 1, 195),
(207, -51.22644883190088, -30.035279057097164, 1, 1, 196),
(25, -51.22643107178942, -30.035153083619644, 1, 1, 162),
(227, -51.22643107178942, -30.035153083619644, 1, 2, 262),
(235, -51.22643107178942, -30.035153083619644, 1, 3, 362),
(200, -51.22641932815361, -30.035232939331216, 1, 1, 195),
(204, -51.22641610500682, -30.035234489517563, 1, 1, 196),
(22, -51.226415369771985, -30.03513222632849, 1, 1, 162),
(224, -51.226415369771985, -30.03513222632849, 1, 2, 262),
(232, -51.226415369771985, -30.03513222632849, 1, 3, 362),
(21, -51.226414554427265, -30.035130613104197, 1, 1, 161),
(9, -51.226414554427265, -30.035130613104197, 1, 2, 261),
(231, -51.226414554427265, -30.035130613104197, 1, 3, 361),
(24, -51.22641146164631, -30.035164148117374, 1, 1, 162),
(226, -51.22641146164631, -30.035164148117374, 1, 2, 262),
(234, -51.22641146164631, -30.035164148117374, 1, 3, 362),
(33, -51.226411453094215, -30.03516488847308, 1, 1, 163),
(213, -51.22640159712739, -30.035311143260028, 1, 1, 198),
(18, -51.22639885240983, -30.03510975580834, 1, 1, 161),
(6, -51.22639885240983, -30.03510975580834, 1, 2, 261),
(228, -51.22639885240983, -30.03510975580834, 1, 3, 361),
(206, -51.226398694062254, -30.035306650397736, 1, 1, 196),
(219, -51.22639748455185, -30.03531064556134, 1, 1, 199),
(23, -51.22639575962887, -30.03514329082855, 1, 1, 162),
(225, -51.22639575962887, -30.03514329082855, 1, 2, 262),
(233, -51.22639575962887, -30.03514329082855, 1, 3, 362),
(20, -51.22639494428421, -30.03514167760444, 1, 1, 161),
(8, -51.22639494428421, -30.03514167760444, 1, 2, 261),
(230, -51.22639494428421, -30.03514167760444, 1, 3, 361),
(211, -51.22638259288965, -30.035315378640504, 1, 1, 197),
(19, -51.22637924226677, -30.0351208203109, 1, 1, 161),
(7, -51.22637924226677, -30.0351208203109, 1, 2, 261),
(229, -51.22637924226677, -30.0351208203109, 1, 3, 361),
(30, -51.2263792422667, -30.0351208203109, 1, 1, 163),
(32, -51.22636934634079, -30.035187954989492, 1, 1, 163),
(37, -51.22636787511084, -30.03518902029482, 1, 1, 164),
(205, -51.22636596716819, -30.03526208283054, 1, 1, 196),
(208, -51.22635024590659, -30.035270494723985, 1, 1, 197),
(217, -51.22634786368508, -30.035467382745818, 1, 1, 199),
(187, -51.22633801777363, -30.035468214515674, 1, 1, 191),
(31, -51.22633713551335, -30.03514388683755, 1, 1, 163),
(34, -51.2263356642834, -30.035144952143384, 1, 1, 164),
(36, -51.22632576835741, -30.03521208680563, 1, 1, 164),
(41, -51.22632387594649, -30.035213790784987, 1, 1, 165),
(184, -51.22631406223087, -30.03543458463656, 1, 1, 191),
(191, -51.22631189812438, -30.03543008482745, 1, 1, 192),
(210, -51.226304998126466, -30.035356775354792, 1, 1, 197),
(199, -51.226302986469705, -30.03535793637133, 1, 1, 194),
(188, -51.22629728093705, -30.03541056715961, 1, 1, 192),
(195, -51.22629525486195, -30.035407104794388, 1, 1, 193),
(35, -51.22629355752997, -30.035168018664397, 1, 1, 164),
(38, -51.22629127682001, -30.035170032801506, 1, 1, 165),
(40, -51.22628615806474, -30.035234850323242, 1, 1, 165),
(45, -51.226284100567, -30.035237447280277, 1, 1, 166),
(218, -51.226275444041676, -30.035375662497575, 1, 1, 199),
(198, -51.22627331528315, -30.03537142131395, 1, 1, 194),
(209, -51.22627265114352, -30.03531014993138, 1, 1, 197),
(196, -51.226270639486756, -30.035311310948476, 1, 1, 194),
(190, -51.226270426019596, -30.035453362679235, 1, 1, 192),
(44, -51.226259389899894, -30.03525127740028, 1, 1, 166),
(189, -51.22625580883232, -30.035433845015998, 1, 1, 192),
(194, -51.22625437464313, -30.035430050432193, 1, 1, 193),
(49, -51.226254190248596, -30.035254266416672, 1, 1, 167),
(39, -51.2262535589382, -30.035191092349066, 1, 1, 165),
(42, -51.2262508764224, -30.035192957012022, 1, 1, 166),
(197, -51.22624129149648, -30.035328395714462, 1, 1, 194),
(192, -51.22623740180006, -30.035331135184602, 1, 1, 193),
(48, -51.22623345952593, -30.035265963159443, 1, 1, 167),
(53, -51.22623154521534, -30.03526710741055, 1, 1, 168),
(43, -51.22622616575535, -30.03520678713825, 1, 1, 166),
(186, -51.226223024040166, -30.035532759238247, 1, 1, 191),
(46, -51.226220595234565, -30.035209641554907, 1, 1, 167),
(52, -51.22620941699097, -30.035280459112155, 1, 1, 168),
(57, -51.22620575129986, -30.03527987860342, 1, 1, 169),
(185, -51.22620040960203, -30.035497968366126, 1, 1, 191),
(47, -51.2261998645119, -30.035221338302936, 1, 1, 167),
(50, -51.226198017602655, -30.035222408222502, 1, 1, 168),
(193, -51.22619719213367, -30.035352339315104, 1, 1, 193),
(73, -51.22619363156508, -30.03545677377264, 1, 1, 173),
(56, -51.22618206275445, -30.03529240913397, 1, 1, 169),
(51, -51.22617521882603, -30.035235179421147, 1, 1, 168),
(54, -51.22617155526086, -30.03523479783349, 1, 1, 169),
(60, -51.22616046667645, -30.03526942944574, 1, 1, 170),
(59, -51.22614705563137, -30.035251433671583, 1, 1, 170),
(55, -51.226147037775945, -30.035247937255853, 1, 1, 169),
(70, -51.22612670833348, -30.035367416352535, 1, 1, 173),
(69, -51.22612503933385, -30.03536537327242, 1, 1, 172),
(62, -51.22611450650072, -30.035320713188366, 1, 1, 171),
(61, -51.22610682249615, -30.035301357424114, 1, 1, 170),
(66, -51.226101044931454, -30.035333307360226, 1, 1, 172),
(72, -51.22609868495874, -30.035510066927042, 1, 1, 173),
(58, -51.22609274089882, -30.03528278114704, 1, 1, 170),
(77, -51.22608812607183, -30.03550250701313, 1, 1, 174),
(63, -51.22608794210532, -30.03528511356644, 1, 1, 171),
(65, -51.226085014292266, -30.03533720672493, 1, 1, 171),
(183, -51.2260628058923, -30.035618375427177, 1, 1, 190),
(64, -51.22605844989681, -30.035301607108963, 1, 1, 171),
(76, -51.226056400937466, -30.03552034051973, 1, 1, 174),
(68, -51.2260556551733, -30.03540428606696, 1, 1, 172),
(81, -51.22604981039626, -30.035522475086974, 1, 1, 175),
(180, -51.22603900516634, -30.035586742181046, 1, 1, 190),
(175, -51.22603506835691, -30.03563401639558, 1, 1, 189),
(182, -51.2260350683569, -30.03563401639558, 1, 1, 190),
(71, -51.226031761253296, -30.03542070787538, 1, 1, 173),
(67, -51.22603166043075, -30.03537222076501, 1, 1, 172),
(74, -51.22602933697374, -30.035424044033164, 1, 1, 174),
(80, -51.2260180852619, -30.035540308590004, 1, 1, 175),
(85, -51.2260126796773, -30.035541270417525, 1, 1, 176),
(172, -51.22601178865477, -30.0356030756407, 1, 1, 189),
(181, -51.22601126763095, -30.035602383154444, 1, 1, 190),
(167, -51.22600812290602, -30.035649210711664, 1, 1, 188),
(174, -51.22600812290601, -30.035649210711664, 1, 1, 189),
(75, -51.22599759026866, -30.035441866431476, 1, 1, 174),
(78, -51.22599102129817, -30.035444012122824, 1, 1, 175),
(173, -51.225984843203946, -30.035618269961546, 1, 1, 189),
(164, -51.22598433167525, -30.035617590095264, 1, 1, 188),
(151, -51.22598117830023, -30.035664404548903, 1, 1, 187),
(166, -51.22598117830022, -30.035664404548903, 1, 1, 188),
(79, -51.22595927459315, -30.035461834517534, 1, 1, 175),
(148, -51.22595894037062, -30.035634848409835, 1, 1, 187),
(139, -51.22595740266627, -30.035677811427544, 1, 1, 186),
(150, -51.22595740266626, -30.035677811427544, 1, 1, 187),
(165, -51.2259573870694, -30.03563278393733, 1, 1, 188),
(82, -51.225954748622485, -30.035463944319773, 1, 1, 176),
(149, -51.225935164736654, -30.03564825529246, 1, 1, 187),
(136, -51.22593413645001, -30.03564688861024, 1, 1, 186),
(131, -51.22592728697589, -30.035694793407686, 1, 1, 185),
(138, -51.22592728697588, -30.035694793407686, 1, 1, 186),
(84, -51.22592061893556, -30.035592943068394, 1, 1, 176),
(89, -51.22591439677592, -30.035595589779472, 1, 1, 177),
(123, -51.22590430448281, -30.03570775303696, 1, 1, 184),
(130, -51.2259043044828, -30.03570775303696, 1, 1, 185),
(137, -51.225904020759685, -30.03566387059569, 1, 1, 186),
(128, -51.225902993573925, -30.035662505376834, 1, 1, 185),
(120, -51.22588053127902, -30.03567615639874, 1, 1, 184),
(129, -51.22588001108079, -30.03567546501035, 1, 1, 185),
(93, -51.22587699999997, -30.0356186, 1, 1, 102),
(88, -51.22587572982843, -30.035617293090265, 1, 1, 177),
(122, -51.225874189426236, -30.035724734654572, 1, 1, 184),
(119, -51.225872373537186, -30.03572615537013, 1, 1, 183),
(83, -51.22586269870044, -30.035515604907477, 1, 1, 176),
(86, -51.22585465135643, -30.03551581453706, 1, 1, 177),
(121, -51.2258504162225, -30.035693138021774, 1, 1, 184),
(116, -51.22584857358822, -30.03569452319113, 1, 1, 183),
(118, -51.22584758886683, -30.035740131227115, 1, 1, 183),
(115, -51.22584486666551, -30.035741269500733, 1, 1, 182),
(117, -51.225823788917864, -30.035708499052575, 1, 1, 183),
(112, -51.22582161999003, -30.035710372674586, 1, 1, 182),
(90, -51.22581600000001, -30.0355375, 1, 1, 102),
(87, -51.22581598440888, -30.03553751786532, 1, 1, 177),
(92, -51.225806199999965, -30.0356585, 1, 1, 102),
(114, -51.22580444859477, -30.035764060889765, 1, 1, 182),
(159, -51.22580444859476, -30.035764060889765, 1, 1, 181),
(97, -51.22580367805608, -30.035658789266144, 1, 1, 103),
(113, -51.22578120191935, -30.03573316407073, 1, 1, 182),
(156, -51.22578069273004, -30.035732487314476, 1, 1, 181),
(96, -51.22576008932339, -30.035683368583403, 1, 1, 103),
(101, -51.22575439365852, -30.035684115048237, 1, 1, 178),
(91, -51.22574529999997, -30.0355774, 1, 1, 102),
(158, -51.225745020284535, -30.03579757197353, 1, 1, 181),
(94, -51.22574475066523, -30.035580469624183, 1, 1, 103),
(157, -51.22572126441969, -30.035765998408948, 1, 1, 181),
(109, -51.22571517203477, -30.035768493671586, 1, 1, 180),
(100, -51.22570763553148, -30.03571048155313, 1, 1, 178),
(95, -51.225701161932534, -30.035605048960825, 1, 1, 103),
(98, -51.225695974356086, -30.0356064707202, 1, 1, 178),
(108, -51.2256676598513, -30.035795285359548, 1, 1, 180),
(106, -51.22565659894195, -30.035689580968988, 1, 1, 180),
(102, -51.22565496596508, -30.035688555906606, 1, 1, 179),
(99, -51.225649216229044, -30.035632837245767, 1, 1, 178),
(105, -51.22562143835239, -30.035641534882245, 1, 1, 179),
(107, -51.225609757310565, -30.035713470147325, 1, 1, 180),
(103, -51.22560869785957, -30.035712937169716, 1, 1, 179),
(104, -51.22557584079914, -30.035665916156916, 1, 1, 179);

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
-- Estrutura da tabela `evento_geral`
--

CREATE TABLE IF NOT EXISTS `evento_geral` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id do evento',
  `data_inicio` date NOT NULL COMMENT 'data de inicio do evento',
  `hora_inicio` time NOT NULL DEFAULT '00:00:00' COMMENT 'hora de inicio do evento',
  `data_final` date NOT NULL COMMENT 'data final do evento',
  `hora_final` time NOT NULL DEFAULT '00:00:00' COMMENT 'hora final do evento',
  `descricao` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'descricao do evento',
  `local_evento` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'local do evento',
  PRIMARY KEY (`data_inicio`,`hora_inicio`,`data_final`,`hora_final`,`descricao`,`local_evento`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Extraindo dados da tabela `evento_geral`
--

INSERT INTO `evento_geral` (`id`, `data_inicio`, `hora_inicio`, `data_final`, `hora_final`, `descricao`, `local_evento`) VALUES
(3, '2015-06-05', '21:00:00', '2015-06-11', '22:40:00', 'Semana acadêmica', 'Auditório da Faculdade Senac Porto Alegre'),
(4, '2015-06-15', '19:00:00', '2015-06-09', '22:40:00', 'Bancas de TCC II', 'Salas de aula'),
(18, '2015-06-25', '21:00:00', '2015-06-09', '22:20:00', 'Evento de agradecimento aos professores', 'Auditório da faculdade');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=57 ;

--
-- Extraindo dados da tabela `info_locais`
--

INSERT INTO `info_locais` (`id`, `descricao`, `tags_local`, `imagem`, `email`, `telefone`, `horario`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`) VALUES
(8, 'Portaria', 'portaria', '', '', '', '', 1, 1, 160),
(9, 'Elevador 1 Térreo', 'elevador', '', '', '', '', 1, 1, 161),
(10, 'Elevador 2 Térreo', 'elevador', '', '', '', '', 1, 1, 162),
(11, 'Coordenação de turno', 'coordenação turno', '', '', '', '', 1, 1, 163),
(12, 'Sanitário Masculino 1 Térreo', 'sanitário masculino banheiro', '', '', '', '', 1, 1, 164),
(13, 'Sanitário Feminino 1 Térreo', 'sanitário feminino banheiro', '', '', '', '', 1, 1, 165),
(14, 'Escada - 2 andar e subsolo', 'escada acesso', '', '', '', '', 1, 1, 166),
(15, 'Shaft térreo', 'shaft', '', '', '', '', 1, 1, 167),
(16, 'Elevador de carga Térreo', 'elevador acesso vertical', '', '', '', '', 1, 1, 168),
(17, 'Sala de reuniões', 'reuniões reunião', '', '', '', '', 1, 1, 169),
(18, 'Administrativo Comunicação Marketing Eventos', 'administrativo comunicação marketing eventos', '', '', '', '', 1, 1, 170),
(19, 'Sala Docentes TI', 'docentes ti t.i.', '', '', '', '', 1, 1, 171),
(20, 'Escada de incêndio térreo - 2 andar', 'escada incêndio corta-fogo', '', '', '', '', 1, 1, 172),
(21, 'Área da Cantina', 'cantina alimentação lancheria lanche comida', '', '', '', '', 1, 1, 173),
(22, 'Cantina', 'cantina alimentação lancheria lanche comida', '', '', '', '', 1, 1, 174),
(23, 'Reprografia', 'xerox cópias encadernação', '', '', '', '', 1, 1, 175),
(24, 'Coordenação de Ensino Superior', 'coordenação curso coordenador', '', '', '', '', 1, 1, 176),
(25, 'Sala dos Professores', 'professor professores', '', '', '', '', 1, 1, 177),
(26, 'Laboratório Produção Multimídia 1', 'laboratório produção multimídia design', '', '', '', '', 1, 1, 102),
(27, 'Laboratório Produção Multimídia 2', 'laboratório produção multimídia design', '', '', '', '', 1, 1, 103),
(28, 'Financeiro', 'financeiro pagamento mensalidade', '', '', '', '', 1, 1, 178),
(29, 'Sala de Convivência de Funcionários', 'sala convivência terceirizados terceiros', '', '', '', '', 1, 1, 179),
(30, 'Coordenação de Pós Gradução', 'coordenação pós coordenador', '', '', '', '', 1, 1, 180),
(31, 'Soluções Corporativas ', 'soluções corporativas corporativo', '', '', '', '', 1, 1, 181),
(32, 'Área de Convivência Terceirizados', 'área convivência terceirizados terceiros', '', '', '', '', 1, 1, 182),
(33, 'Sanitário e vestiário Masculino Térreo', 'sanitário vestiario masculino banheiro wc', '', '', '', '', 1, 1, 183),
(34, 'Sanitário e vestiário Feminino Térreo', 'sanitário vestiário feminino banheiro wc', '', '', '', '', 1, 1, 184),
(35, 'Interagir', 'interagir', '', '', '', '', 1, 1, 185),
(36, 'Atendimento SEAP - Outros Cursos', 'serviço estágio aperfeiçoamento profissional todos cursos', '', '', '', '', 1, 1, 186),
(37, 'Ouvidoria', 'ouvidoria', '', '', '', '', 1, 1, 187),
(38, 'Atendimento SEAP Graduação', 'serviço estágio aperfeiçoamento profissional', '', '', '', '', 1, 1, 188),
(39, 'Sanitário Feminino 2 Térreo', 'sanitário feminino banheiro wc', '', '', '', '', 1, 1, 189),
(40, 'Sanitário Masculino 2 Térreo', 'sanitário masculino banheiro wc', '', '', '', '', 1, 1, 190),
(41, 'Estúdio de rádio', 'estúdio rádio', '', '', '', '', 1, 1, 191),
(42, 'Escada - 2 Andar', 'escada 2 andar', '', '', '', '', 1, 1, 192),
(43, 'Direção', 'direção diretoria', '', '', '', '', 1, 1, 193),
(44, 'Assessoria Direção', 'assessoria direção', '', '', '', '', 1, 1, 194),
(45, 'Escada de Incêndio Portaria - 2 Andar', 'escada incêndio corta-fogo', '', '', '', '', 1, 1, 195),
(46, 'Protocolo Secretaria', 'protocolo secretaria', '', '', '', '', 1, 1, 196),
(47, 'Direção de Ensino', 'direção ensino', '', '', '', '', 1, 1, 197),
(48, 'Secretaria', 'secretaria', 'secretaria', 'atendimentofatecpoa@senacrs.com.br', '(51) 30221044', '8:00 às 21:00', 1, 1, 198),
(49, 'Pedagógico', 'pegagógico', '', '', '', '', 1, 1, 199),
(50, 'Atendimento ao Público', 'atendimento publico venda informações', '', '', '', '', 1, 1, 159),
(51, 'Elevador 1 Segundo andar', 'elevador acesso', '', '', '', '', 1, 2, 261),
(54, 'Elevador 2 Segundo andar', 'elevador acesso', '', '', '', '', 1, 2, 262),
(55, 'Elevador 1 Terceiro andar', 'elevador acesso', '', '', '', '', 1, 3, 361),
(56, 'Elevador 2 Terceiro andar', 'elevador acesso', '', '', '', '', 1, 3, 362);

-- --------------------------------------------------------

--
-- Estrutura da tabela `lembrete_tipo`
--

CREATE TABLE IF NOT EXISTS `lembrete_tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `lembrete_tipo`
--

INSERT INTO `lembrete_tipo` (`id`, `nome`, `descricao`) VALUES
(1, 'pemail', 'Email enviado através da classe PhpMailer'),
(2, 'zsms', 'SMS enviado a partir de webservice da empresa Zenvia'),
(3, 'icloud', 'Evento do iCalendar da Apple, que envia o lembrete do tipo PUSH no disposito Apple do usuário'),
(4, 'gpush', 'Evento do Google Calendar, que envia o lembrete do tipo PUSH nos dispositivos mobile ou popup nos desktops logados com conta Google do usuário'),
(5, 'email', 'Evento do Google Calendar, que envia email para os dispositivos logados com conta Google do usuário'),
(6, 'sms', 'Evento do Google Calendar, que envia sms para os dispositivos logados com conta Google do usuário, recurso será desativado após 27/06/2015 pelo Google');

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
-- Estrutura da tabela `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id do perfil',
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'descricao do perfil',
  PRIMARY KEY (`descricao`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='tabela de perfil de usuarios' AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `perfil`
--

INSERT INTO `perfil` (`id`, `descricao`) VALUES
(1, 'administrador'),
(2, 'gerente'),
(3, 'usuario');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=88 ;

--
-- Extraindo dados da tabela `sala`
--

INSERT INTO `sala` (`id`, `fk_id_unidade`, `andar`, `numero`, `fk_id_categoria`) VALUES
(19, 1, 1, 102, 2),
(20, 1, 1, 103, 2),
(46, 1, 1, 159, 1),
(1, 1, 1, 160, 6),
(2, 1, 1, 161, 5),
(3, 1, 1, 162, 5),
(4, 1, 1, 163, 6),
(5, 1, 1, 164, 6),
(6, 1, 1, 165, 6),
(7, 1, 1, 166, 5),
(8, 1, 1, 167, 6),
(9, 1, 1, 168, 5),
(10, 1, 1, 169, 1),
(11, 1, 1, 170, 1),
(12, 1, 1, 171, 1),
(13, 1, 1, 172, 5),
(14, 1, 1, 173, 3),
(15, 1, 1, 174, 3),
(16, 1, 1, 175, 4),
(17, 1, 1, 176, 1),
(18, 1, 1, 177, 6),
(21, 1, 1, 178, 1),
(22, 1, 1, 179, 1),
(23, 1, 1, 180, 1),
(24, 1, 1, 181, 1),
(25, 1, 1, 182, 6),
(26, 1, 1, 183, 6),
(27, 1, 1, 184, 6),
(28, 1, 1, 185, 1),
(29, 1, 1, 186, 1),
(30, 1, 1, 187, 1),
(31, 1, 1, 188, 1),
(32, 1, 1, 189, 6),
(33, 1, 1, 190, 6),
(34, 1, 1, 191, 2),
(35, 1, 1, 192, 5),
(36, 1, 1, 193, 1),
(37, 1, 1, 194, 1),
(38, 1, 1, 195, 5),
(39, 1, 1, 196, 1),
(40, 1, 1, 197, 1),
(41, 1, 1, 198, 1),
(47, 1, 1, 199, 1),
(59, 1, 2, 202, 2),
(60, 1, 2, 203, 2),
(61, 1, 2, 204, 2),
(62, 1, 2, 205, 2),
(84, 1, 2, 261, 5),
(85, 1, 2, 262, 5),
(42, 1, 3, 301, 2),
(63, 1, 3, 302, 2),
(64, 1, 3, 303, 2),
(65, 1, 3, 304, 2),
(66, 1, 3, 305, 2),
(86, 1, 3, 361, 5),
(87, 1, 3, 362, 5),
(67, 1, 4, 401, 2),
(68, 1, 4, 402, 2),
(69, 1, 4, 403, 2),
(70, 1, 4, 404, 2),
(71, 1, 4, 405, 2),
(72, 1, 4, 406, 2),
(73, 1, 4, 407, 2),
(74, 1, 4, 408, 2),
(44, 1, 4, 409, 2),
(75, 1, 4, 410, 2),
(53, 1, 5, 501, 2),
(51, 1, 5, 502, 2),
(54, 1, 5, 503, 2),
(48, 1, 5, 504, 2),
(76, 1, 5, 505, 2),
(49, 1, 6, 601, 2),
(47, 1, 6, 602, 2),
(43, 1, 6, 603, 2),
(46, 1, 6, 604, 2),
(77, 1, 6, 605, 2),
(57, 1, 7, 701, 2),
(55, 1, 7, 702, 2),
(56, 1, 7, 703, 2),
(45, 1, 7, 704, 2),
(78, 1, 7, 705, 2),
(79, 1, 8, 801, 2),
(80, 1, 8, 802, 2),
(81, 1, 8, 803, 2),
(82, 1, 8, 804, 2),
(83, 1, 8, 805, 2),
(58, 2, 2, 201, 2),
(50, 2, 5, 502, 2);

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
