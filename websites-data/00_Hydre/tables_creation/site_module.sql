/* ---------------------------------------- */
/* Foreign keys: ws_id					*/
/* ---------------------------------------- */
/*
module_etat		OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
site_module_id	INTEGER NOT NULL,
ws_id 		INTEGER,
module_id		INTEGER,
module_etat 	INTEGER,
module_position	INTEGER,

PRIMARY KEY (site_module_id),
KEY idx_!IdxNom!_ws_id (ws_id),
KEY idx_!IdxNom!_module_id (module_id)

);
