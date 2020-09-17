/* ---------------------------------------- */
/* Foreign keys: ws_id, groupe_id			*/
/* ---------------------------------------- */
/*
groupe_etat 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
site_groupe_id	INTEGER NOT NULL,
ws_id			INTEGER,
groupe_id		INTEGER,
groupe_etat 	INTEGER,

PRIMARY KEY (site_groupe_id),
KEY idx_!IdxNom!_ws_id (ws_id),
KEY idx_!IdxNom!_groupe_id (groupe_id)

);
