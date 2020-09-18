/* ---------------------------------------- */
/* Foreign keys: user_id, group_id			*/
/* ---------------------------------------- */
/*
groupe_premier	NON 0	OUI 1
*/
CREATE TABLE !table! ( 
groupe_user_id	INTEGER NOT NULL,
group_id		INTEGER,
user_id			INTEGER,
groupe_premier	INTEGER,

PRIMARY KEY (groupe_user_id),
KEY idx_!IdxNom!_group_id (group_id),
KEY idx_!IdxNom!_user_id (user_id)

);
