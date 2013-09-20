/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     20-09-2013 13:16:57                          */
/*==============================================================*/


drop table if exists ACTIVIDAD_MASIVA;

drop table if exists ACT_ESTUDIANTE;

drop table if exists ADJUNTO;

drop table if exists ASISTENCIA;

drop table if exists AUDITORIA;

drop table if exists AYUDANTE;

drop table if exists AYU_PROFE;

drop table if exists BORRADOR;

drop table if exists CARRERA;

drop table if exists CARTA;

drop table if exists CARTA_PERSONA;

drop table if exists CARTA_USUARIO;

drop table if exists COORDINADOR;

drop table if exists CRON_JOBS;

drop table if exists DIA_HORARIO;

drop table if exists EQUIPO_PROFESOR;

drop table if exists ESTUDIANTE;

drop table if exists EVALUACION;

drop table if exists FILTRO_CONTACTO;

drop table if exists HISTORIALES_BUSQUEDA;

drop table if exists HORARIO;

drop table if exists IMPLEMENTO;

drop table if exists MODULO_HORARIO;

drop table if exists MODULO_TEMATICO;

drop table if exists NOTA;

drop table if exists PERSONA;

drop table if exists PLANIFICACION_CLASE;

drop table if exists PLANTILLA;

drop table if exists PROFESOR;

drop table if exists PROFESOR_SECCION;

drop table if exists PROFE_EQUI_LIDER;

drop table if exists REQUISITO;

drop table if exists REQUISITO_MODULO;

drop table if exists SALA;

drop table if exists SALA_IMPLEMENTO;

drop table if exists SECCION;

drop table if exists SESION_DE_CLASE;

drop table if exists TIPO_PROFESOR;

drop table if exists TIPO_USER;

drop table if exists USUARIO;

/*==============================================================*/
/* Table: ACTIVIDAD_MASIVA                                      */
/*==============================================================*/
create table ACTIVIDAD_MASIVA
(
   ID_ACT               int not null auto_increment,
   NOMBRE_ACT           varchar(20) not null,
   FECHA_ACT            date not null,
   LUGAR_ACT            varchar(20),
   LUGAR_RETIRAR_ENTRADA varchar(20),
   primary key (ID_ACT)
);

alter table ACTIVIDAD_MASIVA comment 'El curso tiene programa 3 salidas extraprogramáticas, obre d';

/*==============================================================*/
/* Table: ACT_ESTUDIANTE                                        */
/*==============================================================*/
create table ACT_ESTUDIANTE
(
   ID_ACT               int not null,
   RUT_USUARIO          int not null
);

alter table ACT_ESTUDIANTE comment 'Se utiliza con el fin de representar que muchos estudiantes ';

/*==============================================================*/
/* Table: ADJUNTO                                               */
/*==============================================================*/
create table ADJUNTO
(
   ID_ADJUNTO           int not null auto_increment,
   ID_CORREO            int not null,
   NOMBRE_LOGICO_ADJ    varchar(255),
   NOMBRE_FISICO_ADJ    varchar(255),
   primary key (ID_ADJUNTO)
);

/*==============================================================*/
/* Table: ASISTENCIA                                            */
/*==============================================================*/
create table ASISTENCIA
(
   ID_SESION            int not null,
   RUT_USUARIO          int not null,
   PRESENTE_ASISTENCIA  bool,
   JUSTIFICADO_ASISTENCIA bool,
   COMENTARIO_ASISTENCIA varchar(100)
);

/*==============================================================*/
/* Table: AUDITORIA                                             */
/*==============================================================*/
create table AUDITORIA
(
   ID_REG_AUDITORIA     int not null auto_increment,
   RUT_USUARIO          int,
   NOMBRE               varchar(20),
   DATO_PRE_CAMBIO      text,
   DATO_POST_CAMBIO     text,
   TABLA_MODIFICADA     varchar(30),
   QUERY                text,
   FECHA_HORA_ACCION    timestamp,
   primary key (ID_REG_AUDITORIA)
);

