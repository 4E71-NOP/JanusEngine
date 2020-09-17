/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
part_modification	NON 0	OUI 1
*/

CREATE TABLE !table! (
part_id			INTEGER NOT NULL,
docu_id				INTEGER,
ws_id				INTEGER,
part_modification	INTEGER,

PRIMARY KEY (part_id),
KEY idx_!IdxNom!_docu_id (docu_id),
KEY idx_!IdxNom!_ws_id (ws_id)

);

