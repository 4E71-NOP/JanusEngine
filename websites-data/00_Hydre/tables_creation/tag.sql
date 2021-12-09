/* ---------------------------------------- */
/* Foreign keys: 							*/
/* ---------------------------------------- */

CREATE TABLE !table! (
tag_id		BIGINT NOT NULL UNIQUE, 
tag_name	VARCHAR(64), 
tag_html	VARCHAR(64), 
fk_ws_id	BIGINT, 

PRIMARY KEY (tag_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id)

);
