/* ---------------------------------------- */
/* Foreign keys: ws_id, group_id			*/
/* ---------------------------------------- */
/*
group_state 	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! ( 
lang_website_id	BIGINT NOT NULL UNIQUE, 
fk_ws_id			BIGINT,
fk_lang_id			BIGINT,

PRIMARY KEY (lang_website_id)

);
