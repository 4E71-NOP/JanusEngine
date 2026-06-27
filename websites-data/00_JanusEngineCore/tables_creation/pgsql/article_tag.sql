/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
article_tag_id		BYTEA NOT NULL UNIQUE, 
fk_arti_id			BYTEA,
fk_tag_id			BYTEA,

PRIMARY KEY (article_tag_id)


);
