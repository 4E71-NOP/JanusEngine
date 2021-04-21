DELIMITER $$
CREATE TRIGGER `!table_website!_entryInsert` 
BEFORE INSERT ON !table_website! FOR EACH ROW 
SET NEW.row_creation = CURRENT_TIMESTAMP(), NEW.row_user_creation = CURRENT_USER();
$$ DELIMITER;


DELIMITER $$
CREATE TRIGGER `!table_website!_entryUpdate` 
BEFORE UPDATE 
ON !table_website! FOR EACH ROW
BEGIN 
	IF NEW.ws_state = 0 THEN 
		SET NEW.row_update = CURRENT_TIMESTAMP(), NEW.row_user_update = CURRENT_USER(), NEW.row_disabled = CURRENT_TIMESTAMP(), NEW.row_user_disabled = CURRENT_USER();
	ELSEIF NEW.ws_state > 0 THEN
		SET NEW.row_update = CURRENT_TIMESTAMP(), NEW.row_user_update = CURRENT_USER(), NEW.row_disabled = CURRENT_TIMESTAMP(), NEW.row_user_disabled = CURRENT_USER();
	END IF;
END;
$$ DELIMITER;

