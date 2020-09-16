/* ---------------------------------------- */
/* Foreign keys: user_id, groupe_id			*/
/* ---------------------------------------- */
/*
groupe_premier	NON 0	OUI 1
*/
CREATE TABLE !table! ( 
groupe_user_id	INTEGER NOT NULL,
groupe_id		INTEGER,
user_id			INTEGER,
groupe_premier	INTEGER,

PRIMARY KEY (groupe_user_id),
KEY idx_!IdxNom!_groupe_id (groupe_id),
KEY idx_!IdxNom!_user_id (user_id)

);
