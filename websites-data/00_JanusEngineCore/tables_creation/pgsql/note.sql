/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
note_origin 	CORRECTION 0	VALIDATION 1
*/

CREATE TABLE !table! (
note_id         BIGINT NOT NULL UNIQUE, 
fk_docu_id 		BIGINT,
fk_user_id 		BIGINT,
note_date 		INTEGER,
note_origin 	INTEGER,
note_content 	TEXT,

PRIMARY KEY (note_id)

);

