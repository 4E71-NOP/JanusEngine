/* ---------------------------------------- */
/* Foreign keys: ws_id, group_id			*/
/* ---------------------------------------- */
/*
group_state 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
group_website_id		BINARY(16) NOT NULL UNIQUE, 
group_website_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(group_website_id))),
fk_ws_id				BINARY(16),
fk_group_id				BINARY(16),
group_state 			INTEGER,

PRIMARY KEY (group_website_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_group_id (fk_group_id)

);
