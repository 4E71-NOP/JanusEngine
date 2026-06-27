/* ---------------------------------------- */
/* Foreign keys: ws_id					*/
/* ---------------------------------------- */
/*
module_state		OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
module_website_id		BYTEA NOT NULL UNIQUE, 
fk_ws_id 				BYTEA,
fk_module_id			BYTEA,
module_state 			INTEGER,

PRIMARY KEY (module_website_id)


);
