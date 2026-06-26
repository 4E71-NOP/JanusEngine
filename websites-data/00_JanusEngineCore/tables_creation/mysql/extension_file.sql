/* ---------------------------------------- */
/* Foreign keys: ext_id						*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extfil_id			BINARY(16) NOT NULL UNIQUE, 
extfil_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(extfil_id))),
fk_ext_id			BINARY(16),
extfil_generic_name	VARCHAR(255), 
extfil_file			VARCHAR(255), 

PRIMARY KEY (extfil_id),
KEY idx_!IdxNom!_ext_id (fk_ext_id)

);
