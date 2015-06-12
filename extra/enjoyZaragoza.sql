-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-06-2015 a las 10:02:04
-- Versión del servidor: 5.5.41-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `enjoyZaragoza`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`id`, `category`) VALUES
(1, 'musica'),
(2, 'arte'),
(3, 'deporte'),
(4, 'teatro'),
(5, 'cine'),
(6, 'videojuegos'),
(7, 'manga'),
(8, 'social'),
(9, 'cultural'),
(10, 'otros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_creator_user` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `dateCreate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateFinish` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` varchar(16) NOT NULL DEFAULT 'accepted',
  `category` varchar(15) NOT NULL,
  PRIMARY KEY (`id`,`id_creator_user`),
  KEY `fk_creator_user:event_idx` (`id_creator_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Volcado de datos para la tabla `event`
--

INSERT INTO `event` (`id`, `id_creator_user`, `name`, `dateCreate`, `dateFinish`, `status`, `category`) VALUES
(64, 16, 'Concierto benéfico', '2015-06-12 09:35:00', '2015-06-12 09:31:00', 'completed', 'musica'),
(65, 16, 'Clases de yoga al aire libre', '2015-06-12 09:38:00', '2015-06-20 11:30:00', 'accepted', 'deporte'),
(66, 16, 'Ven a ver la LCS a nuestro bar', '2015-06-12 09:43:00', '2015-06-19 07:00:00', 'accepted', 'videojuegos'),
(67, 16, 'Hackathon en Zaragoza', '2015-06-12 09:46:00', '2015-07-02 10:00:00', 'accepted', 'otros'),
(68, 16, 'Charla de los vecinos del barrio delicias sob', '2015-06-12 09:50:00', '2015-06-23 18:00:00', 'accepted', 'cultural'),
(69, 16, 'Pachanga con los amigos', '2015-06-12 09:57:00', '2015-06-20 10:30:00', 'accepted', 'deporte');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_files`
--

CREATE TABLE IF NOT EXISTS `events_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` int(11) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `file` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_events_files_1_idx` (`event`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `events_files`
--

INSERT INTO `events_files` (`id`, `event`, `source`, `file`) VALUES
(27, 64, 'files/events/64.jpg', 'image/jpeg'),
(28, 65, 'files/events/65.jpg', 'image/jpeg'),
(29, 66, 'files/events/66.jpg', 'image/jpeg'),
(30, 67, 'files/events/67.jpg', 'image/jpeg'),
(31, 68, 'files/events/68.jpg', 'image/jpeg'),
(32, 69, 'files/events/69.jpg', 'image/jpeg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_info`
--

CREATE TABLE IF NOT EXISTS `events_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_event` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `price` varchar(45) DEFAULT 'free',
  `capacity` varchar(45) DEFAULT NULL,
  `details` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_event`),
  KEY `fk_events_info_1` (`id_event`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `events_info`
--

INSERT INTO `events_info` (`id`, `id_event`, `description`, `phone`, `price`, `capacity`, `details`) VALUES
(27, 64, 'Evento benéfico para ayudar a las asociaciones de animales, la entrada anticipada son 5€ y en taquilla 6€.', '616223344', '6', '100', 'Mayoría de edad obligatorio'),
(28, 65, 'Quedada en el parque grande para unas clases de yoga gratuitas.', '655789933', 'free', 'unlimited', 'Traer ropa de deporte, una toalla y una esterilla.'),
(29, 66, 'Ven a ver a nuestro var la LCS europea, tenemos grandes pantallas, será una velada encantadora con los aficionados a los videojuegos.', '678543123', 'free', '150', 'Para todos los públicos'),
(30, 67, 'Hola amigos, el próximo  2 de Julio se producirá una quedada colectiva de programadores para intentar crear de 0 un videojuego de temática futurística,  habrá concursos y premios, si te gusta codear, no lo duddes, ven.', '667353442', '10', '200', 'Si te quedas a dormir, tráete una esterilla, te ayudará a descansar :)'),
(31, 68, 'Hola vecinos, el próximo día 23 de Junio se producirán unas charlas para hablar sobre los problemas del barrio, las políticas que necesita el barrio y que hacer, estáis todos invitados para oír y hablar.', '976334455', 'free', 'unlimited', 'Ven con ganas e ilusión por tu barrio.'),
(32, 69, 'Hola a todos, el próximo diá 20, unos amigos y yo hemos decidido ir al parque grande a jugar unas pachangas, cualquiera que le apetezca jugar un rato que se pase.', '677844532', 'free', 'unlimited', 'Traer las deportivas de futbol y algo para cambiarse!');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events_score`
--

CREATE TABLE IF NOT EXISTS `events_score` (
  `id_event` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `score` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_event`,`id_user`),
  KEY `fk_events_score_2_idx` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lang`
--

CREATE TABLE IF NOT EXISTS `lang` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '',
  `slug` varchar(3) NOT NULL DEFAULT '',
  `locale` varchar(5) NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL,
  `priority` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `lang`
--

INSERT INTO `lang` (`id`, `name`, `slug`, `locale`, `active`, `priority`) VALUES
(1, 'English', 'eng', 'en_US', 1, 1),
(2, 'Español', 'esp', 'es_ES', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lang_strings`
--

CREATE TABLE IF NOT EXISTS `lang_strings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language` int(11) NOT NULL,
  `label` varchar(64) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Volcado de datos para la tabla `lang_strings`
--

INSERT INTO `lang_strings` (`id`, `language`, `label`, `text`) VALUES
(1, 2, 'modal-label-logSignin', 'Inicia sesión o crea una cuenta'),
(2, 1, 'modal-label-logSignin', 'Log in or Sign in'),
(3, 2, 'modal-label-login', 'Entra en tu cuenta.'),
(4, 1, 'modal-label-login', 'Log in.'),
(5, 2, 'modal-label-email-placeholder', 'Tu email...'),
(6, 1, 'modal-label-email-placeholder', 'Your email...'),
(7, 2, 'modal-label-pass-placeholder', 'Tu contraseña...'),
(8, 1, 'modal-label-pass-placeholder', 'Your password...'),
(9, 2, 'modal-label-login-button', 'Iniciar'),
(10, 1, 'modal-label-login-button', 'Log in'),
(11, 2, 'modal-label-login-button-forget', '¿Olvidaste la contraseña?'),
(12, 1, 'modal-label-login-button-forget', 'Do you forgot your password?'),
(13, 2, 'modal-label-signin', 'Crear cuenta.'),
(14, 1, 'modal-label-signin', 'Sign in.'),
(15, 2, 'modal-label-tooltip', 'Crea tu cuenta para acceder a la información de los eventos. Es gratis y sencillo.'),
(16, 1, 'modal-label-tooltip', 'Sign in to access to the info about events.It''s free and simple.'),
(17, 2, 'modal-label-name-placeholder', 'Tu nombre...'),
(18, 1, 'modal-label-name-placeholder', 'Your name...'),
(19, 2, 'modal-label-terms', 'Acepto los términos de registro.'),
(20, 1, 'modal-label-terms', 'I accept the terms of registration'),
(21, 2, 'modal-label-create-account', 'Crear cuenta.'),
(22, 1, 'modal-label-create-account', 'Create a account.'),
(23, 2, 'modal-label-info', '*Puedes agilizar el registro usando directamente tu cuenta de Facebook.'),
(24, 1, 'modal-label-info', '*You can make the registration easier using your Facebook directly.'),
(25, 2, 'header-logged-admin', 'Administar'),
(26, 1, 'header-logged-admin', 'dashboard'),
(27, 2, 'header-logged-profile', 'Mi perfil'),
(28, 1, 'header-logged-profile', 'My profile'),
(29, 2, 'label-log-out', 'Desconectarse'),
(30, 1, 'label-log-out', 'Log out'),
(31, 2, 'header-create-event', 'Crear evento'),
(32, 1, 'header-create-event', 'Create event'),
(33, 2, 'how-it-works', 'Como funciona'),
(34, 1, 'how-it-works', 'How it works'),
(35, 2, 'label-search', 'Buscar'),
(36, 1, 'label-search', 'Search'),
(37, 2, 'header-my-account', 'Mi cuenta'),
(38, 1, 'header-my-account', 'My account'),
(39, 1, 'meta-description', '#meta-description#'),
(40, 2, 'meta-description', '#meta-description#'),
(41, 2, 'title-404', '#title-404#'),
(42, 2, 'hello_world', '#hello_world#'),
(43, 2, 'header-logged-account', '#header-logged-account#'),
(44, 1, 'title-404', '#title-404#'),
(45, 2, 'title-discover', '#title-discover#'),
(46, 2, 'title-create', '#title-create#'),
(47, 2, 'title-about', '#title-about#'),
(48, 2, 'login', '#login#'),
(49, 2, 'error-login', '#error-login#'),
(50, 2, 'label-status-1', '#label-status-1#'),
(51, 2, 'label-status-0', '#label-status-0#');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(5) NOT NULL DEFAULT 'user',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `dateRegister` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dateLastLogin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `level`, `active`, `dateRegister`, `dateLastLogin`) VALUES
(16, 'daniel', 'danielzgz11@gmail.com', 'c0efe5756a9db56b553da18d23e95b0e', 'admin', 1, '2015-05-08 13:42:11', '2015-06-12 09:57:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_files`
--

CREATE TABLE IF NOT EXISTS `users_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `source` varchar(255) DEFAULT NULL,
  `tittle` varchar(255) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `file` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_files_index` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_info`
--

CREATE TABLE IF NOT EXISTS `users_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `biography` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `surname` varchar(45) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_user`),
  KEY `fk_id_users_info` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_score`
--

CREATE TABLE IF NOT EXISTS `users_score` (
  `id_user` int(11) NOT NULL,
  `id_user_score` int(11) NOT NULL,
  `score` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_user`,`id_user_score`),
  KEY `fk_users_score_2_idx` (`id_user_score`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_events`
--

CREATE TABLE IF NOT EXISTS `user_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_user`,`id_event`),
  KEY `fk_user_events_events_idx` (`id_event`),
  KEY `fk_id_user_events` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Volcado de datos para la tabla `user_events`
--

INSERT INTO `user_events` (`id`, `id_user`, `id_event`) VALUES
(21, 16, 64),
(22, 16, 65),
(23, 16, 66),
(24, 16, 67),
(25, 16, 68),
(26, 16, 69);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `fk_creator_user:event` FOREIGN KEY (`id_creator_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `events_files`
--
ALTER TABLE `events_files`
  ADD CONSTRAINT `fk_events_files_drop` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `events_info`
--
ALTER TABLE `events_info`
  ADD CONSTRAINT `fk_events_info_1` FOREIGN KEY (`id_event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `events_score`
--
ALTER TABLE `events_score`
  ADD CONSTRAINT `fk_events_score_1` FOREIGN KEY (`id_event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_events_score_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_files`
--
ALTER TABLE `users_files`
  ADD CONSTRAINT `fk_user_files_drop` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_info`
--
ALTER TABLE `users_info`
  ADD CONSTRAINT `fk_id_users_info` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users_score`
--
ALTER TABLE `users_score`
  ADD CONSTRAINT `fk_users_score_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_score_2` FOREIGN KEY (`id_user_score`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `user_events`
--
ALTER TABLE `user_events`
  ADD CONSTRAINT `fk_id_user_events` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_events_events` FOREIGN KEY (`id_event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
