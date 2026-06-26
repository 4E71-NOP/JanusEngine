/* ---------------------------------------- */
/* Foreign keys: ws_id, theme_id			*/
/* ---------------------------------------- */
/*
theme_state	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
theme_website_id		BINARY(16) NOT NULL UNIQUE, 
theme_website_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(theme_website_id))),
fk_ws_id 				BINARY(16),
fk_theme_id				BINARY(16),
theme_state	 			INTEGER,
row_creation			TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
row_user_creation		VARCHAR(255),
row_update				TIMESTAMP NULL NULL,
row_user_update			VARCHAR(255),
row_disabled			TIMESTAMP NULL NULL,
row_user_disabled		VARCHAR(255),

PRIMARY KEY (theme_website_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_theme_id (fk_theme_id)
);