alter table AUDITORIA comment 'Se utiliza para realizar un registro de los datos que son re';

/*==============================================================*/
/* Table: AYUDANTE                                              */
/*==============================================================*/
create table AYUDANTE
(
   RUT_USUARIO          int not null,
   ID_AYUDANTE          int not null auto_increment,
   primary key (RUT_USUARIO),
   key AK_IDENTIFIER_1 (ID_AYUDANTE)
);

alter table AYUDANTE comment 'Las secciones cuentan con ayudante a los que el sistema debe';

/*==============================================================*/
/* Table: AYU_PROFE                                             */
/*==============================================================*/
create table AYU_PROFE
(
   ID_SECCION           int,
   RUT_USUARIO          int not null,
   PRO_RUT_USUARIO      int not null
);

/*==============================================================*/
/* Table: BORRADOR                                              */
/*==============================================================*/
create table BORRADOR
(
   ID_BORRADOR          int not null auto_increment,
   ID_CORREO            int not null,
   FECHA_HORA_BORRADOR  datetime,
   primary key (ID_BORRADOR)
);

/*==============================================================*/
/* Table: CARRERA                                               */
/*==============================================================*/
create table CARRERA
(
   COD_CARRERA          int not null,
   NOMBRE_CARRERA       varchar(100) not null,
   DESCRIPCION_CARRERA  varchar(500),
   primary key (COD_CARRERA)
);

alter table CARRERA comment 'Estas son las carreras pertenecientes a la Faculdad de Ingen';

/*==============================================================*/
/* Table: CARTA                                                 */
/*==============================================================*/
create table CARTA
(
   ID_CORREO            int not null auto_increment,
   RUT_USUARIO          int not null,
   ID_PLANTILLA         int,
   CUERPO_EMAIL         text not null,
   ASUNTO               varchar(40),
   FECHA_HORA_CORREO    datetime not null,
   ENVIADO_CARTA        bool,
   primary key (ID_CORREO)
);

alter table CARTA comment 'Esta carta representa la posibilidad de crear un mail y pode';

/*==============================================================*/
/* Table: CARTA_PERSONA                                         */
/*==============================================================*/
create table CARTA_PERSONA
(
   ID_CORREO            int not null,
   ID_PERSONA           int not null
);

/*==============================================================*/
/* Table: CARTA_USUARIO                                         */
/*==============================================================*/
create table CARTA_USUARIO
(
   ID_CORREO            int not null,
   RUT_USUARIO          int not null,
   NO_LEIDA_CARTA_USUARIO bool,
   RECIBIDA_CARTA_USUARIO bool
);

alter table CARTA_USUARIO comment 'Representa la posibilidad que tiene un coordinador de enviar';

/*==============================================================*/
/* Table: COORDINADOR                                           */
/*==============================================================*/
create table COORDINADOR
(
   RUT_USUARIO          int not null,
   ID_COORDINADOR       int not null auto_increment,
   primary key (RUT_USUARIO),
   key AK_IDENTIFIER_1 (ID_COORDINADOR)
);

alter table COORDINADOR comment 'Se utiliza para guardar los datos de las personas que usarán';

/*==============================================================*/
/* Table: CRON_JOBS                                             */
/*==============================================================*/
create table CRON_JOBS
(
   ID_JOB               int not null auto_increment,
   DESCRIPCION_JOB      varchar(255),
   PROXIMA_EJECUCION    timestamp,
   PATH_PHP_TO_EXEC     varchar(255),
   PERIODICITY_MINUTES  bigint,
   primary key (ID_JOB)
);

/*==============================================================*/
/* Table: DIA_HORARIO                                           */
/*==============================================================*/
create table DIA_HORARIO
(
   ID_DIA               int not null auto_increment,
   NOMBRE_DIA           varchar(10) not null,
   ABREVIATURA_DIA      varchar(2) not null,
   primary key (ID_DIA)
);

alter table DIA_HORARIO comment 'Se utiliza para indicar los días que hay clases.';

