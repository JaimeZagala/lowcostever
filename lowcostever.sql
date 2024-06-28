-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-05-2024 a las 19:55:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lowcostever`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  `pais` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellidos`, `direccion`, `ciudad`, `provincia`, `pais`, `correo`, `contraseña`) VALUES
(1, 'cliente1', 'apellidos1', 'direccion1', 'ciudad1', 'provincia1', 'pais1', 'correo1@lowcostever.com', 'contraseña1'),
(2, 'cliente2', 'apellidos2', 'direccion2', 'ciudad2', 'provincia2', 'pais2', 'correo2@lowcostever.com', 'contraseña2'),
(3, 'cliente3', 'apellidos3', 'direccion3', 'ciudad3', 'provincia3', 'pais3', 'correo3@lowcostever.com', 'contraseña3'),
(4, 'cliente4', 'apellidos4', 'direccion4', 'ciudad4', 'provincia4', 'pais4', 'correo4@lowcostever.com', 'contraseña4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `producto` varchar(50) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `producto`, `descripcion`, `precio`, `cantidad`) VALUES
(1, 'Cocaína', 'La cocaína es una droga muy adictiva que se elabora a partir de las hojas de coca, una planta que crece en América del Sur. Algunas personas usan esta sustancia ilegal para drogarse. En casos raros, también se utiliza como medicamento recetado para anestesia durante ciertas cirugías. Como droga ilegal, la cocaína suele ser un polvo cristalino fino y blanco. A veces, los traficantes la mezclan con maicena, talco o harina para que parezca que tienen más cocaína. De esa manera pueden ganar más dinero. También pueden mezclarla con otras drogas ilegales. Otra forma de droga es el crack. La cocaína crack se ha calentado para convertirla en cristal de roca.', 59.95, 200),
(2, 'Heroína', 'La heroína es una droga opioide ilegal y muy adictiva. Está hecha de morfina, que proviene de la vaina de las plantas de adormidera (amapola). Estas plantas crecen en el sudeste y suroeste de Asia, México y Colombia. La heroína puede ser un polvo blanco o marrón, o una sustancia negra y pegajosa conocida como \"heroína de alquitrán negro\".', 59.95, 1000),
(3, 'Marihuana', 'La marihuana es una mezcla verde, marrón o gris de partes desmenuzadas y secas de la planta de marihuana. La planta contiene sustancias químicas que actúan en el cerebro y pueden cambiar su estado de ánimo o conciencia.', 4.95, 10000),
(4, 'Éxtasis', 'Las drogas de club son un grupo de drogas psicoactivas. Actúan sobre el sistema nervioso central y pueden causar cambios en el estado de ánimo, la conciencia y el comportamiento. A menudo, los adultos jóvenes usan estas sustancias en bares, conciertos, clubes nocturnos y fiestas. Como la mayoría de las drogas, tienen apodos que cambian con el tiempo o son diferentes en distintas áreas del país.', 9.95, 1000),
(5, 'Metanfetamina', 'La metanfetamina es una droga estimulante muy adictiva. Es un polvo que se puede presentar como una píldora o una roca brillante (llamada cristal). El polvo se puede ingerir o inhalar por la nariz. También se puede mezclar con un líquido e inyectarse con una aguja. La metanfetamina cristal se fuma en una pequeña pipa de vidrio.\r\nAl principio la droga provoca una oleada de buenos sentimientos, pero luego los usuarios se sienten nerviosos, demasiado excitados, enojados o asustados. El uso de metanfetamina puede llevar rápidamente a la adicción.', 29.95, 1),
(6, 'Ketamina', 'Las drogas de club son un grupo de drogas psicoactivas. Actúan sobre el sistema nervioso central y pueden causar cambios en el estado de ánimo, la conciencia y el comportamiento. A menudo, los adultos jóvenes usan estas sustancias en bares, conciertos, clubes nocturnos y fiestas. Como la mayoría de las drogas, tienen apodos que cambian con el tiempo o son diferentes en distintas áreas del país.', 44.95, 100),
(7, 'Alucinógenos', 'Son sustancias psicoactivas que al ser tomadas alteran la percepción de la realidad, las emociones y el pensamiento de quien las consume. Las drogas alucinógenas son capaces de modificar las sensaciones y los sentidos, pudiendo generar alucinaciones y alteraciones sensoriales.', 11.95, 1000),
(8, 'MDMA', 'También conocida como Éxtasis o Molly, esta droga está vinculada a contextos recreativos y concretamente a eventos de música electrónica, si bien su popularidad es tal que hace mucho que desbordó esa clase de escena. De hecho, es una de las drogas más consumidas por los jóvenes durante los fines de semana, normalmente a la vez que socializan.', 14.95, 100),
(9, 'Anfetamina', 'Las anfetaminas se basan en la potenciación excesiva de los efectos de la dopamina y la noradrenalina, sustancias que están presentes de manera natural en el cerebro y que actúan como neurotransmisores, es decir, moléculas mensajeras que van de una neurona a otra. Por otro lado, sus efectos estimulantes de las anfetaminas han hecho que en ciertos casos, y solo bajo supervisión médica, versiones deesta sustancia se utilicen como fármacos para tratar algunos trastornos, como por ejemplo la narcolepsia o el TDAH.', 49.95, 100),
(10, 'Crack', 'El crack es una droga extremadamente adictiva que se consigue al mezclar cocaína con bicarbonato sódico. A diferencia de la cocaína, el crack se fuma y se empiezan a notar los efectos a los pocos segundos. La sensación que produce es de euforia y bienestar. Sin embargo, es una droga muy dañina (más que la cocaína) para el cuerpo, pues su consumo excesivo es potencialmente mortal.', 59.95, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contraseña` varchar(50) NOT NULL,
  `rango` tinyint(4) NOT NULL DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `alias`, `correo`, `contraseña`, `rango`) VALUES
(1, 'admin', 'admin@lowcostever.com', 'admin1234', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
