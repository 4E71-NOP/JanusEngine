/* ---------------------------------------- */
/* Foreign keys: theme_id, layout_id			*/
/* ---------------------------------------- */
/*
default_layout_content		NON 0	OUI 1
*/

CREATE TABLE !table! (
layout_theme_id INTEGER NOT NULL,
theme_id 		INTEGER,
layout_id 		INTEGER,
default_layout_content		INTEGER,

PRIMARY KEY (layout_theme_id),
KEY idx_!IdxNom!_theme_id (theme_id),
KEY idx_!IdxNom!_layout_id (layout_id)

);