/*==============================================================*/
/* Table: EQUIPO_PROFESOR                                       */
/*==============================================================*/
create table EQUIPO_PROFESOR
(
   ID_EQUIPO            int not null auto_increment,
   ID_MODULO_TEM        int,
   primary key (ID_EQUIPO)
);

alter table EQUIPO_PROFESOR comment 'Existe un equipo de profesores por cada modulo temático(Unid';

/*==============================================================*/
/* Table: ESTUDIANTE                                            */
/*==============================================================*/
create table ESTUDIANTE
(
   RUT_USUARIO          int not null,
   COD_CARRERA          int not null,
   ID_SECCION           int,
   ID_ESTUDIANTE        int not null auto_increment,
   primary key (RUT_USUARIO),
   key AK_IDENTIFIER_1 (ID_ESTUDIANTE)
);

alter table ESTUDIANTE comment 'Son los estudiantes inscritos, los que pertenecen a las 20 c';

/*==============================================================*/
/* Table: EVALUACION                                            */
/*==============================================================*/
create table EVALUACION
(
   ID_EVALUACION        int not null auto_increment,
   ID_MODULO_TEM        int,
   primary key (ID_EVALUACION)
);

/*==============================================================*/
/* Table: FILTRO_CONTACTO                                       */
/*==============================================================*/
create table FILTRO_CONTACTO
(
   ID_FILTRO_CONTACTO   int not null,
   RUT_USUARIO          int not null,
   NOMBRE_FILTRO_CONTACTO varchar(20) not null,
   QUERY_FILTRO_CONTACTO text not null,
   primary key (ID_FILTRO_CONTACTO)
);

alter table FILTRO_CONTACTO comment 'Cada usuario tiene la posibilidad de crear filtros con respe';

/*==============================================================*/
/* Table: HISTORIALES_BUSQUEDA                                  */
/*==============================================================*/
create table HISTORIALES_BUSQUEDA
(
   ID_HISTORIAL_BUSQ    int not null auto_increment,
   RUT_USUARIO          int not null,
   PALABRA_BUSQ         varchar(255),
   TIMESTAMP_BUSQ       timestamp,
   TIPO_BUSQ            int,
   primary key (ID_HISTORIAL_BUSQ)
);

/*==============================================================*/
/* Table: HORARIO                                               */
/*==============================================================*/
create table HORARIO
(
   ID_HORARIO           int not null auto_increment,
   ID_MODULO            int not null,
   ID_DIA               int not null,
   NOMBRE_HORARIO       varchar(20),
   primary key (ID_HORARIO)
);

alter table HORARIO comment 'Se usa para representar los horarios en los que se realizan ';

/*==============================================================*/
/* Table: IMPLEMENTO                                            */
/*==============================================================*/
create table IMPLEMENTO
(
   ID_IMPLEMENTO        int not null auto_increment,
   NOMBRE_IMPLEMENTO    varchar(20) not null,
   DESCRIPCION_IMPLEMENTO varchar(50),
   primary key (ID_IMPLEMENTO),
   key AK_IDENTIFIER_2 (NOMBRE_IMPLEMENTO)
);

alter table IMPLEMENTO comment 'Es utilizada con el fin de indicar los artefactos que posee ';

/*==============================================================*/
/* Table: MODULO_HORARIO                                        */
/*==============================================================*/
create table MODULO_HORARIO
(
   ID_MODULO            int not null auto_increment,
   HORA_INI             time not null,
   HORA_FIN             time not null,
   primary key (ID_MODULO)
);

alter table MODULO_HORARIO comment 'Se utiliza para representar los módulos en los que se realiz';

/*==============================================================*/
/* Table: MODULO_TEMATICO                                       */
/*==============================================================*/
create table MODULO_TEMATICO
(
   ID_MODULO_TEM        int not null auto_increment,
   ID_EQUIPO            int,
   NOMBRE_MODULO        varchar(50) not null,
   DESCRIPCION_MODULO   varchar(100),
   primary key (ID_MODULO_TEM),
   key AK_IDENTIFIER_2 (NOMBRE_MODULO)
);

