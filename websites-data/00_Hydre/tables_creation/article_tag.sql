/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
article_tag_id	INTEGER NOT NULL, 
arti_id			INTEGER,
tag_id			INTEGER,

PRIMARY KEY (article_tag_id),
KEY idx_!IdxNom!_arti_id (arti_id),
KEY idx_!IdxNom!_tag_id (tag_id)

);
