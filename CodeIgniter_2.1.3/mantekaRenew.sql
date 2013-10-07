/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     07/10/2013 4:07:45 p. m.                     */
/*==============================================================*/


drop table if exists act_estudiante;

drop table if exists actividad_masiva;

drop table if exists adjunto;

drop table if exists asistencia;

drop table if exists auditoria;

drop table if exists ayu_profe;

drop table if exists ayudante;

drop table if exists borrador;

drop table if exists carrera;

drop table if exists carta;

drop table if exists carta_persona;

drop table if exists carta_usuario;

drop table if exists coordinador;

drop table if exists cron_jobs;

drop table if exists dia_horario;

drop table if exists equipo_profesor;

drop table if exists estudiante;

drop table if exists evaluacion;

drop table if exists filtro_contacto;

drop table if exists historiales_busqueda;

drop table if exists horario;

drop table if exists implemento;

drop table if exists implementos_modulo_tematico;

drop table if exists modulo_horario;

drop table if exists modulo_tematico;

drop table if exists nota;

drop table if exists persona;

drop table if exists planificacion_clase;

drop table if exists plantilla;

drop table if exists profe_equi_lider;

drop table if exists profesor;

drop table if exists sala;

drop table if exists sala_implemento;

drop table if exists seccion;

drop table if exists sesion_de_clase;

drop table if exists tipo_justificacion;

drop table if exists tipo_profesor;

drop table if exists tipo_user;

drop table if exists usuario;

/*==============================================================*/
/* Table: act_estudiante                                        */
/*==============================================================*/
create table act_estudiante
(
   ID_ACT               int not null,
   RUT_USUARIO          int not null
);

alter table act_estudiante comment 'Se utiliza con el fin de representar que muchos estudiantes ';

/*==============================================================*/
/* Table: actividad_masiva                                      */
/*==============================================================*/
create table actividad_masiva
(
   ID_ACT               int not null auto_increment,
   NOMBRE_ACT           varchar(20) not null,
   FECHA_ACT            date not null,
   LUGAR_ACT            varchar(20),
   LUGAR_RETIRAR_ENTRADA varchar(20),
   primary key (ID_ACT)
);

alter table actividad_masiva comment 'El curso tiene programa 3 salidas extraprogramáticas, obre d';

/*==============================================================*/
/* Table: adjunto                                               */
/*==============================================================*/
create table adjunto
(
   ID_ADJUNTO           int not null auto_increment,
   ID_CORREO            int not null,
   NOMBRE_LOGICO_ADJ    varchar(255),
   NOMBRE_FISICO_ADJ    varchar(255),
   primary key (ID_ADJUNTO)
);

/*==============================================================*/
/* Table: asistencia                                            */
/*==============================================================*/
create table asistencia
(
   ID_SESION            int not null,
   ID_SUSPENCION        int,
   RUT_USUARIO          int not null,
   PRESENTE_ASISTENCIA  bool,
   JUSTIFICADO_ASISTENCIA bool,
   COMENTARIO_ASISTENCIA varchar(100)
);

/*==============================================================*/
/* Table: auditoria                                             */
/*==============================================================*/
create table auditoria
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

alter table auditoria comment 'Se utiliza para realizar un registro de los datos que son re';

/*==============================================================*/
/* Table: ayu_profe                                             */
/*==============================================================*/
create table ayu_profe
(
   ID_AYU_PROFE         int not null auto_increment,
   RUT_USUARIO          int,
   PRO_RUT_USUARIO      int not null,
   primary key (ID_AYU_PROFE)
);

/*==============================================================*/
/* Table: ayudante                                              */
/*==============================================================*/
create table ayudante
(
   RUT_USUARIO          int not null,
   ID_AYUDANTE          int not null auto_increment,
   primary key (RUT_USUARIO),
   key AK_IDENTIFIER_1 (ID_AYUDANTE)
);

alter table ayudante comment 'Las secciones cuentan con ayudante a los que el sistema debe';

