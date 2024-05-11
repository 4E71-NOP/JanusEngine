/* ---------------------------------------- */
/* Foreign keys: ws_id, group_id			*/
/* ---------------------------------------- */
/*
group_state 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
group_website_id	BIGINT NOT NULL UNIQUE, 
fk_ws_id			BIGINT,
fk_group_id			BIGINT,
group_state 		INTEGER,

PRIMARY KEY (group_website_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_group_id (fk_group_id)

);
