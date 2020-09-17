/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
remplacement_type
	1	vers_catégorie
	2	vers_url
	3	vers_aide_dynamique
*/
CREATE TABLE !table! (
mc_id			INTEGER NOT NULL,
mc_etat			INTEGER,
mc_nom			VARCHAR(255),
arti_id  		INTEGER,
ws_id			INTEGER,
mc_chaine		VARCHAR(255),
mc_compteur		INTEGER,
mc_type			INTEGER,
mc_donnee		VARCHAR(255),

PRIMARY KEY (mc_id),
KEY idx_!IdxNom!_arti_id (arti_id),
KEY idx_!IdxNom!_ws_id (ws_id)

);