/*==============================================================*/
/* Table: borrador                                              */
/*==============================================================*/
create table borrador
(
   ID_BORRADOR          int not null auto_increment,
   ID_CORREO            int not null,
   FECHA_HORA_BORRADOR  datetime,
   primary key (ID_BORRADOR)
);

/*==============================================================*/
/* Table: carrera                                               */
/*==============================================================*/
create table carrera
(
   COD_CARRERA          int not null,
   NOMBRE_CARRERA       varchar(100) not null,
   DESCRIPCION_CARRERA  varchar(500),
   primary key (COD_CARRERA)
);

alter table carrera comment 'Estas son las carreras pertenecientes a la Faculdad de Ingen';

/*==============================================================*/
/* Table: carta                                                 */
/*==============================================================*/
create table carta
(
   ID_CORREO            int not null auto_increment,
   RUT_USUARIO          int not null,
   ID_BORRADOR          int,
   CUERPO_EMAIL         text not null,
   ASUNTO               varchar(40),
   FECHA_HORA_CORREO    datetime not null,
   ENVIADO_CARTA        bool,
   primary key (ID_CORREO)
);

alter table carta comment 'Esta carta representa la posibilidad de crear un mail y pode';

/*==============================================================*/
/* Table: carta_persona                                         */
/*==============================================================*/
create table carta_persona
(
   ID_CORREO            int not null,
   ID_PERSONA           int not null
);

/*==============================================================*/
/* Table: carta_usuario                                         */
/*==============================================================*/
create table carta_usuario
(
   ID_CORREO            int not null,
   RUT_USUARIO          int not null,
   NO_LEIDA_CARTA_USUARIO bool,
   RECIBIDA_CARTA_USUARIO bool
);

alter table carta_usuario comment 'Representa la posibilidad que tiene un coordinador de enviar';

/*==============================================================*/
/* Table: coordinador                                           */
/*==============================================================*/
create table coordinador
(
   RUT_USUARIO          int not null,
   ID_COORDINADOR       int not null auto_increment,
   primary key (RUT_USUARIO),
   key AK_IDENTIFIER_1 (ID_COORDINADOR)
);

alter table coordinador comment 'Se utiliza para guardar los datos de las personas que usarán';

/*==============================================================*/
/* Table: cron_jobs                                             */
/*==============================================================*/
create table cron_jobs
(
   ID_JOB               int not null auto_increment,
   DESCRIPCION_JOB      varchar(255),
   PROXIMA_EJECUCION    timestamp,
   PATH_PHP_TO_EXEC     varchar(255),
   PERIODICITY_MINUTES  bigint,
   primary key (ID_JOB)
);

/*==============================================================*/
/* Table: dia_horario                                           */
/*==============================================================*/
create table dia_horario
(
   ID_DIA               int not null auto_increment,
   NOMBRE_DIA           varchar(10) not null,
   ABREVIATURA_DIA      varchar(2) not null,
   primary key (ID_DIA)
);

alter table dia_horario comment 'Se utiliza para indicar los días que hay clases.';

/*==============================================================*/
/* Table: equipo_profesor                                       */
/*==============================================================*/
create table equipo_profesor
(
   ID_EQUIPO            int not null auto_increment,
   ID_MODULO_TEM        int,
   primary key (ID_EQUIPO)
);

alter table equipo_profesor comment 'Existe un equipo de profesores por cada modulo temático(Unid';

/*==============================================================*/
/* Table: estudiante                                            */
/*==============================================================*/
create table estudiante
(
   RUT_USUARIO          int not null,
   COD_CARRERA          int not null,
   ID_SECCION           int,
   ID_ESTUDIANTE        int not null auto_increment,
   primary key (RUT_USUARIO),
   key AK_IDENTIFIER_1 (ID_ESTUDIANTE)
);

alter table estudiante comment 'Son los estudiantes inscritos, los que pertenecen a las 20 c';

