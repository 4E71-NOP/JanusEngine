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
keyword_id			BYTEA NOT NULL UNIQUE, 
keyword_state		INTEGER,
keyword_name		VARCHAR(255),
fk_arti_id  		BYTEA,
fk_ws_id			BYTEA,
keyword_string		VARCHAR(255),
keyword_count		INTEGER,
keyword_type		INTEGER,
keyword_data		VARCHAR(255),

PRIMARY KEY (keyword_id)



);

