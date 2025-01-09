drop database if exists basedados_padaria;
create database basedados_padaria;
use basedados_padaria;

create table Clientes(
ID int primary key auto_increment,	
nome varchar(60) not null,
idade int not null,
morada varchar(40),
email varchar(40),
data_nascimento date,
telefone int(9),
sexo ENUM('M', 'F') not null 
);

create table Utilizadores(
ID int primary key auto_increment,
nome varchar (50)not null,
telefone int(9) not null unique,
email varchar(30) not null unique,
password varchar(255) not null 
);
create table Feedback(
id_cliente int,
id_loja int,
avaliacao tinyint not null,
comentario varchar(255)
);
create table Lojas(
ID int primary key auto_increment,
morada varchar (30) not null unique 
); 
create table Produtos(
ID int primary key auto_increment,
nome varchar(60) not null unique,
valor decimal(10,2) not null
);
CREATE TABLE Stock_Lojas(
ID INT PRIMARY KEY AUTO_INCREMENT,
id_produto INT NOT NULL,
id_loja INT NOT NULL,
quantidade INT(9) DEFAULT 0
);
create table Vendas(
ID int primary key auto_increment,
id_cliente int not null,
id_produto int not null,
id_loja int not null,
quantidade int not null
);
-- foreing keys -----------------------------------------
alter table feedback
add constraint FK_Feedback_id_clientes
foreign key (id_cliente) references Clientes(ID);
					 
alter table feedback
add constraint FK_Feedback_id_lojas
foreign key (id_loja) references Lojas(ID);

alter table Stock_Lojas
add CONSTRAINT FK_Feedback_id_lojas_2 
FOREIGN KEY (id_loja) REFERENCES Lojas(ID);

alter table Stock_Lojas
add CONSTRAINT FK_Feedback_id_produto
FOREIGN KEY (id_produto) REFERENCES Produtos(ID);

alter table Vendas
add CONSTRAINT FK_Vendas_id_clientes_2 
FOREIGN KEY (id_cliente) REFERENCES Clientes(ID);

alter table Vendas
add constraint FK_Vendas_id_lojas
foreign key (id_loja) references Lojas(ID);

 -- lojas  ---------------------------------------------------- 
INSERT INTO Lojas(ID, Morada)
VALUES
(1, 'Rua das Flores, 123'),
(2, 'Avenida Principal, 45'),
(3, 'Praça da Alegria, 67'),
(4, 'Rua do Comércio, 89');

 -- Produtos ---------------------------------------------------- 
INSERT INTO Produtos (nome, valor) VALUES
('Pão de Milho', 3.50),
('Brioche', 4.20),
('Pão de Centeio', 2.80),
('Muffin de Chocolate', 5.00),
('Tarte de Limão', 6.00),
('Pão de Alho', 3.00),
('Donut', 2.50),
('Bolo de Laranja', 7.50),
('Baguete', 2.00),
('Pão de Batata', 3.10),
('Pão de Deus', 3.90),
('Croissant', 4.50);

 -- Stock de lojas ---------------------------------------------------- 
INSERT INTO Stock_Lojas(id_produto, id_loja, quantidade) VALUES
(1, 1, 0),
(1, 2, 50),
(1, 3, 20),
(1, 4, 25),
(2, 1, 25),
(2, 2, 30),
(2, 3, 35),
(2, 4, 45),
(3, 1, 10),
(3, 2, 12),
(3, 3, 15),
(3, 4, 8),
(4, 1, 50),
(4, 2, 40),
(4, 3, 0),
(4, 4, 30),
(5, 1, 20),
(5, 2, 18),
(5, 3, 25),
(5, 4, 15),
(6, 1, 12),
(6, 2, 18),
(6, 3, 14),
(6, 4, 22),
(7, 1, 30),
(7, 2, 25),
(7, 3, 28),
(7, 4, 33),
(8, 1, 22),
(8, 2, 26),
(8, 3, 32),
(8, 4, 18),
(9, 1, 40),
(9, 2, 45),
(9, 3, 38),
(9, 4, 25),
(10, 1, 33),
(10, 2, 28),
(10, 3, 22),
(10, 4, 30),
(11, 1, 27),
(11, 2, 34),
(11, 3, 19),
(11, 4, 24),
(12, 1, 10),
(12, 2, 13),
(12, 3, 15),
(12, 4, 18);

 -- CLIENTES ---------------------------------------------------- 
INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("João Mendes de Almeida", 20, "24 de julho", "joao@gmail.com", 999999999, '2004-09-09', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Nuno Rocha", 19, "Estrada de Benfica", "araoalmeida@gmail.com", 999999991, '2005-07-08', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("D. Afonso Henriques", 19, "Avenida D. Carlos I", "afonsohenriques@hotmail.com", 965121111, '2005-10-18', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("José Castelo Branco", 50, "Rua Castelo Branco", "zecastelo@icloud.com", 963121110, '1974-12-15', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Cristiano Ronaldo", 39, "Hotel Pestana", "cristiano07@hotmail.com", 907070707, '1985-02-05', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Tino das Rãs", 19, "Cova da Moura", "tino@gmail.com", 932112211, '2005-07-08', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Jubas", 119, "Estádio José de Alvalade", "jubas@icloud.com", 919060701, '1906-07-01', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Piruka", 37, "Rua da Madorna", 'piruka@iade.pt', 966322222, '1987-06-20', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Jorge Jesus", 70, "Rua do AlHilal", "jjboçe@yahoo.pt", 988888888, '1954-07-24', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Vitor Gyökeres", 26, "Marquês de Pombal", "gyokeres@gmail.com", 920240505, '1998-06-04', 'M');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Maria Silva", 34, "Rua das Flores, nº 12", "maria.silva@gmail.com", 927654321, '1990-05-12', 'F');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Ana Santos", 39, "Avenida da Liberdade, nº 200", "ana.santos@hotmail.com", 917555444, '1985-11-20', 'F');

