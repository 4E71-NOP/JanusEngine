/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
article_tag_id	BIGINT NOT NULL UNIQUE, 
fk_arti_id			BIGINT,
fk_tag_id			BIGINT,

PRIMARY KEY (article_tag_id),
KEY idx_!IdxNom!_arti_id (fk_arti_id),
KEY idx_!IdxNom!_tag_id (fk_tag_id)

);
