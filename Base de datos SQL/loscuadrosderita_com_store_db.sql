-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 30, 2021 at 03:38 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loscuadrosderita_com_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `compra`
--

CREATE TABLE `compra` (
  `id_compra` int(11) NOT NULL,
  `forma_pago_compra` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preciototal_compra` int(11) DEFAULT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad_compra` tinyint(11) NOT NULL,
  `id_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `compra`
--

INSERT INTO `compra` (`id_compra`, `forma_pago_compra`, `preciototal_compra`, `id_pedido`, `id_producto`, `cantidad_compra`, `id_estado`) VALUES
(1, 'Efectivo', 134, 1, 1, 1, 2),
(2, 'tarjeta', 160, 2, 16, 1, 2),
(3, 'tarjeta', 160, 2, 22, 3, 2),
(4, 'tarjeta', 160, 3, 3, 3, 1),
(5, 'tarjeta', 160, 3, 8, 2, 1),
(6, 'tarjeta', 160, 3, 11, 2, 1),
(7, 'tarjeta', 160, 3, 10, 1, 1),
(8, 'tarjeta', 145, 3, 13, 2, 1),
(9, 'tarjeta', 160, 3, 19, 1, 1),
(10, 'tarjeta', 160, 4, 16, 1, 1),
(11, 'tarjeta', 160, 5, 29, 1, 1),
(12, 'Efectivo', 160, 6, 10, 1, 1),
(13, 'Efectivo', 160, 7, 8, 2, 1),
(14, 'Efectivo', 160, 7, 22, 1, 1),
(15, 'tarjeta', 160, 8, 21, 2, 2),
(16, 'Efectivo', 160, 9, 5, 1, 1),
(17, 'tarjeta', 160, 10, 10, 1, 1),
(19, 'tarjeta', 160, 10, 19, 1, 1),
(20, 'tarjeta', 160, 11, 20, 1, 1),
(21, 'tarjeta', 129, 12, 6, 1, 1),
(22, 'tarjeta', 160, 11, 29, 1, 1),
(23, 'Efectivo', 160, 13, 16, 1, 1),
(24, 'tarjeta', 160, 14, 31, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `consulta`
--

CREATE TABLE `consulta` (
  `id_consulta` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `mensaje_consulta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `respuesta_consulta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `like_consulta` int(11) DEFAULT NULL,
  `fecha_consulta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hora_consulta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_consulta` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consulta`
--

INSERT INTO `consulta` (`id_consulta`, `id_usuario`, `id_producto`, `mensaje_consulta`, `respuesta_consulta`, `like_consulta`, `fecha_consulta`, `hora_consulta`, `estado_consulta`) VALUES
(1, 2, 1, 'Cuánto se demora en realizar este Cuadro?', '1 Semana desde la fecha de confirmación de solicitud', 0, '2020-12-25', '17:00', 'Respondido'),
(2, 3, 3, 'Qué Bonito ¿Cuánto está?', 'El precio lo tienes justo arribita S/.160 soles', 0, '2021-02-19', '10:36', 'Respondido'),
(3, 2, 3, 'Este me encanta a cuanto me lo dejas?', 'Sin leer', 1, '2021-01-08', '23:33', 'Sin Responder'),
(4, 7, 1, 'Que Mono Lo envía a Europa?', 'Sin leer', 1, '2021-01-09', '17:38', 'Sin Responder'),
(5, 2, 4, 'Me gustan mucho las flores', 'No hay respuestaSin leer', 0, '2021-01-14', '1:45', 'Sin responder'),
(8, 2, 2, '', '', 1, '2021-01-10', '14:35', ''),
(9, 3, 2, '', '', 0, '2021-04-2', '22:24', 'xfas'),
(10, 3, 4, '', '', 1, '2021-01-20', '19:06', ''),
(11, 3, 1, '', '', 1, '2021-01-10', '13:13', ''),
(12, 6, 4, '', '', 1, '2021-01-10', '21:53', ''),
(13, 5, 2, '', '', 1, '2021-01-10', '21:57', ''),
(14, 3, 15, '', '', 0, '2021-01-19', '23:43', ''),
(15, 3, 5, '', '', 0, '2021-01-11', '22:5', ''),
(16, 3, 8, '', '', 0, '2021-01-14', '1:52', ''),
(17, 3, 16, '', '', 1, '2021-01-13', '18:56', ''),
(18, 3, 7, '', '', 0, '2021-01-11', '23:58', ''),
(19, 3, 6, '', '', 0, '2021-01-12', '0:3', ''),
(20, 3, 17, NULL, NULL, 0, '2021-01-17', '13:47', NULL),
(21, 3, 18, '', '', 0, '2021-01-13', '18:49', ''),
(22, 3, 27, '', '', 0, '2021-01-14', '1:13', ''),
(23, 3, 26, '', '', 1, '2021-01-21', '19:20', ''),
(24, 3, 25, '', '', 1, '2021-01-12', '15:44', ''),
(25, 3, 28, '', '', 0, '2021-01-30', '17:41', ''),
(26, 2, 28, '', '', 1, '2021-01-14', '1:45', ''),
(27, 3, 14, '', '', 1, '2021-01-22', '21:30', ''),
(32, 10, 2, '', '', 1, '2021-01-24', '00:18', ''),
(33, 10, 29, '', '', 1, '2021-01-24', '00:20', ''),
(34, 10, 7, '', '', 1, '2021-01-24', '00:29', ''),
(35, 5, 17, '', '', 1, '2021-01-24', '8:34', ''),
(36, 10, 16, '', '', 1, '2021-01-24', '13:47', ''),
(37, 3, 29, 'Finalmente a cuanto me lo dejas?', 'Te hare un descuento en la siguiente compra ;)', 1, '2021-04-27', '13:06:03', 'Sin Leer'),
(38, 6, 6, '', '', 1, '2021-03-2', '17:35', ''),
(39, 3, 10, 'Cuantas Flores tiene?', 'Sin leer', 0, '2021-04-27', '18:28:46', 'Sin Leer'),
(40, 12, 20, 'Hay de color Amarillo ó Naranja?', 'Sin leer', 0, '2021-04-27', '12:11:46', 'Sin Leer'),
(41, 3, 19, 'Lo puedo pedir más grande?', 'Sin leer', 0, '2021-04-27', '18:29:49', 'Sin Responder'),
(42, 4, 3, '', '', 1, '2021-04-29', '17:11', ''),
(43, 11, 4, '', '', 1, '2021-04-29', '17:38', ''),
(44, 11, 27, '', '', 1, '2021-04-29', '17:38', ''),
(45, 11, 22, '', '', 1, '2021-04-29', '17:41', ''),
(46, 15, 27, 'Que Mono a cuanto me lo deja?', 'El precio Son S/.160 no hay rebaja =(', 0, '2021-04-29', '18:42:35', 'Sin Responder');

-- --------------------------------------------------------

--
-- Table structure for table `contenido`
--

CREATE TABLE `contenido` (
  `id_contenido` int(11) NOT NULL,
  `titulo_contenido` text NOT NULL,
  `soporte_contenido` text NOT NULL,
  `poema_contenido` text NOT NULL,
  `bio_contenido` text NOT NULL,
  `foto_contenido` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contenido`
--

INSERT INTO `contenido` (`id_contenido`, `titulo_contenido`, `soporte_contenido`, `poema_contenido`, `bio_contenido`, `foto_contenido`) VALUES
(1, 'Visualizando la Espontaniedad', 'Mirando el arte desde una perspectiva particular', 'La estrella se ha entregado a la negrura de las nubes\r\nY sucumbió a los despeñaderos de la Finitud.\r\nAntes, escupió su grito de fuego\r\nSobre el plúmbeo de las aguas,\r\nSobre la bahía del espacio todo azul.', 'Rita Cam Abarca, de ascendencia china por la rama paterna –su padre, Julio Cam Win, contaba con negocios en el distrito limeño de Vitarte, donde residió en unión con María Abarca-, decidió, gracias a la pandemia de la Covid-19, reinventarse para incursionar profesionalmente en el arte vidriado, motivada por su inclinación al dibujo y a los colores desde la tierna infancia, como prueban los reconocimientos a los que se hizo acreedora en su paso por las aulas.', 'assets/rsc/img2/fotorita.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `descuento`
--

CREATE TABLE `descuento` (
  `id_descuento` int(11) NOT NULL,
  `tipo_descuento` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `descuento`
--

INSERT INTO `descuento` (`id_descuento`, `tipo_descuento`, `id_producto`) VALUES
(1, '10%', 1);

-- --------------------------------------------------------

--
-- Table structure for table `direccion`
--

CREATE TABLE `direccion` (
  `id_direccion` int(11) NOT NULL,
  `nombre_direccion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_direccion` int(11) DEFAULT NULL,
  `portal_direccion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `planta_direccion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `puerta_direccion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `escalera_direccion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distrito_direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia_direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pais_direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `codigopostal_direccion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `direccion`
--

INSERT INTO `direccion` (`id_direccion`, `nombre_direccion`, `numero_direccion`, `portal_direccion`, `planta_direccion`, `puerta_direccion`, `escalera_direccion`, `distrito_direccion`, `provincia_direccion`, `pais_direccion`, `codigopostal_direccion`) VALUES
(1, 'Lopez de Ayala ', 1544, '1', '3', 'A', '1', 'San Borja', 'Lima', 'Perú', '15037'),
(2, 'Av. República de Panamá', 6251, '1', '1', '1', '1', 'Miraflores', 'Lima', 'Perú', '15048'),
(3, 'Av Aviación', 201, '1', '2', ' B', '2', 'San Borja', 'Lima', 'Perú', '15099'),
(4, 'Av Aviacion', 43, '5', '3', 'C', '1', 'San Borja', 'Sevilla', 'España', '41008'),
(5, 'Carretera Carmona', 40, '2', '2', 'D', '2', 'La Rosaleda', 'Sevilla', 'España', '41009'),
(6, 'Alamaden de la Plata', 23, '1', '3', 'A', '1', 'Barzola', 'Sevilla', 'España', '41008'),
(7, 'Av. Los martires ', 543, '4', '2', 'C', '3', 'Pedicurie', 'Estrogonof', 'Holanda', '3025'),
(8, 'Los Alpes Suizos', 456, 'D', '3', 'G', 'B', 'Canguro', 'Golden Beach', 'Australia', '4130'),
(9, 'Lopez de ayala', 1544, '1', '301', 'A', '1', 'San Borja', 'Lima', 'Peru', '41008'),
(10, 'Carretera Carmona', 36, '5', '8', 'D', '3', 'Rosaleda', 'Sevilla', 'España', '41008'),
(12, 'Av. Larco', 23, '1', '2', '2', '1', 'Macarena', 'Sevilla', 'España', '4321'),
(13, 'Calle Las Acacias', 12, 'Sin', 'A', '1', 'Sin', 'Mirlos', 'Sevilla', 'España', '432'),
(14, 'Av. Carretara Carmona ', 43, 'Sin', '4', 'B', 'Sin', 'La Rosaleda', 'Sevilla', 'España', '2155'),
(15, 'Av Jaen', 9, 'Sin', '1', '2', 'Sin', 'la piruleta', 'Cadiz', 'España', '232'),
(16, 'Av Cerro Amate', 10, 'Sin', '1', 'E', 'Sin', 'Las Aguilas', 'Sevilla', 'España', '4321'),
(17, 'Calle Matamoros', 5, 'Sin', '1', 'B', 'Sin', 'El Arcangel', 'Córdoba', 'España', '6432');

-- --------------------------------------------------------

--
-- Table structure for table `domicilio`
--

CREATE TABLE `domicilio` (
  `id_domicilio` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_direccion` int(11) NOT NULL,
  `tipo_domicilio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `domicilio`
--

INSERT INTO `domicilio` (`id_domicilio`, `id_usuario`, `id_direccion`, `tipo_domicilio`) VALUES
(1, 2, 2, 'Entrega y Facturacion'),
(2, 3, 3, 'Facturación y entrega'),
(3, 6, 5, 'Facturación y entrega'),
(4, 7, 6, 'Facturación y entrega'),
(5, 8, 7, 'Facturación y entrega'),
(6, 9, 8, 'Facturación y entrega'),
(7, 10, 9, 'Facturación y entrega'),
(8, 11, 10, 'Facturación y entrega'),
(10, 12, 12, 'Facturación y entrega'),
(11, 4, 13, 'Facturación y entrega'),
(12, 15, 14, 'Facturación y entrega'),
(13, 17, 15, 'Facturación y entrega'),
(14, 16, 16, 'Facturación y entrega'),
(15, 18, 17, 'Facturación y entrega');

-- --------------------------------------------------------

--
-- Table structure for table `estado`
--

CREATE TABLE `estado` (
  `id_estado` int(11) NOT NULL,
  `nombre_estado` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estado`
--

INSERT INTO `estado` (`id_estado`, `nombre_estado`) VALUES
(1, 'Sin Pagar'),
(2, 'Pagado'),
(3, 'Devolución de dinero');

-- --------------------------------------------------------

--
-- Table structure for table `estilo`
--

CREATE TABLE `estilo` (
  `id_estilo` int(11) NOT NULL,
  `tema_estilo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_estilo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tecnico_estilo` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `estilo`
--

INSERT INTO `estilo` (`id_estilo`, `tema_estilo`, `nombre_estilo`, `tecnico_estilo`) VALUES
(1, 'Naturaleza', 'Naif', 'Faux vitro'),
(2, 'Infantil', 'Naif', 'Faux vitro'),
(3, 'Infantil Personalizado', 'Naif', 'Faux vitro'),
(4, 'Paisaje', 'Naif', 'Faux vitro'),
(5, 'Moderno Figurativo', 'Naif', 'Faux vitro'),
(6, 'Sin tema', 'Sin Estilo', 'Sin técnica');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id_material` int(11) NOT NULL,
  `nombre_material` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`id_material`, `nombre_material`, `id_producto`) VALUES
(1, 'Vidrio, lacas vitrales', 1),
(2, 'Vidrio, lacas vitrales', 2),
(3, 'Vidrio, lacas vitrales', 3),
(4, 'Vidrio, lacas vitrales', 4),
(5, 'Vidrio, lacas vitrales', 5),
(6, 'Vidrio, lacas vitrales', 6),
(7, 'Vidrio, lacas vitrales', 7),
(8, 'Vidrio, lacas vitrales', 8),
(9, 'Vidrio, lacas vitrales', 9),
(10, 'Vidrio, lacas vitrales', 10),
(11, 'Vidrio, lacas vitrales y', 11),
(12, 'Vidrio, lacas vitrales', 12),
(13, 'Vidrio, lacas vitrales', 13),
(14, 'Vidrio, lacas vitrales', 14),
(15, 'Vidrio, lacas vitrales', 15),
(16, 'Vidrio, lacas vitrales', 16),
(17, 'Vidrio, lacas vitrales', 17),
(18, 'Vidrio, lacas vitrales', 18),
(19, 'Vidrio, lacas vitrales', 19),
(20, 'Vidrio, lacas vitrales', 20),
(21, 'Vidrio, lacas vitrales', 21),
(22, 'Vidrio, lacas vitrales', 22),
(23, 'Vidrio, lacas vitrales', 23),
(24, 'Vidrio, lacas vitrales', 24),
(25, 'Vidrio, lacas vitrales', 25),
(26, 'Vidrio, lacas vitrales', 26),
(27, 'Vidrio, lacas vitrales', 27),
(28, 'Vidrio, lacas vitrales', 28),
(29, 'Vidrio, lacas vitrales', 29),
(30, 'Vidrio y Pinturas vitrales', 30),
(31, 'Vidrio y Pinturas vitrales', 31),
(32, 'Madera y Cristal', 32),
(33, 'Plastilina Mosh', 33);

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `comentario_pedido` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado_pedido` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad_pedido` int(11) DEFAULT NULL,
  `fecha_pedido` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hora_pedido` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_domicilio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `comentario_pedido`, `estado_pedido`, `cantidad_pedido`, `fecha_pedido`, `hora_pedido`, `id_domicilio`) VALUES
(1, '+34-602-296-250', 'fin', 1, '2020-01-01', '17:06', 1),
(2, 'Sin Comentario', 'fin', 2, '2021.01.22', '22:01:14', 2),
(3, 'Sin Comentario', 'guardado', 12, '2021.04.26', '11:50:20', 2),
(4, '2222', 'ruta', 1, '2021.04.28', '12:47:40', 10),
(5, '55555 33', 'ruta', 1, '2021.04.28', '13:48:08', 10),
(6, '413-666-44', 'ruta', 1, '2021-04-29', '15:05', 11),
(7, '34-444-3322', 'ruta', 3, '2021-04-29', '17:41', 8),
(8, 'Sin Comentario', 'ruta', 2, '2021-04-29', '18:55', 12),
(9, '224-0203', 'ruta', 1, '2021-04-29', '19:08', 12),
(10, 'Sin Comentario', 'guardado', 2, '2021-04-29', '19:24', 8),
(11, 'Sin Comentario', 'guardado', 2, '2021-04-30', '08:25', 12),
(12, 'Sin Comentario', 'guardado', 1, '2021-04-30', '08:18', 13),
(13, '989-222-444', 'ruta', 3, '2021-04-30', '08:52', 14),
(14, 'Sin Comentario', 'ruta', 2, '2021-04-30', '09:56', 15);

-- --------------------------------------------------------

--
-- Table structure for table `precio`
--

CREATE TABLE `precio` (
  `id_precio` int(11) NOT NULL,
  `precio` double DEFAULT NULL,
  `fecha_precio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `precio`
--

INSERT INTO `precio` (`id_precio`, `precio`, `fecha_precio`, `id_producto`) VALUES
(1, 149.99, '2021-01-01', 1),
(2, 149.99, '2021-01-01', 2),
(3, 149.99, '2021-01-01', 3),
(4, 149.99, '2020-01-01', 3),
(5, 149.99, '2021-01-01', 4);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL,
  `orden_producto` tinyint(4) NOT NULL,
  `nombre_producto` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_producto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_producto` double NOT NULL,
  `stock_producto` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_estilo` int(11) NOT NULL,
  `medida_producto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `info_producto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `promotxt_producto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `txtconte_producto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slider_producto` tinyint(4) NOT NULL,
  `pagina_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `producto`
--

INSERT INTO `producto` (`id_producto`, `orden_producto`, `nombre_producto`, `foto_producto`, `precio_producto`, `stock_producto`, `id_estilo`, `medida_producto`, `info_producto`, `promotxt_producto`, `txtconte_producto`, `slider_producto`, `pagina_producto`) VALUES
(1, 2, 'Ramo de Flores', 'assets/rsc/img2/32n1.jpg', 160, 'A pedido', 4, '32 x 32 cm', 'Mucho brillo en formas floridas, color y alegría', '', '', 0, 0),
(2, 3, 'Abstracto 1', 'assets/rsc/img2/32n2.jpg', 160, 'Por pedido', 2, '32 x 32 cm', 'Interpretación abstracta muchas flores de colores', '', '', 0, 0),
(3, 4, 'Jardin Florido 1', 'assets/rsc/img2/32n3.jpg', 160, 'Por pedido', 2, '32 x 32 cm', 'Jardin lleno de coloridas flores', '', '', 0, 0),
(4, 5, 'Jardin Florido 2', 'assets/rsc/img2/32n4.jpg', 115, 'Por pedido', 1, '32 x 32 cm', 'Jardin lleno de coloridas flores', '', '', 0, 0),
(5, 6, 'Campo Florido', 'assets/rsc/img2/32n5.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Siente el perfume de las flores de campo al estilo Naif', '', '', 0, 0),
(6, 7, 'Margaritas', 'assets/rsc/img2/32n6.jpg', 129, 'Por pedido', 1, '** x ** cm', 'Margaritas en abstracto al estilo Naif', '', '', 0, 0),
(7, 1, 'Grandes Flores', 'assets/rsc/img2/32n7.jpg', 160, 'Por pedido', 1, '32 X 32 cm', 'Grandes flores resaltan la forma y brillos del cuadro', '', '', 0, 0),
(8, 8, 'Ramillete Abstracto', 'assets/rsc/img2/32n8.jpg', 160, 'Por pedido', 2, '32 x 32', 'Ramo de flores abstactas. Tanto colorido junto… imposible', '', '', 0, 0),
(9, 9, 'Flores y más flores 1', 'assets/rsc/img2/32n10.jpg', 160, 'Por pedido', 2, '32 x 32 cm', 'Muchas flores llenan de alegria cualquier ambiente. Naif', '', '', 0, 0),
(10, 10, 'Flores y más flores 2', 'assets/rsc/img2/32n11.jpg', 160, 'Por pedido', 2, '32 x 32 cm', 'Muchas flores llenan de alegria cualquier ambiente. Naif', 'Flores y más flores', 'Decora con alegría tus ambientes', 2, 2),
(11, 11, 'Pavo Real', 'assets/rsc/img2/pavo_c.jpg', 160, 'Por pedido', 5, '32 x32 cm', 'Hermoso Pavo Real Figurativo', '', '', 0, 0),
(12, 12, 'Hojas azules', 'assets/rsc/img2/32n13.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Hermoso cuadro digna explosión de alegria Naif', '', '', 0, 0),
(13, 13, 'Abstracto 2', 'assets/rsc/img2/32n15.jpg', 145, 'Por pedido', 1, '32 x 32 cm', 'Libre expresión abstracta de flores Naif', '', '', 0, 2),
(14, 14, 'Orquideas', 'assets/rsc/img2/32n32.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Orquideas blancas y en Flor', '', '', 0, 2),
(15, 15, 'Abstracto 3', 'assets/rsc/img2/32n17.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Flores al estilo Naif en un ramo de flores abstractas', '', '', 0, 2),
(16, 16, 'Expresión Exótica ', 'assets/rsc/img2/32n16.jpg', 160, 'Por pedido', 5, '32 x 32 cm', 'info Pavo real N2..', '', '', 0, 0),
(17, 17, 'Flores de Jardin', 'assets/rsc/img2/27n2.jpg', 160, 'Por pedido', 3, '27 x 32 cm', 'Flores de Jardin para decorar ese rinconcito muy tuyo', '', '', 0, 0),
(18, 18, 'Abstracto 4', 'assets/rsc/img2/32n19.jpg', 160, 'Por pedido', 3, '32 X 32 cm', 'Flores al estilo Naif en un ramo de flores abstractas', '', '', 0, 0),
(19, 19, 'Flores en Rosa', 'assets/rsc/img2/32n21.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Románticas adelfas agitadas por el viento. Estilo Naif ', '', '', 0, 0),
(20, 20, 'Flores en Violeta', 'assets/rsc/img2/32n22.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Elegantes fresias para un ambiente elegante. Estilo Naif.', 'Elegantes fresias', 'Destaca y resalta tu decoración', 3, 3),
(21, 21, 'Hojas en Otoño', 'assets/rsc/img2/32n24.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Hermosa impresión de las hojas en otoño al estilo Naif', '', '', 0, 0),
(22, 22, 'Astromelias', 'assets/rsc/img2/32n25.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Astromelias amarillas llenan de color al estilo Naif', '', '', 0, 0),
(23, 23, 'Amapolas en Rojo', 'assets/rsc/img2/32n26.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Amapolas en Rojo Naif', '', '', 0, 0),
(24, 24, 'Explosión de Color', 'assets/rsc/img2/32n27.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Divertidas flores de campo… Naif', '', '', 0, 0),
(25, 25, 'Orquideas en Abstracto', 'assets/rsc/img2/32n28.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Interpretación abstracta de un ramillete de coloridas orquideas', '', '', 0, 0),
(26, 26, 'Juego de Color', 'assets/rsc/img2/32n29.jpg', 160, 'Pro pedido', 1, '32 x 32 cm', 'Cuadro tipico del estilo Naif, para dar color a cualquier ambiente', '', '', 0, 0),
(27, 27, 'Ramillete de Flores', 'assets/rsc/img2/32n30.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Ramillete de exquisitas flores ', '', '', 0, 0),
(28, 28, 'Fresias en Rosa', 'assets/rsc/img2/32n31.jpg', 160, 'Por pedido', 1, '32 x 32 cm', 'Elegante interpretación de un ramo de Fresias', '', '', 0, 0),
(29, 29, 'Gallo Joaquin', 'assets/rsc/img2/32b4.jpg', 160, 'Por pedido', 3, '32 x 32 cm', 'Personaliza el cuadro de tu engreído con su nombre', 'Regalo personalizado:', 'un cuadro con el nombre del(a) engreído(a) de la casa y el personaje de su preferencia!!!!🥳🥳🥳', 1, 4),
(30, 30, 'Barquito ', 'assets/rsc/img2/32b1.jpg', 160, 'A pedido', 4, '32 x 32 cm', 'Ideal para la decoración de la habitación del recien nacido', '', '', 0, 0),
(31, 31, 'Buho Mirón', 'assets/rsc/img2/32b6.jpg', 160, 'A pedido', 3, '32 x 32 cm', 'Info Buho', '', '', 0, 0),
(32, 32, 'Pavo Moradete', 'assets/rsc/img2/pavo_Morado.jpg', 128, '', 5, '32 x 32 cm', 'Bello Pavo real Morado', '', '', 0, 0),
(33, 33, 'Barco en Gris', 'assets/rsc/img2/nofoto.jpg', 100, 'A pedido', 4, '34 x 40 cm', 'Producto de prueba', '', '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `nombre_rol` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
(1, 'Admin'),
(2, 'Estándar');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `clave_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fdn_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fuc_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `finc_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fdr_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexo_usuario` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activo_usuario` int(11) DEFAULT NULL,
  `estado_usuario` int(11) DEFAULT NULL,
  `validado_usuario` int(11) DEFAULT NULL,
  `contador_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre_usuario`, `correo_usuario`, `clave_usuario`, `foto_usuario`, `fdn_usuario`, `fuc_usuario`, `finc_usuario`, `fdr_usuario`, `sexo_usuario`, `activo_usuario`, `estado_usuario`, `validado_usuario`, `contador_usuario`, `id_rol`) VALUES
(1, 'Rita', 'yucsan2018@gmail.com', '$2y$10$0Qcaomb1T5H2awmwFl87NukQWX8.8/VGall1pFTFZ0hHtksNx6Dki', 'users/mujer.jpg', '1990-01-01', '2021-04-29 20:05', '2021-04-30 13:55', '2020-11-02 12:02:10', 'Mujer', 1, 0, 1, 17, 1),
(2, 'Pepe', 'spotyuc@gmail.com', '$2y$10$VoSghwBS0l1ymauAkuEtCuKzrVfYDwm2UZXBMOOwIwZJsWCfEZcb6', 'users/2/profile/juan.png', '1992-08-01', '2021-04-25 22:28', '2021-04-25 22:28', '2020-12-01 17:43:31', 'Hombre', 0, 0, 1, 17, 2),
(3, 'Yucsan', 'yucsandata8@gmail.com', '$2y$10$VoSghwBS0l1ymauAkuEtCuKzrVfYDwm2UZXBMOOwIwZJsWCfEZcb6', 'users/3/profile/another.png', '1983-08-02', '2021-04-30 13:56', '2021-04-30 14:22', '2021-01-04 13:49:46', 'Hombre', 1, 0, 1, 631, 2),
(4, 'Lucy in the Sky', 'loscuadrosderita@gmail.com', '$2y$10$pQ2YPRmySiAwvFjlIHJGnec3muLI5Sw1g9y80uyPP1jkQwkBehrYO', 'users/4/profile/lucy.png', '1986-11-27', '2021-04-30 09:40', '2021-04-30 09:40', '2021-01-04 16:43:58', 'Otro', 1, 0, 1, 112, 2),
(5, 'Mario Garcia', 'yucsandata2@gmail.com', '$2y$10$9QJdYB.863moAMYqGFaxfOKrS4xqyRfbEK0oTbg3.eNeDZuxs2DN.', 'users/5/profile/juan.png', '1986-04-20', '2021-04-26 13:40', '2021-04-26 13:41', '2021-01-06 11:11:21', 'Hombre', 1, 0, 1, 8, 2),
(6, 'Merche Garcia', 'yucsandata4@gmail.com', '$2y$10$nz.kcplbPn/Cc9fMhEiVguxHGXUji3JLUXeJRER53.zAIq3J1UZ1W', 'users/6/profile/juana.png', '1988-01-07', '2021-04-26 20:51', '2021-04-26 20:53', '2021-01-07 17:55:34', 'Mujer', 1, 0, 1, 38, 2),
(7, 'Josefina', 'yucsandata5@gmail.com', '$2y$10$V7R6.HAqyX/IslH.ivah9uC.czqcLnzVRGI67fh8bRJPacRWDibB6', 'users/7/profile/jose.png', '1968-09-06', '2021-04-29 09:45', '2021-04-29 09:45', '2021-01-08 11:28:01', 'Mujer', 1, 0, 1, 2, 2),
(8, '💀', '💀', '💀', '💀', '000', '💀', '💀', '💀', '💀', 3, 3, 3, 3, 2),
(9, 'Fabrizio', 'yucsandata6@gmail.com', '$2y$10$54dIQZdayTqkh9rePzkUWu6ek0.RJmbZUkQ7wdKaQKQ/k1roHtX9i', 'users/otro.jpg', '1983-07-06', '2021-04-29 11:16', '2021-04-29 11:20', '2021-01-17 13:02:28', 'Otro', 1, 0, 1, 1, 2),
(10, '💀', '💀', '💀', '💀', '000', '💀', '💀', '💀', '💀', 3, 3, 3, 3, 2),
(11, 'The Champ', 'yucsan2018@yahoo.com', '$2y$10$wDg66jUAHfbGKpM2CzH1qO1IK/6XRyS7OVaGuuXEIGi8TQKdoiFTW', 'users/11/profile/champ.png', '1980-01-04', '2021-04-30 09:40', '2021-04-30 09:40', '2021-01-24 12:56:51', 'Hombre', 1, 0, 1, 34, 2),
(12, 'Juan Roller Blade', 'yucsandata3@gmail.com', '$2y$10$nlyGp7oXGauq9d6NKs/cM.FwINz8Iy2d2IT9MjX9Yqt19qo7MjYQK', 'users/12/profile/juan.png', '1981-04-15', '2021-04-29 09:31', '2021-04-29 09:38', '2021-04-15 16:00:31', 'Otro', 1, 0, 1, 374, 2),
(13, 'Andres', 'andres@gmail.com', '$2y$10$FGcwrX5JGJw/nC4msddJ8erY26X3ea84VIlLO2EwL284IsrvN2sM.', 'users/Otro.jpg', '1995-04-07', '2021-04-27 16:15', '2021-04-27 16:15', '2021-04-26 17:24:29', 'Otro', 1, 0, 1, 4, 2),
(14, 'Dick', 'dick@gmail.com', '$2y$10$wiAe1o4ILbgzxtwaSnIqkuWChTw4zNV/xTZ0jSL2HQ81WGelfYCWG', 'users/14/profile/dick.png', '1978-04-10', '2021-04-29 10:28', '2021-04-29 10:31', '2021-04-29 09:47:26', 'Otro', 1, 0, 1, 4, 2),
(15, 'Susana', 'yucsandata7@gmail.com', '$2y$10$r.QEDRuHJgH5ExVGamnjYeDQh6X9917QNY2upp/NUb2WTRVwyraZS', 'users/15/profile/susan.png', '1978-06-21', '2021-04-30 13:28', '2021-04-30 11:00', '2021-04-29 16:38:26', 'Mujer', 1, 1, 1, 59, 2),
(16, 'Kris', 'kris@gmail.com', '$2y$10$UB104dLY4eiqy1lfBewrr.EX/IA2k86zjRmz1qoTxKilc/4iaP1WG', 'users/otro.jpg', '1968-10-07', '2021-04-30 09:23', '2021-04-30 09:32', '2021-04-29 21:04:44', 'Otro', 1, 0, 1, 17, 2),
(17, 'Wendy', 'wen@gmail.com', '$2y$10$mY0b4S.VY4wz9qwdR0IgCO7hvk/wqpi9aXtskWe/l7RaUT8DPA9YK', 'users/mujer.jpg', '1991-05-06', '2021-04-30 08:18', '2021-04-30 08:19', '2021-04-30 08:16:44', 'Mujer', 1, 0, 1, 2, 2),
(18, 'Denis', 'denis@gmail.com', '$2y$10$wqtlEOGFGIaXtxlni68eTu6Khvkx0ajh3Fgy1oZ.HUa9Ot/otOrQK', 'users/hombre.jpg', '1993-05-05', '2021-04-30 09:57', '2021-04-30 10:00', '2021-04-30 09:41:28', 'Hombre', 1, 0, 1, 10, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `fk_compra_pedido1_idx` (`id_pedido`),
  ADD KEY `fk_compra_producto1_idx` (`id_producto`),
  ADD KEY `fk_compra_estado1_idx` (`id_estado`);

--
-- Indexes for table `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_consulta`),
  ADD KEY `fk_usuario_has_producto_producto2_idx` (`id_producto`),
  ADD KEY `fk_usuario_has_producto_usuario2_idx` (`id_usuario`);

--
-- Indexes for table `contenido`
--
ALTER TABLE `contenido`
  ADD PRIMARY KEY (`id_contenido`);

--
-- Indexes for table `descuento`
--
ALTER TABLE `descuento`
  ADD PRIMARY KEY (`id_descuento`),
  ADD KEY `fk_descuento_producto1_idx` (`id_producto`);

--
-- Indexes for table `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`id_direccion`);

--
-- Indexes for table `domicilio`
--
ALTER TABLE `domicilio`
  ADD PRIMARY KEY (`id_domicilio`),
  ADD KEY `fk_usuario_has_direccion_direccion1_idx` (`id_direccion`),
  ADD KEY `fk_usuario_has_direccion_usuario1_idx` (`id_usuario`);

--
-- Indexes for table `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indexes for table `estilo`
--
ALTER TABLE `estilo`
  ADD PRIMARY KEY (`id_estilo`);

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id_material`),
  ADD KEY `fk_material_producto1_idx` (`id_producto`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_pedido_domicilio1_idx` (`id_domicilio`);

--
-- Indexes for table `precio`
--
ALTER TABLE `precio`
  ADD PRIMARY KEY (`id_precio`),
  ADD KEY `fk_precio_producto1_idx` (`id_producto`);

--
-- Indexes for table `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_cuadro_estilo1_idx` (`id_estilo`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `fk_usuario_rol_idx` (`id_rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `compra`
--
ALTER TABLE `compra`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `consulta`
--
ALTER TABLE `consulta`
  MODIFY `id_consulta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `contenido`
--
ALTER TABLE `contenido`
  MODIFY `id_contenido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `descuento`
--
ALTER TABLE `descuento`
  MODIFY `id_descuento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `direccion`
--
ALTER TABLE `direccion`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `domicilio`
--
ALTER TABLE `domicilio`
  MODIFY `id_domicilio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `estado`
--
ALTER TABLE `estado`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `estilo`
--
ALTER TABLE `estilo`
  MODIFY `id_estilo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `precio`
--
ALTER TABLE `precio`
  MODIFY `id_precio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `producto`
--
ALTER TABLE `producto`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_estado1` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_pedido1` FOREIGN KEY (`id_pedido`) REFERENCES `pedido` (`id_pedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `fk_usuario_has_producto_producto2` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_producto_usuario2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `descuento`
--
ALTER TABLE `descuento`
  ADD CONSTRAINT `fk_descuento_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `domicilio`
--
ALTER TABLE `domicilio`
  ADD CONSTRAINT `fk_usuario_has_direccion_direccion1` FOREIGN KEY (`id_direccion`) REFERENCES `direccion` (`id_direccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_direccion_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `fk_material_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_pedido_domicilio1` FOREIGN KEY (`id_domicilio`) REFERENCES `domicilio` (`id_domicilio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `precio`
--
ALTER TABLE `precio`
  ADD CONSTRAINT `fk_precio_producto1` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_cuadro_estilo1` FOREIGN KEY (`id_estilo`) REFERENCES `estilo` (`id_estilo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `fk_usuario_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
