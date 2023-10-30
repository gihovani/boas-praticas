drop database if exists test;
create database test;
# drop table if exists test.product;
create table test.product (
	product_id integer,
	description text,
	amount float(9,2)
);
insert into test.product values (1, 'HUAWEI-MateBook E Go 2023 Tablet Portátil com Teclado', 951.60); -- R$ 5.148,75 -- 882.81 estimados em imposto
insert into test.product values (2, 'HUWEI-Capa de teclado para Huawei MateBook E, 12.6', 59.00); -- R$319,84 -- $54.73 estimados em imposto
insert into test.product values (3, 'Torneira Monocomando Bica Baixa Lavabo Banheiro', 15.40);
insert into test.product values (4, 'Lenovo Xiaoxin Pad Tab 2022 128GB/64GB 10,6"', 109.69);
insert into test.product values (5, 'Hambúrguer Anti-Forno Panela', 35.52);
insert into test.product values (6, 'F', 129);