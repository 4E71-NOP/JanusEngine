/* ---------------------------------------- */
/* Foreign keys: ext_id						*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
extfil_id			BYTEA NOT NULL UNIQUE, 
fk_ext_id			BYTEA,
extfil_generic_name	VARCHAR(255), 
extfil_file			VARCHAR(255), 

PRIMARY KEY (extfil_id)


);
