/* ---------------------------------------- */
/* Foreign keys: ws_id, theme_id			*/
/* ---------------------------------------- */
/*
theme_state	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
theme_website_id	INTEGER NOT NULL,
ws_id 				INTEGER,
theme_id			INTEGER,
theme_state	 		INTEGER,
entry_date			TIMESTAMP NULL NULL,
entry_user_date		VARCHAR(255),
entry_update		TIMESTAMP NULL NULL,
entry_user_update	VARCHAR(255),
entry_disabled		TIMESTAMP NULL NULL,
entry_user_disabled	VARCHAR(255),

PRIMARY KEY (theme_website_id),
KEY idx_!IdxNom!_ws_id (ws_id),
KEY idx_!IdxNom!_theme_id (theme_id)
);
CREATE TRIGGER `entryInsert` 
BEFORE INSERT ON !table! FOR EACH ROW 
SET NEW.entry_date = CURRENT_TIMESTAMP(), NEW.entry_user_date = CURRENT_USER();

CREATE TRIGGER `entryUpdate` 
BEFORE UPDATE ON !table! FOR EACH ROW 
SET NEW.entry_update = CURRENT_TIMESTAMP(), NEW.entry_user_update = CURRENT_USER();

COMMIT;