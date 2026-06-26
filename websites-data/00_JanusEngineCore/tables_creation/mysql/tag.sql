/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
tag_id		BINARY(16) NOT NULL UNIQUE, 
tag_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(tag_id))),
tag_name	VARCHAR(64), 
tag_html	VARCHAR(64), 
fk_ws_id	BINARY(16), 

PRIMARY KEY (tag_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);
