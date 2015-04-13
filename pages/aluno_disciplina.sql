-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 12-Abr-2015 às 20:17
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno_disciplina`
--

CREATE TABLE IF NOT EXISTS `aluno_disciplina` (
  `id` int(11) NOT NULL,
  `dia_semana` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `turno` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `fk_id_aluno` int(11) NOT NULL,
  `fk_sala_fk_id_unidade` int(11) NOT NULL,
  `fk_andar_sala` tinyint(4) NOT NULL,
  `fk_numero_sala` int(11) NOT NULL,
  `fk_id_disciplina` int(11) NOT NULL,
  KEY `fk_aluno_disciplina_aluno1_idx` (`fk_id_aluno`),
  KEY `fk_aluno_disciplina_sala1_idx` (`fk_sala_fk_id_unidade`,`fk_andar_sala`,`fk_numero_sala`),
  KEY `fk_aluno_disciplina_disciplina1_idx` (`fk_id_disciplina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `aluno_disciplina`
--

INSERT INTO `aluno_disciplina` (`id`, `dia_semana`, `turno`, `fk_id_aluno`, `fk_sala_fk_id_unidade`, `fk_andar_sala`, `fk_numero_sala`, `fk_id_disciplina`) VALUES
(0, 'SEG', 'N', 2, 1, 3, 301, 32),
(0, 'TER', 'N', 2, 1, 6, 603, 30),
(0, 'QUA', 'N', 2, 1, 6, 603, 28),
(0, 'QUI', 'N', 2, 1, 4, 409, 31),
(0, 'SEX', 'N', 2, 1, 7, 704, 23);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