/*==============================================================*/
/* Table: evaluacion                                            */
/*==============================================================*/
create table evaluacion
(
   ID_EVALUACION        int not null auto_increment,
   ID_MODULO_TEM        int,
   primary key (ID_EVALUACION)
);

/*==============================================================*/
/* Table: filtro_contacto                                       */
/*==============================================================*/
create table filtro_contacto
(
   ID_FILTRO_CONTACTO   int not null,
   RUT_USUARIO          int not null,
   NOMBRE_FILTRO_CONTACTO varchar(20) not null,
   QUERY_FILTRO_CONTACTO text not null,
   primary key (ID_FILTRO_CONTACTO)
);

alter table filtro_contacto comment 'Cada usuario tiene la posibilidad de crear filtros con respe';

/*==============================================================*/
/* Table: historiales_busqueda                                  */
/*==============================================================*/
create table historiales_busqueda
(
   ID_HISTORIAL_BUSQ    int not null auto_increment,
   RUT_USUARIO          int not null,
   PALABRA_BUSQ         varchar(255),
   TIMESTAMP_BUSQ       timestamp,
   TIPO_BUSQ            int,
   primary key (ID_HISTORIAL_BUSQ)
);

/*==============================================================*/
/* Table: horario                                               */
/*==============================================================*/
create table horario
(
   ID_HORARIO           int not null auto_increment,
   ID_MODULO            int not null,
   ID_DIA               int not null,
   primary key (ID_HORARIO)
);

alter table horario comment 'Se usa para representar los horarios en los que se realizan ';

/*==============================================================*/
/* Table: implemento                                            */
/*==============================================================*/
create table implemento
(
   ID_IMPLEMENTO        int not null auto_increment,
   NOMBRE_IMPLEMENTO    varchar(20) not null,
   DESCRIPCION_IMPLEMENTO varchar(50),
   primary key (ID_IMPLEMENTO),
   key AK_IDENTIFIER_2 (NOMBRE_IMPLEMENTO)
);

alter table implemento comment 'Es utilizada con el fin de indicar los artefactos que posee ';

/*==============================================================*/
/* Table: implementos_modulo_tematico                           */
/*==============================================================*/
create table implementos_modulo_tematico
(
   ID_IMPLEMENTO        int,
   ID_MODULO_TEM        int not null
);

alter table implementos_modulo_tematico comment 'Es utilizada para tratar la relación n a n que existe entre ';

/*==============================================================*/
/* Table: modulo_horario                                        */
/*==============================================================*/
create table modulo_horario
(
   ID_MODULO            int not null auto_increment,
   HORA_INI             time not null,
   HORA_FIN             time not null,
   primary key (ID_MODULO)
);

alter table modulo_horario comment 'Se utiliza para representar los módulos en los que se realiz';

/*==============================================================*/
/* Table: modulo_tematico                                       */
/*==============================================================*/
create table modulo_tematico
(
   ID_MODULO_TEM        int not null auto_increment,
   NOMBRE_MODULO        varchar(50) not null,
   DESCRIPCION_MODULO   varchar(100),
   primary key (ID_MODULO_TEM),
   key AK_IDENTIFIER_2 (NOMBRE_MODULO)
);

alter table modulo_tematico comment 'Es la unidad temática que se le pasará a los alumnos durante';

/*==============================================================*/
/* Table: nota                                                  */
/*==============================================================*/
create table nota
(
   ID_EVALUACION        int not null,
   RUT_USUARIO          int not null,
   VALOR_NOTA           decimal(2,2),
   COMENTARIO_NOTA      varchar(100)
);

/*==============================================================*/
/* Table: persona                                               */
/*==============================================================*/
create table persona
(
   ID_PERSONA           int not null auto_increment,
   CORREO_PERSONA       varchar(200) not null,
   primary key (ID_PERSONA)
);

alter table persona comment 'corresponde a cualquier persona, de la que no se necesitan l';

