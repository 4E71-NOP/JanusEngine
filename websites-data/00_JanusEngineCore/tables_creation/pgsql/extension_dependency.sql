/* ---------------------------------------- */
/* Foreign keys: fk_ext_id					*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extdep_id		BYTEA NOT NULL UNIQUE, 
fk_ext_id		BYTEA, 

PRIMARY KEY (extdep_id)


);
