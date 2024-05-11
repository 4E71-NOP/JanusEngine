/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
part_modification	NON 0	OUI 1
*/

CREATE TABLE !table! (
share_id			BIGINT NOT NULL UNIQUE, 
fk_docu_id			BIGINT,
fk_ws_id			BIGINT,
share_modification	INTEGER,

PRIMARY KEY (share_id)

);

