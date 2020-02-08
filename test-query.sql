create table test (IDCOL number(35), NAME varchar);
select DATE_ADD(current_timestamp, interval 3 month) now from dual;
use mydb.*;
select * from lots;
select * from categories;
SET GLOBAL sql_mode = 'ALLOW_INVALID_DATES';

drop table categories;
delete from categories where id = 7;
delete from lots where id in (5,6);

SET NAMES 'utf8';
SET CHARACTER SET utf8;

/*Check coding of tables*/
SELECT
  `tables`.`TABLE_NAME`,
  `collations`.`character_set_name`
FROM
  `information_schema`.`TABLES` AS `tables`,
  `information_schema`.`COLLATION_CHARACTER_SET_APPLICABILITY` AS `collations`
WHERE
  `tables`.`table_schema` = DATABASE()
  AND `collations`.`collation_name` = `tables`.`table_collation`
;

ALTER SCHEMA yeticave DEFAULT CHARACTER SET utf8;

/*Change encoding for each table that has uncorrect encoding*/
ALTER TABLE categories CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE categories DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

ALTER TABLE categories CHANGE categ_name title VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci;

/*Show set encoding configuration for MySQL system*/
show variables like 'char%';

SELECT default_character_set_name FROM information_schema.SCHEMATA S WHERE schema_name = "yeticave";

/* utf8mb4 */
ALTER DATABASE yeticave CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;