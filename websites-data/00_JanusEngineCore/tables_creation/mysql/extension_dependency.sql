/* ---------------------------------------- */
/* Foreign keys: fk_ext_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extdep_id		BIGINT NOT NULL UNIQUE, 
fk_ext_id		BIGINT, 

PRIMARY KEY (extdep_id),
KEY idx_!IdxNom!_ext_id (extdep_id)

);
