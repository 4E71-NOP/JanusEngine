/* ---------------------------------------- */
/* Foreign keys: theme_id, pres_id			*/
/* ---------------------------------------- */
/*
pres_defaut		NON 0	OUI 1
*/

CREATE TABLE !table! (
theme_pres_id 	INTEGER NOT NULL,
theme_id 		INTEGER,
pres_id 		INTEGER,
pres_defaut		INTEGER,

PRIMARY KEY (theme_pres_id),
KEY idx_!IdxNom!_theme_id (theme_id),
KEY idx_!IdxNom!_pres_id (pres_id)

);