/*==============================================================*/
/* Table: planificacion_clase                                   */
/*==============================================================*/
create table planificacion_clase
(
   ID_PLANIFICACION_CLASE int not null auto_increment,
   ID_SESION            int not null,
   ID_SALA              int not null,
   ID_AYU_PROFE         int,
   ID_SECCION           int not null,
   FECHA_PLANIFICADA    date,
   NUM_SESION_SECCION   int,
   primary key (ID_PLANIFICACION_CLASE)
);

alter table planificacion_clase comment 'Se utiliza para representar la hora en que se realiza una se';

/*==============================================================*/
/* Table: plantilla                                             */
/*==============================================================*/
create table plantilla
(
   ID_PLANTILLA         int not null auto_increment,
   RUT_USUARIO          int,
   CUERPO_PLANTILLA     text,
   NOMBRE_PLANTILLA     varchar(40) not null,
   ASUNTO_PLANTILLA     varchar(40),
   primary key (ID_PLANTILLA)
);

alter table plantilla comment 'Se refiere a las plantillas que se podrán adjuntar en la car';

/*==============================================================*/
/* Table: profe_equi_lider                                      */
/*==============================================================*/
create table profe_equi_lider
(
   ID_EQUIPO            int,
   RUT_USUARIO          int,
   LIDER_PROFESOR       bool not null
);

/*==============================================================*/
/* Table: profesor                                              */
/*==============================================================*/
create table profesor
(
   RUT_USUARIO          int not null,
   ID_TIPO_PROFESOR     int not null,
   ID_PROFESOR          int not null auto_increment,
   primary key (RUT_USUARIO),
   key AK_IDENTIFIER_1 (ID_PROFESOR)
);

alter table profesor comment 'Se utiliza para guardar los datos de las personas que usarán';

/*==============================================================*/
/* Table: sala                                                  */
/*==============================================================*/
create table sala
(
   ID_SALA              int not null auto_increment,
   NUM_SALA             int not null,
   UBICACION            varchar(100),
   CAPACIDAD            int,
   primary key (ID_SALA)
);

alter table sala comment 'Es el lugar físico en donde los estudiantes tendrán sus clas';

/*==============================================================*/
/* Table: sala_implemento                                       */
/*==============================================================*/
create table sala_implemento
(
   ID_SALA              int not null,
   ID_IMPLEMENTO        int not null
);

alter table sala_implemento comment 'Se utiliza para representar la relación que exite entre las ';

/*==============================================================*/
/* Table: seccion                                               */
/*==============================================================*/
create table seccion
(
   ID_SECCION           int not null auto_increment,
   ID_SESION            int,
   ID_HORARIO           int not null,
   LETRA_SECCION        varchar(2) not null,
   NUMERO_SECCION       int not null,
   primary key (ID_SECCION),
   key AK_IDENTIFIER_2 (LETRA_SECCION, NUMERO_SECCION)
);

alter table seccion comment 'Las secciones son la forma en que se organizarán los más de ';

/*==============================================================*/
/* Table: sesion_de_clase                                       */
/*==============================================================*/
create table sesion_de_clase
(
   ID_SESION            int not null auto_increment,
   ID_MODULO_TEM        int not null,
   NOMBRE_SESION        varchar(30) not null,
   DESCRIPCION_SESION   varchar(100),
   primary key (ID_SESION)
);

alter table sesion_de_clase comment 'Las sesiones son los bloques del curso, cada unidad son 3 se';

/*==============================================================*/
/* Table: tipo_justificacion                                    */
/*==============================================================*/
create table tipo_justificacion
(
   ID_SUSPENCION        int not null auto_increment,
   NOMBRE_SUSPENCION    varchar(50),
   primary key (ID_SUSPENCION)
);

/*==============================================================*/
/* Table: tipo_profesor                                         */
/*==============================================================*/
create table tipo_profesor
(
   ID_TIPO_PROFESOR     int not null auto_increment,
   TIPO_PROFESOR        varchar(20) not null,
   primary key (ID_TIPO_PROFESOR)
);

