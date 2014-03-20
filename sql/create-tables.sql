create table Member (
    memberID serial primary key,
    username varchar(40) not null unique,
    password varchar(128) not null,
    salt varchar(128) not null
);