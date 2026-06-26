/* ---------------------------------------- */
/* Foreign keys: ext_id						*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
ext_id				BINARY(16) NOT NULL UNIQUE, 
ext_id_str			CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(ext_id))),
fk_ws_id			BINARY(16), 
ext_name			VARCHAR(255), 
ext_version			VARCHAR(255), 
ext_author			VARCHAR(255), 
ext_class			VARCHAR(255), 
ext_directory		VARCHAR(255), 

PRIMARY KEY (ext_id)
);
