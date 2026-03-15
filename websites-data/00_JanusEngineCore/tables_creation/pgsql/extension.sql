/* ---------------------------------------- */
/* Foreign keys: ext_id						*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
ext_id				BIGINT NOT NULL UNIQUE, 
fk_ws_id			BIGINT, 
ext_name			VARCHAR(255), 
ext_version			VARCHAR(255), 
ext_author			VARCHAR(255), 
ext_class			VARCHAR(255), 
ext_directory		VARCHAR(255), 

PRIMARY KEY (ext_id)
);
