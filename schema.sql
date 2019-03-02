create database yeticave
	default character set utf8
	default collate utf8_general_ci;

use yeticave;
 
create table categories (
	id int auto_increment primary key,
    categ_name char(30) not null
);

create table lots (
	id int auto_increment primary key,
    date_creation TIMESTAMP default current_timestamp,
    lot_name char(255) not null,
    description text not null,
    image char(255) not null,
    start_price int not null,
    step int not null,
    category_id int not null,
    date_close TIMESTAMP,
    winner_id int,
    author_id int not null
);

create table users (
	id int auto_increment primary key,
    date_reg TIMESTAMP default current_timestamp,
    user_name char(30) not null,
    email char(128) not null unique,
    pass char(100) not null,
    avatar char(100) default 'img/user.png',
    contact char(200) not null
);
alter table users modify email char(255);
alter table users modify contact char(255);


create table bets (
	id int auto_increment primary key,
	date_bet TIMESTAMP default current_timestamp,
    amount int not null,
    user_id int not null,
    lot_id int not null
);

