-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-01-2026 a las 20:43:06
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
-- Base de datos: `pasteleria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'Tortas'),
(2, 'Bocaditos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `usuario_id`, `telefono`, `direccion`) VALUES
(1, 3, '999599466', 'Ferreñafe'),
(2, 4, '946734621', 'calle santa lucia 290'),
(3, 5, '946734621', 'Av Riva Aguero\r\nLima'),
(4, 6, '946734621', 'calle santa lucia 290');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

DROP TABLE IF EXISTS `detalle_pedido`;
CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(6,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 4, 1, 47.50, 47.50),
(2, 2, 4, 1, 47.50, 47.50),
(3, 3, 1, 10, 40.00, 400.00),
(4, 4, 2, 2, 35.00, 70.00),
(5, 5, 7, 2, 104.50, 209.00),
(6, 6, 8, 2, 81.00, 162.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta_directa`
--

DROP TABLE IF EXISTS `detalle_venta_directa`;
CREATE TABLE `detalle_venta_directa` (
  `id` int(11) NOT NULL,
  `venta_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(6,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre`, `telefono`) VALUES
(1, 'Alexander Capitan', '946734621');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregas`
--

DROP TABLE IF EXISTS `entregas`;
CREATE TABLE `entregas` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `empleado_id` int(11) DEFAULT NULL,
  `fecha_entrega` datetime DEFAULT NULL,
  `estado` enum('programado','en camino','entregado') DEFAULT 'programado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entregas`
--

INSERT INTO `entregas` (`id`, `pedido_id`, `empleado_id`, `fecha_entrega`, `estado`) VALUES
(1, 2, 1, '2025-07-16 14:11:00', 'programado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `tipo` enum('entrada','salida') DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) DEFAULT NULL,
  `metodo` enum('efectivo','tarjeta','yape','plin') DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `estado` enum('pendiente','completado') DEFAULT 'pendiente',
  `fecha_pago` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `pedido_id`, `metodo`, `monto`, `estado`, `fecha_pago`) VALUES