/*==============================================================*/
/* Table: tipo_user                                             */
/*==============================================================*/
create table tipo_user
(
   ID_TIPO              int not null,
   NOMBRE_TIPO          varchar(11) not null comment 'Debe tener el mismo nombre que la tabla con la que hacer JOIN',
   primary key (ID_TIPO),
   key AK_IDENTIFIER_2 (NOMBRE_TIPO)
);

alter table tipo_user comment 'Existen distintos usuarios, con diferentes permisos dentro d';

/*==============================================================*/
/* Table: usuario                                               */
/*==============================================================*/
create table usuario
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

alter table usuario comment 'Se utiliza para guardar los datos de las personas que usarán';

alter table act_estudiante add constraint FK_RELATIONSHIP_33 foreign key (ID_ACT)
      references actividad_masiva (ID_ACT) on delete cascade on update cascade;

alter table act_estudiante add constraint FK_RELATIONSHIP_34 foreign key (RUT_USUARIO)
      references estudiante (RUT_USUARIO) on delete cascade on update cascade;

alter table adjunto add constraint FK_RELATIONSHIP_50 foreign key (ID_CORREO)
      references carta (ID_CORREO) on delete cascade on update cascade;

alter table asistencia add constraint FK_RELATIONSHIP_56 foreign key (RUT_USUARIO)
      references estudiante (RUT_USUARIO) on delete cascade on update cascade;

alter table asistencia add constraint FK_RELATIONSHIP_57 foreign key (ID_SESION)
      references sesion_de_clase (ID_SESION) on delete cascade on update cascade;

alter table asistencia add constraint FK_RELATIONSHIP_60 foreign key (ID_SUSPENCION)
      references tipo_justificacion (ID_SUSPENCION) on delete cascade on update cascade;

alter table auditoria add constraint FK_RELATIONSHIP_35 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table ayu_profe add constraint FK_RELATIONSHIP_37 foreign key (RUT_USUARIO)
      references ayudante (RUT_USUARIO) on delete cascade on update cascade;

alter table ayu_profe add constraint FK_RELATIONSHIP_39 foreign key (PRO_RUT_USUARIO)
      references profesor (RUT_USUARIO) on delete cascade on update cascade;

alter table ayudante add constraint FK_INHERIT_USUARIO3 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table borrador add constraint FK_RELATIONSHIP_45 foreign key (ID_CORREO)
      references carta (ID_CORREO) on delete cascade on update cascade;

alter table carta add constraint FK_RELATIONSHIP_43 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table carta add constraint FK_RELATIONSHIP_44 foreign key (ID_BORRADOR)
      references borrador (ID_BORRADOR) on delete cascade on update cascade;

alter table carta_persona add constraint FK_RELATIONSHIP_46 foreign key (ID_PERSONA)
      references persona (ID_PERSONA) on delete cascade on update cascade;

alter table carta_persona add constraint FK_RELATIONSHIP_47 foreign key (ID_CORREO)
      references carta (ID_CORREO) on delete cascade on update cascade;

alter table carta_usuario add constraint FK_RELATIONSHIP_29 foreign key (ID_CORREO)
      references carta (ID_CORREO) on delete cascade on update cascade;

alter table carta_usuario add constraint FK_RELATIONSHIP_30 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table coordinador add constraint FK_INHERIT_USUARIO foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table equipo_profesor add constraint FK_RELATIONSHIP_28 foreign key (ID_MODULO_TEM)
      references modulo_tematico (ID_MODULO_TEM) on delete cascade on update cascade;

alter table estudiante add constraint FK_INHERIT_USUARIO4 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table estudiante add constraint FK_RELATIONSHIP_1 foreign key (COD_CARRERA)
      references carrera (COD_CARRERA) on delete cascade on update cascade;

alter table estudiante add constraint FK_RELATIONSHIP_6 foreign key (ID_SECCION)
      references seccion (ID_SECCION) on delete cascade on update cascade;

alter table evaluacion add constraint FK_RELATIONSHIP_48 foreign key (ID_MODULO_TEM)
      references modulo_tematico (ID_MODULO_TEM) on delete cascade on update cascade;

