/* ---------------------------------------- */
/* Foreign keys: site_id, groupe_id			*/
/* ---------------------------------------- */
/*
groupe_etat 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
site_lang_id	INTEGER NOT NULL,
site_id			INTEGER,
lang_id			INTEGER,

PRIMARY KEY (site_lang_id),
KEY idx_!IdxNom!_site_id (site_id),
KEY idx_!IdxNom!_lang_id (lang_id)

);