alter table MODULO_TEMATICO comment 'Es la unidad temática que se le pasará a los alumnos durante';

/*==============================================================*/
/* Table: NOTA                                                  */
/*==============================================================*/
create table NOTA
(
   ID_EVALUACION        int not null,
   RUT_USUARIO          int not null,
   VALOR_NOTA           decimal(2,2),
   COMENTARIO_NOTA      varchar(100)
);

/*==============================================================*/
/* Table: PERSONA                                               */
/*==============================================================*/
create table PERSONA
(
   ID_PERSONA           int not null auto_increment,
   CORREO_PERSONA       varchar(200) not null,
   primary key (ID_PERSONA)
);

alter table PERSONA comment 'corresponde a cualquier persona, de la que no se necesitan l';

/*==============================================================*/
/* Table: PLANIFICACION_CLASE                                   */
/*==============================================================*/
create table PLANIFICACION_CLASE
(
   ID_PLANIFICACION_CLASE int not null auto_increment,
   ID_SESION            int not null,
   ID_SALA              int not null,
   ID_SECCION           int not null,
   ID_HORARIO           int not null,
   FECHA_PLANIFICADA    date,
   primary key (ID_PLANIFICACION_CLASE)
);

alter table PLANIFICACION_CLASE comment 'Se utiliza para representar la hora en que se realiza una se';

/*==============================================================*/
/* Table: PLANTILLA                                             */
/*==============================================================*/
create table PLANTILLA
(
   ID_PLANTILLA         int not null auto_increment,
   RUT_USUARIO          int,
   CUERPO_PLANTILLA     text,
   NOMBRE_PLANTILLA     varchar(40) not null,
   ASUNTO_PLANTILLA     varchar(40),
   primary key (ID_PLANTILLA)
);

alter table PLANTILLA comment 'Se refiere a las plantillas que se podrán adjuntar en la car';

/*==============================================================*/
/* Table: PROFESOR                                              */
/*==============================================================*/
create table PROFESOR
(
   RUT_USUARIO          int not null,
   ID_TIPO_PROFESOR     int not null,
   ID_PROFESOR          int not null auto_increment,
   primary key (RUT_USUARIO),
   key AK_IDENTIFIER_1 (ID_PROFESOR)
);

alter table PROFESOR comment 'Se utiliza para guardar los datos de las personas que usarán';

/*==============================================================*/
/* Table: PROFESOR_SECCION                                      */
/*==============================================================*/
create table PROFESOR_SECCION
(
   ID_SECCION           int not null,
   RUT_USUARIO          int not null
);

/*==============================================================*/
/* Table: PROFE_EQUI_LIDER                                      */
/*==============================================================*/
create table PROFE_EQUI_LIDER
(
   ID_EQUIPO            int,
   RUT_USUARIO          int,
   LIDER_PROFESOR       bool not null
);

/*==============================================================*/
/* Table: REQUISITO                                             */
/*==============================================================*/
create table REQUISITO
(
   ID_REQUISITO         int not null auto_increment,
   NOMBRE_REQUISITO     varchar(20) not null,
   DESCRIPCION_REQUISITO varchar(50),
   primary key (ID_REQUISITO),
   key AK_IDENTIFIER_2 (NOMBRE_REQUISITO)
);

alter table REQUISITO comment 'Cada modulo temático tiene sus requisitos para que se pueda ';

/*==============================================================*/
/* Table: REQUISITO_MODULO                                      */
/*==============================================================*/
create table REQUISITO_MODULO
(
   ID_MODULO_TEM        int not null,
   ID_REQUISITO         int not null
);

alter table REQUISITO_MODULO comment 'Es utilizada para tratar la relación n a n que existe entre ';

/*==============================================================*/
/* Table: SALA                                                  */
/*==============================================================*/
create table SALA
(
   ID_SALA              int not null auto_increment,
   NUM_SALA             int not null,
   UBICACION            varchar(100),
   CAPACIDAD            int,
   primary key (ID_SALA)
);

