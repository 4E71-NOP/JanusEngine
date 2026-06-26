/* ---------------------------------------- */
/* Foreign keys: fk_ext_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extdep_id		BINARY(16) NOT NULL UNIQUE, 
extdep_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(extdep_id))),
fk_ext_id		BINARY(16), 

PRIMARY KEY (extdep_id),
KEY idx_!IdxNom!_ext_id (extdep_id)

);
