-- Set mode for a better life
SET SESSION sql_mode = `NO_BACKSLASH_ESCAPES,IGNORE_SPACE,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION`;
USE `!db!`;
DROP TRIGGER IF EXISTS !table_website!_entryUpdate;


CREATE DEFINER=`*user_install*`@`localhost` TRIGGER !table_website!_entryUpdate
BEFORE UPDATE 
ON !table_website! FOR EACH ROW
BEGIN 
	SET NEW.row_update = CURRENT_TIMESTAMP;
	SET NEW.row_user_update = SESSION_USER();
	IF (OLD.ws_state = 1 AND NEW.ws_state = 0) THEN
		SET NEW.row_disabled = CURRENT_TIMESTAMP;
		SET NEW.row_user_disabled = SESSION_USER();
	END IF;
END