alter table SALA comment 'Es el lugar físico en donde los estudiantes tendrán sus clas';

/*==============================================================*/
/* Table: SALA_IMPLEMENTO                                       */
/*==============================================================*/
create table SALA_IMPLEMENTO
(
   ID_SALA              int not null,
   ID_IMPLEMENTO        int not null
);

alter table SALA_IMPLEMENTO comment 'Se utiliza para representar la relación que exite entre las ';

/*==============================================================*/
/* Table: SECCION                                               */
/*==============================================================*/
create table SECCION
(
   ID_SECCION           int not null auto_increment,
   ID_SESION            int,
   LETRA_SECCION        varchar(2) not null,
   NUMERO_SECCION       int not null,
   primary key (ID_SECCION),
   key AK_IDENTIFIER_2 (LETRA_SECCION, NUMERO_SECCION)
);

alter table SECCION comment 'Las secciones son la forma en que se organizarán los más de ';

/*==============================================================*/
/* Table: SESION_DE_CLASE                                       */
/*==============================================================*/
create table SESION_DE_CLASE
(
   ID_SESION            int not null auto_increment,
   ID_SECCION           int,
   ID_MODULO_TEM        int not null,
   NOMBRE_SESION        varchar(30) not null,
   DESCRIPCION_SESION   varchar(100),
   primary key (ID_SESION)
);

alter table SESION_DE_CLASE comment 'Las sesiones son los bloques del curso, cada unidad son 3 se';

/*==============================================================*/
/* Table: TIPO_PROFESOR                                         */
/*==============================================================*/
create table TIPO_PROFESOR
(
   ID_TIPO_PROFESOR     int not null auto_increment,
   TIPO_PROFESOR        varchar(20) not null,
   primary key (ID_TIPO_PROFESOR)
);

/*==============================================================*/
/* Table: TIPO_USER                                             */
/*==============================================================*/
create table TIPO_USER
(
   ID_TIPO              int not null,
   NOMBRE_TIPO          varchar(11) not null comment 'Debe tener el mismo nombre que la tabla con la que hacer JOIN',
   primary key (ID_TIPO),
   key AK_IDENTIFIER_2 (NOMBRE_TIPO)
);

alter table TIPO_USER comment 'Existen distintos usuarios, con diferentes permisos dentro d';

/*==============================================================*/
/* Table: USUARIO                                               */
/*==============================================================*/
create table USUARIO
(
   RUT_USUARIO          int not null,
   ID_TIPO              int not null,
   PASSWORD_PRIMARIA    varchar(32),
   PASSWORD_TEMPORAL    varchar(32),
   CORREO1_USER         varchar(200) not null,
   CORREO2_USER         varchar(200),
   VALIDEZ              timestamp,
   NOMBRE1              varchar(20) not null,
   NOMBRE2              varchar(20),
   APELLIDO1            varchar(20) not null,
   APELLIDO2            varchar(20),
   TELEFONO             int,
   LOGUEABLE            bool not null,
   primary key (RUT_USUARIO)
);

alter table USUARIO comment 'Se utiliza para guardar los datos de las personas que usarán';

alter table ACT_ESTUDIANTE add constraint FK_RELATIONSHIP_33 foreign key (ID_ACT)
      references ACTIVIDAD_MASIVA (ID_ACT) on delete cascade on update cascade;

alter table ACT_ESTUDIANTE add constraint FK_RELATIONSHIP_34 foreign key (RUT_USUARIO)
      references ESTUDIANTE (RUT_USUARIO) on delete cascade on update cascade;

alter table ADJUNTO add constraint FK_RELATIONSHIP_50 foreign key (ID_CORREO)
      references CARTA (ID_CORREO) on delete cascade on update cascade;

alter table ASISTENCIA add constraint FK_RELATIONSHIP_56 foreign key (RUT_USUARIO)
      references ESTUDIANTE (RUT_USUARIO) on delete cascade on update cascade;