alter table filtro_contacto add constraint FK_RELATIONSHIP_38 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table historiales_busqueda add constraint FK_RELATIONSHIP_51 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table horario add constraint FK_RELATIONSHIP_8 foreign key (ID_DIA)
      references dia_horario (ID_DIA) on delete cascade on update cascade;

alter table horario add constraint FK_RELATIONSHIP_9 foreign key (ID_MODULO)
      references modulo_horario (ID_MODULO) on delete cascade on update cascade;

alter table implementos_modulo_tematico add constraint FK_RELATIONSHIP_27 foreign key (ID_MODULO_TEM)
      references modulo_tematico (ID_MODULO_TEM) on delete cascade on update cascade;

alter table implementos_modulo_tematico add constraint FK_RELATIONSHIP_53 foreign key (ID_IMPLEMENTO)
      references implemento (ID_IMPLEMENTO) on delete cascade on update cascade;

alter table nota add constraint FK_RELATIONSHIP_36 foreign key (RUT_USUARIO)
      references estudiante (RUT_USUARIO) on delete cascade on update cascade;

alter table nota add constraint FK_RELATIONSHIP_42 foreign key (ID_EVALUACION)
      references evaluacion (ID_EVALUACION) on delete cascade on update cascade;

alter table planificacion_clase add constraint FK_RELATIONSHIP_10 foreign key (ID_SALA)
      references sala (ID_SALA) on delete cascade on update cascade;

alter table planificacion_clase add constraint FK_RELATIONSHIP_54 foreign key (ID_AYU_PROFE)
      references ayu_profe (ID_AYU_PROFE) on delete cascade on update cascade;

alter table planificacion_clase add constraint FK_RELATIONSHIP_55 foreign key (ID_SECCION)
      references seccion (ID_SECCION) on delete cascade on update cascade;

alter table planificacion_clase add constraint FK_RELATIONSHIP_59 foreign key (ID_SESION)
      references sesion_de_clase (ID_SESION) on delete cascade on update cascade;

alter table plantilla add constraint FK_RELATIONSHIP_58 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table profe_equi_lider add constraint FK_RELATIONSHIP_40 foreign key (ID_EQUIPO)
      references equipo_profesor (ID_EQUIPO) on delete cascade on update cascade;

alter table profe_equi_lider add constraint FK_RELATIONSHIP_41 foreign key (RUT_USUARIO)
      references profesor (RUT_USUARIO) on delete cascade on update cascade;

alter table profesor add constraint FK_INHERIT_USUARIO2 foreign key (RUT_USUARIO)
      references usuario (RUT_USUARIO) on delete cascade on update cascade;

alter table profesor add constraint FK_RELATIONSHIP_52 foreign key (ID_TIPO_PROFESOR)
      references tipo_profesor (ID_TIPO_PROFESOR) on delete cascade on update cascade;

alter table sala_implemento add constraint FK_RELATIONSHIP_16 foreign key (ID_SALA)
      references sala (ID_SALA) on delete cascade on update cascade;

alter table sala_implemento add constraint FK_RELATIONSHIP_17 foreign key (ID_IMPLEMENTO)
      references implemento (ID_IMPLEMENTO) on delete cascade on update cascade;

alter table seccion add constraint FK_RELATIONSHIP_11 foreign key (ID_HORARIO)
      references horario (ID_HORARIO) on delete cascade on update cascade;

alter table seccion add constraint FK_RELATIONSHIP_49 foreign key (ID_SESION)
      references sesion_de_clase (ID_SESION) on delete cascade on update cascade;

alter table sesion_de_clase add constraint FK_RELATIONSHIP_13 foreign key (ID_MODULO_TEM)
      references modulo_tematico (ID_MODULO_TEM) on delete cascade on update cascade;

alter table usuario add constraint FK_RELATIONSHIP_23 foreign key (ID_TIPO)
      references tipo_user (ID_TIPO) on delete cascade on update cascade;

