/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */
/*
remplacement_type
	1	vers_catégorie
	2	vers_url
	3	vers_aide_dynamique
*/
CREATE TABLE !table! (
keyword_id			BINARY(16) NOT NULL UNIQUE, 
keyword_id_str		CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(keyword_id))),
keyword_state		INTEGER,
keyword_name		VARCHAR(255),
fk_arti_id  		BINARY(16),
fk_ws_id			BINARY(16),
keyword_string		VARCHAR(255),
keyword_count		INTEGER,
keyword_type		INTEGER,
keyword_data		VARCHAR(255),

PRIMARY KEY (keyword_id),
KEY idx_!IdxNom!_arti_id (fk_arti_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);

