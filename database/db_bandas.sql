-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2022 a las 20:56:03
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_bandas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bandas`
--

CREATE TABLE `bandas` (
  `id_banda` int(11) NOT NULL,
  `id_genero_fk` int(11) NOT NULL,
  `nombre_banda` varchar(45) NOT NULL,
  `cantidad_discos` int(11) NOT NULL,
  `origen_banda` varchar(45) NOT NULL,
  `imagen_banda` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `bandas`
--

INSERT INTO `bandas` (`id_banda`, `id_genero_fk`, `nombre_banda`, `cantidad_discos`, `origen_banda`, `imagen_banda`) VALUES
(3, 2, 'ABBA', 9, ' Estocolmo, Suecia (1972)', 'images/abbaa.jpg'),
(4, 1, 'Soda stereo', 7, 'Buenos Aires,Argentina(1982)', 'images/soda stereo.png'),
(5, 2, 'La Oreja de Van Gogh', 8, 'San Sebastián, España (1996)', 'images/la oreja de van gogh.jpg'),
(21, 1, 'La vela puerca', 10, 'Montevideo,Uruguay(1995)', 'images/la vela puerca.jpg'),
(22, 1, 'El Plan De La Mariposa', 6, 'Necochea,Argentina(2008)', 'images/el plan de la mariposa.jpg'),
(23, 1, 'Queen', 15, 'Londres, Inglaterra(1970)', 'images/queen.jpg'),
(24, 2, 'Backstreet Boys', 9, 'Orlando, Florida Estados Unidos(1993)', 'images/backstreet boys.jpg'),
(34, 1, 'La Renga', 10, ' Argentina, Buenos Aires(1994)', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `exitos_musicales`
--

CREATE TABLE `exitos_musicales` (
  `id_exitos` int(11) NOT NULL,
  `id_nombre_banda_fk` int(11) NOT NULL,
  `cancion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `exitos_musicales`
--

INSERT INTO `exitos_musicales` (`id_exitos`, `id_nombre_banda_fk`, `cancion`) VALUES
(1, 21, '-El Viejo.\n-Zafar.\n-Mi Semilla.'),
(2, 23, '-Bohemian Rhapsody.\r\n-I Want to Break Free.\r\n-The Show Must Go On.'),
(3, 3, '-Dancing Queen.'),
(4, 4, 'De musica ligera'),
(5, 5, 'Rosas'),
(6, 22, 'El Riesgo'),
(7, 24, ' I Want It That Way');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id_genero` int(11) NOT NULL,
  `genero_banda` varchar(25) NOT NULL,
  `historia_genero` varchar(500) NOT NULL,
  `instrumentos_comunes` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id_genero`, `genero_banda`, `historia_genero`, `instrumentos_comunes`) VALUES
(1, 'Rock', 'El rock and roll como tal, El género también estaba influenciado por géneros tradicionales como el Hillbilly, la música folk de Irlanda, la música gospel y la música country. Regresando aún más atrás en el tiempo, se puede trazar el linaje del rock and roll hasta el antiguo distrito Five Points de Nueva York a mediados del siglo XIX, que fue el escenario de la primera fusión entre la música africana fuertemente rítmica y los géneros europeos.tiene sus orígenes entre 1930 y 1950', 'Bajo. batería. guitarra eléctrica. teclados. voz.'),
(2, 'Pop', 'La música Pop tiene su origen en la música popular Estadounidense y Británica que surge a partir del Rock & Roll de los años 1950', 'Voz, guitarra, bajo, batería, guitarra eléctrica, teclado, sintetizador, caja de ritmos, secuenciador, sampler, percusión'),
(15, 'reggae', 'bob marley', 'guitarra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `nombre_usuario` varchar(50) NOT NULL,
  `contraseña` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`nombre_usuario`, `contraseña`) VALUES
('oroquietaluciano@gmail.com', '$2y$10$mo8/XJ.vff0LvO/LQGbuj.Ami459kSwgEykdHP0M/y9ipA9CplxP.');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bandas`
--
ALTER TABLE `bandas`
  ADD PRIMARY KEY (`id_banda`),
  ADD KEY `fk_restriction` (`id_genero_fk`);

--
-- Indices de la tabla `exitos_musicales`
--
ALTER TABLE `exitos_musicales`
  ADD PRIMARY KEY (`id_exitos`),
  ADD KEY `fk_exitos_restriction` (`id_nombre_banda_fk`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id_genero`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bandas`
--
ALTER TABLE `bandas`
  MODIFY `id_banda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `exitos_musicales`
--
ALTER TABLE `exitos_musicales`
  MODIFY `id_exitos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `id_genero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bandas`
--
ALTER TABLE `bandas`
  ADD CONSTRAINT `fk_restriction` FOREIGN KEY (`id_genero_fk`) REFERENCES `genero` (`id_genero`);

--
-- Filtros para la tabla `exitos_musicales`
--
ALTER TABLE `exitos_musicales`
  ADD CONSTRAINT `fk_exitos_restriction` FOREIGN KEY (`id_nombre_banda_fk`) REFERENCES `bandas` (`id_banda`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