INSERT INTO clientes(nome, idade, morada, email, telefone, data_nascimento, sexo)
VALUES ("Pedro Carvalho", 31, "Travessa do Tejo, nº 45", "pedro.carvalho@yahoo.com", 965432987, '1993-08-15', 'M');
 -- Avaliaçoes ---------------------------------------------------- 
INSERT INTO Feedback(id_cliente, id_loja, avaliacao, comentario)
VALUES 
(1, 1, 5, 'Excelente ambiente e atendimento impecável.'),
(2, 4, 3, 'Produtos bons, mas falta organização na loja.'),
(3, 2, 4, 'Gostei muito do pão, mas o café poderia ser melhor.'),
(4, 3, 2, 'Os funcionários não foram muito prestativos.'),
(5, 1, 5, 'Melhor pão de cereais que já comi, muito bom!'),
(6, 2, 1, 'Fiquei decepcionado com a limpeza da loja.'),
(7, 4, 4, 'O bolo de aniversário foi um sucesso, recomendo!'),
(8, 3, 3, 'Loja bem localizada, mas o atendimento é mediano.'),
(9, 1, 5, 'Voltarei com certeza, serviço de excelência!'),
(10, 4, 2, 'A qualidade caiu bastante nos últimos meses.'),
(11, 2, 4, 'Muito bom, mas poderia ter mais opções de bebidas.'),
(12, 3, 5, 'Ótima experiência, funcionários super simpáticos!'),
(13, 1, 3, 'Serviço rápido, mas achei os preços altos.');



-- UTILIZADORES -------------------------------------------

insert into Utilizadores(nome, telefone, email, password)
values('Jocca', 980980980, 'jocca@gmail.com', 'pass1234');

insert into Utilizadores(nome, telefone, email, password)
values('Mark Zuckerberg', 914051984, 'mark.zuckerberg@hotmail.com', 'pass1234');

insert into Utilizadores(nome, telefone, email, password)
values('Elon Musk', 980980999, 'elon.musk@yahoo.com', 'spacex123');

insert into Utilizadores(nome, telefone, email, password)
values('Jeff Bezos', 912345678, 'jeff.bezos@gmail.com', 'amazon123');

insert into Utilizadores(nome, telefone, email, password)
values('Mark Cuban', 912121212, 'mark.cuban@hotmail.com', 'cuban123');

insert into Utilizadores(nome, telefone, email, password)
values('Donald Trump', 939130132, 'donald.trump@yahoo.com', 'trump123');

insert into Utilizadores(nome, telefone, email, password)
values('Joe Biden', 919111911, 'joe.biden@gmail.com', 'biden2023');

insert into Utilizadores(nome, telefone, email, password)
values('Peter Parker', 915201256, 'peter.parker@hotmail.com', 'spidey123');

insert into Utilizadores(nome, telefone, email, password)
values('Bruce Wayne', 933434545, 'bruce.wayne@yahoo.com', 'batman123');

insert into Utilizadores(nome, telefone, email, password)
values('Tony Stark', 987667398, 'tony.stark@gmail.com', 'ironman123');
-- Vendas ---------------------------------------------------------
INSERT INTO Vendas(id_cliente,id_produto,id_loja,quantidade) 
VALUES
(1,3,1,10),
(2,1,2,15),
(3,2,1,5),
(4,5,2,7),
(5,6,3,4),
(6,4,4,8),
(7,4,4,5),
(8,8,3,6),
(9,9,3,12),
(10,10,3,3),
(11,11,2,9),
(12,12,2,11),
(13,9,2,12),
(1,10,4,3),
(11,11,2,9),
(12,12,3,11);
-- Exemplos de possiveis informações pedidas---------------------------------------------------------
-- Stock em todas as lojas ---------------------------------------------------------
SELECT L.morada AS Loja, P.nome AS Produto, SL.quantidade AS Quantidade_Em_Estoque
FROM Stock_Lojas SL
JOIN Lojas L ON SL.id_loja = L.ID
JOIN Produtos P ON SL.id_produto = P.ID
ORDER BY L.morada, P.nome;
-- Stock total numa loja expecifica ---------------------------------------------------------
SELECT L.morada AS Loja, P.nome AS Produto, SL.quantidade AS Quantidade_Em_Estoque
FROM Stock_Lojas SL
JOIN Lojas L ON SL.id_loja = L.ID
JOIN Produtos P ON SL.id_produto = P.ID
WHERE SL.id_loja = 1
ORDER BY P.nome;
-- Somas de stock em todas as lojas--------------------------------------------------------
SELECT P.nome AS Produto, SUM(SL.quantidade) AS Quantidade_Total
FROM Stock_Lojas SL
JOIN Produtos P ON SL.id_produto = P.ID
GROUP BY P.nome
ORDER BY P.nome;






