/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
article_tag_id	INTEGER NOT NULL, 
fk_arti_id			INTEGER,
fk_tag_id			INTEGER,

PRIMARY KEY (article_tag_id),
KEY idx_!IdxNom!_arti_id (fk_arti_id),
KEY idx_!IdxNom!_tag_id (fk_tag_id)

);
