/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
note_origin 	CORRECTION 0	VALIDATION 1
*/

CREATE TABLE !table! (
note_id         BYTEA NOT NULL UNIQUE, 
fk_docu_id 		BYTEA,
fk_user_id 		BYTEA,
note_date 		INTEGER,
note_origin 	INTEGER,
note_content 	TEXT,

PRIMARY KEY (note_id)


);