alter table ASISTENCIA add constraint FK_RELATIONSHIP_57 foreign key (ID_SESION)
      references SESION_DE_CLASE (ID_SESION) on delete cascade on update cascade;

alter table AUDITORIA add constraint FK_RELATIONSHIP_35 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table AYUDANTE add constraint FK_INHERIT_USUARIO3 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table AYU_PROFE add constraint FK_RELATIONSHIP_37 foreign key (RUT_USUARIO)
      references AYUDANTE (RUT_USUARIO) on delete cascade on update cascade;

alter table AYU_PROFE add constraint FK_RELATIONSHIP_39 foreign key (PRO_RUT_USUARIO)
      references PROFESOR (RUT_USUARIO) on delete cascade on update cascade;

alter table AYU_PROFE add constraint FK_RELATIONSHIP_54 foreign key (ID_SECCION)
      references SECCION (ID_SECCION) on delete cascade on update cascade;

alter table BORRADOR add constraint FK_RELATIONSHIP_44 foreign key (ID_CORREO)
      references CARTA (ID_CORREO) on delete cascade on update cascade;

alter table CARTA add constraint FK_RELATIONSHIP_22 foreign key (ID_PLANTILLA)
      references PLANTILLA (ID_PLANTILLA) on delete cascade on update cascade;

alter table CARTA add constraint FK_RELATIONSHIP_43 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table CARTA_PERSONA add constraint FK_RELATIONSHIP_45 foreign key (ID_PERSONA)
      references PERSONA (ID_PERSONA) on delete cascade on update cascade;

alter table CARTA_PERSONA add constraint FK_RELATIONSHIP_46 foreign key (ID_CORREO)
      references CARTA (ID_CORREO) on delete cascade on update cascade;

alter table CARTA_USUARIO add constraint FK_RELATIONSHIP_30 foreign key (ID_CORREO)
      references CARTA (ID_CORREO) on delete cascade on update cascade;

alter table CARTA_USUARIO add constraint FK_RELATIONSHIP_31 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table COORDINADOR add constraint FK_INHERIT_USUARIO foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table EQUIPO_PROFESOR add constraint FK_RELATIONSHIP_29 foreign key (ID_MODULO_TEM)
      references MODULO_TEMATICO (ID_MODULO_TEM) on delete cascade on update cascade;

alter table ESTUDIANTE add constraint FK_INHERIT_USUARIO4 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table ESTUDIANTE add constraint FK_RELATIONSHIP_1 foreign key (COD_CARRERA)
      references CARRERA (COD_CARRERA) on delete cascade on update cascade;

alter table ESTUDIANTE add constraint FK_RELATIONSHIP_6 foreign key (ID_SECCION)
      references SECCION (ID_SECCION) on delete cascade on update cascade;

alter table EVALUACION add constraint FK_RELATIONSHIP_48 foreign key (ID_MODULO_TEM)
      references MODULO_TEMATICO (ID_MODULO_TEM) on delete cascade on update cascade;

alter table FILTRO_CONTACTO add constraint FK_RELATIONSHIP_38 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table HISTORIALES_BUSQUEDA add constraint FK_RELATIONSHIP_51 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table HORARIO add constraint FK_RELATIONSHIP_8 foreign key (ID_DIA)
      references DIA_HORARIO (ID_DIA) on delete cascade on update cascade;

alter table HORARIO add constraint FK_RELATIONSHIP_9 foreign key (ID_MODULO)
      references MODULO_HORARIO (ID_MODULO) on delete cascade on update cascade;

alter table MODULO_TEMATICO add constraint FK_RELATIONSHIP_28 foreign key (ID_EQUIPO)
      references EQUIPO_PROFESOR (ID_EQUIPO) on delete cascade on update cascade;

alter table NOTA add constraint FK_RELATIONSHIP_36 foreign key (RUT_USUARIO)
      references ESTUDIANTE (RUT_USUARIO) on delete cascade on update cascade;

