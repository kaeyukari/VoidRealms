
CREATE TABLE categorias (
       cat_codigo           INTEGER NOT NULL,
       cat_nome             VARCHAR(30)
);

CREATE UNIQUE INDEX XPKcategorias ON categorias
(
       cat_codigo                     ASC
);


ALTER TABLE categorias
       ADD CONSTRAINT PRIMARY KEY (cat_codigo);


CREATE TABLE eventos (
       eve_codigo           INTEGER NOT NULL,
       eve_nome             VARCHAR(100),
       eve_datainicio       DATE,
       eve_datafim          DATE,
       eve_descritivo       VARCHAR(5000),
       eve_periodo          VARCHAR(20),
       eve_area             VARCHAR(50),
       eve_local            VARCHAR(50)
);

CREATE UNIQUE INDEX XPKeventos ON eventos
(
       eve_codigo                     ASC
);


ALTER TABLE eventos
       ADD CONSTRAINT PRIMARY KEY (eve_codigo);


CREATE TABLE usuario (
       usu_codigo           INTEGER NOT NULL,
       usu_nome             VARCHAR(50),
       usu_email            VARCHAR(70),
       usu_senha            VARCHAR(20),
       usu_cep              VARCHAR(10),
       usu_logradouro       VARCHAR(70),
       usu_numero           VARCHAR(20),
       usu_complemento      VARCHAR(50),
       usu_bairro           VARCHAR(40),
       usu_cidade           VARCHAR(70),
       usu_uf               VARCHAR(2),
       cat_codigo           INTEGER
);

CREATE UNIQUE INDEX XPKusuario ON usuario
(
       usu_codigo                     ASC
);


ALTER TABLE usuario
       ADD CONSTRAINT PRIMARY KEY (usu_codigo);


CREATE TABLE usuario_eventos (
       usu_codigo           INTEGER NOT NULL,
       eve_codigo           INTEGER NOT NULL
);

CREATE UNIQUE INDEX XPKusuario_eventos ON usuario_eventos
(
       usu_codigo                     ASC,
       eve_codigo                     ASC
);


ALTER TABLE usuario_eventos
       ADD CONSTRAINT PRIMARY KEY (usu_codigo, eve_codigo);


CREATE TABLE usuario_eventospresenca (
       usu_codigo           INTEGER NOT NULL,
       eve_codigo           INTEGER NOT NULL,
       uep_codigo           INTEGER NOT NULL,
       uep_data             DATE,
       uep_avaliacao        INTEGER
);

CREATE UNIQUE INDEX XPKusuario_eventospresenca ON usuario_eventospresenca
(
       usu_codigo                     ASC,
       eve_codigo                     ASC,
       uep_codigo                     ASC
);


ALTER TABLE usuario_eventospresenca
       ADD CONSTRAINT PRIMARY KEY (usu_codigo, eve_codigo, uep_codigo);


ALTER TABLE usuario
       ADD CONSTRAINT FOREIGN KEY (cat_codigo)
                             REFERENCES categorias  (cat_codigo);


ALTER TABLE usuario_eventos
       ADD CONSTRAINT FOREIGN KEY (eve_codigo)
                             REFERENCES eventos  (eve_codigo);


ALTER TABLE usuario_eventos
       ADD CONSTRAINT FOREIGN KEY (usu_codigo)
                             REFERENCES usuario  (usu_codigo);


ALTER TABLE usuario_eventospresenca
       ADD CONSTRAINT FOREIGN KEY (eve_codigo)
                             REFERENCES eventos  (eve_codigo);


ALTER TABLE usuario_eventospresenca
       ADD CONSTRAINT FOREIGN KEY (usu_codigo)
                             REFERENCES usuario  (usu_codigo);

