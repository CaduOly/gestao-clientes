SET NAMES 'utf8';
SET CHARACTER SET utf8;

CREATE SCHEMA IF NOT EXISTS `gestao_clientes`;

USE `gestao_clientes`;

DROP TABLE IF EXISTS `endereco`;

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `rg` varchar(20) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(15) NOT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE `endereco` (
  `id_endereco` int NOT NULL AUTO_INCREMENT,
  `cep` varchar(10) NOT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `logradouro` varchar(255) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `bairro` varchar(100) NOT NULL,
  `localidade` varchar(100) NOT NULL,
  `uf` char(2) NOT NULL,
  `id_cliente` int DEFAULT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_cliente` (`id_cliente`),
  CONSTRAINT `fk_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- INSERT para a tabela 'gestao_clientes.cliente'
INSERT INTO gestao_clientes.cliente
(id_cliente, nome, cpf, rg, data_nascimento, telefone)
VALUES
(1, 'Fulano', '12312345656', '1234567', '2001-07-29', '61987886544');

-- INSERT para a tabela 'gestao_clientes.endereco'
INSERT INTO gestao_clientes.endereco
(id_endereco, cep, numero, logradouro, complemento, bairro, localidade, uf, id_cliente)
VALUES
(1,'71571-102', '', 'Quadra 11 Conjunto B', '', 'Paranoá', 'Brasília', 'DF', 1),
(2,'71571-102', '324234', 'Quadra 11 Conjunto D', '342', 'Paranoá', 'Brasília', 'DF', 1);
