CREATE TABLE categoria (
    id      INT         NOT NULL AUTO_INCREMENT,
    nome    VARCHAR(20) NOT NULL,

    CONSTRAINT `pk_categoria`
        PRIMARY KEY (id),
    CONSTRAINT `unq_receita`
        UNIQUE (nome)
) Engine=InnoDB;

CREATE TABLE receita (
    id                  INT                                 NOT NULL AUTO_INCREMENT,
    nome                VARCHAR(60)                         NOT NULL,
    descricao           VARCHAR(200),
    tempo_de_preparo    INT                                 NOT NULL,
    nivel               ENUM('FACIL', 'MEDIO', 'DIFICIL')   NOT NULL,
    data_de_criacao     DATE,

    categoria__id       INT                                 NOT NULL,

    CONSTRAINT `pk_receita`
        PRIMARY KEY (id),
    CONSTRAINT `fk_receita__categoria__id`
        FOREIGN KEY (categoria__id) REFERENCES categoria(id)
) Engine=InnoDB;

CREATE TABLE ingrediente (
    id      INT             NOT NULL AUTO_INCREMENT,
    nome    VARCHAR(50)     NOT NULL,

    CONSTRAINT `pk_ingrediente`
        PRIMARY KEY (id),
    CONSTRAINT `unq_ingrediente`
        UNIQUE (nome)
) Engine=InnoDB;

CREATE TABLE ingrediente_receita ( 
    id              INT             NOT NULL AUTO_INCREMENT,
    quantidade      INT             NOT NULL,
    unidade         VARCHAR(20),

    receita__id     INT             NOT NULL,
    ingrediente__id INT             NOT NULL,

    CONSTRAINT `pk_fk_ingrediente_receita`
        PRIMARY KEY (id),
    CONSTRAINT `fk_ingrediente_receita__receita__id`
        FOREIGN KEY (receita__id) REFERENCES receita(id),
    CONSTRAINT `fk_ingrediente_receita__ingrediente__id`
        FOREIGN KEY (ingrediente__id) REFERENCES ingrediente(id)
) Engine=InnoDB;
