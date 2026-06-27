/* ---------------------------------------- */
/* Foreign keys: ws_id, group_id			*/
/* ---------------------------------------- */
/*
group_state 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
lang_website_id		BYTEA NOT NULL UNIQUE, 
fk_ws_id			BYTEA,
fk_lang_id			BYTEA,

PRIMARY KEY (lang_website_id)



);
