/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
retnot_origin 	CORRECTION 0	VALIDATION 1
*/

CREATE TABLE !table! (
retnot_id INTEGER NOT NULL,
docu_id 				INTEGER,
user_id 				INTEGER,
retnot_date 		INTEGER,
retnot_origin 	INTEGER,
retnot_content 	BLOB,

PRIMARY KEY (retnot_id),
KEY idx_!IdxNom!_docu_id (docu_id),
KEY idx_!IdxNom!_user_id (user_id)

);

