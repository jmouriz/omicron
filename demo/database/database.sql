drop table if exists products;

create table products (
   id integer primary key,
   detail varchar(60) not null,
   price number,
   stock integer
);
