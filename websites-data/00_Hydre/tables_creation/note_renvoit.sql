/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
noterenvoit_origine 	CORRECTION 0	VALIDATION 1
*/

CREATE TABLE !table! (
noterenvoit_id INTEGER NOT NULL,
docu_id 				INTEGER,
user_id 				INTEGER,
noterenvoit_date 		INTEGER,
noterenvoit_origine 	INTEGER,
noterenvoit_contenu 	BLOB,

PRIMARY KEY (noterenvoit_id),
KEY idx_!IdxNom!_docu_id (docu_id),
KEY idx_!IdxNom!_user_id (user_id)

);

