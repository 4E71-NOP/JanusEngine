/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

/*
deco_etat	OFFLINE:0	ONLINE:1	SUPPRIME:2
deco_type
*/

CREATE TABLE !table! (
deco_ref_id				INTEGER NOT NULL,
deco_nom				VARCHAR(255),
deco_etat				INTEGER,
deco_type				INTEGER,
deco_id					INTEGER,

PRIMARY KEY (deco_ref_id),
KEY idx_!IdxNom!_deco_id (deco_id)

);
