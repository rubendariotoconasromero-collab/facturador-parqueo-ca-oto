-- campos agregados a users
alter table users add rol varchar(50);
alter table users add codigo_sistema int default 0;
alter table users add estado int default 1;