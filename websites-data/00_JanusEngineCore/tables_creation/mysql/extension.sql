/* ---------------------------------------- */
/* Foreign keys: ext_id						*/
/* ---------------------------------------- */

CREATE TABLE !table! ( 
ext_id				BIGINT NOT NULL UNIQUE, 
fk_ws_id			BIGINT, 
ext_name			VARCHAR(255), 
ext_version			VARCHAR(255), 
ext_author			VARCHAR(255), 
ext_author_website	VARCHAR(255), 
ext_class_exec		VARCHAR(255), 
ext_directory		VARCHAR(255), 

PRIMARY KEY (ext_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);
