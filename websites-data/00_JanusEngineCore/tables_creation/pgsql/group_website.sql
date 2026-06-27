/* ---------------------------------------- */
/* Foreign keys: ws_id, group_id			*/
/* ---------------------------------------- */
/*
group_state 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
group_website_id		BYTEA NOT NULL UNIQUE, 
fk_ws_id				BYTEA,
fk_group_id				BYTEA,
group_state 			INTEGER,

PRIMARY KEY (group_website_id)



);
