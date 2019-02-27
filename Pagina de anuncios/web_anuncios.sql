-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-02-2019 a las 15:39:11
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `web_anuncios`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

CREATE TABLE `anuncios` (
  `id` int(11) NOT NULL,
  `producto` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `precio` decimal(9,2) NOT NULL,
  `precio_alto` decimal(9,2) NOT NULL,
  `precio_chollo` decimal(9,2) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_urlweb` int(11) NOT NULL,
  `url_foto` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `url_anuncio` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`id`, `producto`, `precio`, `precio_alto`, `precio_chollo`, `id_categoria`, `id_urlweb`, `url_foto`, `url_anuncio`, `id_usuario`) VALUES
(28, 'Zapatillas para correr Nike Air Zoom', '70.00', '90.00', '60.00', 22, 5, 'https://c.static-nike.com/a/images/t_PDP_1728_v1/f_auto,b_rgb:f5f5f5/sjezybjiqegfpwwavg8d/air-zoom-pegasus-35-zapatillas-de-running-kX9NZL.jpg', '', 7),
(29, 'Honda VFR VTEC ABS 2002', '3000.00', '4000.00', '3200.00', 18, 4, 'https://www.motorcyclespecs.co.za/Gallery/Honda%20VFR800%20abs%2003%20%202.jpg', '', 7),
(30, 'Sillas de diseño', '300.00', '250.00', '170.00', 20, 7, 'https://www.tendenzastore.com/media/catalog/product/cache/1/image/650x/040ec09b1e35df139433887a97daa66f/s/t/stua-laclasica-19.jpg', '', 7),
(31, 'Lego Mindstorm', '200.00', '350.00', '230.00', 17, 11, 'https://images-na.ssl-images-amazon.com/images/I/91Qxf3uhv6L._SL1500_.jpg', '', 7),
(32, 'La casa moderna de Playmobil', '40.00', '60.00', '40.00', 17, 6, 'https://images-na.ssl-images-amazon.com/images/I/91kP7trlofL._SL1500_.jpg', '', 7),
(33, 'Portatil Alienware m17x R4', '1500.00', '1400.00', '1200.00', 24, 5, 'https://www.laptopmag.com/images/uploads/ppress/43862/alienware_m17x_2012_g16.jpg', '', 7),
(34, 'Macbook Pro 2018', '1600.00', '2000.00', '1500.00', 24, 7, 'https://www.macnificos.com/sites/files/styles/product_page_zoom/public/images/product/mbp15.jpg?itok=kWWwTr-y', '', 7),
(35, 'BMW R1200GS', '15000.00', '16000.00', '14000.00', 18, 4, 'https://www.mundomotero.com/wp-content/uploads/2017/07/BMW-R-1200-GS-Adventure-2018-7-1024x768.jpg', '', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(22, 'Deportes'),
(23, 'Fotografía'),
(24, 'Informática '),
(21, 'Inmuebles'),
(17, 'Juguetes'),
(19, 'Maquinaria'),
(20, 'Muebles'),
(18, 'Vehículos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `reg_token` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `reg_conf` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `nombre`, `password`, `reg_token`, `reg_conf`) VALUES
(7, 'harkaitz2@gmail.com', 'Harkaitz', '81dc9bdb52d04dc20036dbd8313ed055', 'ys97Iy13gWZtJRdvQXRrm4hQKR3Ei2', 1),
(8, 'amaya.reguera@gmail.com', 'Perico', '81dc9bdb52d04dc20036dbd8313ed055', 'zUE5mZsNhD0yzRdqQmHBA2cHmnSva3', 1),
(9, 'pepe@pepe.es', 'Pepe', '81dc9bdb52d04dc20036dbd8313ed055', 'EfwDP24matMyqJaLVvKxGqNOgqgej8', 1),
(10, 'Unai@pepe.es', 'Unai', '81dc9bdb52d04dc20036dbd8313ed055', 'Rq1dVoaS3dPpb1CTC3iIlpLQJjqT1k', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `webs`
--

CREATE TABLE `webs` (
  `id` int(11) NOT NULL,
  `web` varchar(30) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `url_web` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `webs`
--

INSERT INTO `webs` (`id`, `web`, `url_web`) VALUES
(4, 'Coches.net', 'http://www.coches.net/'),
(5, 'Wallapop', 'https://es.wallapop.com/'),
(6, 'Facebook Market', 'https://www.facebook.com/marketplace'),
(7, 'Mil Anuncios', 'www.milanuncios.com'),
(11, 'Vibbo', 'www.vibbo.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`,`id_usuario`),
  ADD KEY `id_urlweb` (`id_urlweb`),
  ADD KEY `id_categoria_2` (`id_categoria`),
  ADD KEY `anuncios_ibfk_2` (`id_usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `webs`
--
ALTER TABLE `webs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `webs`
--
ALTER TABLE `webs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `anuncios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `anuncios_ibfk_3` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `anuncios_ibfk_4` FOREIGN KEY (`id_urlweb`) REFERENCES `webs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
