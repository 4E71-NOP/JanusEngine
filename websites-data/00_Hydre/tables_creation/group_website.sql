/* ---------------------------------------- */
/* Foreign keys: ws_id, group_id			*/
/* ---------------------------------------- */
/*
group_state 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
group_website_id	INTEGER NOT NULL,
ws_id			INTEGER,
group_id		INTEGER,
group_state 	INTEGER,

PRIMARY KEY (group_website_id),
KEY idx_!IdxNom!_ws_id (ws_id),
KEY idx_!IdxNom!_group_id (group_id)

);
