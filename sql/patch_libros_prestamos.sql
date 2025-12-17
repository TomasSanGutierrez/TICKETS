-- Create printed books table and loans table

CREATE TABLE IF NOT EXISTS `libros` (
  `id_libro` int(11) NOT NULL AUTO_INCREMENT,
  `Autor` varchar(128) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Editorial` varchar(128) DEFAULT NULL,
  `anio` varchar(10) DEFAULT NULL,
  `Comentario` text,
  `cantidad_total` int(11) DEFAULT 1,
  `cantidad_disponible` int(11) DEFAULT 1,
  `video` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_libro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `prestamos` (
  `id_prestamo` int(11) NOT NULL AUTO_INCREMENT,
  `id_libro` int(11) NOT NULL,
  `id_socio` int(11) NOT NULL,
  `fecha_prestamo` date NOT NULL DEFAULT CURRENT_DATE,
  `fecha_devolucion` date DEFAULT NULL,
  `estado` varchar(20) NOT NULL DEFAULT 'pendiente',
  PRIMARY KEY (`id_prestamo`),
  KEY `fk_libro` (`id_libro`),
  KEY `fk_socio` (`id_socio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
