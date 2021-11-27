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
keyword_id			INTEGER NOT NULL,
keyword_state		INTEGER,
keyword_name		VARCHAR(255),
fk_arti_id  		INTEGER,
fk_ws_id			INTEGER,
keyword_string		VARCHAR(255),
keyword_count		INTEGER,
keyword_type		INTEGER,
keyword_data		VARCHAR(255),

PRIMARY KEY (keyword_id),
KEY idx_!IdxNom!_arti_id (fk_arti_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);

