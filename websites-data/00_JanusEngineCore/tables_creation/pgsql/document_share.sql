/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
part_modification	NON 0	OUI 1
*/

CREATE TABLE !table! (
share_id			BYTEA NOT NULL UNIQUE, 
fk_docu_id			BYTEA,
fk_ws_id			BYTEA,
share_modification	INTEGER,

PRIMARY KEY (share_id)



);

