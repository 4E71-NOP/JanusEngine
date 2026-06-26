/* ---------------------------------------- */
/* Foreign keys: ws_id, group_id			*/
/* ---------------------------------------- */
/*
group_state 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
lang_website_id		BINARY(16) NOT NULL UNIQUE, 
lang_website_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(lang_website_id))),
fk_ws_id			BINARY(16),
fk_lang_id			BINARY(16),

PRIMARY KEY (lang_website_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_lang_id (fk_lang_id)

);
