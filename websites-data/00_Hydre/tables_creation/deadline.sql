/* ---------------------------------------- */
/* Foreign keys: ws_id, user_id			*/
/* ---------------------------------------- */
/*
deadline_state 				OFFLINE 0	ONLINE 1	SUPPRIME 2
*/
CREATE TABLE !table! (
deadline_id 				INTEGER NOT NULL,
deadline_name 				VARCHAR(255),
deadline_title 				VARCHAR(255),
deadline_state 				INTEGER,
deadline_creation_date 		INTEGER,
deadline_end_date 		INTEGER,
fk_ws_id						INTEGER,
fk_user_id						INTEGER,

PRIMARY KEY (deadline_id),
KEY idx_!IdxNom!_ws_id (fk_ws_id),
KEY idx_!IdxNom!_user_id (fk_user_id)

);
