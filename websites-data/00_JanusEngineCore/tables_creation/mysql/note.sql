/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
note_origin 	CORRECTION 0	VALIDATION 1
*/

CREATE TABLE !table! (
note_id         BINARY(16) NOT NULL UNIQUE, 
note_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(note_id))),
fk_docu_id 		BINARY(16),
fk_user_id 		BINARY(16),
note_date 		INTEGER,
note_origin 	INTEGER,
note_content 	BLOB,

PRIMARY KEY (note_id),
KEY idx_!IdxNom!_docu_id (fk_docu_id),
KEY idx_!IdxNom!_user_id (fk_user_id)

);

