/* ---------------------------------------- */
/* Foreign keys: ws_id, user_id			*/
/* ---------------------------------------- */
/*
deadline_state 				OFFLINE 0	ONLINE 1	SUPPRIME 2
*/
CREATE TABLE !table! (
deadline_id 				BYTEA NOT NULL UNIQUE, 
deadline_name 				VARCHAR(255),
deadline_title 				VARCHAR(255),
deadline_state 				INTEGER,
deadline_creation_date 		INTEGER,
deadline_end_date 			INTEGER,
fk_ws_id					BYTEA,

PRIMARY KEY (deadline_id)


);
