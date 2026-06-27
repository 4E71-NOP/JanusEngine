/* ---------------------------------------- */
/* Foreign keys: extcfg_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extcfg_id			BIGINT NOT NULL UNIQUE, 
fk_ws_id			BIGINT, 
fk_ext_id			BIGINT,
extcfg_variable		VARCHAR(255), 
extcfg_value		VARCHAR(255), 

PRIMARY KEY (extcfg_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_ext_id (fk_ext_id)

);
