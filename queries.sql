/*Получить все категории*/
select categ_name name from categories;


/*Получить самые новые, открытые лоты. 
Каждый лот должен включать название, стартовую цену, 
ссылку на изображение, цену, название категории*/
select l.lot_name name, c.categ_name category_name, l.start_price price, l.image img, l.step 
from lots l
join categories c on l.category_id = c.id
where date_format(date_close,'%Y-%m-%d') > date_format(SYSDATE(),'%Y-%m-%d')
order by date_creation desc;


/*Показать лот по его id. Получите также название категории, к которой принадлежит лот*/
select l.id, l.date_creation, l.lot_name, l.description, l.image, l.start_price, l.step, l.date_close, c.categ_name
from lots l
join categories c on l.category_id = c.id
where l.id = 0;


/*Обновить название лота по его идентификатору*/
update lots set lot_name = 'Супер классная куртка для сноуборда DC Mutiny Charocal'
where id = 5;
commit;

/*Обновить url картинки лота*/
update lots set image = concat('/',image) where id>0;

delete from lots where DATE(date_creation) = CURDATE() and id>0;

select * from lots;

rollback;
/*получить список самых свежих ставок для лота по его идентификатору*/
select b.id, b.date_bet, b.amount, b.user_id, b.lot_id, u.user_name
from bets b
join users u on b.user_id = u.id
where b.lot_id = 3
order by b.date_bet desc;


select * from lots;
delete from lots where id =32;

select * from users;

select * from categories;

select b.id, b.date_bet, b.amount, b.user_id, b.lot_id, u.user_name
              from bets b
              join users u on b.user_id = u.id
              where b.lot_id = 23
              order by b.date_bet desc;