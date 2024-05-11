/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
article_tag_id	BIGINT NOT NULL UNIQUE, 
fk_arti_id			BIGINT,
fk_tag_id			BIGINT,

PRIMARY KEY (article_tag_id)

);
