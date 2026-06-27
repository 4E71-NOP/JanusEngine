/* ---------------------------------------- */
/* Foreign keys: extcfg_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extcfg_id			BYTEA NOT NULL UNIQUE, 
fk_ws_id			BYTEA, 
fk_ext_id			BYTEA,
extcfg_variable		VARCHAR(255), 
extcfg_value		VARCHAR(255), 

PRIMARY KEY (extcfg_id)



);
