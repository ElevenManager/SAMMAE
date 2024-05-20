USE SAMAAE;

INSERT INTO `persona` (`nroDocumento`, `TipoDocumento`, `Nombres`, `Apellidos`, `FechaNacimiento`, `sexo`, `estado_civil`, `direccion`, `telefono`, `email`, `ocupacion`, `apoderado`) VALUES
    (74065870, 'DNI', 'Tadeo', 'Tupayachi', '2001-09-17', 'M', 'S', 'UrbJoseCarlosMariaTeguiE-2', '924395689', 'tadeoyuri@gmail.com', 'Admin', NULL);

INSERT INTO `usuario` (`UsuarioID`,`nroDocumento`, `NombreUsuario`, `rol`,  `clave`, `NivelID`, `login`, `condicion`) VALUES
    (1,74065870, 'Administrador', 'admin', '7728d77ad16eff3be09edbc982833591b7f89e55eb76acbd918005592e089201', NULL,'admin', 1);

INSERT INTO `usuario_permiso` (`idusuario_permiso`, `UsuarioID`, `idpermiso`) VALUES
                                                                                  (1, 1, 1),
                                                                                  (2, 1, 2),
                                                                                  (3, 1, 3),
                                                                                  (4, 1, 4),
                                                                                  (5, 1, 5),
                                                                                  (6, 1, 6),
                                                                                  (7, 1, 7);

INSERT INTO `permiso` (`idpermiso`, `nombre`) VALUES
                                                  (1, 'escritorio'),
                                                  (2, 'alumnos'),
                                                  (3, 'profesores'),
                                                  (4, 'cursos'),
                                                  (5, 'CURSOSPROFESOR'),
                                                  (6 ,'Asistencias'),
                                                  (7, 'Niveles'),
                                                  (9, 'cursos'),
                                                  (10, 'cargas masivas');

