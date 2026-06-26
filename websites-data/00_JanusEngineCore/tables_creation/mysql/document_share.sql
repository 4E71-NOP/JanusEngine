/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
part_modification	NON 0	OUI 1
*/

CREATE TABLE !table! (
share_id			BINARY(16) NOT NULL UNIQUE, 
share_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(share_id))),
fk_docu_id			BINARY(16),
fk_ws_id			BINARY(16),
share_modification	INTEGER,

PRIMARY KEY (share_id),
KEY idx_!IdxNom!_docu_id (fk_docu_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);

