
create database yeticave
	default character set utf8
	default collate utf8_general_ci;

use yeticave;

SET NAMES 'utf8';
SET CHARACTER SET utf8;
SET GLOBAL sql_mode = 'ALLOW_INVALID_DATES';

create table categories (
	id int auto_increment primary key,
    categ_name varchar(100) not null
);

create table lots (
	id int auto_increment primary key,
    date_creation TIMESTAMP default current_timestamp,
    lot_name varchar(255) not null,
    description text not null,
    image varchar(255) not null,
    start_price int not null,
    step int not null,
    current_price int,
    category_id int not null,
    date_close TIMESTAMP default current_timestamp,
    winner_id int,
    author_id int not null
);

/*alter table lots add column current_price int;*/

create table users (
	id int auto_increment primary key,
    date_reg TIMESTAMP default current_timestamp,
    user_name varchar(30) not null,
    email varchar(255) not null unique,
    pass varchar(100) not null,
    avatar varchar(100) default 'img/user.png',
    contact varchar(255) not null
);
/*alter table users modify email varchar(255);
alter table users modify contact varchar(255);*/


create table bets (
	id int auto_increment primary key,
	date_bet TIMESTAMP default current_timestamp,
    amount int not null,
    user_id int not null,
    lot_id int not null
);