(1, 1, 'yape', 47.50, 'completado', '2025-07-16 01:25:38'),
(2, 2, 'yape', 47.50, 'completado', '2025-07-16 08:09:41'),
(3, 3, 'efectivo', 400.00, 'completado', '2025-07-16 10:29:06'),
(4, 4, 'yape', 70.00, 'completado', '2025-07-22 21:53:15'),
(5, 5, 'plin', 209.00, 'completado', '2025-07-25 00:37:15'),
(6, 6, 'plin', 162.00, 'completado', '2025-09-11 01:20:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL,
  `estado` enum('pendiente','procesando','enviado','entregado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `fecha`, `total`, `estado`) VALUES
(1, 1, '2025-07-16 01:25:38', 47.50, 'pendiente'),
(2, 1, '2025-07-16 08:09:41', 47.50, 'procesando'),
(3, 2, '2025-07-16 10:29:06', 400.00, 'entregado'),
(4, 1, '2025-07-22 21:53:15', 70.00, 'pendiente'),
(5, 3, '2025-07-25 00:37:15', 209.00, 'pendiente'),
(6, 4, '2025-09-11 01:20:43', 162.00, 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_personalizados`
--

DROP TABLE IF EXISTS `pedidos_personalizados`;
CREATE TABLE `pedidos_personalizados` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `precio_estimado` decimal(8,2) DEFAULT NULL,
  `estado` enum('pendiente','aceptado','rechazado','completado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(6,2) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `categoria_id` int(11) DEFAULT NULL,
  `destacado` tinyint(1) DEFAULT 0,
  `promocion` tinyint(1) DEFAULT 0,
  `descuento` decimal(5,2) DEFAULT 0.00,
  `precio_original` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `imagen`, `stock`, `categoria_id`, `destacado`, `promocion`, `descuento`, `precio_original`) VALUES
(1, 'Torta de chocolate con chinchin', '\"Deliciosa torta de chocolate casera, decorada con suaves capas de chinchín, ideal para cualquier ocasión.', 40.00, '6871f3468440e_Torta_de_chocolate_con_chinchin.png', 5, 1, 1, 1, 10.00, 50.00),
(2, 'Torta clasica Zamantha', '\"Suave bizcocho casero relleno de manjar y decorado con un toque tradicional, ideal para cualquier celebración.\"', 35.00, '6871fb369f658_Torta_clasica_Zamantha.png', 5, 1, 1, 1, 4.00, 45.00),
(4, 'Torta de cumpleaños para mamá', '\"Delicada torta decorada con amor, perfecta para celebrar a la reina del hogar en su día especial.\"\r\n\r\n', 47.50, '6871fb9b9b9d0_Torta_happy_birthday_mama.png', 5, 1, 1, 1, 5.00, 50.00),
(5, 'Torta de cumpleaños 50 años', 'Celebra medio siglo de vida con estilo y dulzura. Nuestra torta especial de 50 años combina diseño elegante, sabor artesanal y decoración personalizada.', 54.00, '68771737a860c_Torta_50_a__os_Ana_Maria-.png', 5, 1, 1, 1, 10.00, 60.00),
(6, 'Trufas de Chocolate', 'Deliciosas bolitas hechas a base de chocolate fundido, crema y mantequilla, cubiertas con cacao en polvo, coco rallado, grajeas o frutos secos.', 2.00, '6877c9aa001dd_Torta_de_cumplea__os_personalizada_de_Alianza_Lima_para_Eberth.png', 500, 2, 1, 0, 0.00, 2.00),
(7, 'Torta de cumpleaños personalizada de Frozen ', 'Torta de cumpleaños personalizada de Frozen, decorada con detalles inspirados en los personajes principales de la película, como Elsa, Anna y Olaf. La torta está cubierta con fondant azul celeste y blanco, simulando un paisaje nevado, y adornada con copos de nieve comestibles, escarcha brillante y figuras en 3D.', 104.50, '6877d52235649_Torta_de_cumplea__os_personalizada_de_Frozen_para_Dulce.png', 7, 1, 1, 1, 5.00, 110.00),
(8, 'Torta de cumpleaños del Real Madrid ', 'Diseño: Decorada con el escudo del Real Madrid en fondant o papel comestible.\r\nColores: Blanco, dorado y detalles en azul.\r\nSabor: A elección (chocolate, vainilla, tres leches, etc.).\r\n\r\nRelleno: Manjar blanco, fudge o crema chantilly.\r\nExtras: Balón, camiseta o detalles futbolísticos personalizados.', 81.00, '687aeea45f5e5_Torta_de_cumplea__os_personalizada_del_Real_Madrid_para_Luan.png', 6, 1, 1, 1, 10.00, 90.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` enum('admin','cliente') DEFAULT 'cliente',
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `creado_en`) VALUES
(2, 'Admin', 'admin@pasteleria.com', '$2y$10$e7G3dj6BRscVQggJeWBMzuOH.BiP4rozdW1aU7IE3ABwWjN4fcYZu', 'admin', '2025-07-12 05:01:56'),
(3, 'Daniel Erick Escribano Macalopu', 'daniel@correo.com', '$2y$10$NHBokI3tZtrXPIAsG3vqtODjHXcA1Q0YUtfFzMDRB3VZoxrZrr5t.', 'cliente', '2025-07-12 05:03:41'),
(4, 'grabiel leon', 'grabielleon@gmail.com', '$2y$10$W6XJaSkHeX1xbmKRggoGDeT6EjnzXyFXEpsBCHDGw.ZbG9uZxqiK.', 'cliente', '2025-07-16 15:27:08'),
(5, 'Alexander Capitán', 'calec2603@gmail.com', '$2y$10$1.n08ZgTiJk4aljEr6mdieYdLbgm7cTkcL0fa2iYe8xUmnLZZcXT6', 'cliente', '2025-07-25 05:36:19'),
(6, 'cale', 'cale123@gmail.com', '$2y$10$mrwdHpmjO6874FW1EqP9wO/A9ZrEn4Uv5yw22255EN1FeAjDAHkBe', 'cliente', '2025-09-11 06:17:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas_directas`
--

DROP TABLE IF EXISTS `ventas_directas`;
CREATE TABLE `ventas_directas` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `detalle_venta_directa`
--
ALTER TABLE `detalle_venta_directa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`),
  ADD KEY `empleado_id` (`empleado_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `pedidos_personalizados`
--
ALTER TABLE `pedidos_personalizados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categoria` (`categoria_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `ventas_directas`
--
ALTER TABLE `ventas_directas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `detalle_venta_directa`
--
ALTER TABLE `detalle_venta_directa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entregas`
--
ALTER TABLE `entregas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedidos_personalizados`
--
ALTER TABLE `pedidos_personalizados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ventas_directas`
--
ALTER TABLE `ventas_directas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `detalle_venta_directa`
--
ALTER TABLE `detalle_venta_directa`
  ADD CONSTRAINT `detalle_venta_directa_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas_directas` (`id`),
  ADD CONSTRAINT `detalle_venta_directa_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `entregas`
--
ALTER TABLE `entregas`
  ADD CONSTRAINT `entregas_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `entregas_ibfk_2` FOREIGN KEY (`empleado_id`) REFERENCES `empleados` (`id`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `pedidos_personalizados`
--
ALTER TABLE `pedidos_personalizados`
  ADD CONSTRAINT `pedidos_personalizados_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `ventas_directas`
--
ALTER TABLE `ventas_directas`
  ADD CONSTRAINT `ventas_directas_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
