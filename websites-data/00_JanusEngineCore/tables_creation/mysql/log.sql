/* ---------------------------------------- */
/* Foreign keys: ws_id					*/
/* ---------------------------------------- */
/*
log_signal	ERR 0	OK 1	WARN 2	INFO 3	AUTRE 4
*/

CREATE TABLE !table! (
log_id			BINARY(16) NOT NULL UNIQUE, 
log_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(log_id))),
fk_ws_id		BINARY(16),
log_date		INTEGER,
log_initiator	VARCHAR(255),
log_action		BLOB,
log_signal		INTEGER,
log_msgid		VARCHAR(255),
log_contenu		BLOB,

PRIMARY KEY (log_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);
