/* ---------------------------------------- */
/* Foreign keys: ws_id					*/
/* ---------------------------------------- */
/*
module_state		OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
module_website_id		BINARY(16) NOT NULL UNIQUE, 
module_website_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(module_website_id))),
fk_ws_id 				BINARY(16),
fk_module_id			BINARY(16),
module_state 			INTEGER,

PRIMARY KEY (module_website_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_module_id (fk_module_id)

);
