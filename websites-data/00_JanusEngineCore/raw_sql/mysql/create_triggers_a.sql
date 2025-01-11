-- Sync all
FLUSH TABLES;
FLUSH PRIVILEGES;

-- Set mode for a better life
-- SESSION / GLOBAL
SET SESSION sql_mode = `NO_BACKSLASH_ESCAPES,IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION`;

USE `!db!`;

DROP TRIGGER IF EXISTS !table_website!_entryInsert;

CREATE DEFINER=`*user_install*`@`%` TRIGGER !table_website!_entryInsert 
BEFORE INSERT ON !table_website! FOR EACH ROW 
SET NEW.row_creation = NOW(), NEW.row_user_creation = CURRENT_USER();
