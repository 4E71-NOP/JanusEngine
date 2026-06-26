/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
article_tag_id		BINARY(16) NOT NULL UNIQUE, 
article_tag_id_str	CHAR(34) GENERATED ALWAYS AS (CONCAT('0x', HEX(article_tag_id))),
fk_arti_id			BINARY(16),
fk_tag_id			BINARY(16),

PRIMARY KEY (article_tag_id),
KEY idx_!IdxNom!_arti_id (fk_arti_id),
KEY idx_!IdxNom!_tag_id (fk_tag_id)

);
