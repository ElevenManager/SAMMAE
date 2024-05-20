CREATE DATABASE IF NOT EXISTS SAMAAE;

USE SAMAAE;

CREATE TABLE IF NOT EXISTS persona (
  nroDocumento varchar(25) NOT NULL,
  tipoDocumento varchar(100) NOT NULL,
  Nombres varchar(100) NOT NULL,
  Apellidos varchar(100) NOT NULL,
  FechaNacimiento date NOT NULL,
  sexo varchar(1),
  estado_civil varchar(1),
  direccion varchar(70),
  telefono varchar(20),
  email varchar(50),
  ocupacion varchar(30) DEFAULT 'estudiante',
  apoderado varchar(30),
  
  PRIMARY KEY (nroDocumento)
);
CREATE TABLE IF NOT EXISTS nivel (
  NivelID varchar(8) NOT NULL,
  Descripcion varchar(255) NOT NULL,
  PRIMARY KEY (NivelID)
);
CREATE TABLE IF NOT EXISTS usuario (
  UsuarioID varchar(25) NOT NULL,
  nroDocumento varchar(25) NOT NULL,
  NombreUsuario varchar(50) NOT NULL,
  rol VARCHAR(50) NOT NULL DEFAULT 'estudiante',
  clave varchar(50) NOT NULL,
  NivelID varchar(8) DEFAULT NULL,
  login varchar(20) NOT NULL,
  condicion tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (UsuarioID),
  FOREIGN KEY (nroDocumento) REFERENCES persona(nroDocumento),
  FOREIGN KEY (NivelID) REFERENCES nivel (NivelID)
);

CREATE TABLE IF NOT EXISTS asistencia (
AsistenciaID int NOT NULL AUTO_INCREMENT,
nroDocumento varchar(25) NOT NULL,
Curso varchar(25) NOT NULL DEFAULT 'General',
anotacion varchar(255),  -- Aumentado si necesitas más espacio para texto
Fecha date NOT NULL,
Hora time NOT NULL,
 PRIMARY KEY (AsistenciaID),
FOREIGN KEY (nroDocumento) REFERENCES persona(nroDocumento)
);

CREATE TABLE IF NOT EXISTS grado (
  GradoID varchar(8) NOT NULL,
  NombreGrado varchar(50) NOT NULL,
  NivelID varchar(8) DEFAULT NULL,
  PRIMARY KEY (GradoID),
  FOREIGN KEY (NivelID) REFERENCES nivel (NivelID)
);

CREATE TABLE IF NOT EXISTS curso (
  CursoID varchar(8) NOT NULL,
  NombreCurso varchar(100) NOT NULL,
  PRIMARY KEY (CursoID)
);

CREATE TABLE IF NOT EXISTS gradocurso (
  GradoCursoID varchar(8) NOT NULL,
  GradoID varchar(8) DEFAULT NULL,
  CursoID varchar(8) DEFAULT NULL,
  PRIMARY KEY (GradoCursoID),
  FOREIGN KEY (GradoID) REFERENCES grado (GradoID),
  FOREIGN KEY (CursoID) REFERENCES curso (CursoID)
);

CREATE TABLE IF NOT EXISTS seccion (
  SeccionID varchar(8) NOT NULL,
  NombreSeccion varchar(50) NOT NULL,
  GradoID varchar(8) DEFAULT NULL,
  PRIMARY KEY (SeccionID),
  FOREIGN KEY (GradoID) REFERENCES grado (GradoID)
);

CREATE TABLE IF NOT EXISTS mensaje (
  MensajeID varchar(8) NOT NULL,
  nroDocumento varchar(25) NOT NULL,
  Contenido text NOT NULL,
  FechaHora datetime NOT NULL,
  PRIMARY KEY (MensajeID),
  FOREIGN KEY (nroDocumento) REFERENCES persona(nroDocumento)
);

CREATE TABLE IF NOT EXISTS permiso (
  idpermiso varchar(8) NOT NULL,
  nombre varchar(25) NOT NULL,
  PRIMARY KEY (idpermiso)
);

CREATE TABLE IF NOT EXISTS usuario_permiso (
  idusuario_permiso INT NOT NULL AUTO_INCREMENT,
  UsuarioID varchar(25) NOT NULL,
  idpermiso varchar(8) NOT NULL,
  PRIMARY KEY (idusuario_permiso),
  UNIQUE (UsuarioID, idpermiso),
  FOREIGN KEY (UsuarioID) REFERENCES usuario (UsuarioID),
  FOREIGN KEY (idpermiso) REFERENCES permiso (idpermiso)
);
alter table usuario
    modify clave varchar(200) not null;
