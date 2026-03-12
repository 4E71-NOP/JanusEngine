/* ---------------------------------------- */
/* Foreign keys: ext_id						*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extfil_id			BIGINT NOT NULL UNIQUE, 
fk_ext_id			BIGINT,
extfil_generic_name	VARCHAR(255), 
extfil_file			VARCHAR(255), 

PRIMARY KEY (extfil_id),
KEY idx_!IdxNom!_ext_id (fk_ext_id)

);
