/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
note_origin 	CORRECTION 0	VALIDATION 1
*/

CREATE TABLE !table! (
note_id         INTEGER NOT NULL,
fk_docu_id 		INTEGER,
fk_user_id 		INTEGER,
note_date 		INTEGER,
note_origin 	INTEGER,
note_content 	BLOB,

PRIMARY KEY (note_id),
KEY idx_!IdxNom!_docu_id (fk_docu_id),
KEY idx_!IdxNom!_user_id (fk_user_id)

);

