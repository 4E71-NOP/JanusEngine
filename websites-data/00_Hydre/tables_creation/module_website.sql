/* ---------------------------------------- */
/* Foreign keys: ws_id					*/
/* ---------------------------------------- */
/*
module_state		OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
module_website_id	INTEGER NOT NULL,
fk_ws_id 		INTEGER,
fk_module_id	INTEGER,
module_state 	INTEGER,
module_position	INTEGER,

PRIMARY KEY (module_website_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_module_id (fk_module_id)

);