alter table NOTA add constraint FK_RELATIONSHIP_42 foreign key (ID_EVALUACION)
      references EVALUACION (ID_EVALUACION) on delete cascade on update cascade;

alter table PLANIFICACION_CLASE add constraint FK_RELATIONSHIP_10 foreign key (ID_SALA)
      references SALA (ID_SALA) on delete cascade on update cascade;

alter table PLANIFICACION_CLASE add constraint FK_RELATIONSHIP_11 foreign key (ID_HORARIO)
      references HORARIO (ID_HORARIO) on delete cascade on update cascade;

alter table PLANIFICACION_CLASE add constraint FK_RELATIONSHIP_55 foreign key (ID_SECCION)
      references SECCION (ID_SECCION) on delete cascade on update cascade;

alter table PLANIFICACION_CLASE add constraint FK_RELATIONSHIP_59 foreign key (ID_SESION)
      references SESION_DE_CLASE (ID_SESION) on delete cascade on update cascade;

alter table PLANTILLA add constraint FK_RELATIONSHIP_58 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table PROFESOR add constraint FK_INHERIT_USUARIO2 foreign key (RUT_USUARIO)
      references USUARIO (RUT_USUARIO) on delete cascade on update cascade;

alter table PROFESOR add constraint FK_RELATIONSHIP_52 foreign key (ID_TIPO_PROFESOR)
      references TIPO_PROFESOR (ID_TIPO_PROFESOR) on delete cascade on update cascade;

alter table PROFESOR_SECCION add constraint FK_RELATIONSHIP_49 foreign key (RUT_USUARIO)
      references PROFESOR (RUT_USUARIO) on delete cascade on update cascade;

alter table PROFESOR_SECCION add constraint FK_RELATIONSHIP_53 foreign key (ID_SECCION)
      references SECCION (ID_SECCION) on delete cascade on update cascade;

alter table PROFE_EQUI_LIDER add constraint FK_RELATIONSHIP_40 foreign key (ID_EQUIPO)
      references EQUIPO_PROFESOR (ID_EQUIPO) on delete cascade on update cascade;

alter table PROFE_EQUI_LIDER add constraint FK_RELATIONSHIP_41 foreign key (RUT_USUARIO)
      references PROFESOR (RUT_USUARIO) on delete cascade on update cascade;

alter table REQUISITO_MODULO add constraint FK_RELATIONSHIP_19 foreign key (ID_REQUISITO)
      references REQUISITO (ID_REQUISITO) on delete cascade on update cascade;

alter table REQUISITO_MODULO add constraint FK_RELATIONSHIP_27 foreign key (ID_MODULO_TEM)
      references MODULO_TEMATICO (ID_MODULO_TEM) on delete cascade on update cascade;

alter table SALA_IMPLEMENTO add constraint FK_RELATIONSHIP_16 foreign key (ID_SALA)
      references SALA (ID_SALA) on delete cascade on update cascade;

alter table SALA_IMPLEMENTO add constraint FK_RELATIONSHIP_17 foreign key (ID_IMPLEMENTO)
      references IMPLEMENTO (ID_IMPLEMENTO) on delete cascade on update cascade;

alter table SECCION add constraint FK_SE_ENCUENTRA_ACTUALMENTE foreign key (ID_SESION)
      references SESION_DE_CLASE (ID_SESION) on delete cascade on update cascade;

alter table SESION_DE_CLASE add constraint FK_RELATIONSHIP_13 foreign key (ID_MODULO_TEM)
      references MODULO_TEMATICO (ID_MODULO_TEM) on delete cascade on update cascade;

alter table SESION_DE_CLASE add constraint FK_RELATIONSHIP_14 foreign key (ID_SECCION)
      references SECCION (ID_SECCION) on delete cascade on update cascade;

alter table USUARIO add constraint FK_RELATIONSHIP_23 foreign key (ID_TIPO)
      references TIPO_USER (ID_TIPO) on delete cascade on update cascade;

