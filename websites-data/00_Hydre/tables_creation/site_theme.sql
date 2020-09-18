/* ---------------------------------------- */
/* Foreign keys: ws_id, theme_id			*/
/* ---------------------------------------- */
/*
theme_state	OFFLINE 0	ONLINE 1	SUPPRIME 2
*/

CREATE TABLE !table! (
site_theme_id		INTEGER NOT NULL,
ws_id 			INTEGER,
theme_id			INTEGER,
theme_state	 		INTEGER,

PRIMARY KEY (site_theme_id),
KEY idx_!IdxNom!_ws_id (ws_id),
KEY idx_!IdxNom!_theme_id (theme_id)

);
