/* ---------------------------------------- */
/* Foreign keys: ws_id					*/
/* ---------------------------------------- */
/*
module_state		OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
module_website_id	BIGINT NOT NULL UNIQUE, 
fk_ws_id 		BIGINT,
fk_module_id	BIGINT,
module_state 	INTEGER,
module_position	INTEGER,

PRIMARY KEY (module_website_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_module_id (fk_module_id)

);
