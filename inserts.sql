insert into categories (categ_name) 
values ("Доски и лыжи"), ("Крепления"), ("Ботинки"), ("Одежда"), ("Инструменты"), ("Разное");

insert into categories (categ_name) 
values ("Аксессуары");

insert into lots (lot_name, description, image, start_price, step, category_id, date_close, author_id)
		values ('2014 Rossignol District Snowboard',
				'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
				'img/lot-1.jpg', 
				10999,
				12000,
				1,
				date_format('2019-03-25', '%Y-%m-%d'),
				1), 
                ('DC Ply Mens 2016/2017 Snowboard', 
				'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
                'img/lot-2.jpg', 
                159999,
                10000,
                1,
                date_format('2019-03-01','%Y-%m-%d'),
                2),
                ('Крепления Union Contact Pro 2015 года размер L/XL', 
				'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
                'img/lot-3.jpg', 
                8000,
                1000,
                2,
                date_format('2019-04-19','%Y-%m-%d'),
                5),
                ('Ботинки для сноуборда DC Mutiny Charocal', 
				'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
                'img/lot-4.jpg', 
                10999,
                2000,
                3,
                date_format('2019-03-23','%Y-%m-%d'),
                3),
                ('Куртка для сноуборда DC Mutiny Charocal', 
				'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
                'img/lot-5.jpg', 
                7500,
                500,
                4,
                date_format('2019-05-03','%Y-%m-%d'),
                4),
                ('Маска Oakley Canopy', 
				'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
                'img/lot-6.jpg', 
                5400,
                200,
                6,
                date_format('2019-04-28','%Y-%m-%d'),
                5);
                
insert into lots (lot_name, description, image, start_price, step, category_id, date_close, author_id)
		values ('Лыжная-куртка RS Termo Ligth',
				'Лёгкая и тёплая куртка. Отличный вариант для активного отдыха.',
                'img/lot-7.jpg',
				20500,
				500,
				4,
				date_format('2019-03-31', '%Y-%m-%d'),
				2),
                ('Очки TM DRADON',
				'Брендовые очки TM DRADON надёжная защита ваших глаз от снега и ветра.',
                'img/lot-8.jpg',
				1500,
				300,
				4,
				date_format('2019-03-31', '%Y-%m-%d'),
				5);

insert into users (user_name, email, pass, avatar, contact)
values ('Paul', 'paul@com.co', 'paul123', 'img/user.jpg', '+196548325464'),
        ('John-Smith', 'jhon_smith@com.gr', '123456', 'img/avatar.jpg', '+260456313354'),
        ('Lola', 'lola@net.com', 'lolanet', default, '+365141456624'),
        ('Mia_Brown', 'mbrown@mia.net', 'miabrown', default, '+895611335476'),
        ('Jourge', 'gourge@net.ua', '321654', default, '+895446321123');
        
insert into bets (amount, user_id, lot_id)
values (8000,1,3), (8000,1,5), (18000,1,6),
		(10000,2,5), (1500,1,3), (1500,1,4),
        (12000,3,2), (15000,3,6), (9700,3,5),
        (9500,5,5), (1000,4,3), (20000,5,2);
        
insert into bets (amount, user_id, lot_id)
values (21500,5,23);

insert into bets (amount, user_id, lot_id)
values (2100,3,24);