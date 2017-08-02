# Omicron

Micro ORM

```
drop table if exists users;

create table users (
   id integer primary key,
   email varchar(60) not null,
   password varchar(20) not null,
   firstname varchar(60),
   lastname varchar(60),
   phone varchar(20)
);
```
