/* ---------------------------------------- */
/* Foreign keys: extcfg_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extcfg_id			BINARY(16) NOT NULL UNIQUE, 
extcfg_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(extcfg_id))),
fk_ws_id			BINARY(16), 
fk_ext_id			BINARY(16),
extcfg_variable		VARCHAR(255), 
extcfg_value		VARCHAR(255), 

PRIMARY KEY (extcfg_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_ext_id (fk_ext_id)

);
