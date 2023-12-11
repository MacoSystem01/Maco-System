-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-04-2021 a las 01:53:24
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articulos`
--

CREATE TABLE `articulos` (
  `id_producto` varchar(30) NOT NULL,
  `id_usuario` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float NOT NULL,
  `origen` varchar(1) NOT NULL,
  `fechaCaptura` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articulos`
--

INSERT INTO `articulos` (`id_producto`, `id_usuario`, `nombre`, `cantidad`, `precio`, `origen`, `fechaCaptura`) VALUES
('0001', 'Admin', 'Articulo 0001', 50, 5000, 'C', '2021-01-29'),
('0002', 'Admin', 'Articulo 0001', 20, 2000, 'C', '2021-04-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_codigo` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(200) NOT NULL,
  `departamento` varchar(200) NOT NULL,
  `ciudad` varchar(200) NOT NULL,
  `razonsocial` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_codigo`, `nombre`, `apellido`, `direccion`, `telefono`, `departamento`, `ciudad`, `razonsocial`) VALUES
('1122', 'fd', 'ret', 'rte', 'ff435', 'ert', 'dret', 'adg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `credito`
--

CREATE TABLE `credito` (
  `id_CodigoC` int(11) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `id_usuario` varchar(20) NOT NULL,
  `tipoC` varchar(200) NOT NULL,
  `origenSelect` varchar(200) NOT NULL,
  `valor` float NOT NULL,
  `tipo_cliente` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `credito`
--

INSERT INTO `credito` (`id_CodigoC`, `id_cliente`, `id_usuario`, `tipoC`, `origenSelect`, `valor`, `tipo_cliente`) VALUES
(4, '5', 'Admin', 'hjgfh', 'B', 4564, 'proveedor'),
(5, '1122', 'Admin', 'ffffff', 'C', 2, 'cliente'),
(6, '1122', 'Admin', 'ghhh', 'B', 55, 'cliente'),
(7, '1', 'Admin', 'dsfsf', 'B', 34543, 'proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `id_codigoG` int(11) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `id_usuario` varchar(20) NOT NULL,
  `tipoG` varchar(200) DEFAULT NULL,
  `origenSelect` varchar(200) DEFAULT NULL,
  `valor` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `gastos`
--

INSERT INTO `gastos` (`id_codigoG`, `id_cliente`, `id_usuario`, `tipoG`, `origenSelect`, `valor`) VALUES
(3, '999', 'Admin', 'hfghfgh', 'C', 345);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_codigo` varchar(20) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `telefono` varchar(200) NOT NULL,
  `razonsocial` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_codigo`, `nombre`, `apellido`, `direccion`, `telefono`, `razonsocial`) VALUES
('1', 'que', 'que', 'que', 'que', 'que'),
('3', 'gd', 'e', 'e', 'e', 'e'),
('435', 'er', 'wer', 'wer', 'wer', 'wer'),
('5', 'd', 'd', 'd', 'd', 'd'),
('6', 'gjh', 'gjhg', 'jhgjh', 'gjh', 'gj');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recaudo`
--

CREATE TABLE `recaudo` (
  `id_codigoR` int(11) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `id_usuario` varchar(20) NOT NULL,
  `tipoR` varchar(200) NOT NULL,
  `origenSelect` varchar(200) NOT NULL,
  `valor` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recaudo`
--

INSERT INTO `recaudo` (`id_codigoR`, `id_cliente`, `id_usuario`, `tipoR`, `origenSelect`, `valor`) VALUES
(2, '999', 'Admin', 'cvxvsdf', 'B', 65786);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `password` tinytext NOT NULL,
  `fechaCaptura` date NOT NULL,
  `rol` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido`, `password`, `fechaCaptura`, `rol`) VALUES
('Admin', 'Super', 'Administrador', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2021-01-29', '99'),
('prb', 'aef', 'sdfs', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '2021-01-29', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `id_producto` varchar(30) NOT NULL,
  `id_usuario` varchar(20) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` float NOT NULL,
  `total` float NOT NULL,
  `fechaCompra` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `id_cliente`, `id_producto`, `id_usuario`, `cantidad`, `precio`, `total`, `fechaCompra`) VALUES
(4, 'A', '0001', 'Admin', 1, 5000, 5000, '2021-01-30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `articulos`
--
ALTER TABLE `articulos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_codigo`);

--
-- Indices de la tabla `credito`
--
ALTER TABLE `credito`
  ADD PRIMARY KEY (`id_CodigoC`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`id_codigoG`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_codigo`);

--
-- Indices de la tabla `recaudo`
--
ALTER TABLE `recaudo`
  ADD PRIMARY KEY (`id_codigoR`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `credito`
--
ALTER TABLE `credito`
  MODIFY `id_CodigoC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `gastos`
--
ALTER TABLE `gastos`
  MODIFY `id_codigoG` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `recaudo`
--
ALTER TABLE `recaudo`
  MODIFY `id_codigoR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
