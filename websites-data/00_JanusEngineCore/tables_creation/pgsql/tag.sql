/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
tag_id		BYTEA NOT NULL UNIQUE, 
tag_name	VARCHAR(64), 
tag_html	VARCHAR(64), 
fk_ws_id	BYTEA, 

PRIMARY KEY (tag_id)


);
