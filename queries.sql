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
select l.*, c.categ_name
from lots l
join categories c on l.category_id = c.id
where l.id = 5;


/*Обновить название лота по его идентификатору*/
update lots set lot_name = 'Супер классная куртка для сноуборда DC Mutiny Charocal'
where id = 5;
commit;


/*получить список самых свежих ставок для лота по его идентификатору*/
select b.*
from bets b
where b.lot_id = 3
order by b.date_bet desc
limit 3;


select * from lots;
delete from lots where id in(21,22);